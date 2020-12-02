@include('layouts.header')

@include('layouts.navbar')

<div class="bg">
    <div class="card text-center transparent-card p-3 mx-auto">

        <form class="container form-signin" method="POST" action="{{ route('password_update') }}">
            {{ csrf_field() }}
            <h1 class="h3 mb-3 h1-responsive font-weight-light text-center">New Password</h1>


            <input class="form-control" value="{{$user}}" id="user" type="hidden" name="user">

            <div class="form-group row justify-content-center">
        <div class="col-md-7">
          <label class="sr-only" for="password">Password</label>
          <input class="form-control" placeholder="Password" id="password" type="password" name="password" required>
          @if ($errors->any())
          <span class="error">
          {{ $errors->first() }}
          </span>
          @endif
        </div>
      </div>

      <div class="form-group row justify-content-center">
        <div class="col-md-7">
          <label class="sr-only" for="password-confirm">Confirm Password</label>
          <input class="form-control" placeholder="Password Confirmation" id="password-confirm" type="password" name="password_confirmation" required>
        </div>
      </div>
      <div class="text-center">
        <button class="btn btn-primary" type="submit">
          Update Password
        </button>
      </div>
        </form>


    </div>
</div>

@include('layouts.footer')