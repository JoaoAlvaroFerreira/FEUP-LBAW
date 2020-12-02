@include('layouts.header')

@include('layouts.navbar')

@if (session('event_deleted'))
<div class="alert alert-info">
  {{ session('event_deleted') }}
</div>
@endif

<div class="mt-3 ml-3 md-3 mr-3">
<table class="table table-hover">
  <thead class="thead-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Event Name</th>
      <th scope="col">Description</th>
      <th scope="col">Attendants</th>
      <th scope="col">Type</th>
      <th scope="col"><img data-toggle="tooltip" width="15" height="15" data-placement="top" title="Events with currently reported comments will appear here as 'Attention required'." src="/images/tooltip_inverted.png"></img>
      </th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php  

    $events = App\Models\Event::all();

    foreach($events as $event){
   
      $comments = App\Models\Comment::where('event_id', $event->id);
      $reported = false;
      $attendants = count($event->attending);
      foreach($comments->get() as $comment) {

        
        $reports = App\Models\Report::where('comment_id', $comment->id);
        foreach($reports->get() as $report)
          $reported = true;
        }
      ?>
    
    <tr>
      <th scope="row">{{$event->id}}</th>
      <td><a href="/event/{{$event->id}}">{{$event->event_name}}</a></td>
      <td>{{$event->description}}</td>
      <td>{{ $attendants }}</td>
      @if($event->private_event != null)
      <td>Private</td>
      @else
      <td>Public</td>
      @endif
      @if($reported == true)
      <td><a type="button" class="btn btn-info" href="/event/{{$event->id}}">Attention required</a></td>
      @else
      <td></td>
      @endif
      <div class="form-group">
        <form action="{{route('event.delete', ['id' => $event->id])}}" method="post">
          <td><input class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit" value="Delete Event" /></td>
          @method('delete')
          @csrf
        </form>

      </div>
    </tr>
    
<?php 
    }?>
  </tbody>
</table>
</div>


@include('layouts.footer')