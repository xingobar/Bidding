var websocket ;
var msg ;
var currentDateTime ;
var floor_price;
var bidding_price ; // bidding price
$(document).ready(function(){
    var floor_price =  parseInt($('#floor_price').text());
    console.log(floor_price);
    init();
    getBiddingHistory();
    postBiddingData();
    updateBiddingCount();
    updateTopPeople();
    updateFloorPrice();
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
        updateTable(e);;
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
    floor_price = $('#floor_price').text().split('元')[0];
    bidding_price = $('#amount').val();
    $('.bidding').click(function(){
        $.ajax({
            url:'/biddingKing/Bidding/BiddingHistory.php',
            type:'post',
            data:{
                price:$('#amount').val(),
                floor_price:$('#floor_price').text().split('元')[0],
                productId :$("#product_id").val()
            },
            success:function(data){
                var code = JSON.parse(data).msg;
                if(code === 'success'){
                    swal('下標成功','','success');
                    updateNavbar();
                    appendToTable();
                    sendMessage();
                    updateTopPeople();
                    updateFloorPrice();
                    updateBiddingCount();
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
    $(tbody).prepend('<tr>\
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

function updateTable(e){
    var currentName = $('.username').text();
    var e_array = JSON.parse(e.data);
    var name ;
    var now ;
    var bidding_price;
    var currentProductId = $('#product_id').val();
    var product_id ;
    if(Array.isArray(e_array)){
        name = e_array[0]['name'];
        now = e_array[0]['now'];
        bidding_price = e_array[0]['bidding_price'];
        product_id = e_array[0]['product_id'];
    }
    if(currentName !== name && name !== undefined && currentProductId === product_id){
        var tbody = $('.bidding-table').find('tbody');
        $(tbody).prepend('<tr>\
                            <td>'+ now + ' </td>\
                        <td>'+ name + '</td>\
                        <td>' + bidding_price + '</td>\
                    </tr>');
        
        updateFloorPrice();
        updateBiddingCount();
        updateTopPeople();
    }
}
function sendMessage(){ 
    var userName = $('.username').text();
    msg ={
        now:currentDateTime,
        name:userName,
        bidding_price:$("#amount").val(),
        product_id : $('#product_id').val()
    };
    websocket.send(JSON.stringify(msg));
}

function updateBiddingCount(){
    var count = $('.bidding-table tbody tr').length;
    $('#bidding_count').text(count);
}
function updateTopPeople(){
    var topPepole= $('.bidding-table tbody tr:first td:nth-child(2)').text();
    $('#top_people').text(topPepole);
}

function updateFloorPrice(){
    var tr = $('.bidding-table tbody tr');
    var tmp_floor_price = floor_price ; 
    for(var index = 0 ; index < tr.length ; index ++){
        tmp_floor_price = parseInt(tmp_floor_price) + parseInt($(tr[index]).find('td:last').text());
    }
    $('#floor_price').text(tmp_floor_price +'元');
}