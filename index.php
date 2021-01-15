<?php
    error_reporting(0);

    function stringValidation($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function randToken() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 24; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

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

        $token = randToken();

        $getToken = "INSERT INTO token_request (kelompok, token) VALUES ('$kelompok', '$token');";
        if ($kon->query($getToken) === FALSE){
            header("location: http://kapfileup.000webhostapp.com?error=inputTokenGagal");
        }

        session_start();
        $_SESSION['token'] = $token;
    }

    if (isset($_REQUEST['error'])) {
        switch ($_GET['error']) {
            case "kelompokSalah":
                $backMessage = "Kelompok Kamu Salah!";
                break;
            case "inputTokenGagal":
                $backMessage = "Token Kamu Salah!";
                break;
            case "gagalHapusToken":
                $backMessage = "Maaf ada error saat menghapus token";
                break;
            case "aksesDitolak":
                $backMessage = "Pake token dulu ya bang!";
                break;
            case "bukanGambar":
                $backMessage = "Hanya boleh upload gambar ya!";
                break;
            case "gambarSudahAda":
                $backMessage = "Kamu udah pernah upload file ini";
                break;
            case "terlaluBesar":
                $backMessage = "Max 5MB ya bang jaog";
                break;
            case "formatSalah":
                $backMessage = "Hanya boleh file tipe jpg, png, jpeg sama gif ya!";
                break;
            case "uploadGagal":
                $backMessage = "Maaf ada error saat mengupload file";
                break;
            default:
                $backMessage = "Maaf pesan tidak dikenali";
        }
    } else if (isset($_REQUEST['upload'])) {
        if ($_REQUEST['upload'] == "success") {
            $backMessage = "Berhasil upload gan";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Tugas KAP File Upload</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="tema/images/icons/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="tema/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="tema/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="tema/vendor/animate/animate.css">
        <link rel="stylesheet" type="text/css" href="tema/vendor/css-hamburgers/hamburgers.min.css">
        <link rel="stylesheet" type="text/css" href="tema/vendor/animsition/css/animsition.min.css">
        <link rel="stylesheet" type="text/css" href="tema/vendor/select2/select2.min.css">
        <link rel="stylesheet" type="text/css" href="tema/vendor/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" type="text/css" href="tema/css/util.css">
        <link rel="stylesheet" type="text/css" href="tema/css/main.css">
    </head>
    <body>
        <div class="container-contact100">
            <div class="wrap-contact100">
                <?php if(isset($_POST['kelompok'])) : ?>
                    <form class="contact100-form validate-form" action='upload.php' method='POST' enctype='multipart/form-data'>
                        <span class="contact100-form-title">Silahkan Upload Gambarmu!</span>
                        <input type="hidden" name="kelompok" value="<?php echo $kelompok ?>">
                        <div class="wrap-input100 validate-input" data-validate="Image is required">
                            <span class="label-input100">Gambar</span>
                            <input class="input100" type="file" name="fileToUpload" id="filetoUpload">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="container-contact100-form-btn">
                            <div class="wrap-contact100-form-btn">
                                <div class="contact100-form-bgbtn"></div>
                                <button class="contact100-form-btn" type="submit" name="submit">
                                    <span>
                                        Upload
                                        <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                    <a href="file-list.php">
                        <span class="label-input100 text-file">File List
                            <i class="fa fa-download" aria-hidden="true"></i>
                        </span>
                    </a>
                <?php else: ?>
                    <form class="contact100-form validate-form" action='index.php' method='POST' enctype='multipart/form-data'>
                        <span class="contact100-form-title">Kelompok Berapa?</span>

                        <div class="wrap-input100 input100-select">
                            <span class="label-input100 text-file">
                                <?php echo $backMessage; ?>
                            </span>
                            <span class="label-input100">Kelompok</span>
                            <div>
                                <select class="selection-2" name="kelompok" id="kelompok">
                                    <option value="Kelompok 1">Kelompok 1</option>
                                    <option value="Kelompok 2">Kelompok 2</option>
                                    <option value="Kelompok 3">Kelompok 3</option>
                                    <option value="Kelompok 4">Kelompok 4</option>
                                    <option value="Kelompok 5">Kelompok 5</option>
                                    <option value="Kelompok 6">Kelompok 6</option>
                                    <option value="Kelompok 7">Kelompok 7</option>
                                </select>
                            </div>
                            <span class="focus-input100"></span>
                        </div>
                        <div class="container-contact100-form-btn">
                            <div class="wrap-contact100-form-btn">
                                <div class="contact100-form-bgbtn"></div>
                                <button class="contact100-form-btn" type="submit" name="submit">
                                    <span>
                                        Gaskan
                                        <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                    <a href="file-list.php">
                        <span class="label-input100 text-file">File List
                            <i class="fa fa-download" aria-hidden="true"></i>
                        </span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div id="dropDownSelect1"></div>

        <script src="tema/vendor/jquery/jquery-3.2.1.min.js"></script>
        <script src="tema/vendor/animsition/js/animsition.min.js"></script>
        <script src="tema/vendor/bootstrap/js/popper.js"></script>
        <script src="tema/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="tema/vendor/select2/select2.min.js"></script>
        <script>
            $(".selection-2").select2({
                minimumResultsForSearch: 20,
                dropdownParent: $('#dropDownSelect1')
            });
        </script>
        <script src="tema/js/main.js"></script>

    </body>
</html>