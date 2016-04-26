$("#searchform").submit(function(event) {
    // stop form from submitting normally
    event.preventDefault();
    // display loading icon
    $("body").addClass("loading");
    // get form data
    var searchdata = $("#searchform").serialize();
    var getting = $.get("story.php", searchdata);
        /* Alerts the results */
    getting.done(function(data){
        // replace page content
        $("body").removeClass("loading");
        $("#output").html(data);
    });
});

$("#dictionary-search").keyup(function() {
    // get form data
    var searchdata = $("#dictionary-form").serialize();
    var getting = $.get("dictionary.php", searchdata);
        /* Alerts the results */
    getting.done(function(data){
        // replace page content
        $("#dictionary-output").html(data);
    });
});