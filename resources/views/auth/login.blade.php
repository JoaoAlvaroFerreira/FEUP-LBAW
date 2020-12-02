@include('layouts.header')

@include('layouts.navbar')

<div class="bg">
    <div class="card text-center transparent-card p-3 mx-auto">

        <form class="container form-signin" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
           
            <h1 class="h3 mb-3 h1-responsive font-weight-light text-center">Sign In</h1>
            <div class="form-group row justify-content-center">
                <div class="col-md-7">
                    <label class="sr-only"  for="email">E-mail</label>
                    <input class="form-control" id="email" placeholder="E-Mail Address" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                    <span class="error">
                        {{ $errors->first('email') }}
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <div class="col-md-7">

                    <label class="sr-only"  for="password">Password</label>
                    <input class="form-control" id="password" placeholder="Password" type="password" name="password" required>
                    @if ($errors->has('password'))
                    <span class="error">
                        {{ $errors->first('password') }}
                    </span>
                    @endif
                </div>
            </div>
            
            <div class="text-center">
                <button class="btn btn-primary" type="submit">
                    Sign In
                </button>
               
            </div>
           
        </form>
        <div class="text-center mt-2">
            <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
            <br>
            <p>Forgot your password? <a href="/password_recovery_email_input">Click here!</a></p>
            </div>

           
    </div>
</div>

@include('layouts.footer')