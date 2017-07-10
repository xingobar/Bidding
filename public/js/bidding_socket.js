var websocket ;
var msg ;
$(document).ready(function(){
    init();
    postBiddingData();
});

function init(){
    var wsUrl = 'ws://localhost:9000';
    websocket = new WebSocket(wsUrl);

    websocket.onopen = function(e){
       // sendText();
       console.log('connect success');
    };

    websocket.onclose = function(){
        console.log('websocket close');
    }

    websocket.onmessage = function(e){
        console.log('receive message success');
        console.log(e); 
        updateTable(e);
      //  websocket.close();
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
            url:'/biddingKing/Bidding/BiddingHistory.php',
            type:'post',
            data:{
                price:$("#amount").val(),
                floor_price:$("#floor_price").text().split('元')[0],
                productId :$("#product_id").val()
            },
            success:function(data){
                var code = JSON.parse(data).msg;
                if(code === 'success'){
                    swal('下標成功','','success');
                    updateNavbar();
                    appendToTable();
                    sendMessage();
                    return;
                }
                swal('餘額不足','','warning');
            }
        });
    });
}
function updateNavbar(){
    var remain = parseInt($('.remain').text());
    var diff = remain - parseInt($('#amount').val());
    $('.remain').text(diff.toString());
}

function appendToTable(){
    var tbody = $('.bidding-table').find('tbody');
    var now = new Date();
    now = now.getFullYear()+'-'+(now.getMonth()+1)+'-'+now.getDay(); 
    var userName = $('.username').text();
    $(tbody).append('<tr>\
                        <td>'+ now + ' </td>\
                        <td>'+ userName + '</td>\
                        <td>' + $('#amount').val() + '</td>\
                    </tr>');
}
function updateTable(e){
    var currentName = $('.username').text();
    if(currentName !== e.name && e.name !== undefined){
        console.log('update table');
    }
}
function sendMessage(){
    var now = new Date();
    now = now.getFullYear()+'-'+(now.getMonth()+1)+'-'+now.getDay(); 
    var userName = $('.username').text();
    msg ={
        now:now,
        name:userName,
        bidding_price:$("#amount").val()
    };
    websocket.send(JSON.stringify(msg));
}