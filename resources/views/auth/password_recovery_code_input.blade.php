@include('layouts.header')

@include('layouts.navbar')

<div class="bg">
    <div class="card text-center transparent-card p-3 mx-auto">

        <form class="container form-signin" method="POST" action="{{ route('password_recovery_new_pass') }}">
            {{ csrf_field() }}
            <h1 class="h3 mb-3 h1-responsive font-weight-light text-center">Code:</h1>

            <input class="form-control" value="{{$code}}" id="code" type="hidden" name="code">
            
            <input class="form-control" value="{{$user}}" id="user" type="hidden" name="user">


            <div class="form-group row justify-content-center">
                <div class="col-md-7">
                    <label class="sr-only" for="password">Code</label>
                    <input class="form-control" placeholder="Code" id="code_input" type="text" name="code_input" required>
                    @if ($errors->any())
                    <span class="error">
                        {{ $errors->first() }}
                    </span>
                    @endif
                </div>
            </div>

            <div class="text-center">
        <button class="btn btn-primary" type="submit">
          Submit Code
        </button>
      </div>
        </form>


    </div>
</div>

@include('layouts.footer')