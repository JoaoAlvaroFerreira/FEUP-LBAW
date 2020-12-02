@include('layouts.header')

@include('layouts.navbar')

<h2 class="title">Here are the top tags:</h2>
<ul id="hs">
    <?php
    $tags = App\Models\Tags::get();
    
    $aux = array();
    foreach($tags as $tag){
        $auxbool = true;
        foreach($aux as $auxtag){
            if($auxtag == $tag->tag){
                $auxbool = false;
            }
        }
        if($auxbool){
            $auxvar = $tag->tag;
            $aux[] = $auxvar;
        }
    }
    ?>
    <div class="col-md-3 subtitle">
    @foreach ($aux as $aux_tag) 
    
    
        <a href="{{ route('categories', ['tag' => $aux_tag ])}}">#{{$aux_tag}}</a>
    
    @endforeach 
</div>
    <?php
    

    if (isset($requested_tag)) {
        $requested_tags = App\Models\Tags::where('tag', $requested_tag)->get();
        
    ?>
</ul>
<h3 class="col-md-3 subtitle">All events with tag #{{ $requested_tag }}:</h3>
<ul id="hs">
<?php
        foreach ($requested_tags as $r_tag) {
            $event = App\Models\Event::findOrFail($r_tag->event_id);
              if ($event->start_date < today())
                    continue;

                $image = App\Models\Event_Image::where('event_id', $event->id)->first();

                if ($image == null) {
                    $image = '/images/placeholder-event.png';
                } else {
                    $image = $image->image_url;
                }
                        ?>

        <li class="item">
            <img class="imagefithome event" alt="" width="341px" height="226px" src="{{ $image }}">

            <h3>{{ $event->event_name }}</h3>
            <?php
                if ($event->price == 0) { ?>
                <p>{{ $event->start_date }} | {{ $event->location }} | Free</p>
            <?php } else { ?>
                <p>{{ $event->start_date }} | {{ $event->location }} | Price: {{ $event->price}}€</p>
            <?php } ?>
            <a class="btn btn-outline-info" href="/event/{{ $event->id }}" role="button">See more</a>
        </li>
    <?php
            }  
        }
    
?>

</ul>

@include('layouts.footer')