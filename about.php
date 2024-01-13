<?php
    include "___SCRIPT/systemChecker.php";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "___SCRIPT/GoogleAnalytics.php" ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami</title>
    <link rel="shortcut icon" href="assets/img/unika-logo.png" type="image/x-icon">
    <style>
    <?php
        include_once "___DESIGN/about.css";
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
                <div class="sidebar-menu-items active">
                    <a href="#">
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
                    <span>Tentang Kami</span>
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
                <div>Campus Ministry adalah program atau layanan konseling yang bertujuan untuk memberikan layanan spritual,rohani,kesehatan,dan juga psikologis bagi seluruh civitas akademika Universitas Katolik Santo Thomas.</div>
                <div>Adapun Karyawan dan Konselor di Campus Ministry sebagai berikut :</div>
                <div>
                    <ul>
                        <li>RP.Gregorius Jeffrey Wibiksono,O.carm Sebagai Konselor Layanan Spiritual.</li>
                        <li>Yernita Sinaga,S.Tr.Keb Sebagai Konselor Layanan Kesehatan.</li>
                        <li>Sr.Ruminta Simamora,S.Psi.,M.Psi.,Psikolog Sebagai Konselor Layanan Psikologis/konseling.</li>
                        <li>Novenita Marpaung,S.Psi. Sebagai Konselor Layanan Psikologis/konseling.</li>
                    </ul>
                </div>
                <div>Hubungi Kami :</div>
                <div>0859-6050-4361 (RP.Gregorius Jeffrey Wibiksono,O.carm)</div>
                <div>0821-6845-8857 (Yernita Sinaga,S.Tr.Keb)</div>
                <div>0815-4616-9638 (Sr.Ruminta Simamora,S.Psi.,M.Psi)</div>
                <div>0823-2005-5540 (Novenita Marpaung,S.Psi)</div>
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