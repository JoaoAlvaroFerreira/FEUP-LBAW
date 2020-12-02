@include('layouts.header')

@include('layouts.navbar')

<div class="bg">
  <div class="card text-center transparent-card p-3 mx-auto">

    <form class="container form-signin" method="POST" action="{{ route('register') }}">
      {{ csrf_field() }}
      <h1 class="h3 mb-3 h1-responsive font-weight-light text-center">Register</h1>

      <div class="form-group row justify-content-center">
      <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="The name other users will know you for in the website." src="/images/tooltip.png"></img>
         
        <div class="col-md-7">
          <label class="sr-only" for="name">Name</label>
          <input class="form-control" placeholder="Full Name" id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
          @if ($errors->has('name'))
          <span class="error">
            {{ $errors->first('name') }}
          </span>
          @endif
        </div>
      </div>

      <div class="form-group row justify-content-center">
      <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="The e-mail you'll use for logins, must be valid. It will also be used for password recovery." src="/images/tooltip.png"></img>
         
        <div class="col-md-7">
          <label class="sr-only" for="email">E-Mail Address</label>
          <input class="form-control" placeholder="E-Mail Address" id="email" type="email" name="email" value="{{ old('email') }}" required>
          @if ($errors->has('email'))
          <span class="error">
            {{ $errors->first('email') }}
          </span>
          @endif
        </div>
      </div>

      <div class="form-group row justify-content-center">
      <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="Your password, which must be over 6 characters." src="/images/tooltip.png"></img>
         
        <div class="col-md-7">
          <label class="sr-only" for="password">Password</label>
          <input class="form-control" placeholder="Password" id="password" type="password" name="password" required>
          @if ($errors->has('password'))
          <span class="error">
            {{ $errors->first('password') }}
          </span>
          @endif
        </div>
      </div>

      <div class="form-group row justify-content-center">
      <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="This field must be the same as the password inserted above." src="/images/tooltip.png"></img>
         
        <div class="col-md-7">
          <label class="sr-only" for="password-confirm">Confirm Password</label>
          <input class="form-control" placeholder="Password Confirmation" id="password-confirm" type="password" name="password_confirmation" required>
        </div>
      </div>
      <div class="text-center">
        <button class="btn btn-primary" type="submit">
          Register
        </button>

      </div>
   
    </form>
    <div class="text-center mt-2">
        <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
      </div>
  </div>
   
</div>


@include('layouts.footer')