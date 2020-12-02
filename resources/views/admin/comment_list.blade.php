@include('layouts.header')

@include('layouts.navbar')


<div class="mt-3 ml-3 md-3 mr-3">
<table class="table table-hover">
  <thead class="thead-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Reported User</th>
      <th scope="col">Comment</th>
      <th scope="col">Report Note</th>
      <th scope="col">Link</th>
      <th scope="col">Dismiss</th>
    </tr>
  </thead>
  <tbody>
    <?php  

    $reports = App\Models\Report::all();

    foreach($reports as $report){
   
     $comment = App\Models\Comment::find($report->comment_id);
      $commenter = App\Models\User::find($comment->commenter_id);
      ?>
    
    <tr>
      <th scope="row">{{$report->id}}</th>
      <td><a href="/user/{{$commenter->id}}">{{$commenter->name}}</a></td>
      <td>{{$comment->content}}</td>
      <td>{{$report->report_note}}</td>
      <td><a type="button" class="btn btn-info" href="/event/{{$comment->event_id}}">See Origin</a></td>
      <div class="form-group">
        <form action="{{route('report.delete', ['id' => $report->id])}}" method="post">
          <td><input class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit" value="Remove Report" /></td>
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