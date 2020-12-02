@include('layouts.header')

@include('layouts.navbar')

<?php $tags = App\Models\Event::find($event->id)->tags;
$tag_list = "";
foreach ($tags as $tag) {
    $tag_list .= " ";
    $tag_list .= $tag->tag;
}
?>

@if (session('fail'))
    <div class="alert alert-danger">
        {{ session('fail') }}
    </div>
@endif


<form class="container form-signin" method="POST" action="{{ route('event.update', $event->id) }}" role="form" enctype="multipart/form-data">
    @method('PATCH')
    @csrf

    <br></br>
    <input class="form-control" type="hidden" value="{{ Auth::user()->id }}" name="owner_id" id="owner_id">
    <h1 class="h3 h1-responsive font-weight-light text-center mb-3">Edit Event</h1>

    <div class="form-group row justify-content-center">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="The name of the event." alt="" src="/images/tooltip.png"></img>

        <div class="col-md-7">

            <label for="event_name">Name*</label>
            <input class="form-control" placeholder="Name *" id="event_name" type="text" name="event_name" value="{{$event->event_name}}" required autofocus>
            @if ($errors->has('event_name'))
            <span class="error">
                {{ $errors->first('event_name') }}
            </span>
            @endif
        </div>
    </div>


    <div class="form-group row justify-content-center">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="A description for the event." alt="" src="/images/tooltip.png"></img>

        <div class="col-md-7">
            <label for="description">Description*</label>
            <input class="form-control" placeholder="Description *" id="description" type="text" name="description" value="{{$event->description}}" required autofocus>
            @if ($errors->has('description'))
            <span class="error">
                {{ $errors->first('description') }}
            </span>
            @endif
        </div>
    </div>

    <div class="form-group row justify-content-center">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="The cost of entry for the event. Must be a whole number. If the event is free, set it as 0. If not, a Paypal address is also required." alt="" src="/images/tooltip.png"></img>

        <div class="col-md-7">
            <label for="description">Price*</label>
            <input class="form-control" placeholder="Price *" id="price" type="number" name="price" value="{{$event->price}}" required autofocus>
            @if ($errors->has('price'))
            <span class="error">
                {{ $errors->first('price') }}
            </span>
            @endif
        </div>
    </div>


    <div class="form-group row justify-content-center">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="The billing address for tickets bought. Can be left blank if the event is free, but is mandatory for paid events." alt="" src="/images/tooltip.png"></img>

        <div class="col-md-7">
            <label for="description">Paypal</label>
            <input class="form-control" placeholder="Paypal" id="paypal" type="text" name="paypal" value="{{$event->paypal}}" autofocus>
            @if ($errors->has('paypal'))
            <span class="error">
                {{ $errors->first('paypal') }}
            </span>
            @endif
        </div>
    </div>


    <div class="form-group row justify-content-center">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="The opening date for the event. If the event only has one day, this date  serves as the only event date." alt="" src="/images/tooltip.png"></img>

        <div class="col-md-7">
            <label for="date">Start Date*</label>
            <input class="form-control" placeholder="Start Date *" id="start_date" type="date" name="start_date" value="{{$event->start_date}}" required autofocus>
            @if ($errors->has('start_date'))
            <span class="error">
                {{ $errors->first('start_date') }}
            </span>
            @endif
        </div>
    </div>

    <div class="form-group row justify-content-center">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="This element represents the ending date for a multi-day event. It should be left empty if the event only has one date." alt="" src="/images/tooltip.png"></img>

        <div class="col-md-7">
            <label for="date">End Date</label>

            <input class="form-control" placeholder="End Date" id="end_date" type="date" name="end_date" value="{{$event->end_date}}" autofocus>
            @if ($errors->has('end_date'))
            <span class="error">
                {{ $errors->first('end_date') }}
            </span>
            @endif
        </div>
    </div>


    <div class="form-group row justify-content-center">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="The tags of the event, for easier search." alt="" src="/images/tooltip.png"></img>

        <div class="col-md-7">
            <label for="tags">Tags</label>
            @if ( $event->tags != null )
            <input class="form-control" type="text" id="tags" name="tags" value="{{ $tag_list }}" autofocus="" />
            @else
            <input class="form-control" type="text" id="tags" name="tags" placeholder="(separated by spaces)" autofocus="" />
            @endif

        </div>
    </div>


    <div class="form-group row justify-content-center">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="The address of the event." alt="" src="/images/tooltip.png"></img>

        <div class="col-md-7">
            <label for="location">Location*</label>

            <input type="text" id="location" name="location" class="form-control" placeholder="Location *" value="{{$event->location}}" autofocus="" required>

        </div>
    </div>




    <div class="form-group row justify-content-center">
        <div class="col-md-7">
            <label for="private">Is the event private? </label>
            @if( $event->private_event != null)
            <input type="checkbox" class="form-check-input col-md-3" name="private_event" id="private_event" class="form-control" checked>
            @else
            <input type="checkbox" class="form-check-input col-md-3" name="private_event" id="private_event" class="form-control">
            @endif
        </div>
    </div>

    <br>

    <div class="text-center">
        <div class="col-md-7">* means the field is required</div>
        <br>
        <button class="btn btn-sm btn-info" type="submit">Submit Event!</button>
    </div>
    </div>


</form>

<br>
<form class="container" method="POST" action="{{ route('add_image', $event->id) }}" role="form" enctype="multipart/form-data">
    @csrf
    <fieldset>
    <legend>Event Images:</legend>
    <div class="form-group row justify-content-center">
        <img data-toggle="tooltip" width="15" height="15" data-placement="top" title="A cover image for the event. More images can be added by editing the event." alt="" src="/images/tooltip.png"></img>

        <div class="col-md-7 text-center">
            <label for="description">Add Event Image (recommended image ratio is 2.95:1 - ex: 1900x640)</label>

            <input id="event_image" type="file" class="form-control" name="event_image">
            <input id="event_id" type="hidden" name="event_id" value="{{$event->id}}">
            <button class="btn btn-sm btn-secondary" type="submit">Submit Image!</button>
        </div>
    </div>
  
</form>
<form class="container" method="POST" action="{{ route('reset_images', $event->id) }}" role="form" enctype="multipart/form-data">
    @csrf
    <div class="form-group row justify-content-center">
        <div class="col-md-7 text-center">
            <input id="event_id" type="hidden" name="event_id" value="{{$event->id}}">
            <button class="btn btn-sm btn-danger" type="submit">Delete Images</button>
        </div>
    </div>
    </fieldset>
</form>







@include('layouts.footer')