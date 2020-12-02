<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event_Image;
use App\Models\FullTextSearch;
use App\Models\Event;
use phpDocumentor\Reflection\Location;

class SearchController extends Controller
{


  function index()
  {
    return view('pages.search');
  }

  function action()
  {
    $q = Input::get('q');

    $users = User::search($q)->get();
    $events = Event::search($q)->get();
 
    return view('pages.search',['users'=>$users,'events'=>$events,'query'=>$q]);
  }

  function searchAJAX(Request $request)
  {

    $search_query = $request->get('search');
    $location_query = $request->get('location');
    $price = $request->get('price');

    $users = User::search($search_query)->get();
    $events_searched = Event::search($search_query)->get();
 
    ///ACTIVATE TO FILTER FOR ONLY PAID EVENTS
    if($location_query != null){
    $events_location = $events_searched->filter(function ($value, $key) use ($location_query){
      return (strpos($value->location, $location_query) !== false );
    
   });
  }else{$events_location = $events_searched;}


  switch($price){
    case 'all':
      $events = $events_location;
    break;
    case 'free':
      $events = $events_location->filter(function ($value, $key) {
        return $value->price == 0;
      });
    break;
    case 'paid':
      $events = $events_location->filter(function ($value, $key) {
        return $value->price > 0;
      });
    break;
  }
 



    /////TURNING THE EVENT RESULTS INTO HTML FOR THE REPLACEMENT WITH AJAX
    
    $event_html = '<h3 class="searchpage">Matching Events for: <b>'. $search_query .'</b></h3>  <ul class="hs">';
    if($events->isNotEmpty()){
    foreach ($events as $event) {


      if ($event->start_date <= today())
        continue;

      $image = Event_Image::where('event_id', $event->id)->first();

      if ($image == null) {
        $image = '/images/placeholder-event.png';
      } else {
        $image = $image->image_url;
      }
     $event_html = $event_html. '<li class="item">
      <img class="imagefit event" src="'. $image .'">

      <h3>'.$event->event_name .'</h3>
      <p>'. $event->start_date .' | '. $event->location .'</p>
      <a class="btn btn-outline-info" href="/event/'.$event->id .'" role="button">See more</a>
    </li>';

    }} else{

      $event_html = $event_html . "<h4>No events with that search query have been found!</h4>";
    } 

    $event_html = $event_html . '</ul>';


    /////TURNING THE USER RESULTS INTO HTML FOR THE REPLACEMENT WITH AJAX
    $user_html = '<h3 class="searchpage">Matching Users for: <b>'. $search_query .'</b></h3>  <ul class="hs">';

     if( $users->isNotEmpty()){
   
    foreach ($users as $search_user) {

     $user_html = $user_html. '	<li class="user">
     <img class="imagefituser2 user" src="'. $search_user->photo .'">

     <h3>'. $search_user->name .'</h3>
     <a class="btn btn-outline-info" href="/user/'. $search_user->id .'" role="button">See more</a>
   </li>';

    }
   }else{

    $user_html = $user_html . "<h4>No users with that search query have been found!</h4>";
    } 
    

    $user_html = $user_html . '</ul>';


   

    return response()->json(array('events' => $event_html,'users'=>$user_html), 200);
  }
}
