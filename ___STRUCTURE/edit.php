<?php
    if(strpos($_SERVER["REQUEST_URI"],"___STRUCTURE/")){
        header("Location: dashboard.php");
    }

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $_dataAi = $_POST["username"];
        $_dataBi = $_POST["usermail"];
        $_dataCi = $_POST["usercontact"];
        $_dataDi = $_POST["useraddr"];

        if(isset($_FILES["userphoto"]) && $_FILES["userphoto"]["error"] === 0){
            $_dataEi = file_get_contents($_FILES["userphoto"]["tmp_name"]);
            $_letQUERY = $_DC->prepare("UPDATE cmuserinfo SET cmUsername = ?, cmUsermail = ?, cmUserphone = ?, cmUseraddress = ?, cmUserphoto = ? WHERE cmUserID = $ownUSERID");
            $_letQUERY->bind_param("sssss",$_dataAi,$_dataBi,$_dataCi,$_dataDi,$_dataEi);
        } else{
            $_letQUERY = $_DC->prepare("UPDATE cmuserinfo SET cmUsername = ?, cmUsermail = ?, cmUserphone = ?, cmUseraddress = ? WHERE cmUserID = $ownUSERID");
            $_letQUERY->bind_param("ssss",$_dataAi,$_dataBi,$_dataCi,$_dataDi);
        }

        if($_letQUERY->execute()){
            header("Location: ?edit=success");
        } else{
            header("Location: ?edit=error");
        }
        $_letQUERY->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "___SCRIPT/GoogleAnalytics.php" ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="shortcut icon" href="assets/img/unika-logo.png" type="image/x-icon">
    <style>
        <?php include_once "___DESIGN/edit.css"; ?>
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="campus-ministry">
                <div class="campus-ministry-logo">
                    <img src="assets/img/unika-logo.png" alt="">
                </div>
                <div class="campus-ministry-text">
                    <span>CAMPUS MINISTRY</span>
                </div>
            </div>
            <div class="sidebar-menu">
                <div class="sidebar-menu-items active">
                    <a href="<?php echo $_URL?>/profil.php">
                        <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                        <span class="labels">Profil</span>
                    </a>
                </div>
                <div class="sidebar-menu-items">
                    <a href="<?php echo $_URL?>/layanan.php<?php if($ownLICENCE == "O"){echo "?konseling";} ?>">
                        <span class="icon"><ion-icon name="school-outline"></ion-icon></span>
                        <span class="labels">Konseling</span>
                    </a>
                </div>
                <?php
                    include_once "___STRUCTURE/systemSidebarPart.php";
                ?>
                <div class="sidebar-menu-items">
                    <a href="<?php echo $_URL?>/chatting.php">
                        <span class="icon"><ion-icon name="chatbubble-ellipses-outline"></ion-icon></span>
                        <span class="labels">Chatting</span>
                    </a>
                </div>
                <div class="sidebar-menu-items">
                    <a href="<?php echo $_URL?>/about.php">
                        <span class="icon"><ion-icon name="alert-circle-outline"></ion-icon></span>
                        <span class="labels">Tentang Kami</span>
                    </a>
                </div>
                <div class="sidebar-menu-items">
                    <a href="<?php echo $_URL?>/setting.php">
                        <span class="icon"><ion-icon name="settings-outline"></ion-icon></span>
                        <span class="labels">Pengaturan</span>
                    </a>
                </div>
                <div class="sidebar-menu-items">
                    <a href="#logout" id="confirmation-button">
                        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                        <span class="labels">Log Out</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="contents">
            <div class="content-header">
                <div class="sidebar-button">
                    <ion-icon name="menu"></ion-icon>
                </div>
                <div class="content-title">
                    <span>Profil</span>
                </div>
                <div class="header-navigations">
                    <a href="<?php echo $_URL?>/inbox.php" title="Inbox"><ion-icon name="mail-outline"></ion-icon></a>
                    <a href="<?php echo $_URL?>/profil.php" title="Profil">
                    <?php
                        echo '
                        <img src="data:image/jpeg;base64,'.base64_encode($ownPHOTO).'" alt="">
                        <span>'.$ownNAME.'</span>
                        ';    
                    ?>
                    </a>
                </div>
            </div>
            <div class="content-body">
                <form action="" method="post" onsubmit="return formRules();" enctype="multipart/form-data">
                    <div class="user-pictures">
                        <label>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($ownPHOTO); ?>" alt="">
                            <input type="file" name="userphoto" id="userphoto" onchange="previewImage(event, 'preview')" hidden>
                            <span class="label">Ganti Foto</span>
                        </label>
                    </div>
                    <div class="user-profil">
                        <div class="user-profil-data">
                            <span class="label">Nama</span>
                            <input type="text" class="value" name="username" value="<?php echo $ownNAME ?>">
                        </div>
                        <div class="user-profil-data">
                            <span class="label">Email</span>
                            <input type="email" class="value" name="usermail" value="<?php echo $ownMAIL ?>">
                        </div>
                        <div class="user-profil-data">
                            <span class="label">Jenis Kelamin</span>
                            <span class="value"><?php echo $ownSEX ?></span>
                        </div>
                        <div class="user-profil-data">
                            <span class="label">Tanggal Lahir</span>
                            <span class="value"><?php echo date("d F Y", strtotime($ownBIRTH)) ?></span>
                        </div>
                        <div class="user-profil-data">
                            <span class="label">No. HP</span>
                            <input type="text" class="value" name="usercontact" value="<?php echo $ownPHONE ?>">
                        </div>
                        <div class="user-profil-data">
                            <span class="label">Alamat</span>
                            <input type="text" class="value" name="useraddr" value="<?php echo $ownADDRESS ?>">
                        </div>
                        <div class="user-profil-control">
                            <div class="alert-message">
                                <?php
                                    if(isset($_GET["edit"])){
                                        if($_GET["edit"] === "success"){
                                            echo "Perubahan telah disimpan!";
                                        } else if($_GET["edit"] === "error"){
                                            echo "Terjadi kesalahan saat menyimpan perubahan!";
                                        }
                                    }
                                ?>
                            </div>
                            <a href="<?php echo $_URL?>/profil.php">Kembali</a>
                            <button type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include_once "___STRUCTURE/systemLogoutPart.php" ?>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".container").css('opacity','1');
        });
        $(".sidebar-button ion-icon").click(function(){
            if($(".sidebar").hasClass("wrap")){
                $(".sidebar-menu-items a .labels").css('display','block');
                setTimeout(function(){
                    $(".sidebar").removeClass("wrap");
                    $(".contents").css('width','calc(100vw - 260px)');
                },50);
            } else{
                $(".sidebar").addClass("wrap");
                $(".contents").css('width','calc(100vw - 60px)');
                setTimeout(function(){
                    $(".sidebar-menu-items a .labels").css('display','none');
                },500);
            }
        });
        function previewImage(event, target) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var previewUser = $("#" + target);
                previewUser.attr('src', src);
                previewUser.css('display', 'block');
            }
        };
        function formRules(){
            var letCheck = true;
            if($("input[name='username']").val().trim() === ""){
                $(".alert-message").html("Terdapat data kosong!");
                letCheck = false;
            }
            if($("input[name='usermail']").val().trim() === ""){
                $(".alert-message").html("Terdapat data kosong!");
                letCheck = false;
            }
            if($("input[name='usercontact']").val().trim() === ""){
                $(".alert-message").html("Terdapat data kosong!");
                letCheck = false;
            }
            if($("input[name='useraddr']").val().trim() === ""){
                $(".alert-message").html("Terdapat data kosong!");
                letCheck = false;
            }
            if($("input[name='userphoto']").val().trim() !== ""){
                const isAllowed = ["image/jpeg", "image/jpg"];
                if($("input[name='userphoto']")[0].files[0].size > 5 * 1024 * 1024){
                    $(".alert-message").html("Ukuran file maksimal 5mb.");
                    letCheck = false;
                } else if(!isAllowed.includes($("input[name='userphoto']")[0].files[0].type)){
                    $(".alert-message").html("Hanya format .jpg atau .jpeg yang di izinkan!");
                    letCheck = false;
                } else if($(".user-pictures label img").width() != $(".user-pictures label img").height()){
                    $(".alert-message").html("Pilih gambar dengan Aspect Ratio 1:1 atau bentuk persegi.");
                    letCheck = false;
                }
            }
            return letCheck;
        }
        $("#confirmation-button").click(function(){
            if($(".confirmation-area").hasClass("show")){
                $(".confirmation-area").removeClass("show");
                setTimeout(function(){
                    $(".logout-confirmation").css('display','none');
                },500);
            } else{
                $(".logout-confirmation").css('display','flex');
                setTimeout(function(){
                    $(".confirmation-area").addClass("show");
                },10);
            }
        });
        function cancelConfirmation(){
            $(".confirmation-area").removeClass("show");
            setTimeout(function(){
                $(".logout-confirmation").css('display','none');
            },500);
        }
    </script>
</body>
</html>