@include('layouts.header')

@include('layouts.navbar')

@if (session('user_update'))
<div class="alert alert-success">
<p>{{ session('user_update') }}</p>
</div>
@endif

<div class="app">
  <div class="row">
    <div class="d-flex justify-content-center col-sm-6 col-md-6">

      <?php

      if ($user->banned) {
       $user->bio = "[This user has been banned.]";
      }

      if ($user->photo == null) {
        $photo = '/images/placeholder-event.png';
      } else {
        $photo = $user->photo;
      }
      ?>

      <img alt="Profile picture" class="imagefituserpro" src="{{ $photo }}">
    </div>
    <div class="row">
      <div class="col-md-6 col-md-border"></div>
      <div class="col-md-6 col-md-border"></div>
    </div>

    <div class="col-sm-5 col-md-5">
      <blockquote>
        <h3 class="usertext">{{ $user->name }}</h3> <small><cite title="Source Title"></cite></small>
        <h6 class="usertext" >Joined on {{ $user->join_date }}</h6>
      </blockquote>
      <p class="usertext">
        <br /> <i class="glyphicon glyphicon-globe"></i> Status: {{ $user->bio }}
        <br /> </p>
      <div class="col-md-8">
                            @if (Auth::user()->id == $user->id)
          <a class="btn btn-outline-info userbutton" href="/edit_user/{{ $user->id }}" type="submit">Edit Profile</a>
          <form method="POST" id="deleteNotifications" action="{{ route('user.deleteNotifications',$user->id) }}">
            {{ csrf_field() }}
            <input type="hidden" id="notification_id" name="notification_id" value="{{ $user->id }}" />
            <button class="btn btn-outline-danger userbutton" type="submit">Delete Notifications</button>
          </form>
          <form method="POST" id="deleteInvitations" action="{{ route('user.deleteInvitations',$user->id) }}">
            {{ csrf_field() }}
            <input type="hidden" id="invitation_id" name="invitation_id" value="{{ $user->id }}" />
            <button class="btn btn-outline-danger userbutton" type="submit">Delete Invitations</button>
          </form>
          @endif
          @if(Auth::user()->isAdmin())

          <form method="POST" id="banUser" action="/banUser">
            {{ csrf_field() }}
            <input type="hidden" id="ban_id" name="ban_id" value="{{ $user->id }}" />
            <input class="btn btn-danger userbutton"  onclick="return confirm('Are you sure?')" type="submit" value="Ban User"/>
          </form>

          <form method="POST" id="deleteUser" action="/deleteUser">
            {{ csrf_field() }}
            <input type="hidden" id="delete_id" name="delete_id" value="{{ $user->id }}" />

            <input  class="btn btn-danger userbutton" onclick="return confirm('Are you sure?')"  type="submit" value="Delete User"/>
          </form>
        @endif
      </div>
    </div>
  </div>


  <!-- Attending Events -->
  <div class="app">
    <h2 class="title">Attending events</h2>

    <ul class="hs">


      <?php


      $events = App\Models\Event::orderBy('start_date', 'asc')->get();

      $attending_user = App\Models\Attending::orderBy('attendee_id', 'asc')->get();

      foreach ($events as $event) {
        foreach ($attending_user as $attending) {
          if ($attending->event_id == $event->id && $attending->attendee_id == $user->id) {

            $image = App\Models\Event_Image::where('event_id', $event->id)->first();

            if ($image == null) {
              $image = '/images/placeholder-event.png';
            } else {
              $image = $image->image_url;
            }
      ?>

            <li class="item">
              <img alt="Attending event photo" class="imagefithome event" width="341px" height="226px" src="{{ $image }}">

              <h3>{{ $event->event_name }}</h3>
              <p>{{ $event->start_date }} | {{ $event->location }}</p>
              <a class="btn btn-outline-info" href="/event/{{ $event->id }}" role="button">See more</a>
            </li>
      <?php
          }
        }
      } ?>




    </ul>
  </div>



  <!-- Created events -->


  <div class="app">
    <h2 class="title">Created events</h2>

    <ul class="hs">


      <?php


      $events = App\Models\Event::orderBy('start_date', 'asc')->get();

      foreach ($events as $event) {
        if ($event->owner_id == $user->id) {

          $image = App\Models\Event_Image::where('event_id', $event->id)->first();

          if ($image == null) {
            $image = '/images/placeholder-event.png';
          } else {
            $image = $image->image_url;
          }
      ?>

          <li class="item">
            <img alt="Created event photo" class="imagefithome event" width="341px" height="226px" src="{{ $image }}">

            <h3>{{ $event->event_name }}</h3>
            <p>{{ $event->start_date }} | {{ $event->location }}</p>
            <a class="btn btn-outline-info" href="/event/{{ $event->id }}" role="button">See more</a>
          </li>
      <?php
        }
      }  ?>




    </ul>
  </div>




  @include('layouts.footer')