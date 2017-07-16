<?php
include_once('../DbConnection/DbConnect.php'); 

class File{
    
    private $target_dir;
    private $target_file;
    private $isSuccess;
    private $fileType;
    private $productName;
    private $description;
    private $price;
    private $promotion;
    private $timer;
    private $end_time;
    private $conn;
    
    public function __construct(){
        session_start();
        $this->target_dir = '../uploads/';
        $this->target_file = $this->target_dir . basename($_FILES['productImg']['name']);
        $this->isSuccess = false;
        $this->fileType = pathinfo($this->target_file,PATHINFO_EXTENSION);
        $this->productName = $_POST['name'];
        $this->description = $_POST['description'];
        $this->price = $_POST['price'];
        $this->promotion = $_POST['promotion'];
        $this->timer = $_POST['timer'];
        $this->conn = DbConnect::connect();
    }
    
    public function upload(){
        if(!$this->checkFileType()){
            $_SESSION['file_type_error'] = '副檔名有誤，副檔名只允許 jpg 、jpeg、bmp、png';
            return header('location:../views/upload.php');
        }

        if(!file_exists($this->target_dir)){
            mkdir($this->target_dir,'0777',true);
        }

        if(file_exists($this->target_file)){
            $_SESSION['file_exists_error'] = '檔案已經存在';
            return header('location:../views/upload.php');
        }

        $imageSize  = getimagesize($_FILES['productImg']['tmp_name']);
        if($imageSize !== false){
            $this->isSuccess = true;
        }else{
            $_SESSION['file_type_error'] = '檔案不是圖片';
            return header('location:../views/upload.php');
        }

        if (!$this->isSuccess) {
            $_SESSION['error'] ='檔案上傳失敗';
            return header('location:../views/upload.php');
        } else {
            if (move_uploaded_file($_FILES["productImg"]["tmp_name"], $this->target_file)) {
                $_SESSION['productImg'] = $_FILES['productImg']['name'];
                $this->insertData();
                return header('location:../views/upload.php');
            } else {
                $_SESSION['error'] ='檔案上傳失敗';
                return header('location:../views/upload.php');
            }
        }  
        
    }
    
    public function checkFileType(){
        $this->fileType = strtolower($this->fileType);
        if($this->fileType != 'jpg' && $this->fileType !='jpeg' && $this->fileType !='bmp' && $this->fileType != 'png'){
            return false;
        }
        return true;
    }

    public function insertData(){
        $sql = 'INSERT INTO product (name,price,description,
                created_at,file_dir,promotion,end_time)
                VALUES(:name,:price,:description,
                       :created_at,:file_dir,:promotion,
                       :end_time)';
        $query = $this->conn->prepare($sql);
        $cdate = new DateTime();
        $cdate = $cdate->format('Y-m-d H:i:s');
        $this->addHour();
        //$this->end_time = $this->end_time->format('Y-m-d');
        $query->execute(array(
            'name' => $this->productName,
            'price' => $this->price,
            'description'=> $this->description,
            'created_at' => $cdate,
            'file_dir' => $this->target_file,
            'promotion'=>$this->promotion,
            'end_time' => $this->end_time
        ));
    }

    public function addHour(){
        $now = new DateTime(); //current date/time;
        $now = $now->format('Y-m-d H:i:s');
        $this->end_time = date('Y-m-d H:i:s', strtotime($now . ' + ' . $this->timer .' hour'));
        //$this->end_time = date("Y-m-d H:i:s", strtotime('+'. $this->timer .'hours', $now));
    }
}
$file = new File();
$file->upload();
?>