<?php
require "databaseQuery.php";

class registeration {

    public function __construct() {
        $this->db = new dbQuery();
    }

     public function post($post_data, $image_data) {
        $check_post = $this->check_data($post_data);
        $check_file = $this->check_data_image($image_data);

        extract($check_post);
        extract($check_file);
        
        if (move_uploaded_file($temp, $dir) === TRUE) {
            try {
                $this->db->saveInto("INSERT", "persons", [":name"=> $name,":address"=> $address,":phone"=> $phonenumber,
                ":account_name"=> $acctname,":account_number"=> $accno,":bank_name"=> $bankname,":vmoi"=> $vmoi,
                ":formname"=>$formname,":passport_src"=>$filename])->execute();
            } catch(PDOEXCEPTION $e) {
                die("error: ". $e->getMessage());
            }    
        }

        echo "DONE";
    } 

    private function check_data($data) {
        extract($data);

        if (empty($name) || empty($address) || empty($phonenumber) || empty($acctname) || 
            empty($bankname) || empty($vmoi) || empty($accno) || empty($formname)) {
            echo "All fields are required";
            exit;
        } else {
            return $data;
        }
    }

    private function check_data_image($data) {
        
        $uploadok = 1;

        if ($data["passport"]["name"] === NULL) {
            $uploadok = 0;
            echo "please select image form your device";
            exit;
        }

        if ($data["passport"]["error"] == TRUE) {
            $uploadok = 0;
            echo "An unexpected error occured please try again or upload another image file";
            exit;
        }

        if (getimagesize($data["passport"]["tmp_name"]) === FALSE) {
            $uploadok = 0;
            echo "Please upload an image file";
            exit;
        }

        switch($data["passport"]["type"]) {
            case "image/jpeg" : // Accepted
            case "image/pjpeg": // Accepted
            case "image/png"  : // Accepted
            case "image/tif"  : // Accepted
            case "image/gif"  : $uploadok = 1; break;
            default           : $uploadok = 0; break; exit;
        }

        $directory =  "../img/upload";

        if ($uploadok !== 0) {
            $name = hash("ripemd128", $data["passport"]["name"].mt_rand(1,9)) . ".jpg";
            $dir = $directory."/".$name;
            $new_data = array(
                "dir"=>$dir,
                "temp"=>$data["passport"]["tmp_name"],
                "filename"=>$name,
                );

            return $new_data;
        }
    }


}
?>