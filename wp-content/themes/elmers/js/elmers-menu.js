(function($){

    var masonryOptions = { 'itemSelector': '.tab-pane.active .span6', 'columnWidth': '.tab-pane.active .grid-sizer', 'gutter': '.tab-pane.active .gutter-sizer' }; // masonry options - gfh
    var $container = $( '.menu .tab-pane.active .row-fluid' ); // container of initial content to be re-arranged - gfh
    
    // get full viewport width and height so masonry uses same sizes as CSS media queries - gfh
    // source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript
    function viewport() {
	var e = window, a = 'inner';
	if (!('innerWidth' in window )) {
	    a = 'client';
	    e = document.documentElement || document.body;
	}
	return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
    }
    
    var viewportWidth = viewport().width;
    
    function fireMasonry() {
	if ( viewportWidth > 767 ) {
	    $container.imagesLoaded( function(){
		$container.masonry( masonryOptions );
	    });	
	}
    }
    
    fireMasonry();

    $( '.menu .filter a' ).click( function(e) {
	if ( !$(this).parent( "li" ).hasClass( "nofilter" ) ) {
	    e.preventDefault();
    
	    var menuTab = $(this).attr( "href" );	
	    $container = $( '.menu ' + menuTab + ' .row-fluid' );
	    var activeClass = "active";
    
	    $( ".menu .filter li" ).removeClass( activeClass );
	    $(this).parent().addClass( activeClass );
    
	    var slider_id = $(this).attr( "data-slider-id" );
    
	    $.ajax({
		    type: "post",
		    dataType: "html",
		    url: "http://eatatelmers.com/wp-admin/admin-ajax.php",
		    data: {
			    action: "get_menu_slider",
			    slider_id: slider_id
		    },
		    success: function( response ) {
			    $( ".menu-slider" ).html( response );
    
			    $(".menu-slider .nivoSlider").nivoSlider({
				    effect: "fade",
				    slices: 15,
				    boxCols: 8,
				    boxRows: 4,
				    animSpeed: 500,
				    pauseTime: 5000,
				    startSlide: 0,
				    directionNav: true,
				    controlNav: false,
				    controlNavThumbs: false,
				    pauseOnHover: false,
				    manualAdvance: false,
				    prevText: "Prev",
				    nextText: "Next",
				    randomStart: false,
				    afterLoad: function() {
					$( ".menu-slider, .tab-pane.active" ).removeClass( "active" ).fadeOut( 250 );
					$( ".menu-slider, " + menuTab ).fadeIn( 250, function() {
					    $( menuTab ).addClass( "active" );
					    fireMasonry();
					});
				    }
			    });
    
		    },
		    error: function(jqXHR, textStatus, errorThrown) {
			    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
		    }
	    });
	}
    });
})( jQuery );