<?php

namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\MessageSent;

class MessageController extends Controller
{
    private function eligibleTailorIds($customerId)
    {
        return DB::table('user_orders')->where('user_id', $customerId)->pluck('service_user_id')
            ->merge(DB::table('confirm_orders')->where('user_id', $customerId)->pluck('service_user_id'))
            ->unique()->values();
    }

    private function eligibleCustomerIds($tailorId)
    {
        return DB::table('user_orders')->where('service_user_id', $tailorId)->pluck('user_id')
            ->merge(DB::table('confirm_orders')->where('service_user_id', $tailorId)->pluck('user_id'))
            ->unique()->values();
    }

    private function isTailor($userId)
    {
        return DB::table('customers')->where('id', $userId)->value('tailor') === 'yes';
    }

    /** Resolve which of (sessionUserId, otherId) is the customer vs. the tailor, regardless of who initiates. */
    private function conversationPair($sessionUserId, $otherId)
    {
        return $this->isTailor($sessionUserId)
            ? ['customer_id' => $otherId, 'tailor_id' => $sessionUserId]
            : ['customer_id' => $sessionUserId, 'tailor_id' => $otherId];
    }

    private function isEligible($customerId, $tailorId)
    {
        return DB::table('user_orders')->where(['user_id' => $customerId, 'service_user_id' => $tailorId])->exists()
            || DB::table('confirm_orders')->where(['user_id' => $customerId, 'service_user_id' => $tailorId])->exists();
    }

    private function isParticipant($conversation, $userId)
    {
        return $conversation && ($conversation->customer_id == $userId || $conversation->tailor_id == $userId);
    }

    private function sidebarData($id, $filter = 'all')
    {
        $isTailor    = $this->isTailor($id);
        $archivedCol = $isTailor ? 'archived_by_tailor' : 'archived_by_customer';

        $conversations = DB::table('conversations')
            ->where('customer_id', $id)->orWhere('tailor_id', $id)
            ->orderByRaw('last_message_at IS NULL, last_message_at DESC')
            ->get();

        foreach ($conversations as $conv) {
            $otherId = $conv->customer_id == $id ? $conv->tailor_id : $conv->customer_id;
            $other = DB::table('customers')->where('id', $otherId)->first();
            $conv->other_id    = $otherId;
            $conv->other_name  = $other->name ?? 'Unknown';
            $conv->other_image = $other->image ?? null;
            $conv->archived    = (bool) $conv->{$archivedCol};
            $conv->unread_count = DB::table('messages')
                ->where('conversation_id', $conv->id)
                ->where('sender_id', '!=', $id)
                ->whereNull('read_at')
                ->count();
            $conv->last_message = DB::table('messages')
                ->where('conversation_id', $conv->id)
                ->orderByDesc('created_at')
                ->value('body');
        }

        $conversations = match ($filter) {
            'unread'   => $conversations->where('archived', false)->where('unread_count', '>', 0)->values(),
            'read'     => $conversations->where('archived', false)->where('unread_count', '=', 0)->values(),
            'archived' => $conversations->where('archived', true)->values(),
            default    => $conversations->where('archived', false)->values(),
        };

        $my_contacts = $isTailor
            ? DB::table('customers')->whereIn('id', $this->eligibleCustomerIds($id))->where('tailor', 'no')->get()
            : DB::table('customers')->whereIn('id', $this->eligibleTailorIds($id))->where('tailor', 'yes')->get();

        return [$conversations, $my_contacts, $isTailor];
    }

    public function inbox(Request $req)
    {
        $id = session()->get('FRONT_USER_LOGIN');
        $filter = in_array($req->query('filter'), ['unread', 'read', 'archived']) ? $req->query('filter') : 'all';
        [$conversations, $my_contacts, $isTailor] = $this->sidebarData($id, $filter);

        $result['conversations'] = $conversations;
        $result['my_contacts']   = $my_contacts;
        $result['isTailor']      = $isTailor;
        $result['activeFilter']  = $filter;

        return view('front.messages.inbox', $result);
    }

    public function searchTailors(Request $req)
    {
        $id = session()->get('FRONT_USER_LOGIN');
        if (!$id) {
            return response()->json(['status' => 'error', 'message' => 'Session expired', 'data' => null], 401);
        }

        $search = trim((string) $req->query('search_val', ''));
        $isTailor = $this->isTailor($id);
        $contactIds = $isTailor ? $this->eligibleCustomerIds($id) : $this->eligibleTailorIds($id);

        $contacts = DB::table('customers')
            ->whereIn('id', $contactIds)
            ->where('tailor', $isTailor ? 'no' : 'yes')
            ->when($search, fn($q) => $q->where('name', 'like', '%' . $search . '%'))
            ->get(['id', 'name', 'image']);

        foreach ($contacts as $contact) {
            $pair = $this->conversationPair($id, $contact->id);
            $contact->conversation_id = DB::table('conversations')->where($pair)->value('id');
        }

        return response()->json(['status' => 'ok', 'message' => null, 'data' => $contacts]);
    }

