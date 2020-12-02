

<div class="carousel-item active">

<img alt="" class="imagefit first-slide" src='{{$image->image_url }}'>
<div class="container">
  <div class="carousel-caption text-left">
    <h1>{{ $event->event_name }}</h1>
    <p>{{ $event->description }}</p>

    <b> <?php



        foreach ($tags as $tag) {
          echo '<a style="color:white" href= "/categories?tag='.$tag->tag. '">#' . $tag->tag . "</a>";
          echo " ";
        }

        ?> </b>


    <?php if (Auth::user() != null) {
      
      $alreadyAttending = false;
      $attending = App\Models\Event::find($event->id)->attending;
      foreach ($attending as $attend) {
        if ($attend->attendee_id == Auth::user()->id)
          $alreadyAttending = true;
      }
      if ($alreadyAttending) {
    ?>
        <p>

          <form action="{{ route('leave_event',$event->id) }}" method="POST">
            {{ csrf_field() }}
            <input class="form-control" type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id">
            <input class="form-control" type="hidden" value="{{ $event->id }}" name="event_id" id="event_id">
            <input class="btn btn-lg btn-danger commentbuttonheader" type="submit" name="upvote" value="Leave Event" />
            <a class="btn btn-lg btn-dark commentbuttonheader" href="/event/{{$event->id}}/ticket"> Print Ticket</a>
            </form>
        </p> <?php
            } else {
              if ($event->price == 0) {

              ?>

          <p>
            <form action="{{ route('attend_event', $event->id) }}" method="POST">
              {{ csrf_field() }}
              <input class="form-control" type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id">
              <input class="form-control" type="hidden" value="{{ $event->id }}" name="event_id" id="event_id">
              <input class="btn btn-lg btn-info commentbuttonheader" type="submit" name="upvote" value="Join Event" />
            </form>

          </p>

        <?php
              } else {
        ?>

          <p>
            <form method="POST" id="payment-form" action="{!! URL::to('paypal') !!}">
              {{ csrf_field() }}
              <input class="form-control" type="hidden" value="{{ $event->paypal }}" id="payee" name="payee">
              <input class="form-control" type="hidden" value="{{ $event->event_name }}" id="name" name="name">
              <input class="form-control" type="hidden" value="{{ $event->description }}" id="description" name="description">
              <input class="form-control" type="hidden" value="{{ $event->price }}" id="amount" name="amount">
              <input class="form-control" type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id">
              <input class="form-control" type="hidden" value="{{ $event->id }}" name="event_id" id="event_id">
              <input class="btn btn-lg btn-info" type="submit" name="upvote" value="Buy Ticket" />
            </form>

          </p>
    <?php
              }
            }
          } ?>
  </div>
</div>
</div>