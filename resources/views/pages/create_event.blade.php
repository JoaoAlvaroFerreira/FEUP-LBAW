@include('layouts.header')

@include('layouts.navbar')

@if (session('fail'))
    <div class="alert alert-danger">
        {{ session('fail') }}
    </div>
@endif

<form class="container form-signin" method="POST" action="{{ route('create_event') }}" enctype="multipart/form-data">
    {{ csrf_field() }}

    <br></br>
    <input class="form-control" type="hidden" value="{{ Auth::user()->id }}" name="owner_id" id="owner_id">
    <h1 class="h3 h1-responsive font-weight-light text-center mb-3">New Event</h1>

    <div class="form-group row justify-content-center">
    <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="The name of the event." src="/images/tooltip.png"></img>
           
        <div class="col-md-7">
       
            <label class="sr-only" for="event_name">Name</label>
            <input class="form-control" placeholder="Name *" id="event_name" type="text" name="event_name" value="{{ old('event_name') }}" required autofocus>
            @if ($errors->has('event_name'))
            <span class="error">
                {{ $errors->first('event_name') }}
            </span>
            @endif
        </div>
    </div>


    <div class="form-group row justify-content-center">
    <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="A description for the event." src="/images/tooltip.png"></img>
           
        <div class="col-md-7">
            <label class="sr-only" for="description">Description</label>
            <input class="form-control" placeholder="Description *" id="description" type="text" name="description" value="{{ old('description') }}" required autofocus>
            @if ($errors->has('description'))
            <span class="error">
                {{ $errors->first('description') }}
            </span>
            @endif
        </div>
    </div>

    <div class="form-group row justify-content-center">
    <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="The cost of entry for the event. Must be a whole number. If the event is free, set it as 0. If not, a Paypal address is also required." src="/images/tooltip.png"></img>
           
        <div class="col-md-7">
            <label class="sr-only" for="description">Price</label>
             <input class="form-control" placeholder="Price *" id="price" type="number" name="price" value="{{ old('price') }}" required autofocus>
            @if ($errors->has('price'))
            <span class="error">
                {{ $errors->first('price') }}
            </span>
            @endif
        </div>
    </div>


    <div class="form-group row justify-content-center">
    <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="The billing address for tickets bought. Can be left blank if the event is free, but is mandatory for paid events." src="/images/tooltip.png"></img>
            
        <div class="col-md-7">
            <label class="sr-only" for="description">Paypal</label>
            <input class="form-control" placeholder="Paypal" id="paypal" type="text" name="paypal" value="{{ old('paypal') }}" autofocus>
            @if ($errors->has('paypal'))
            <span class="error">
                {{ $errors->first('paypal') }}
            </span>
            @endif
        </div>
    </div>


    <div class="form-group row justify-content-center">
    <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="The opening date for the event. If the event only has one day, this date  serves as the only event date." src="/images/tooltip.png"></img>
           
        <div class="col-md-7">
            <label class="sr-only" for="date">Start Date</label>
            <input class="form-control" placeholder="Start Date *" id="start_date" type="date" name="start_date" required autofocus>
            @if ($errors->has('start_date'))
            <span class="error">
                {{ $errors->first('start_date') }}
            </span>
            @endif
        </div>*
    </div>

    <div class="form-group row justify-content-center">
    <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="This element represents the ending date for a multi-day event. It should be left empty if the event only has one date." src="/images/tooltip.png"></img>
           
        <div class="col-md-7">
            <label class="sr-only" for="date">End Date</label>
            
             <input class="form-control" placeholder="End Date" id="end_date" type="date" name="end_date" autofocus>
            @if ($errors->has('end_date'))
            <span class="error">
                {{ $errors->first('end_date') }}
            </span>
            @endif
        </div>
    </div>

    <div class="form-group row justify-content-center">
    <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="Tags to label the event as, separate each tag with space." src="/images/tooltip.png"></img>
        
        <div class="col-md-7">
            
          <input type="text" name="tags" id="tags" class="form-control" placeholder="Tags" autofocus="">
        </div>
    </div>


    <div class="form-group row justify-content-center">
    <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="A cover image for the event. More images can be added by editing the event." src="/images/tooltip.png"></img>
           
        <div class="col-md-7">
            <label class="sr-only" for="description">Event Image</label>
            
            <input id="event_image" type="file" class="form-control" name="event_image">
            (recommended image ratio is 2.95:1 - ex: 1900x640)
        </div>
    </div>


    <div class="form-group row justify-content-center">
    <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="A private event means it is only visible to you and to those who get invited." src="/images/tooltip.png"></img>
        
        <div class="col-md-7">
            
           <label for="private">Is the event private? </label>
            <input type="checkbox" class="form-check-input col-md-3" name="private_event" id="private_event" class="form-control" autofocus="">
        </div>
    </div>


    <div class="form-group row justify-content-center">
    <img data-toggle="tooltip" width="15" height="15" data-placement="top" alt="" title="The address of the event." src="/images/tooltip.png"></img>
        
        <div class="col-md-7">
            
           <input type="text" id="location" name="location" class="form-control" placeholder="Location *" autofocus="" required>

        </div>
    </div>

    

    <div class="text-center">
    <div class="col-md-7">* means the field is required</div>
        <button class="btn btn-sm btn-info" type="submit">Submit Event!</button>
    </div>
    </div>


</form>


@include('layouts.footer')