@include('layouts.header')

@include('layouts.navbar')

@if (session('account_banned_deleted'))
<div class="alert alert-info">
  {{ session('account_banned_deleted') }}
</div>
@endif

<div class="mt-3 ml-3 md-3 mr-3">
  <table class="table table-hover">
    <thead class="thead-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Join Date</th>
        <th scope="col">Action</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <?php

    $users = App\Models\User::all();

    foreach ($users as $user) {

    ?>

      <tr>
        <th scope="row">{{$user->id}}</th>
        <td><a href="/user/{{$user->id}}">{{$user->name}}</a></td>
        <td>{{$user->join_date}}</td>
        @if($user->banned)
        <td><button type="button" class="btn btn-secondary btn-lg">Banned</button></td>
        @else
        <form method="POST" id="banUser" action="/banUser">
            {{ csrf_field() }}
            <input type="hidden" id="ban_id" name="ban_id" value="{{ $user->id }}" />
          <td><button class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit">Ban</button></td>
        </form>
        @endif
        <div class="form-group">
          <form method="POST" id="deleteUser" action="/deleteUser">
            <input type="hidden" id="delete_id" name="delete_id" value="{{ $user->id }}" />
            <td><input class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit" value="Delete" /></td>
            @csrf
          </form>

        </div>


      </tr>
    <?php
    } ?>

  </table>
</div>


@include('layouts.footer')