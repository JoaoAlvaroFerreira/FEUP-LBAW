<!DOCTYPE html>
<html>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="/js/jsonFunctions.js"></script>

<footer class="page-footer font-small blue">

  <!-- Copyright -->
  <div class="footer-copyright text-center text-muted py-3 static">© 2020 Copyright:
    <a href="{{ url('/') }}"> Meetcamp</a>
    @if(auth()->user())
    <?php if (Auth::user()->isAdmin()) { ?>
      <p>Admin Panel: <a href="{{ url('/admin_user_list') }}">Users</a> | <a href="{{ url('/admin_event_list') }}">Events</a> | <a href="{{ url('/admin_comment_list') }}">Reports</a></p>
    <?php } ?>
    @endif

  </div>
  <!-- Copyright -->

</footer>

</html>