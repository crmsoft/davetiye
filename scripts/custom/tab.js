$(document).ready(function() {

	$(".tab-con").hide();
	$(".tab-con:first").show(); 

	$(".tabs li").click(function() {
		$(".tabs li").removeClass("active");
		$(this).addClass("active");
		$(".tab-con").hide();
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab).fadeIn(); 
	});
});
