(function ($, root, undefined) {

$(function () {

// class ensures panels are hidden only if JS runs
$( '.app-panels' ).addClass( 'slide' );

// calculate height of each section of form
function calcPanelHeight( v ) {

	var p = $( '.app-panels' );

	if ( typeof v === 'undefined' ) {

		$( '.app-panel' ).each(function(){

			var h = $( this ).outerHeight();

			$( this ).attr( 'data-height', h );

		});

		v = $( '.app-panel.active' ).attr( 'data-height' ) + 'px';

	}

	p.css( 'height', v );

}
calcPanelHeight();

// slide to next panel
$( '.app-nav' ).click(function(e){

	e.preventDefault();

	var valid = ( $( this ).hasClass( 'app-next' ) ) ? validatePanel( $( this ) ) : true;
	//var valid = true;

	if ( valid ) {

		// reset notifications from previous validation
		 $( '.app-validate' ).removeClass( 'show' );
		 $( '.invalid' ).removeClass( 'invalid' );

		if ( $( this ).hasClass( 'app-next' ) ) {
			var p = $( this ).parents( '.app-panel' ).next( '.app-panel' );
		} else if ( $( this ).hasClass( 'app-prev' ) ) {
			var p = $( this ).parents( '.app-panel' ).prev( '.app-panel' );
		}
		var i = p.index();

		// set next panel as active and recalculate height
		$( '.app-panel' ).removeClass( 'active' );
		p.addClass( 'active' );
		calcPanelHeight();

		// slide container to display next panel
		$( '.app-panels' ).css( 'left', function(){
			return '-' + ( 100 * ( i ) ) + '%';
		});

		// scroll page to top of slides
		var appTop = $( '.app-panels' ).offset().top;

		$( "html, body" ).animate({
				"scrollTop"	:	appTop - 12
			}, 500
		);

	} else {

		$( '.app-validate' ).addClass( 'show' );
		calcPanelHeight();

	}

});

// disable submissions until release box checked
$( '.app-submit' ).addClass( 'disable' );

// submit form when valid
$( '.app-submit' ).click(function(e){

	if ( $( this ).hasClass( 'disable' ) ){

		e.preventDefault();

	}
 
});

// validate current panel
function validatePanel( v ) {

	var p = v.parents( '.app-panel' ),
		e = p.find( '.app-row' ).find( ':input' ).not( '.btn, .app-notReq, input[name="neverEmployed[]"], input[value="Not available"]' ),
		b = true;

	e.each(function(){

		var t = $( this );

		// check if field is part of reference
		var ref = t.parents( '.app-reference' ).attr( 'data-reference' );

		// only check fields that not part of 2nd+ reference
		if ( ref < 2 || ref === undefined ) {

			var n = t.parents( '.app-panel' ).find( '#app-neverEmployed' );

			if ( !n.length || n.find( 'input[type="checkbox"]' ).not( ':checked' ).length ) { // if not reference panel or reference panel doesn't have "neverEmployed" box checked

				if ( t.attr( 'type' ) == 'radio' || t.attr( 'type' ) == 'checkbox' ) {

					if ( !p.find( 'input[name="' + t.attr( 'name' ) + '"]:checked' ).length ) {

						t.parents( '.app-element' ).find( '.app-label' ).addClass( 'invalid' );

						b = false;

					} 

				} else {

					if( t.val() === '' ) {

						t.addClass( 'invalid' );

						b = false;

					}

				}

			}

		}

	});

	return b;

}

// set height of each reference section
function calcRefHeight() {

	var t = $( '.app-reference' ),
		h = t.outerHeight();

	t.css( 'height', h + 'px' );

}
calcRefHeight();

// set fields that don't need validation
$( '.app-hidden[data-trigger="#app-prev"]' ).find( 'input,select' ).addClass( 'app-notReq' );

$( '#app-referral' ).change(function(){

	var v = $( this ).val(),
		r = $( '.app-referral' ),
		c = "show",
		d = $( '.app-referral-details' ),
		dl = d.find( '.app-label' ),
		emp = "Employee Referral",
		opt = {};
		
		opt[ emp ] = "Employee's name";
		opt.Other = "Please tell us how you heard about us";

	if ( v == emp ) {

		r.addClass( 'employee' );
		$( '#app-referralLocation' ).prop( 'selectedIndex', 0 );

	} else {

		r.removeClass( 'employee' );

	}
	
	if ( opt.hasOwnProperty( v ) ) {

		d.addClass( c );

		dl.text( opt[ v ] );
		
		$( '#app-referralDetails' ).val( '' );

	} else {

		d.removeClass( c );

	}

});

// toggle display elmers work history details
$( '#app-prev input[type="radio"]' ).change(function(){

	var c = "show",
			d = $( '.app-hidden[data-trigger="#app-prev"]' ),
			r = "app-notReq";

	if ( $( this ).val() == "Yes" ) {
		d.addClass( c );
		d.find( 'input, select' ).removeClass( r );
	} else {
		d.removeClass( c );
		d.find( 'input, select' ).addClass( r );
	}

	calcPanelHeight();

});

// hide references if no past work history is selected
$( '#app-neverEmployed input[type="checkbox"]' ).change(function(){

	var r = $( '.app-reference' ),
		b = $( '.app-addRef' );

	if ( this.checked ) {

		r.addClass( 'hidden' );
		b.addClass( 'hidden' );

	} else {

		r.removeClass( 'hidden' );
		b.removeClass( 'hidden' );

	}

	var history_height = setTimeout( calcPanelHeight, 250 );

});

// hide/show available times, toggled by "not available" checkbox
$( '[id^="app-notAvail"]' ).find( 'input[type="checkbox"]' ).change(function(){

	var c = ( $( this ).attr( 'checked' ) || $( this ).is( ':checked' ) ) ? true : false;
	var p = $( this ).parents( '.seventh' );

	p.find( 'select.app-select' ).each(function(){

		var t_val = "  ";

		var s = $( this ).children().filter( ':selected' ).not( '.blank' );
		s.addClass( 'default' );

		if ( c ) {

			// change value if starting time of day
			if ( ( $( this ).attr( 'name' ) ).match(/\S*Start$/) !== null ) {
				t_val = "Not Available";
			}

			$( this )
				.append($("<option></option>")
					.attr( 'value', t_val )
					.addClass( 'blank' )
					.text( '' )
					.attr( 'selected', true )
					.prop( 'selected' , true )
				)
			.prop( 'disabled', true );

			s.attr( 'selected' , false );

		} else {

			$( this ).prop( 'disabled', false );
			$( this )
				.find( 'option[value="  "],option[value="Not Available"]' )
				.remove();

			$( this )
				.find( '.default' )
				.prop( 'selected', true );

		}

	});

});

// mark reference as filled out when value added to any field
function refEnable() {

	$( '.app-reference' ).find( ':input' ).not( '.btn, .app-notReq' ).change( function(){

		var b = $( this ).parents( '.app-reference' ).find( '.ref-enabled input:radio' );

		var c = ( $( this ).val() !== "" || $( this ).attr( 'checked' ) ) ? true : false;

		b.prop( 'checked', c );

	});

}
refEnable();

// add fields for additional reference
$( ".btn-addRef" ).click(function(e) {

	var t = $( '.app-reference' ).last();

	// get reference number
	var i = parseInt( t.attr( 'data-reference' ) );
	var n = i + 1;

	var c = t.clone();

	// clear all fields
	c.find( '.app-input' ).val( '' );
	c.find( 'input[type="radio"]' ).prop( 'checked', false );
	c.find( '.invalid' ).removeClass( 'invalid' );

	// update indexes for all fields
	c.attr( 'data-reference', n );
	nextRef( c.find( '.app-input' ), n, [ 'id', 'name' ] );
	nextRef( c.find( '.app-heading' ), n, [ 'html' ] );
	nextRef( c.find( '.app-label' ), n, [ 'for' ] );
	nextRef( c.find( '.app-options' ), n, [ 'id' ] );
	nextRef( c.find( 'input[type="radio"]' ), n, [ 'name' ] );
	nextRef( c.find( '.wpcf7-form-control-wrap' ), n, [ 'class' ] );

	// insert new empty reference
	c.insertAfter( t );

	// adjust height of container
	calcPanelHeight();

	// lets new elements trigger enabling script
	refEnable();

});

// modify reference number on added fields
function nextRef( t, i, a ) {

	t.each(function(){

		if ( a[0] != 'html' ) {

			for( var c = 0; c < a.length; c++ ) {

				var attr = $( this ).attr( a[c] ),
					match = attr.match(/\d{1,3}$/ ),
					pos = attr.indexOf( match[0] ),

				// modify attribute to use updated index
				attr = attr.substring( 0, pos ) + i;

				$( this ).attr( a[c], attr );

			}

		} else {

			$( this ).text( 'Previous Employer #' + i );

		}

	});

}

// hide references if no past work history is selected
$( 'input[name="app-release"]' ).change(function(){

	var s = $( '.app-submit' );

	if ( this.checked ) {

		s.removeClass( 'disable' );

	} else {

		s.addClass( 'disable' );

	}
	
	var history_height = setTimeout( calcPanelHeight, 250 );

});

// functions to fire on screen size or orientation change
function screenChange() {

	calcPanelHeight();
	calcRefHeight();

}

// recalc
$( window ).resize(function(){
	screenChange();
});
window.addEventListener("orientationchange", function() {
	screenChange();
}, false);

});

})(jQuery, this);
