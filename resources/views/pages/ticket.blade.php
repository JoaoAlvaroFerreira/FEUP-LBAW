    <?php
    $owner = App\Models\User::find($event->owner_id);
?>
@include('layouts.header')

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700|Kreon:700|Audiowide&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css2?family=Monoton&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/ticket.css') }}">
  <!-- <link rel="stylesheet" href="styles/main.css" media="screen" charset="utf-8"/> -->
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="content-type" content="text-html; charset=utf-8">

<style>
  
</style>

<body>
  <div class="container">
    
    <section>
    <div class="meetcamp ticket"><img src="{{ asset('images/logo_transparent.png') }}" alt="Meetcamp Logo" height="80px" width="340px"></div>
      <div class="left">
        
        <div class="title">{{ $event->event_name }}</div>
        <div class="event">Presented by {{ $owner->name }}</div>
        <?php
        if ($event->private_event) { ?>
       <div class="info">{{ $event->location}} // Price: {{ $event->price }}€ // A Private Event // {{ Auth::user()->name }}</div>
       <br>
    <?php
    } else { ?>
        
        <div class="info">{{ $event->location}} // Price: {{ $event->price }}€ // A Public Event // {{ Auth::user()->name }}</div>
        <br>
    <?php } ?>
      </div>
      <div class="right">
    
      <?php if ($event->end_date != null) {
        ?>
          <div class="seats"><strong>Start Date: </strong><span>{{ $event->start_date}} </span></div>
          <div class="seats"><strong>End Date: </strong><span>{{ $event->end_date}} </span></div>
        <?php
        } else { ?>

          <div class="seats"><strong>Event Date:</strong> <span>{{ $event->start_date}} </span></div>

         

        <?php
        }?>
      </div>
    </section>
  </div>
</body>

</html>
