<?php
    include "connection.php";

    error_reporting(0);

    session_start();

    function stringValidation($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $token = $_SESSION['token'];
    if ($checkToken = mysqli_query($kon, "SELECT token FROM token_request WHERE token='$token';")) {
        if (mysqli_num_rows($checkToken) > 0) {
            $deleteToken = "DELETE FROM token_request WHERE token='$token';";
            if ($kon->query($deleteToken) === FALSE){
                header("location: http://kapfileup.000webhostapp.com?error=gagalHapusToken");
            }
        } else {
            header("location: http://kapfileup.000webhostapp.com?error=aksesDitolak");
        }
    }

    
    session_destroy();


    if(isset($_POST['kelompok'])) {
        include "connection.php";
        //Insert database for token
        $kelompok = stringValidation($_POST['kelompok']);
        switch ($kelompok) {
            case "Kelompok 1":
            case "Kelompok 2":
            case "Kelompok 3":
            case "Kelompok 4":
            case "Kelompok 5":
            case "Kelompok 6":
            case "Kelompok 7":
            case "Kelompok 8":
                break;
            default:
                header("location: http://kapfileup.000webhostapp.com?error=kelompokSalah");
        }

        $kelompok = stringValidation($_POST['kelompok']);
        $target_dir = "inifolderbuatuploadgan/".$kelompok."_".md5($kelompok)."/";
    
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
    
        $nama_file = basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir.date("Y-m-d_h-i-s_").md5($nama_file)."_".$nama_file;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            header("location: http://kapfileup.000webhostapp.com?error=formatSalah");
            $uploadOk = 0;
        }
    
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 0;
                try{
                    if($imageCheck = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"])){
                        $uploadOk = 1;
                    } else if($imageCheck = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"])){
                        $uploadOk = 1;
                    } else{
                        $uploadOk = 0;
                    }
                    if($uploadOk == 1){
                        try{
                            $xCheck = rand(0, imagesx($imageCheck)-1);
                            $yCheck = rand(0, imagesy($imageCheck)-1);
                            $colors = array();
        
                            $rgb = imagecolorat($imageCheck, $xCheck, $yCheck);
                            $colors['r'] = ($rgb >> 16) & 0xFF;
                            $colors['g'] = ($rgb >> 8) & 0xFF;
                            $colors['b'] = $rgb & 0xFF;
        
                            $uploadOk = 1;
                        } catch(Exception $e){
                            $uploadOk = 0;
                        }
                    }
                } catch(Exception $e){
                    $uploadOk = 0;
                }
            } else {
                header("location: http://kapfileup.000webhostapp.com?error=bukanGambar");
                $uploadOk = 0;
            }
        }
    
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            header("location: http://kapfileup.000webhostapp.com?error=ukuranTerlaluBesar");
            $uploadOk = 0;
        }
    
        // Check if file already exists
        if (file_exists($target_file)) {
            header("location: http://kapfileup.000webhostapp.com?error=gambarSudahAda");
            $uploadOk = 0;
        }
    
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            header("location: http://kapfileup.000webhostapp.com?error=uploadGagal");
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $successUpload = "INSERT INTO uploaded_image (kelompok, token, nama_file, alamat_file) VALUES ('$kelompok', '$token', '$nama_file', '$target_file');";
                if ($kon->query($successUpload) === FALSE){
                    header("location: http://kapfileup.000webhostapp.com?error=uploadGagal");
                }
    
                header("location: http://kapfileup.000webhostapp.com?upload=success");
            } else {
                header("location: http://kapfileup.000webhostapp.com?error=uploadGagal");
            }
        }
    } else {
        header("location: http://kapfileup.000webhostapp.com?error=kelompokSalah");
    }
?>
