jQuery(document).ready(function($){

	$('#widget-sidebar-manage-wrap').show('fast');
	$('#widgets-right > div').hide().addClass('managed');
	$('#widgets-right > div:first').show();

	function clear_wpWidgetsEvents() {
		$('div.widgets-sortables').sortable('destroy');
		$(document.body).unbind('click.widgets-toggle');
		$('#widget-list').children('.widget').draggable('destroy');
		$('#available-widgets').droppable('destroy');
		$('#widgets-right').children('.widgets-holder-wrap').children('.sidebar-name').unbind('click');
		$('#widgets-left').children('.widgets-holder-wrap').children('.sidebar-name').unbind('click');

		// wait a sec, and re-initiate our wpWidgets events
		setTimeout(function(){
			wpWidgets.init();
		}, 500 );
	}

	$('body').on( 'change', '#widget-sidebar-manage', function(e) {
		e.preventDefault();

		var $this = $(this);
		var id = $('#'+$this.val());
		var toshow = id.parents('.widgets-holder-wrap');

		// hide all sidebars
		$('#widgets-right .widgets-holder-wrap').hide().addClass('closed');
		// and show the one we selected
		toshow.show().removeClass('closed');
		// clear out wpWidgets.init() events
		clear_wpWidgetsEvents();
		// Set this val back to the "Select Sidebar" value
		$this.val('');
	});

	// Get the position of the location where the scroller starts.
	var scroller_anchor = parseFloat( $('#widgets-right').offset().top );
	var container = $('.widget-liquid-right');
	var docHeight = parseFloat( $(document).height() ) - 30;
	var winHeight = parseFloat( $(window).height() ) - 30;
	$(window).scroll(function(e) {
		var newTop = $(this).scrollTop();
		var floater = $('#widgets-right > div:visible');
		var height = floater.outerHeight();

		if ( newTop >= scroller_anchor && height < winHeight ) {
			if ( ( newTop + height ) < docHeight ) {
				floater.css({'top': parseFloat( newTop - scroller_anchor + 10 )});
				container.height(parseFloat(floater.offset().top + height ) - scroller_anchor);
			}
		} else {
			floater.css({'top': 1});
		}

	});

});
