<?php
    if(strpos($_SERVER["REQUEST_URI"],"___STRUCTURE/")){
        header("Location: dashboard.php");
    }
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $_dataAi = $_POST["password"];
        $_dataBi = $_POST["newpassword"];
        $_dataCi = $_POST["confirm"];

        $_letQUERY = $_DC->prepare("SELECT cmAccessKey FROM cmuserdata WHERE cmUserID = $ownUSERID");
        $_letQUERY->execute();
        $_letQUERY->bind_result($_dataAr);
        $_letQUERY->fetch();
        $_letQUERY->close();
        if(password_verify($_dataAi,$_dataAr)){
            if($_dataBi === $_dataCi){
                $_dataCf = password_hash($_dataCi, PASSWORD_BCRYPT);
                $_letQUERY = $_DC->prepare("UPDATE cmuserdata SET cmAccessKey = ? WHERE cmUserID = $ownUSERID");
                $_letQUERY->bind_param("s",$_dataCf);
                if($_letQUERY->execute()){
                    $_letQUERY->close();
                    header("Location: ?ubahpassword=true");
                } else{
                    header("Location: ?ubahpassword=false");
                }
            } else{
                header("Location: ?ubahpassword=false");
            }
        } else{
            header("Location: ?ubahpassword=false");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "___SCRIPT/GoogleAnalytics.php" ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    <link rel="shortcut icon" href="assets/img/unika-logo.png" type="image/x-icon">
    <style>
    <?php
        include_once "___DESIGN/password.css";
    ?>
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
                <div class="sidebar-menu-items">
                    <a href="<?php echo $_URL ?>/profil.php">
                        <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                        <span class="labels">Profil</span>
                    </a>
                </div>
                <div class="sidebar-menu-items">
                    <a href="<?php echo $_URL ?>/layanan.php<?php if($ownLICENCE == "O"){echo "?konseling";} ?>">
                        <span class="icon"><ion-icon name="school-outline"></ion-icon></span>
                        <span class="labels">Konseling</span>
                    </a>
                </div>
                <?php
                    include_once "___STRUCTURE/systemSidebarPart.php";
                ?>
                <div class="sidebar-menu-items">
                    <a href="<?php echo $_URL ?>/chatting.php">
                        <span class="icon"><ion-icon name="chatbubble-ellipses-outline"></ion-icon></span>
                        <span class="labels">Chatting</span>
                    </a>
                </div>
                <div class="sidebar-menu-items">
                    <a href="<?php echo $_URL ?>/about.php">
                        <span class="icon"><ion-icon name="alert-circle-outline"></ion-icon></span>
                        <span class="labels">Tentang Kami</span>
                    </a>
                </div>
                <div class="sidebar-menu-items active">
                    <a href="<?php echo $_URL ?>/setting.php">
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
                    <span>Ubah Password</span>
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
                <form class="setting-forms" action="" method="post" onsubmit="return formValidation()">
                    <div class="form-data">
                        <span>Password Lama</span>
                        <input type="password" name="password" maxlength="20">
                    </div>
                    <div class="form-data">
                        <span>Password Baru</span>
                        <input type="password" name="newpassword" maxlength="20">
                    </div>
                    <div class="form-data">
                        <span>Konfirmasi Password Baru</span>
                        <input type="password" name="confirm" maxlength="20">
                    </div>
                    <div class="form-button">
                        <span class="message"></span>
                        <button type="submit">Ubah Password</button>
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
                },50);
            } else{
                $(".sidebar").addClass("wrap");
                setTimeout(function(){
                    $(".sidebar-menu-items a .labels").css('display','none');
                },500);
            }
        });
        function formValidation(){
            var oldData = $(".form-data input[name='password']");
            var newData = $(".form-data input[name='newpassword']");
            var verData = $(".form-data input[name='confirm']");
            var msgExc = $(".form-button .message");

            if(oldData.val().trim() == "" || newData.val().trim() == "" || verData.val().trim() == ""){
                msgExc.html("Mohon mengisi data yang sesuai!");
                return false;
            }

            if(newData.val().trim() != verData.val().trim()){
                msgExc.html("Konfirmasi password tidak valid!");
                return false;
            }
            
            return true;
        };
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