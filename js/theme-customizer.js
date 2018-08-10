/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

	wp.customize( 'dst_general_href_hover_color', function( value ) {
		value.bind( function( new_value ) {
			style = 'a:hover { color: ' + new_value + '; }'; // build the style element
			el =  'dst_general_href_hover_color'; // look for a matching style element that might already be there
			Replace_Style(el, style);
		});
	});

	wp.customize( 'dst_footer_href_hover_color', function( value, extra ) {
		value.bind( function( new_value ) {
			var style, el;
			style = '#footer-info a:hover { color: ' + new_value + '; }'; // build the style element
			el =  'dst_footer_href_hover_color'; // look for a matching style element that might already be there
			Replace_Style(el, style);
		} );
	});

	wp.customize( 'dst_slider_dot_inactive_color', function( value, extra ) {
		value.bind( function( new_value ) {
			var style, el;
			style = 'body .et-pb-controllers a { background-color: ' + new_value + '; }'; // build the style element
			el =  'dst_slider_dot_inactive_color'; // look for a matching style element that might already be there
			Replace_Style(el, style);
		} );
	});

	wp.customize( 'dst_slider_dot_active_color', function( value, extra ) {
		value.bind( function( new_value ) {
			var style, el;
			style = 'body .et-pb-controllers a.et-pb-active-control { background-color: ' + new_value + ' !important; }'; // build the style element
			el =  'dst_slider_dot_inactive_color'; // look for a matching style element that might already be there
			Replace_Style(el, style);
		} );
	});

	wp.customize( 'dst_submenu_background_hover_color', function( value, extra ) {
		value.bind( function( new_value ) {
			var style, el;
			style = '.et_mobile_menu li a:hover, .nav ul li a:hover { background-color: ' + new_value + ' !important; }'; // build the style element
			el =  'dst_slider_dot_inactive_color'; // look for a matching style element that might already be there
			Replace_Style(el, style);
		} );
	});

	function Replace_Style(element_name, style){
		var new_style = '<style class="' + element_name + '">' + style + '</style>';
    var style_element = $(element_name);
		if ( style_element.length ) {
				style_element.replaceWith( new_style ); // style element already exists, so replace it
		} else {
				$( 'head' ).append( new_style ); // style element doesn't exist so add it
		}
	} //end function Replace_Style

})( jQuery );
