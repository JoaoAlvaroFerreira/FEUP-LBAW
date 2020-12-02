@include('layouts.header')

@include('layouts.navbar')

<div class="bg">
    <div class="card text-center transparent-card p-3 mx-auto">

        <form class="container form-signin" method="POST" action="{{ route('password_recovery_code_input') }}">
            {{ csrf_field() }}
            <h1 class="h3 mb-3 h1-responsive font-weight-light text-center">Your E-Mail</h1>
            <h6>A message will be sent to this address. Make sure you insert an e-mail associated with a Meetcamp account.</h6>



            <div class="form-group row justify-content-center">
                <div class="col-md-7">
                    <label class="sr-only" for="password">E-Mail</label>
                    <input class="form-control" placeholder="E-Mail" id="email" type="email" name="email" required>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary" type="submit">
                    Send Code
                </button>
            </div>
        </form>


    </div>
</div>

@include('layouts.footer')