<?php
    if(strpos($_SERVER["REQUEST_URI"],"___STRUCTURE/")){
        header("Location: dashboard.php");
    }
    $_infoID = $_GET["info"];
    if($_infoID == $ownUSERID){
        header("Location: profil.php");
    }
    $letQUERY = $_DC->prepare("SELECT cmUsername, cmUsermail, cmUsergender, cmUserbirth, cmUserphone, cmUseraddress, cmUserphoto FROM cmuserinfo WHERE cmUserID = ?");
    $letQUERY->bind_param("s",$_infoID);
    $letQUERY->execute();
    $letQUERY->bind_result($infNAME,$infMAIL,$infGENDER,$infBIRTH,$infPHONE,$infADDRESS,$infPHOTO);
    $letQUERY->fetch();
    $letQUERY->close();
    if($infGENDER == "m"){
        $infSEX = "Laki - Laki";
    } else {
        $infSEX = "Perempuan";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "___SCRIPT/GoogleAnalytics.php" ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nama Pengguna</title>
    <link rel="shortcut icon" href="assets/img/unika-logo.png" type="image/x-icon">
    <style>
    <?php
        include_once "___DESIGN/info.css";
    ?>
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="campus-ministry">
                <div class="campus-ministry-logo">
                    <img src="<?php echo $_URL ?>/assets/img/unika-logo.png" alt="">
                </div>
                <div class="campus-ministry-text">
                    <span>CAMPUS MINISTRY</span>
                </div>
            </div>
            <div class="sidebar-menu">
                <div class="sidebar-menu-items">
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
                <div class="sidebar-menu-items active">
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
                    <span>Info Pengguna</span>
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
                <div class="user-pictures">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($infPHOTO); ?>" alt="">
                </div>
                <div class="user-profil">
                    <div class="user-profil-data">
                        <span class="label">Nama</span>
                        <span class="value"><?php echo $infNAME ?></span>
                    </div>
                    <div class="user-profil-data">
                        <span class="label">Email</span>
                        <span class="value"><?php echo $infMAIL ?></span>
                    </div>
                    <div class="user-profil-data">
                        <span class="label">Jenis Kelamin</span>
                        <span class="value"><?php echo $infSEX ?></span>
                    </div>
                    <div class="user-profil-data">
                        <span class="label">Tanggal Lahir</span>
                        <span class="value"><?php echo date("d F Y", strtotime($infBIRTH)) ?></span>
                    </div>
                    <div class="user-profil-data">
                        <span class="label">No. HP</span>
                        <span class="value"><?php echo $infPHONE ?></span>
                    </div>
                    <div class="user-profil-data">
                        <span class="label">Alamat</span>
                        <span class="value"><?php echo $infADDRESS ?></span>
                    </div>
                    <div class="user-profil-control">
                        <a href="<?php echo $_URL."/chatting.php?info=".$_infoID ?>&action=true">Blokir User</a>
                    </div>
                </div>
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