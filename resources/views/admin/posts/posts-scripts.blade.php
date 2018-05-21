<script>
$(document).ready(function () {

  $("#postcat").on('change', function(){
    var selid = $(this).val();
    console.log(selid);

    $.ajax({
        method: 'GET', // Type of response and matches what we said in the route
        url: '/posts/ajax/get/subcat/', // This is the url we gave in the route
        data: {'id' : selid, 'isa' : true}, // a JSON object to send back
        success: function(data){ // What to do if we succeed
            console.log(data.response);
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });

  });


});
</script>
