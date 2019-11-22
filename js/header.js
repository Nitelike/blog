function fullwindowpopup(){
	   window.open("complain.php","Сообщение","width=500,height=330,scrollbars")
	}
	function showDistricts(){
	    var x = document.getElementById("districts-menu");
	  	if (x !== null) {
	  		if (x.style.display === "none") {
	  	    	x.style.display = "block";
	  	  } else {
	  	    	x.style.display = "none";
	  	  }
	  	}
	}

	function showToolbar(){
	    var x = document.getElementById("tool-content");
	  	if (x !== null) {
	  		console.log();
	  		if (x.offsetWidth > 0) {
	  	    	x.style.display = "none";
	  	  } else {
	  	    	x.style.display = "block";
	  	  }
	  	}
	}

	function showCategories(){
	    var x = document.getElementById("categories-section");
	  	if (x !== null) {
	  		console.log();
	  		if (x.offsetWidth > 0) {
	  	    	x.style.display = "none";
	  	  } else {
	  	    	x.style.display = "block";
	  	  }
	  	}
	}