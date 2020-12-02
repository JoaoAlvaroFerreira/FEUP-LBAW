@include('layouts.header')

@include('layouts.navbar')


<?php

use App\Models\Event_Image;
use App\Models\Option;
use App\Models\Poll;
use App\Models\User;

$images = $event->images;
$image_count = $event->images->count();
$tags = $event->tags;


if ($image_count == 0) {
  $image_count = 1;
  $has_images = false;
} else {

  $has_images = true;
}
?>

<div id="myCarousel" class="carousel slide" data-interval="false" data-ride="carousel">
  <ol class="carousel-indicators">
    <?php for ($i = 0; $i < $image_count; $i++) { ?>

      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <!-- <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li> -->
    <?php } ?>
  </ol>

  <div class="carousel-inner">
    <?php if ($has_images) {
      $counter = 0;
      foreach ($images as $image) {

        if ($counter == 0) { ?>

          @include('layouts.event_header')

        <?php } else { ?>

          @include('layouts.event_header_secondary')
      <?php
        }
        $counter++;
      }
    } else {
      $image = new Event_Image();
      $image->image_url = '/images/placeholder-event.png';
      ?>
      @include('layouts.event_header')

    <?php } ?>
  </div>
  <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


<!-- Modal ATTENDING-->
<?php if (Auth::user() != null){ ?>
<div class="modal fade" id="attending_modal" tabindex="-1" role="dialog" aria-labelledby="attending_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="attending_modal_title">Attending List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?PHP
        $attending = $event->attending;

        foreach ($attending as $attendee) {
          $user = App\Models\User::find($attendee->attendee_id);

        ?>


          <p>


            <form action="{{ route('remove_attendant', $event->id) }}" method="POST">
              {{ csrf_field() }}
              <img alt="Attendee profile photo" src="{{ $user->photo }}" width='50' height='50' class="img-circle">
              <a href="../user/{{ $user->id }}"> {{ $user->name }} </a>
              <input class="form-control" type="hidden" value="{{ $user->id }}" name="user_id" id="user_id">
              <input class="form-control" type="hidden" value="{{ $event->id }}" name="event_id" id="event_id">
              @if(Auth::user()->id == $event->owner_id || Auth::user()->isAdmin())
              <button class="btn btn-outline-danger btnatten" type="submit">Remove</button>
              @endif
            </form>
          </p>
        <?php
        }

        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>


<!-- Modal DETAILS-->
<div class="modal fade" id="details_modal" tabindex="-1" role="dialog" aria-labelledby="details_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="details_modal_title">Event Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        $owner = User::find($event->owner_id); ?>
        <p><strong>Event Host: </strong><a href="/user/{{ $event->owner_id }}"> {{ $owner->name}} </a></p>
        <p><strong>Location: </strong>{{ $event->location}} </p>
        <p><strong>Description: </strong>{{ $event->description}} </p>

        <?php if ($event->end_date != null) {
        ?>
          <p><strong>Start Date: </strong>{{ $event->start_date}} </p>
          <p><strong>End Date: </strong>{{ $event->end_date}} </p>
        <?php
        } else { ?>

          <p><strong>Event Date: </strong>{{ $event->start_date}} </p>



        <?php
        }
        if ($event->private_event) { ?>
          <strong>Private Event</strong>
        <?php
        } else { ?>
          <strong>Public Event</strong>

        <?php
        } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal INVITE-->
<?php if (Auth::user() != null){ ?>
<div class="modal fade" id="invite_modal" tabindex="-1" role="dialog" aria-labelledby="invite_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="invite_modal_title">Invite</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php
        if (Auth::user() != null) { ?>



          <?PHP
          $all_users = App\Models\User::all();

          foreach ($all_users as $listed_user) {

            if ($listed_user->id != Auth::user()->id) {
          ?>

              <form>
                <img alt="Invitee profile photo" src="{{ $listed_user->photo }}" width='50' height='50' class="img-circle">



                <a href="../user/{{ $listed_user->id }}"> {{ $listed_user->name }} </a>
                <button class="btn btn-outline-primary" type='button' onclick="make_invite({{ Auth::user()->id}},{{$listed_user->id}},{{ $event->id }})" id="{{$listed_user->id}}">Send Invite</button>
              </form>



          <?php
            }
          }
        } else {

          ?>
          <a href="/login">Log in</a> or <a href="/register">register</a> to invite a friend!
        <?php
        }

        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
      <?php } ?>


<!-- Modal MAKE POLL-->
<?php if (Auth::user() != null){ ?>
<div class="modal fade" id="poll_modal" tabindex="-1" role="dialog" aria-labelledby="poll_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <div class="modal-header">

        <h5 class="modal-title" id="poll_modal_title">Make Poll</h5>

      </div>
      <div class="modal-body">


        <form class="container" method="POST" id="poll" action="{{ route('make_poll',$event->id) }}" enctype="multipart/form-data">
          <div class="container_form_poll">
            {{ csrf_field() }}
            <button class="add_form_field">Add New Field &nbsp; <span>+ </span></button>
            <input class="form-control" type="text" name="question" placeholder="Question" id="question">
            <div><input type="text" class="form-control" placeholder="Poll Option 0" name="poll_option_0" id="poll_option_0"></div>
          </div>

          <input class="form-control" type="hidden" value="{{ $event->id }}" name="event_id" id="event_id">
          <input class="form-control" type="hidden" value="{{ Auth::user()->id }}" name="target_id" id="target_id">
          <button type="submit" class="btn btn-info pull-right commentbutton">Submit</button>
      </div>
      </form>

    </div>
    <div class="modal-footer">

    </div>
  </div>
</div>
</div>
<?php } ?>




<?php
if (Auth::user() != null) {
  if (Auth::user()->id == $event->owner_id) { ?>
    <div class="text-center mb-5"><a class="btn btn-info userbutton2" href='/event/{{ $event->id }}/edit' role="button">Edit Event &raquo;</a></div>
<?php }
} ?>





<!-- Marketing messaging and featurettes
      ================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->

<div class="container mb-3">

  <!-- Three columns of text below the carousel -->
  <div class="row">
    <div class="col-lg-4 mb-5">
      <img class="rounded-circle" src="https://i.pinimg.com/280x280_RS/84/84/c9/8484c92ab73a817bd26da4f46bd11895.jpg" alt="" width="140" height="140">
      <h2>Going</h2>
      <p>See who is attending this event
        <br>

        <?php

        $attending = App\Models\Event::find($event->id)->attending;

        echo count($attending);
        echo " attending";

        ?>
      </p>
      <p><button type="button" data-sm-link-text="Attendee List" class="btn btneve effect04" data-toggle="modal" data-target="#attending_modal">
          See List &raquo;
        </button>
      </p>
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-4">
      <img class="rounded-circle" src="https://papers.co/wallpaper/papers.co-nf96-road-night-car-street-light-blue-dark-flare-40-wallpaper.jpg" alt="" width="140" height="140">
      <h2>Details</h2>
      <p>See event details such as venue address, time and date.


      </p>
      <p><button data-sm-link-text="Event Details" class="btn btneve effect04" data-toggle="modal" type="button" data-target="#details_modal">View details &raquo;</button></p>
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-4">
      <img class="rounded-circle" src="https://d33x644h9xoqir.cloudfront.net/wp-content/uploads/2020/03/group-of-people-sitting-on-white-mat-on-grass-field-745045-300x300.jpg" alt="" width="140" height="140">
      <h2>Share with your friends</h2>
      <p>Invite others that might be interested in the event.</p>
      <p><button data-sm-link-text="Share Event" class="btn btneve effect04" data-toggle="modal" type="button" data-target="#invite_modal">Share &raquo;</button></p>
    </div><!-- /.col-lg-4 -->
  </div><!-- /.row -->
</div>




<?php if (Auth::user() != null) {   ?>
  <button data-sm-link-text="Make Poll" class="btn btneve2 effect04 pull-center" data-toggle="modal" type="button" data-target="#poll_modal">Make Poll &raquo;</button></p>

  <div class="comments mx-auto">
    <div class="row">
      <div class="col-md-offset-2 col-sm-12">
        <div class="comment-wrapper">
          <div class="panel panel-info">
            <div class="panel-heading">
            <h4 class="commenttext">Poll panel</h4><br>
              <div class="panel-body">

                <?php


                $polls = Poll::where('event_id', $event->id)->get();
                if($polls->isEmpty())
                echo "No polls have been made";
                foreach ($polls as $poll) {

                  $options = Option::where('poll_id', $poll->id)->get();
                  $poll_maker = User::findOrFail($poll->target_id);
                  if ($poll->ifVote(Auth::user()->id)) {
                ?>
                    <div class="commenttext" id="poll_results{{$poll->id}}">

                    <h2 class="polltxt">{{ $poll->question }}</h2>
                    <h5>Poll by {{ $poll_maker->name }}</h5>
                      <table>
                        <?php foreach ($options as $option) {

                        ?>
                          <tr>

                            <td > {{ $option->content }}</td>
                            <td class="commenttext"> <b> - Votes({{ $option->votes() }}) </b></td>

                          </tr>
                        <?php } ?>

                      </table>

                      @if(auth()->user())

                      <?php
                      if (Auth::user()->id == $event->owner_id || Auth::user()->isAdmin() || Auth::user()->id == $poll->target_id) { ?>
                        <div class="form-group">

                        <br>
                          <form action="{{route('poll.delete', ['id' => $poll->target_id,'poll_id' => $poll->id])}}" method="post">
                            <input class="btn btn-outline-danger commemtbutton" onclick="return confirm('Are you sure?')" type="submit" value="Delete" />
                            @method('delete')
                            @csrf
                          </form>
                        </div>

                      <?php } ?>
                      @endif
                    </div>
                  <?php
                  } else {
                  ?>
                    <div id="poll{{$poll->id}}">
                      <h3 class="polltxt">{{ $poll->question }}</h3>
                      <form class="pollcontent">
                        <?php
                        foreach ($options as $option) {
                        ?>
                        <input type="radio" name="vote" value="{{ $option->content }}" onclick="getVote(this.value, {{ $poll->id }}, {{ Auth::user()->id }})"> {{ $option->content }} <br> 
                        <?php } ?>
                      </form>
                    </div>
                <?php
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
<?php } ?>





  <div class="comments mx-auto">
    <div class="row">
      <div class="col-md-offset-2 col-sm-12">
        <div class="comment-wrapper">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h4 class="commenttext">Comment panel</h4><br>
            </div>
            <div class="panel-body">
              @if (Auth::user() != null)
              <form class="container" method="POST" id="comment" action="{{ route('comment') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <input class="form-control" type="hidden" value="{{ $event->id }}" name="event_id" id="event_id">
                <input class="form-control" type="hidden" value="{{ Auth::user()->id }}" name="commenter_id" id="commenter_id">
                <textarea class="form-control" form="comment" id="content" name="content" placeholder="write a comment..." required></textarea>
                <br><input class="chooseimage" type="file" name="comment_image" id="comment_image">
                <br>
                <button type="submit" class="btn btn-info pull-right commentbutton">Post</button>
              </form>
              @endif
              <div class="clearfix"></div>
              <hr>
              <ul class="media-list">

                <?php
                $comments = App\Models\Event::find($event->id)->comments;
                $reported = false;
                foreach ($comments as $comment) {

                  $reports = App\Models\Report::where('comment_id', $comment->id);
                  foreach ($reports->get() as $report)
                    $reported = true;

                  $commenter = App\Models\User::find($comment->commenter_id) ?>



                  <li class="media">
                    <a href="../user/{{ $commenter->id }}" class="pull-left">
                      <img src="{{ $commenter->photo }}" width='40' height='40' alt="Commenter photo" class="img-circle">
                    </a>

                    <div class="media-body">

                      <strong class="text-info comment"><a href="../user/{{ $commenter->id }}">{{ $commenter->name }}</a></strong>
                      
                      @if(auth()->user() && Auth::user()->isAdmin() && $reported == true)
                      <p style="color:red" class="comment">
                        {{ $comment->content }}
                      </p>

                      @else
                      <p class="comment">

                        {{ $comment->content }}
                      </p>
                      @endif
                      
                      @if($comment->photo != null)
                      <strong class="comment" width="100px" height="100px">Submitted Image:</strong>

                      @endif
                    </div>



                    @if(auth()->user())

                    <?php
                    if (Auth::user()->id == $event->owner_id || Auth::user()->isAdmin() || Auth::user()->id == $commenter->id) { ?>
                      <div class="form-group">

                        <form action="{{route('comment.delete', ['id' => $event->id,'comment_id' => $comment->id])}}" method="post">
                          <input class="btn btn-outline-danger commentbutton" onclick="return confirm('Are you sure?')" type="submit" value="Delete" />
                          @method('delete')
                          @csrf
                        </form>
                      </div>

                    <?php } ?>
                    @endif

                    @if(auth()->user())
                    <!---REPORT MODAL -->
                    <a class="btn btn-outline-warning commentbutton" id="reportModal{{ $comment->id }}button" data-toggle="collapse" href="#reportModal{{ $comment->id }}" role="button" aria-expanded="false" aria-controls="reportModal{{ $comment->id }}">
                      Report
                    </a>
                    <div class="collapse" id="reportModal{{ $comment->id }}">
                      <div class="card card-body">
                        <form>
                          <label for="description">Reason for report:</label>
                          <input class="form-control" type="hidden" value="{{ $comment->id }}" name="comment_id" id="comment_id">
                          <input class="form-control" placeholder="Describe..." id="report_description.{{ $comment->id }}" type="text" name="report_description.{{ $comment->id }}" autofocus>
                          @if ($errors->has('event_name'))
                          <span class="error">
                            {{ $errors->first('event_name') }}
                          </span>
                          @endif
                          <button class="btn btn-sm btn-outline-info commentbutton" type='button' onclick="make_report({{ $comment->id }})" id="{{$listed_user->id}}">Submit Report</button>
                        </form>
                      </div>
                    </div>
                    @endif
                  </li>
                  @if($comment->photo != null)

                  <img alt="File uploaded by commenter" src="{{ $comment->photo }}" class="img-responsive imagefitcomment">


                  @endif
                <?php
                  $reported = false;
                }

                ?>

              </ul>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <br></br>
  <!--  DELETE FORM -->

  @if(auth()->user())
  <?php
  if (Auth::user()->id == $event->owner_id || Auth::user()->isAdmin()) { ?>
    <div class="form-group text-center">
      <form action="{{route('event.delete', $event->id)}}" method="post">
        <input class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit" value="Delete Event" />
        @method('delete')
        @csrf
      </form>

    </div>
  <?php } ?>
  @endif
  @include('layouts.footer')