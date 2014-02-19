var scrolldelay;

function stopScroll(){
	 clearTimeout(scrolldelay);
}

function leftScroll(){  
	var visibleContentWidth=document.getElementById("slideMenu").clientWidth;
	var currentOffsetScroll=document.getElementById("slideMenu").scrollLeft;
	var hiddenContentWidth=currentOffsetScroll;
	var offsetScroll=Math.min(hiddenContentWidth,visibleContentWidth);
	var i=-Math.PI/2;
	var startOffsetScroll =currentOffsetScroll;
	var increment =30;
	recursiveLeftScroll(i,startOffsetScroll,offsetScroll,increment);
}

function recursiveLeftScroll(i,startOffsetScroll,offsetScroll,increment){
	if(i<=Math.PI/2){
		var currentOffsetScroll= startOffsetScroll-(Math.sin(i)+1)/2*offsetScroll;
		document.getElementById("slideMenu").scrollLeft=currentOffsetScroll;
		i+=(Math.PI/increment);
		scrolldelay = setTimeout(function () {recursiveLeftScroll(i,startOffsetScroll,offsetScroll,increment);},30); 
	}
}


function rightScroll()
{  
	var visibleContentWidth=document.getElementById("slideMenu").clientWidth;
	var currentOffsetScroll=document.getElementById("slideMenu").scrollLeft;
	var hiddenContentWidth=document.getElementById("slideMenu").scrollWidth-currentOffsetScroll-visibleContentWidth;
	
	var offsetScroll=Math.min(hiddenContentWidth,visibleContentWidth);
	var i=-Math.PI/2;
	var startOffsetScroll =currentOffsetScroll;
	var increment =30;
	recursiveRightScroll(i,startOffsetScroll,offsetScroll,increment);
}

function recursiveRightScroll(i,startOffsetScroll,offsetScroll,increment){
	if(i<=Math.PI/2){
		
		var currentOffsetScroll= startOffsetScroll+(Math.sin(i)+1)/2*offsetScroll;
		document.getElementById("slideMenu").scrollLeft=currentOffsetScroll;
		i+=(Math.PI/increment);
		scrolldelay = setTimeout(function () {recursiveRightScroll(i,startOffsetScroll,offsetScroll,increment);},30); 
	}
}