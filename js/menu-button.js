function showMenu() {
  var x = document.getElementById("topmenu");
  if (x !== null) {
  	if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }
}