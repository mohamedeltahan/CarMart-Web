// animation on scroll
window.onscroll = function () {
	scrollNavFunction()
};

function scrollFunction() {
	if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {} else {}
}
window.onscroll = function () {
	scrollFunction()
};

function scrollFunction() {
	if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
		document.getElementById("nav").style.padding = "15px 8%";
		document.getElementById("nav").style.background = "#f9f9f9";
		document.getElementById("nav").style.boxShadow = "0 0 15px rgba(51,51,51,.5)";
	} else {
		document.getElementById("nav").style.padding = "25px 8%";
		document.getElementById("nav").style.background = "rgba(0,0,0,0)";
		document.getElementById("nav").style.boxShadow = "0 0 15px rgba(51,51,51,0)";
	}
}


// form
$(document).ready(function () {
	$("#form-open").click(function () {
		$("#join-form").slideToggle(800);
	});
});
$(document).ready(function () {
	$(".clos-icon").click(function () {
		$("#join-form").slideToggle(800);
	});
});



// get year now
var d = new Date().getFullYear();
document.getElementById("year").innerHTML = d;


AOS.init();
