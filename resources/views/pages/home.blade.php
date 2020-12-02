@include('layouts.header')

@include('layouts.navbar')



@if (session('status'))
<div class="alert alert-info">
<p>{{ session('status') }}</p>
</div>

@endif

@if (session('event_deleted'))
    <div class="alert alert-info">
        {{ session('event_deleted') }}
    </div>
@endif

<div class="app">

  <h2 class="title">Upcoming Events
  </h2>

  <div class="dropdownhome show">
    <a id="dropdownSort" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort by</a>
    <div id="dropdown-sortby" class="dropdown-menu" aria-labelledby="dropdownSort">
      @include('layouts.dropdown')
    </div>
  </div>
  <ul class="hs">

    <?php


    if (isset($sort)) {
    
      switch ($sort) {
       
        case 1:
          $events = App\Models\Event::orderBy('price', 'asc')->get();
          break;
        case 2:
          $events = App\Models\Event::orderBy('price', 'desc')->get();
          break;
        case 3:
          $events = App\Models\Event::orderBy('start_date', 'asc')->get();
          break;
      }
    }
    else{
    $events = App\Models\Event::orderBy('start_date', 'asc')->get();
    }
    foreach ($events as $event) {


      if ($event->start_date < today())
        continue;

      if(auth()->user()){

      if($event->private_event == true && !(Auth::user()->isAdmin() || Auth::user()->id == $event->owner_id || Auth::user()->isAttending($event->id) || Auth::user()->isInvited($event->id)))
        continue;
      }

      if($event->private_event && !(auth()->user()))
        continue;


      $image = App\Models\Event_Image::where('event_id', $event->id)->first();

      if ($image == null) {
        $image = '/images/placeholder-event.png';
      } else {
        $image = $image->image_url;
      }
    ?>

      <li class="item">
        <img class="imagefithome event" alt="Event photo" width="341px" height="226px" src="{{ $image }}">

        <h3>{{ $event->event_name }}</h3>
        <?php
        if ($event->price == 0) { ?>
          <p>{{ $event->start_date }} | {{ $event->location }} | Free</p>
        <?php } else { ?>
          <p>{{ $event->start_date }} | {{ $event->location }} | Price: {{ $event->price}}€</p>
        <?php } ?>
        <a class="btn btn-outline-info" href="/event/{{ $event->id }}" role="button">See more</a>
      </li>
    <?php
    }  ?>




  </ul>

  <h2 class="title">Popular Events</h2>

  <ul class="hs">
    <?php
    if (isset($event)) {
      $nratt = $event->attending->count();

      $events = App\Models\Event::with('attending')->get()->sortBy(function ($event) {
        return $event->attending->count();
      }, null, true);

      foreach ($events as $event) {

        if ($event->start_date < today())
        continue;

      if(auth()->user()){

      if($event->private_event == true && !(Auth::user()->isAdmin() || Auth::user()->id == $event->owner_id || Auth::user()->isAttending($event->id) || Auth::user()->isInvited($event->id)))
        continue;
      }

      if($event->private_event && !(auth()->user()))
        continue;
        
        $image = App\Models\Event_Image::where('event_id', $event->id)->first();

        if ($image == null) {
          $image = '/images/placeholder-event.png';
        } else {
          $image = $image->image_url;
        }
    ?>

        <li class="item">
          <img class="imagefithome event" alt="Event photo" width="341px" height="226px" src="{{ $image }}">

          <h3>{{ $event->event_name }}</h3>
          <?php
          if ($event->price == 0) { ?>
            <p>{{ $event->start_date }} | {{ $event->location }} | Free</p>
          <?php } else { ?>
            <p>{{ $event->start_date }} | {{ $event->location }} | Price: {{ $event->price}}€</p>
          <?php } ?>
          <a class="btn btn-outline-info" href="/event/{{ $event->id }}" role="button">See more</a>
        </li>

    <?php
      }
    }  ?>


  </ul>
</div>

@include('layouts.footer')