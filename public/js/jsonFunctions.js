function getVote(content, poll_id, voter_id) {


    $.ajax({
        type: 'POST',
        url: '/vote',
        data: {
            poll_id: poll_id,
            content: content,
            voter_id: voter_id
        },
        success: function (data) {

            $("#poll" + poll_id).html(data.poll);
        }
    })
};

function make_report(comment_id) {

    var description = document.getElementById("report_description." + comment_id).value;

    $.ajax({
        type: 'POST',
        url: '/report',
        data: {
            comment_id: comment_id,
            report_note: description
        },
        success: function (data) {
            $("#reportModal" + comment_id).html("");
            $("#reportModal" + comment_id + "button").html("Report Sent");
        }
    });
}

function make_invite(inviter_id, invited_id, event_id) {
    $.ajax({
      type: 'POST',
      url: '/invite',
      data: {
        invited_id: invited_id,
        inviter_id: inviter_id,
        event_id: event_id
      },
      success: function(data) {
        $("#" + data.id).html(data.msg);
      }
    });
  }


  $(document).ready(function() {
    var max_fields = 5;
    var wrapper = $(".container_form_poll");
    var add_button = $(".add_form_field");

    var x = 0;
    $(add_button).click(function(e) {
      e.preventDefault();
      if (x < max_fields) {
        x++;
        $(wrapper).append('<div><input class="form-control" type="text" name="poll_option_' + x + '" id="poll_option_' + x + '" placeholder="Poll Option ' + x + '" /><a href="#" class="delete">Delete</a></div>'); //add input box
      } else {
        alert('You Reached the limits')
      }
    });

    $(wrapper).on("click", ".delete", function(e) {
      e.preventDefault();
      $(this).parent('div').remove();
      x--;
    })
  });