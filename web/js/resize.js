//JS Function that permits to resize the pageFrame, the menus, the feedback and the content frames depending on the window size
//It is impossible to do it with percentages in the CSS file because the width is not a "linear" function
function resize() {
	
	var frameWidth = 0;
	  if( typeof( window.innerWidth ) == 'number' ) {
	    //Non-IE
		  frameWidth = window.innerWidth;
	  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
	    //IE 6+ in 'standards compliant mode'
		  frameWidth = document.documentElement.clientWidth;
	  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
	    //IE 4 compatible
		  frameWidth = document.body.clientWidth;
	  }

	frameWidth = frameWidth*94/100;

	document.getElementById('pageFrame').style.width = (frameWidth)+"px";
	document.getElementById('menus').style.width = (frameWidth)+"px";
	
	document.getElementById('feedbackFrame').style.width = (frameWidth-320)+"px";
	document.getElementById('pageContent').style.width = (frameWidth-320)+"px";
	
	resizeMenu();
}

//This function manage the slideMenu behaviour and width depending on the window size
function resizeMenu(){
	var visibleContentWidth = document.getElementById("slideMenu").clientWidth;
	var hiddenContentWidth = document.getElementById("slideMenu").scrollWidth - visibleContentWidth;
	var listWidth = document.getElementById("list").scrollWidth;
	
	document.getElementById("slideMenu").style.width = Math.min(listWidth, document.getElementById("mainMenu").clientWidth - 500)+"px";
	document.getElementById("list").style.width = listWidth+"px";
	
	//If there's not a scrollbar, the arrows must not be "clickable"
	if (document.getElementById("slideMenu").clientWidth == listWidth)
	{
		$("#rightScroll").removeClass("rightScroll");
		$("#rightScroll").addClass("unclickableRightArrow");
		$("#leftScroll").removeClass("leftScroll");
		$("#leftScroll").addClass("unclickableLeftArrow");
	}
	
	else
	{
		$("#rightScroll").removeClass("unclickableRightArrow");
		$("#rightScroll").addClass("rightScroll");
		$("#leftScroll").removeClass("unclickableLeftArrow");
		$("#leftScroll").addClass("leftScroll");
	}
	
}