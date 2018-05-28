$(document).ready(function(){
	
	// search
	$('#q').on('keyup', function(e){
		$('#autosearch').show();
	});
	
	$('#q').on('blur', function(e){
		$('#autosearch').hide();
	});
	
	// tabs
	$('.tab').on('click', function(e){
		alert('here..');
		var id = $(this).attr('data-id');
		// collapse all
		$('#settings .wrap').hide();
		// show
		$('#settings .wrap-' + id).show();
	});
	
	loadpage('./inc/home.inc.php', 'container .left');
	loadpage('./inc/sidebar.inc.php', 'sidebar');
	
	/* toolbar */
	$('.icon').on('mouseover', function(e){
		var id = $(this).attr('data-id');
		$('.icon-'+id).show();
	});
	
	$('.icon').on('mouseout', function(e){
		var id = $(this).attr('data-id');
		$('.icon-'+id).hide();
	});
	
	
	/* menu */
	$('.button').on('click', function(e){
		var id = $(this).attr('data-id');
		var url = $(this).attr('data-url');
		// logout
		if (id == 7) {
			window.location.href=url;
		}
		// change button state
		$('.button').removeClass('active');
		$(this).addClass('active');
		// redirect
		loadpage(url, 'container .left');
	});
	
	// load page function
	function loadpage(path, div){
		$.ajax({
			url: path,
			success: function(data){
				$('#' + div).html(data);
			}
		});
	}
	
});



// load page function
function loadpage(path, div){
	$.ajax({
		url: path,
		success: function(data){
			$('#' + div).html(data);
		}
	});
}