jQuery(document).ready(function($) {

	$(".like").stop().click(function(){

		var rel = $(this).attr("rel");

		var data = {
			data: rel,
			action: 'like_callback'
		}
		$.ajax({
			action: "like_callback",
			type: "GET",
			dataType: "json",
			url: ajaxurl,

			data: data,
			success: function(data){

				console.log(data.likes);
				console.log(data.status);

				if(data.status == true){
					$(".like[rel="+rel+"]").html(data.likes + " likes").addClass("liked");
				}else{
					$(".like[rel="+rel+"]").html(data.likes + " likes").removeClass("liked");
				}

			}
		});

	});

});

jQuery(document).ready(function($) {
$(".unlike").stop().click(function(){

	var rel = $(this).attr("rel");

	var data = {
		data: rel,
		action: 'unlike_callback'
	}
	$.ajax({
		action: "unlike_callback",
		type: "GET",
		dataType: "json",
		url: ajaxurl,

		data: data,
		success: function(data){

			console.log(data.unlikes);
			console.log(data.status);

			if(data.status == true){
				$(".unlike[rel="+rel+"]").html(data.unlikes + " unlikes").addClass("unliked");
			}else{
				$(".unlike[rel="+rel+"]").html(data.unlikes + " unlikes").removeClass("unliked");
			}

		}
	});

});
});