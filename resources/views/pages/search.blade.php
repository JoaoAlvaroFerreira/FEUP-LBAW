@include('layouts.header')

<head>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>


	<script>
		function make_search() {


			var search = document.getElementById("search_query").value;
			var location = document.getElementById("location_query").value;
			var price = document.getElementById("price").value;
			

			$.ajax({
				type: 'POST',
				url: '/searchAJAX',
				data: {
					search: search,
					location: location,
					price: price,
				},
				success: function(data) {

					document.getElementById("events").innerHTML = data.events;
					document.getElementById("users").innerHTML = data.users;

				}
			});
		}
	</script>



</head>


@include('layouts.navbar')
<div class="search-container" id="search-container">




	<form class="ajaxsearch">


		<input class="ajaxsearchitem" type="text"  id="search_query" placeholder="Advanced Search...">
		<input class="ajaxsearchitem" type="text"  id="location_query" placeholder="Filter by Location (Event)">
		<select class="ajaxsearchitem" name="price" id="price">
  <option value="all">All Prices</option>
  <option value="free">Free</option>
  <option value="paid">Paid</option>
</select>


		<button class="ajaxsearchitem btn btneve effect04" data-sm-link-text="Apply Filters" type='button' onclick="make_search()" id="SearchBtn">
			Go!
		</button>
		</span>

	</form>
	<div class="events" id="events">






		<h3 class="searchpage">Matching Events for: <b> {{ $query }} </b></h3>

		<ul class="hs">


			<?php
			if ($events->isNotEmpty()) {


				foreach ($events as $event) {


					if ($event->start_date <= today())
						continue;

					$image = App\Models\Event_Image::where('event_id', $event->id)->first();

					if ($image == null) {
						$image = '/images/placeholder-event.png';
					} else {
						$image = $image->image_url;
					}
			?>

					<li class="item">
						<img class="imagefit event" alt="Event photo" src="{{ $image }}">

						<h3>{{ $event->event_name }}</h3>
						<p>{{ $event->start_date }} | {{ $event->location }}</p>
						<a class="btn btn-outline-info" href="/event/{{ $event->id }}" role="button">See more</a>
					</li>
			<?php
				}
			} else {

				echo "<h4>No events with that search query have been found!</h4>";
			}  ?>

		</ul>

	</div>

	<div class="users" id="users">


		<h3 class="searchpage">Matching Users for: <b> {{ $query }} </b></h3>

		<ul class="hs">

			<?php

			if ($users->isNotEmpty()) {

				foreach ($users as $user) {


			?>

					<li class="user">
						<img class="imagefituser2 user" alt="User photo" width="226px" height="226px" src="{{ $user->photo }}">

						<h3>{{ $user->name }}</h3>
						<a class="btn btn-outline-info" href="/user/{{ $user->id }}" role="button">See more</a>
					</li>
			<?php
				}
			} else {

				echo "<h4>No users with that search query have been found!</h4>";
			}  ?>
		</ul>

	</div>

</div>

@include('layouts.footer')