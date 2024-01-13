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
    <title>Layanan Psikologi</title>
    <link rel="shortcut icon" href="assets/img/unika-logo.png" type="image/x-icon">
    <style>
        <?php include_once "___DESIGN/konseling.css"; ?>
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
                    <a href="#">
                        <span class="icon"><ion-icon name="school-outline"></ion-icon></span>
                        <span class="labels">Konseling</span>
                    </a>
                </div>
                <div class="sidebar-menu-items">
                    <a href="<?php echo $_URL?>/manage.php">
                        <span class="icon"><ion-icon name="school-outline"></ion-icon></span>
                        <span class="labels">Manage User</span>
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
                    <span>Layanan Psikologi</span>
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
                <div class="content-table">
                    <div class="table-head">
                        <div class="title">Nama</div>
                        <div class="title">Tanggal Konseling</div>
                        <div class="title">Sesi</div>
                        <div class="title">Aksi</div>
                    </div>
                    <div class="table-body">
                        <?php
                            $_letQUERY = $_DC->prepare("SELECT cd.csDataID, cu.cmUsername, cd.csDate, cd.csSesi FROM cmuserinfo cu INNER JOIN csdata cd ON cu.cmUserID = cd.csUserID WHERE cd.csKonselor = $ownUSERID AND cd.csSTATUS = 'W'");
                            $_letQUERY->execute();
                            $_letRESULT = $_letQUERY->get_result();
                            while($row = $_letRESULT->fetch_assoc()){
                        ?>
                            <div class="table-row">
                                <div class="table-column"><?php echo $row['cmUsername'] ?></div>
                                <div class="table-column"><?php echo $row['csDate'] ?></div>
                                <div class="table-column"><?php echo $row['csSesi'] ?></div>
                                <div class="table-column">
                                    <a href="<?php echo $_URL ?>/layanan.php?konseling=<?php echo bin2hex(base64_encode($row["csDataID"])) ?>&action=accept">Terima</a>
                                    <a href="<?php echo $_URL ?>/layanan.php?konseling=<?php echo bin2hex(base64_encode($row["csDataID"])) ?>&action=reject">Tolak</a>
                                </div>
                            </div>
                        <?php 
                            }
                            $_letQUERY->close();
                        ?>
                    </div>
                </div>
                <div class="forms-note">
                    <div class="note-head">Keterangan</div>
                    <div class="note-body">
                        <span>Sesi I : 08.00 WIB - 09.00 WIB</span>
                        <span>Sesi II : 09.00 WIB - 10.00 WIB</span>
                        <span>Sesi III : 10.00 WIB - 11.00 WIB</span>
                        <span>Sesi IV : 11.00 WIB - 12.00 WIB</span>
                        <span>Sesi V : 13.00 WIB - 14.00 WIB</span>
                        <span>Sesi VI : 14.00 WIB - 15.00 WIB</span>
                        <span>Sesi VII : 15.00 WIB - 16.00 WIB</span>
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