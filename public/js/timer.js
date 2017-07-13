var getTime;
var timeInnerHtmlArr = [];
$(document).ready(function(){
	getTime = $('.timer');
	pushInnerHtmlArray();
	firstUpdateTime();
	updateEndTime();
});

function pushInnerHtmlArray(){
	for(var index = 0 ; index < getTime.length ; index++){
		timeInnerHtmlArr.push($(getTime)[index].innerHTML);
	}	
}

function firstUpdateTime(){
	for(var index = 0 ; index < getTime.length ; index++){
		var element = $(getTime)[index];
		var text = timeInnerHtmlArr[index];
		diff = new Date(text) - new Date();
		if(diff <=0){
			console.log(' end time less than now');
		}
		diff = new Date(diff);
		diff = convertTime(diff);
		$(element).text(diff);
	}
}

function convertTime(time) {        
    var millis= time % 1000;
    time = time/1000;
    var seconds = parseInt(time % 60);
    time = time/60;
    var minutes = parseInt(time % 60);
    time = time/60;
    var hours = parseInt(time % 24);
    var out = "";
    if(hours && hours > 0) out += hours + " " + ((hours == 1)?"hr":"hrs") + " ";
    if(minutes && minutes > 0) out += minutes + " " + ((minutes == 1)?"min":"mins") + " ";
    if(seconds && seconds > 0) out += seconds + " " + ((seconds == 1)?"sec":"secs") + " ";
    return out.trim();

}

function updateEndTime(){
    var diff ;
  	var timer = setInterval(function(){
  		for(var index = 0 ; index < getTime.length ; index++){
  			var element = $(getTime)[index];
  			var text = timeInnerHtmlArr[index];
  			diff = new Date(text) - new Date();
  			if(diff <=0){
  				console.log(' end time less than now');
  			}
  			diff = new Date(diff);
  			diff = convertTime(diff);
  			$(element).text(diff);
  		}
  	},1000);
}


function convertTime(time) {        
    var millis= time % 1000;
    time = time/1000;
    var seconds = parseInt(time % 60);
    time = time/60;
    var minutes = parseInt(time % 60);
    time = time/60;
    var hours = parseInt(time % 24);
    var out = "";
    hours =  (hours < 10) ? '0'+hours : hours;
    out = hours +':';
    minutes =  (minutes < 10) ? '0'+minutes : minutes;
    out = out + minutes +':';
    seconds =  (seconds <  10) ? '0' + seconds:seconds;
    out = out + seconds;
    return out.trim();
}
