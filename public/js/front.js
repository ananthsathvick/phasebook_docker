$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $("#user").autocomplete({
        source: "/autocomplete/fetch",
        minLength: 2,
        success: function(data) {
            response(data);
        },
        select: function(event, ui) {
            //console.log("Selected: " + ui.item.value + " aka " + ui.item.label);
            window.location.href = '/account/' + ui.item.value;
        }
    });



});