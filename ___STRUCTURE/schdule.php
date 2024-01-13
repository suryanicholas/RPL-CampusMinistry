<?php
    if(strpos($_SERVER["REQUEST_URI"],"___STRUCTURE/")){
        header("Location: dashboard.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "___SCRIPT/GoogleAnalytics.php" ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Layanan</title>
    <link rel="shortcut icon" href="assets/img/unika-logo.png" type="image/x-icon">
    <style>
        <?php include_once "___DESIGN/schdule.css"; ?>
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
                <div class="sidebar-menu-items active">
                    <a href="<?php echo $_URL?>/layanan.php">
                        <span class="icon"><ion-icon name="school-outline"></ion-icon></span>
                        <span class="labels">Konseling</span>
                    </a>
                </div>
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
                    <span>Jadwal Layanan</span>
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
                <div class="search-schdules">
                    <div class="search-forms">
                        <div class="label">Tentukan Tanggal</div>
                        <div class="value">
                            <input type="date" name="schdules">
                        </div>
                    </div>
                    <div class="search-control">
                        <button>Cari Jadwal</button>
                    </div>
                </div>
                <div class="content-table">
                    <div class="table-head">
                        <div class="title">Nama</div>
                        <div class="title">Sesi 1</div>
                        <div class="title">Sesi 2</div>
                        <div class="title">Sesi 3</div>
                        <div class="title">Sesi 4</div>
                        <div class="title">Sesi 5</div>
                        <div class="title">Sesi 6</div>
                        <div class="title">Sesi 7</div>
                    </div>
                    <div class="table-body">
                        <div class="table-row">
                            <div class="table-column">Nama Konselor yang sangat amat panjang</div>
                            <div class="table-column"><ion-icon name="close-circle"></ion-icon></div>
                            <div class="table-column"><ion-icon name="checkmark-circle"></ion-icon></div>
                            <div class="table-column"><ion-icon name="checkmark-circle"></ion-icon></div>
                            <div class="table-column"><ion-icon name="checkmark-circle"></ion-icon></div>
                            <div class="table-column"><ion-icon name="checkmark-circle"></ion-icon></div>
                            <div class="table-column"><ion-icon name="checkmark-circle"></ion-icon></div>
                            <div class="table-column"><ion-icon name="checkmark-circle"></ion-icon></div>
                        </div>
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