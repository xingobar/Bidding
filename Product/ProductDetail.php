<?php
include_once('../DbConnection/DbConnect.php');
include_once('../Bidding/BiddingDetail.php');

class ProductDetail{

    private $id ;
    private $conn;

    public function __construct(){
        $this->id = $_GET['id'];
        $this->conn = DbConnect::connect();
    }

    public function getProduct(){
        $sql = 'SELECT * FROM product WHERE id = :id';
        $query = $this->conn->prepare($sql);
        $query->execute(array(
            'id'=>$this->id
        ));
        $productDetail = $query->fetch();
        return $productDetail;
    }

    public function showProduct(){
        $biddingDetail = new BiddingDetail($this->id);
        $detail = $this->getProduct();
        $response =  <<<REQUEST
        <div class="col-md-4" style=height:255px;background-color:#f5f2f2">
            <div class="thumbnail" style="height:255px;">
                <img src="{$detail['file_dir']}" alt="">
            </div>
        </div>
        <div class="col-md-4" style="height:auto;background-color:#f5f2f2">
            <div class="caption" style="height:255px;">
                <div class="row">
                    <div class="text-center col-md-12">
                        <h2 id="floor_price">{$detail['price']}<span clsas="unit">元</span></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 style="margin-top:10px;"><strong class="timer">{$detail['end_time']}</strong></h1>
                    </div>
                </div>
                <div class="row" style="padding-bottom:10px;">
                    <div class="col-md-12 text-center">
                        <input id="amount" style="height:45px;border-radius:5px;" type="number" name="amount" placeholder="請輸入金額"/>
                        <input type="hidden" id="product_id" value="{$_GET['id']}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-danger bidding" style="font-size:1.2em;width:150px;height:50px;">產品下標</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 text-center" style="padding-top:10px;">
                                <p>每次下標扣除5點</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-right">
                                <h5>底標 : </h5>
                            </div>
                            <div class="col-md-6">
                                <h5>test</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-right">
                                <h5>最高下注人：</h5>
                            </div>
                            <div class="col-md-6">
                                <h5 id="top_people">tttt</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-right">
                                <h5>下標次數：</h5>
                            </div>
                            <div class="col-md-6">
                                <h5 id="bidding_count">100</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="height:255px;overflow:scroll">
            <table class="table bidding-table">
                <thead>
                    <tr>
                        <th>時間</th>
                        <th>玩家姓名</th>
                        <th>金額</th>
                    </tr>
                </thead>
                <tbody>
REQUEST;
           
             $response = $response . $biddingDetail->getAll();
             $response = $response . <<<RESPONSE
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h3>產品規格</h3>
            <div style="width:100%;border-top:1px solid silver">
                <p style="padding:15px;">
                    <small>
                        Stay connected either on the phone or the Web with the Galaxy S4 I337 from Samsung. With 16 GB of memory and a 4G connection, this phone stores precious photos and video and lets you upload them to a cloud or social network at blinding-fast speed. With a 17-hour operating life from one charge, this phone allows you keep in touch even on the go. 
        
                        With its built-in photo editor, the Galaxy S4 allows you to edit photos with the touch of a finger, eliminating extraneous background items. Usable with most carriers, this smartphone is the perfect companion for work or entertainment.
                    </small>
                </p>
                <small>
                    <ul>
                        <li>Super AMOLED capacitive touchscreen display with 16M colors</li>
                        <li>Available on GSM, AT T, T-Mobile and other carriers</li>
                        <li>Compatible with GSM 850 / 900 / 1800; HSDPA 850 / 1900 / 2100 LTE; 700 MHz Class 17 / 1700 / 2100 networks</li>
                        <li>MicroUSB and USB connectivity</li>
                        <li>Interfaces with Wi-Fi 802.11 a/b/g/n/ac, dual band and Bluetooth</li>
                        <li>Wi-Fi hotspot to keep other devices online when a connection is not available</li>
                        <li>SMS, MMS, email, Push Mail, IM and RSS messaging</li>
                        <li>Front-facing camera features autofocus, an LED flash, dual video call capability and a sharp 4128 x 3096 pixel picture</li>
                        <li>Features 16 GB memory and 2 GB RAM</li>
                        <li>Upgradeable Jelly Bean v4.2.2 to Jelly Bean v4.3 Android OS</li>
                        <li>17 hours of talk time, 350 hours standby time on one charge</li>
                        <li>Available in white or black</li>
                        <li>Model I337</li>
                        <li>Package includes phone, charger, battery and user manual</li>
                        <li>Phone is 5.38 inches high x 2.75 inches wide x 0.13 inches deep and weighs a mere 4.59 oz </li>
                    </ul>  
                </small>
            </div>
        </div>
RESPONSE;

        echo $response;
    }
    
}
?>