    public function start(Request $req, $otherId)
    {
        $id = session()->get('FRONT_USER_LOGIN');
        $pair = $this->conversationPair($id, $otherId);

        if (!$this->isEligible($pair['customer_id'], $pair['tailor_id'])) {
            return redirect('/messages')->with('error', 'You can only message someone you have an order history with.');
        }

        $conv = DB::table('conversations')->where($pair)->first();

        if (!$conv) {
            $convId = DB::table('conversations')->insertGetId(array_merge($pair, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        } else {
            $convId = $conv->id;
        }

        return redirect('/messages/' . $convId);
    }

    public function show(Request $req, $conversationId)
    {
        $id = session()->get('FRONT_USER_LOGIN');
        $conv = DB::table('conversations')->where('id', $conversationId)->first();

        if (!$this->isParticipant($conv, $id)) {
            return redirect('/messages')->with('error', 'Conversation not found.');
        }

        $otherId = $conv->customer_id == $id ? $conv->tailor_id : $conv->customer_id;
        $other = DB::table('customers')->where('id', $otherId)->first();

        $messages = DB::table('messages')->where('conversation_id', $conversationId)->orderBy('created_at')->get();

        DB::table('messages')
            ->where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $filter = in_array($req->query('filter'), ['unread', 'read', 'archived']) ? $req->query('filter') : 'all';
        [$conversations, $my_contacts, $isTailor] = $this->sidebarData($id, $filter);

        $result['conversationId'] = (int) $conversationId;
        $result['messages']       = $messages;
        $result['other']          = $other;
        $result['conversations']  = $conversations;
        $result['my_contacts']    = $my_contacts;
        $result['isTailor']       = $isTailor;
        $result['activeFilter']   = $filter;
        $result['pusherKey']      = config('broadcasting.connections.pusher.key');
        $result['pusherCluster']  = env('PUSHER_APP_CLUSTER');

        return view('front.messages.show', $result);
    }

    public function send(Request $req, $conversationId)
    {
        $id = session()->get('FRONT_USER_LOGIN');
        if (!$id) {
            return response()->json(['status' => 'error', 'message' => 'Session expired', 'data' => null], 401);
        }

        $conv = DB::table('conversations')->where('id', $conversationId)->first();
        if (!$this->isParticipant($conv, $id)) {
            return response()->json(['status' => 'error', 'message' => 'Not a participant of this conversation', 'data' => null], 403);
        }

        $body = trim((string) $req->post('body'));
        if ($body === '') {
            return response()->json(['status' => 'error', 'message' => 'Message cannot be empty', 'data' => null], 422);
        }

        $now = now();
        $msgId = DB::table('messages')->insertGetId([
            'conversation_id' => $conversationId,
            'sender_id'       => $id,
            'body'            => $body,
            'created_at'      => $now,
            'updated_at'      => $now,
        ]);

        DB::table('conversations')->where('id', $conversationId)->update(['last_message_at' => $now]);

        $msg = DB::table('messages')->where('id', $msgId)->first();
        $recipientId = $conv->customer_id == $id ? $conv->tailor_id : $conv->customer_id;
        $senderName  = DB::table('customers')->where('id', $id)->value('name') ?? 'Someone';
        event(new MessageSent($msg, $recipientId, $senderName));

        return response()->json([
            'status'  => 'ok',
            'message' => 'Message sent',
            'data'    => $msg,
        ]);
    }

    public function markRead(Request $req, $conversationId)
    {
        $id = session()->get('FRONT_USER_LOGIN');
        if (!$id) {
            return response()->json(['status' => 'error', 'message' => 'Session expired', 'data' => null], 401);
        }

        $conv = DB::table('conversations')->where('id', $conversationId)->first();
        if (!$this->isParticipant($conv, $id)) {
            return response()->json(['status' => 'error', 'message' => 'Not a participant of this conversation', 'data' => null], 403);
        }

        DB::table('messages')
            ->where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['status' => 'ok', 'message' => null, 'data' => null]);
    }

    public function archive(Request $req, $conversationId)
    {
        $id = session()->get('FRONT_USER_LOGIN');
        if (!$id) {
            return response()->json(['status' => 'error', 'message' => 'Session expired', 'data' => null], 401);
        }

        $conv = DB::table('conversations')->where('id', $conversationId)->first();
        if (!$this->isParticipant($conv, $id)) {
            return response()->json(['status' => 'error', 'message' => 'Not a participant of this conversation', 'data' => null], 403);
        }

        $archivedCol = $this->isTailor($id) ? 'archived_by_tailor' : 'archived_by_customer';
        $newValue = !$conv->{$archivedCol};

        DB::table('conversations')->where('id', $conversationId)->update([$archivedCol => $newValue]);

        return response()->json(['status' => 'ok', 'message' => null, 'data' => ['archived' => $newValue]]);
    }

    public function broadcastAuth(Request $req)
    {
        $id = session()->get('FRONT_USER_LOGIN');
        if (!$id) {
            return response()->json(['status' => 'error', 'message' => 'Session expired'], 401);
        }

        $channelName = (string) $req->input('channel_name');

        if (preg_match('/^private-conversation\.(\d+)$/', $channelName, $m)) {
            $conv = DB::table('conversations')->where('id', $m[1])->first();
            if (!$this->isParticipant($conv, $id)) {
                return response()->json(['status' => 'error', 'message' => 'Forbidden'], 403);
            }
        } elseif (preg_match('/^private-user\.(\d+)$/', $channelName, $m)) {
            if ((int) $m[1] !== (int) $id) {
                return response()->json(['status' => 'error', 'message' => 'Forbidden'], 403);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid channel'], 403);
        }

        $pusher = new \Pusher\Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );

        $auth = $pusher->socket_auth($channelName, (string) $req->input('socket_id'));

        return response($auth, 200)->header('Content-Type', 'application/json');
    }
}
