var websocket ;
$(document).ready(function(){
    init();
});

function init(){
    var wsUrl = 'ws://localhost:9000';
    websocket = new WebSocket(wsUrl);

    websocket.onopen = function(e){
        sendText();
    };

    websocket.onclose = function(){
        console.log('websocket close');
    }

    websocket.onmessage = function(e){
        console.log(e);
        console.log(e.data);  
        websocket.close();
    };
}

function sendText() {
  var msg = {
    type: "message",
    text: 'test',
    id: '1111',
    date: Date.now()
  };
  websocket.send(JSON.stringify(msg));
}

function postBiddingData(){
    $('.bidding').click(function(){
        $.ajax({
            url:'../Bidding/insertBiddingHistory',
            type:'post',
            data:{
                amount:$("#amount").val(),
                
            }
        });
    });
}