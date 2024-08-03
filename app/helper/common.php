<?php
use Illuminate\Support\Facades\DB;

function getTopNavCat(){
    $result=DB::table('categories')
            ->where(['status'=>1])
            ->get();
            $arr=[];

            
    foreach($result as $row){
        $arr[$row->id]['category_name']=$row->category_name;
        $arr[$row->id]['parent_category_id']=$row->parent_category_id;
		$arr[$row->id]['category_slug']=$row->category_slug;
		
    }
   
    $str=buildTreeView($arr,0);
 
    return $str;
}

$html='';
function buildTreeView($arr,$parent,$level=0,$prelevel= -1){
	global $html;
	foreach($arr as $id=>$data){
		if($parent==$data['parent_category_id']){
			if($level>$prelevel){
				if($html==''){
					$html.='<ul class="nav navbar-nav helper_nav" style="font-size:23px">';
				}else{
					$html.='<ul class="dropdown-menu">';
				}
				
			}
			if($level==$prelevel){
				$html.='</li>';
			}
			$html.='<li><a href="/category/'.$data['category_slug'].'">'.$data['category_name'].'<span class="caret"></span></a>';
			
			if($level>$prelevel){
				$prelevel=$level;
			}
			$level++;
			buildTreeView($arr,$id,$level,$prelevel);
			$level--;
		}
	}
	if($level==$prelevel){
		$html.='</li></ul>';
	}
	return $html;
}


function total_cart_items(){
	if(session()->has('FRONT_USER_LOGIN')){
        $user_id=session()->get('FRONT_USER_LOGIN');
        $user_type='Reg';

    }else{
        $user_id=getUserTempid();
        $user_type='Not Reg';

    }
	$cart_total=DB::table('cart')->where('user_id',$user_id)->get()->count();
	return $cart_total;
}

function prx($result){
   echo '<pre>';
   print_r($result);
   die();
}

function getUserTempid(){
   
		
        $temp = session()->get('USER_TEMP_ID');
        if($temp == null){
            $rand = rand(111111111, 999999999);
            session()->put('USER_TEMP_ID', $rand);
            return $rand;
        }else{
            return $temp;
        }
    
}

function getTotalReviews($id){
	$total=DB::table('rating')->where('product_id',$id)->get()->count();
	if($total==0){
		return null;
	}
	$star=DB::table('rating')->where('product_id', $id)->sum('rating_stars');
	$total_rating=$star/$total;
	return number_format($total_rating, 2);
}


function getTotalUserReviews($id){
	$total=DB::table('reviews')->where('service_user_id',$id)->get()->count();
	if($total==0){
		return null;
	}
	$star=DB::table('reviews')->where('service_user_id', $id)->sum('review_star');
	$total_rating=$star/$total;
	return number_format($total_rating, 2);
}
function totalCount($id){

	$total=DB::table('reviews')->where('service_user_id',$id)->get()->count();
	if($total==0){
		return null;
	}
	return $total;
}
function totalCompleteOrders($id){
	$total_completed_orders=DB::table('confirm_orders')->where(['service_user_id'=>$id,'status'=>'completed'])->get()->count();

	return $total_completed_orders;

}
function totalEarning($id){

	$earning=DB::table('confirm_orders')->where(['service_user_id'=>$id,'status'=>'completed'])->sum('price');
	$total_earning=$earning*0.75;

	return $total_earning;

}

?>