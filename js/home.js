$(document).ready(function(){
	
	$('#login').on('click', function(e){
		window.location.href='home.php';
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