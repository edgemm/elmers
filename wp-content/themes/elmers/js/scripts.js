(function($) {

function addFancyBox() {
     $( ".flexslider img" ).each( function() {
          var img = $(this).attr( "src" );
          var img = img.replace( "-160x160", "" );
          var a = '<a href="' + img + '" class="fancybox" />';
          $(this).wrap( a );
     });
}

var c = $( ".homePost-container" ); // container for home page featured posts
var p = $( ".home-stories [class*='span']:first-child" );
var dis; // distance in percent to slide per click
var pHeight; // height of each post
var cTop = 0; // top position of container, set on each click
var cHeight; // height of posts container div

function homeFeaturedSlide( direction ) {
    var distance = ( ( direction == 'up' ) ? '+=100%' : ( ( direction == 'down' ) ? '-=100%' : '0' ) );
    c.animate({
        top: distance
    },
    500
    );
}

function homeFeaturedEqualHeight( container ) {
    pHeight = 0;
    $(container).height( "auto" );
    $(container).each(function() {
        var tHeight = $(this).outerHeight( true );
        pHeight = pHeight >= tHeight ? pHeight : tHeight;
    });

    $(container).outerHeight( pHeight );
    var rowHeight = $(window).width() > 767 ? pHeight : "";
    $( ".home-stories > [class*='span']" ).height( rowHeight );
    $( ".home-stories > [class*='span']:first-child" ).height( pHeight );

    cTop = c.position().top;
    
    if ( cTop != 0 ) {
      cTop = Math.abs( parseInt( cTop ) );
      var i = Math.ceil( cTop/pHeight );
    }
}

$(document).ready(function() {

    addFancyBox();
    $("a.fancybox").fancybox({
            'cyclic': false,
            'autoScale': true,
            'padding': 10,
            'opacity': true,
            'speedIn': 500,
            'speedOut': 500,
            'changeSpeed': 300,
            'overlayShow': true,
            'overlayOpacity': "0.3",
            'overlayColor': "#666666",
            'titleShow': true,
            'titlePosition': 'inside',
            'enableEscapeButton': true,
            'showCloseButton': true,
            'showNavArrows': true,
            'hideOnOverlayClick': true,
            'hideOnContentClick': false,
            'width': 900,
            'height': 700,
            'transitionIn': "fade",
            'transitionOut': "fade",
            'centerOnScroll': true
    });

    $(".homePost-navUp").click(function(e) {
        cTop = c.position().top;
        if ( cTop != 0 ) {
            homeFeaturedSlide( 'up' );
            e.preventDefault();
        }        
    });
    $(".homePost-navDown").click(function(e) {
        cTop = c.position().top;
        cHeight = c.height();
        var cPosDiff = parseInt( cHeight ) + parseInt( cTop );
        if ( cPosDiff > parseInt( pHeight ) ) {
            homeFeaturedSlide( 'down' );
            e.preventDefault();
        }
    });

    $(".eclub-legend").click(function() {
        $(".eclub-fields").toggleClass("eclub-show");
        $("#mc-embedded-subscribe-form")[0].reset();
        
        // hide confirmation message after submission
        var conMsg = $('.eclub .wpcf7-response-output');
        if(conMsg.is(':visible')) {
            conMsg.hide();
        }
    });

});

$(window).load(function() {
     if ( $( "body.home" ).length > 0 ) homeFeaturedEqualHeight( ".homePost-container > .homePost" );
})

$(window).resize(function() {
    if ( $( "body.home" ).length > 0 ) homeFeaturedEqualHeight( ".homePost-container > .homePost" );
});

}( jQuery ));