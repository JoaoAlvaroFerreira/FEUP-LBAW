@include('layouts.header')

@include('layouts.navbar')

<div class="container" style="padding-top: 60px;">
  <h1 class="page-header usertext3">Edit Profile</h1>


<fieldset>
      <form method="post" action="{{ route('user.update', $user->id) }}" role="form" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        
        <div class="row">
        <!-- left column -->
        <div class="form-group row usertext">
          
          <label for="photo" class=" col-md-4 col-form-label text-md-right">Profile Image</label>
          <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="This is your profile picture. Recommended square image for formatting." alt="" src="/images/tooltip.png"></img>

            <div class="col-md-6">
            <input class="chooseimage" id="photo" type="file" class="form-control" name="photo">
              @if (auth()->user()->photo)
             @endif
            <p> <div class="alert alert-info userinfo" role="alert">
              For better results, choose a square image.
            </div>
            </div>
         </div>
         
        <!-- Col Separator-->
        <div class="row">
          <div class="col-md-6 col-md-border"></div>
          <div class="col-md-6 col-md-border"></div>
        </div>
        <!-- EDIT FORM - NEEDS TO INCLUDE IMAGE NOW -->
        <div class="col-md-5 col-sm-6 col-xs-11 personal-info">

          <legend>Personal info</legend>

        <div class="form-group">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="The name other users will know you for in the website." alt="" src="/images/tooltip.png"></img>

          <label class="col-lg-5 control-label usertext2">Full Name:</label>
          <div class="col-lg-8">
            <input class="form-control" type="text" name="name" value="{{ $user->name }}" />
          </div>
        </div>
        <div class="form-group">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="A brief description to be displayed on your profile page." alt="" src="/images/tooltip.png"></img>

          <label class="col-lg-3 control-label usertext2">Bio:</label>
          <div class="col-lg-8">
            <input class="form-control" name="bio" value="{{ $user->bio }}" type="text">
          </div>
        </div>
        <div class="form-group">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="The e-mail you'll use for logins, must be valid. It will also be used for password recovery." alt="" src="/images/tooltip.png"></img>

          <label class="col-lg-3 control-label usertext2">Email:</label>
          <div class="col-lg-8">
            <input class="form-control" type="email" name="email" value="{{ $user->email}}" />
          </div>
        </div>

       
        
        <div class="form-group">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="Your existing password, to confirmation your identity." alt="" src="/images/tooltip.png"></img>

          <label class="col-lg-8 control-label usertext2" for="password">Password <b>(Mandatory for any change)</b></label>
          <div class="col-lg-8">
          <input class="form-control" placeholder="Password" id="password" type="password" name="password" required>
          @if ($errors->has('password'))
          <span class="error">
            {{ $errors->first('password') }}
          </span>
          @endif
          </div>
        </div>
    


        <div class="form-group">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="A new password field, if you want to change your password." alt="" src="/images/tooltip.png"></img>

          <label class="col-lg-7 control-label usertext2" for="new-password">New Password</label>
          <div class="col-lg-8">
          <input class="form-control" placeholder="New Password" id="new-password" type="password" name="new-password">
          </div>
        </div>


        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">
            <button class="btn btn-info " type="submit">Submit Changes!</button>
            <span></span>
            <a class="btn btn-outline-info " href="/user/{{ $user->id }}" type="submit">Cancel</a>

          </div>
        </div>
</fieldset>
      </form>
      <!-- DELETE FORM -->
      <div class="form-group">
        <form action="{{route('user.delete', $user->id)}}" method="post">
        <input type="hidden" id="delete_id" name="delete_id" value="{{ $user->id }}" />

          <input class="btn btn-danger userbutton2" onclick="return confirm('Are you sure?')" type="submit" value="Delete" />
          @method('delete')
          @csrf
          <p> <div class="alert alert-danger userdanger usertext" role="alert">
           <b> Warning: </b> This will delete your entire user profile.
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
<b></b>



@include('layouts.footer')