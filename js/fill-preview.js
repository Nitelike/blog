$(document).ready(function () {
	setInterval(function() {
		var val = $.trim($("#post-text").val());
		if (val != '') {
			document.getElementById('post-prew').innerHTML = val;
		}    
	}, 100);
   
});