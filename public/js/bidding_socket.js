var websocket ;
var msg ;
var currentDateTime ;
$(document).ready(function(){
    init();
    getBiddingHistory();
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
     //   console.log(e); 
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

function getBiddingHistory(){
    $.ajax({
        url:'/biddingKing/Bidding/BiddingDetail.php',
        type:'post',
        data:{
            productId :$("#product_id").val()
        },
        success:function(data){
            console.log(data);
        },
        error:function(data){

        }
    });
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
    currentDateTime = getCurrentDateTime();
    var userName = $('.username').text();
    $(tbody).append('<tr>\
                        <td>'+ currentDateTime + ' </td>\
                        <td>'+ userName + '</td>\
                        <td>' + $('#amount').val() + '</td>\
                    </tr>');
}


function getCurrentDateTime(){
    var now = new Date();
    var month = (now.getMonth() + 1 ) < 10 ? '0' + (now.getMonth()+1) : now.getMonth()+1;
    var day = (now.getDay() < 10) ? '0' + now.getDay() : now.getDay();
    var hours = (now.getHours() < 10 ) ? '0' +now.getHours() : now.getHours();
    var minutes = (now.getMinutes() < 10 ) ? '0' + now.getMinutes() : now.getMinutes();
    var seconds = (now.getSeconds() < 10) ? '0' + now.getSeconds() : now.getSeconds(); 
    now = now.getFullYear()+'-'+ month +'-'+ day + ' ' + hours + ':' + minutes +':'+seconds; 
    return now;
}

function updateTable(e){
    var currentName = $('.username').text();
    var e_array = JSON.parse(e.data);
    var name ;
    var now ;
    var bidding_price;
    if(Array.isArray(e_array)){
        name = e_array[0]['name'];
        now = e_array[0]['now'];
        bidding_price = e_array[0]['bidding_price'];
    }
    if(currentName !== name && name !== undefined){
        var tbody = $('.bidding-table').find('tbody');
        $(tbody).append('<tr>\
                            <td>'+ now + ' </td>\
                        <td>'+ name + '</td>\
                        <td>' + bidding_price + '</td>\
                    </tr>');
    }
}
function sendMessage(){ 
    var userName = $('.username').text();
    msg ={
        now:currentDateTime,
        name:userName,
        bidding_price:$("#amount").val()
    };
    websocket.send(JSON.stringify(msg));
}
