<?php
    include "___SCRIPT/systemChecker.php";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "___SCRIPT/GoogleAnalytics.php" ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
    <link rel="shortcut icon" href="assets/img/unika-logo.png" type="image/x-icon">
    <style>
    <?php
        include_once "___DESIGN/inbox.css";
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
                    <span>Inbox</span>
                </div>
                <div class="header-navigations">
                    <a href="#" title="Inbox"><ion-icon name="mail"></ion-icon></a>
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
                <?php 
                    $letQUERY = $_DC->prepare("SELECT inDataID, inTitle FROM indata WHERE inUserID = $ownUSERID AND inREAD = 'F'");
                    $letQUERY->execute();
                    $letRESULT = $letQUERY->get_result();
                    if($letRESULT->num_rows === 0){
                        echo '<div class="ministry-inbox">'."\n";
                        echo '<div class="ministry-inbox-text">Tidak ada apapun disini</div>'."\n";
                        echo '</div>'."\n";
                    } else{
                        while($row = $letRESULT->fetch_assoc()){
                            echo '<div class="inbox-items">'."\n";
                            echo '<a href="'.$_URL."/inbox.php?catch=".bin2hex(base64_encode($row["inDataID"])).'&read">'."\n";
                            echo '<ion-icon name="mail-unread-outline"></ion-icon>'."\n";
                            echo '<div class="inbox-details">'."\n";
                            echo '<div class="inbox-title">'.$row["inTitle"].'</div>'."\n";
                            echo '<div class="inbox-message">Tekan untuk melihat isi pesan!</div>'."\n";
                            echo '</div>'."\n";
                            echo '</a>'."\n";
                            echo '</div>'."\n";
                        }
                    }
                    $letQUERY->close();
                ?>
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