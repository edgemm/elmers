(function($){
    $( "#radius_in_submit > #addressSubmit").click(function(){
	    _gaq.push(['_trackEvent', 'Forms', 'Submit', 'Locations']);
	    var sVal = $( "#address_search #addressInput" ).val();
	    _gaq.push(['_trackEvent', 'Locations', 'Search', sVal]);
    });
})( jQuery );