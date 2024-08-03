@extends('front.layout')

@section('title','Service Detail')
    

 
@section('content')

<div class="container mt-5">
        <div class="service-header">
            <h1>Custom Suit Tailoring</h1>
            <div class="tailor-info">
               <a href="{{url('/profile/'.$user[0]->id)}}"><img src="{{asset('/storage/media/customer/'.$user[0]->image)}}" alt="Tailor Profile Picture" class="tailor-img"></a> 
                <div>
                    <h2>{{$user[0]->name}}</h2>
                </div>
            </div>
        </div>
        <div class="service-section">
            <img src="{{asset('/storage/media/services/'.$services[0]->image)}}" alt="Service Image" class="service-img">
            <div class="service-details">
                <h2>Service Title</h2>
                <p>{{$services[0]->title}}</p>
                <h3>What's Included</h3>
                <ul>
                    <li>Initial consultation and measurements</li>
                    <li>Fabric selection</li>
                    <li>Two fittings</li>
                    <li>Final adjustments and delivery</li>
                </ul>
                <div class="pricing">
                  
                    <h3>Packeges</h3>
                    <h5>1.Basic Package Rs{{$services[0]->min_price}}/-</h5>
                    <p>delivery time {{$services[0]->max_delivery_time}} days-</p>
                    <h5>2.Standard Package Rs{{$services[0]->max_price}}/-</h5>
                    <p>delivery time  {{$services[0]->min_delivery_time}} days-</p>  
                </div>
            </div>
        </div>
        <section class="about profile-container container">
            <h2 class='text-center'>Service Description</h2>
            <p>{{$services[0]->desc}}</p>    
        </section>
        @if(session()->get('IS_TAILOR')=='no')
        <section class="cta">
            <h2>Ready to Get Started?</h2>
            <div class="d-grid gap-2">
            <button class='btn btn-danger btn-lg' onclick='user_order("{{$services[0]->id}}","{{$services[0]->user_id}}")'>Order</button>
            </div>
        </section>
       @endif
    </div>


@endsection

 
       