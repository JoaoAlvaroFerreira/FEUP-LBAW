<!DOCTYPE html>
<html>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{ url('/') }}">
    <img src="{{ asset('images/logo.png') }}" alt="Meetcamp Logo" height="60px" width="260px">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/FAQ') }}">FAQ</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/About') }}">About Us</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/categories') }}">Tags</a>
      </li>



      @if (Auth::check())<?php
      $notifs = App\Models\Notification::where('target_id', Auth::user()->id)->get();
      $invites = App\Models\Invited::where('invited_id', Auth::user()->id)->get();
      ?>
      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          @if ($notifs->count() != 0)
          Notifications (<b>{{$notifs->count()}}</b>)
          @else
          Notifications
          @endif
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php



          
          foreach ($notifs as $notification) {

            
            switch ($notification->type) {
              case 0:
          ?>

                <a class="dropdown-item" href='/event/{{ $notification->origin_id }}'>{{$notification->description}}</a>

                <div class="dropdown-divider"></div>
              <?php
                break;
                case 1: ?>
                  <a class="dropdown-item" href='/event/{{ $notification->origin_id }}'>{{$notification->description}}</a>
  
                  <div class="dropdown-divider"></div>
            <?php
                  break;
                  case 2: ?>
                <div class="dropdown-item">{{$notification->description}}</div>

                <div class="dropdown-divider"></div>
          <?php
                break;
            }
          } ?>



        </div>

      </li>

      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          @if ($invites->count() != 0)
          Invites (<strong>{{$invites->count()}}</strong>)
          @else
          Invites
          @endif
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php




          foreach ($invites as $invitation) {

            $inviter = App\Models\User::find($invitation->inviter_id)->first();
          ?>

            <a class="dropdown-item" href='/event/{{ $invitation->event_id }}'>{{$inviter->name}} has invited you to an event!</a>


            <div class="dropdown-divider"></div>
          <?php

          } ?>



        </div>

      </li>

      <li class="nav-item">

        <a class="nav-link" href="/user/{{ Auth::user()->id }}">My Profile</a>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/logout') }}">Log Out</a>

      </li>
      <li class="nav-item">

      </li>


      <li class="nav-item">
      <a class="btn event_btn btn-info" role="button" href="{{ url('/create_event') }}">Add Event</a>      </li>

      @else

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Authentication
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ url('/login') }}">Sign In</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ url('/register') }}">Register</a>
        </div>
      </li>

      @endif






    </ul>

    <form action="/search" method="POST" role="search">
      {{ csrf_field() }}
      <div class="input-group">
        <input type="text" class="form-control" name="q" placeholder="Search"> <span class="input-group-btn">
          <button type="submit" class="btn btn-default">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </form>
  </div>
</nav>

</html>