<?php
    $pageAUTHORITY = "S";
    if(isset($_GET["jadwalku"]) && isset($_GET["action"])){
        include "___ROOT/___CONFIG.php";
        $_CSTOKEN = base64_decode(hex2bin($_GET["jadwalku"]));
        if($_GET['action'] === "clear" || $_GET['action'] === "cancel"){
            $_letQUERY = $_DC->prepare("DELETE FROM csdata WHERE csDataID = ?");
            $_letQUERY->bind_param("s",$_CSTOKEN);
            if($_letQUERY->execute()){
                header("Location: layanan.php?jadwalku");
            } else{
                header("Location: layanan.php?jadwalku=error");
            }
        } else{
            header("Location: layanan.php?jadwalku=error");
        }
    }else if(isset($_GET["konseling"]) && isset($_GET["action"])){
        $pageAUTHORITY = "O";
        include "___ROOT/___CONFIG.php";
        $_CSTOKEN = base64_decode(hex2bin($_GET["konseling"]));
        if($_GET['action'] === "accept"){
            $_letQUERY = $_DC->prepare("UPDATE csdata SET csSTATUS = 'A' WHERE csDataID = ?");
            $_letQUERY->bind_param("s",$_CSTOKEN);
            if($_letQUERY->execute()){
                $_letQUERY->close();

                $_letQUERY = $_DC->prepare("SELECT csUserID FROM csdata WHERE csDataID = ?");
                $_letQUERY->bind_param("s",$_CSTOKEN);
                $_letQUERY->execute();
                $_letQUERY->bind_result($sentID);
                $_letQUERY->fetch();
                $_letQUERY->close();

                $_sentAi = openssl_random_pseudo_bytes(16);
                $_sentBi = $sentID;
                $_sentCi = "Layanan Konseling";
                $_sentDi = "Permintaan anda telah disetujui oleh Konselor terkait. Silahkan periksa Jadwal Anda di Halaman Konseling";
                $_sentEi = date('Y-m-d H:i:s');
                $_letQUERY = $_DC->prepare("INSERT INTO indata VALUES(?,?,?,?,?,'F')");
                $_letQUERY->bind_param("sssss",$_sentAi,$_sentBi,$_sentCi,$_sentDi,$_sentEi);
                $_letQUERY->execute();
                $_letQUERY->close();
                header("Location: layanan.php?konseling");
            } else{
                $_letQUERY->close();
                header("Location: layanan.php?konseling=error");
            }
        } else if($_GET['action'] === "reject"){
            $_letQUERY = $_DC->prepare("UPDATE csdata SET csSTATUS = 'R' WHERE csDataID = ?");
            $_letQUERY->bind_param("s",$_CSTOKEN);
            if($_letQUERY->execute()){
                $_letQUERY->close();

                $_letQUERY = $_DC->prepare("SELECT csUserID FROM csdata WHERE csDataID = ?");
                $_letQUERY->bind_param("s",$_CSTOKEN);
                $_letQUERY->execute();
                $_letQUERY->bind_result($sentID);
                $_letQUERY->fetch();
                $_letQUERY->close();

                $_sentAi = openssl_random_pseudo_bytes(16);
                $_sentBi = $sentID;
                $_sentCi = "Layanan Konseling";
                $_sentDi = "Permintaan anda telah disetujui oleh Konselor terkait. Silahkan periksa Jadwal Anda di Halaman Konseling";
                $_sentEi = date('Y-m-d H:i:s');
                $_letQUERY = $_DC->prepare("INSERT INTO indata VALUES(?,?,?,?,?,'F')");
                $_letQUERY->bind_param("sssss",$_sentAi,$_sentBi,$_sentCi,$_sentDi,$_sentEi);
                $_letQUERY->execute();
                $_letQUERY->close();
                header("Location: layanan.php?konseling");
            } else{
                $_letQUERY->close();
                header("Location: layanan.php?konseling=error");
            }
        } else{
            header("Location: layanan.php?konseling=error");
        }
    } else if(isset($_GET['psikologi'])){
        include "___SCRIPT/systemChecker.php";
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $_setZi = openssl_random_pseudo_bytes(32);
            $_setAi = $_POST["userid"];
            $_setBi = $_POST["username"];
            $_setCi = $_POST["servicedate"];
            $_setDi = $_POST["konselor"];
            $_setEi = $_POST["metode"];
            $_setFi = $_POST["session"];
            if(isset($_POST["session"]) && is_array($_POST["session"])){
                $_setFi = implode('', $_POST["session"]);
            }

            $_letQUERY = $_DC->prepare("SELECT cmUserID FROM cmuserinfo WHERE cmUsername = ?");
            $_letQUERY->bind_param("s",$_setDi);
            $_letQUERY->execute();
            $_letQUERY->bind_result($_setDi);
            if($_letQUERY->fetch()){
                $_letQUERY->close();
            } else{
                $_letQUERY->close();
                header("Location: layanan.php?error");
            }

            $_letQUERY = $_DC->prepare("INSERT INTO csdata VALUES(?,'Psikologi',?,?,?,?,?,'W')");
            $_letQUERY->bind_param("ssssss",$_setZi,$_setAi,$_setDi,$_setCi,$_setEi,$_setFi);
            if($_letQUERY->execute()){
                $_letQUERY->close();
                header ("Location: layanan.php?success");
            } else{
                $_letQUERY->close();
                header ("Location: layanan.php?failed");
            }
        }
        include_once "___STRUCTURE/psikologi.php";
        exit;
    } else if(isset($_GET['kesehatan'])){
        include "___SCRIPT/systemChecker.php";
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $_setZi = openssl_random_pseudo_bytes(32);
            $_setAi = $_POST["userid"];
            $_setBi = $_POST["username"];
            $_setCi = $_POST["servicedate"];
            $_setDi = $_POST["konselor"];
            $_setEi = $_POST["metode"];
            $_setFi = $_POST["session"];
            if(isset($_POST["session"]) && is_array($_POST["session"])){
                $_setFi = implode('', $_POST["session"]);
            }

            $_letQUERY = $_DC->prepare("SELECT cmUserID FROM cmuserinfo WHERE cmUsername = ?");
            $_letQUERY->bind_param("s",$_setDi);
            $_letQUERY->execute();
            $_letQUERY->bind_result($_setDi);
            if($_letQUERY->fetch()){
                $_letQUERY->close();
            } else{
                $_letQUERY->close();
                header("Location: layanan.php?error");
            }

            $_letQUERY = $_DC->prepare("INSERT INTO csdata VALUES(?,'Kesehatan',?,?,?,?,?,'W')");
            $_letQUERY->bind_param("ssssss",$_setZi,$_setAi,$_setDi,$_setCi,$_setEi,$_setFi);
            if($_letQUERY->execute()){
                $_letQUERY->close();
                header ("Location: layanan.php?success");
            } else{
                $_letQUERY->close();
                header ("Location: layanan.php?failed");
            }
        }
        include_once "___STRUCTURE/kesehatan.php";
        exit;
    } else if(isset($_GET['spiritual'])){
        include "___SCRIPT/systemChecker.php";
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $_setZi = openssl_random_pseudo_bytes(32);
            $_setAi = $_POST["userid"];
            $_setBi = $_POST["username"];
            $_setCi = $_POST["servicedate"];
            $_setDi = $_POST["konselor"];
            $_setEi = $_POST["metode"];
            $_setFi = $_POST["session"];
            if(isset($_POST["session"]) && is_array($_POST["session"])){
                $_setFi = implode('', $_POST["session"]);
            }

            $_letQUERY = $_DC->prepare("SELECT cmUserID FROM cmuserinfo WHERE cmUsername = ?");
            $_letQUERY->bind_param("s",$_setDi);
            $_letQUERY->execute();
            $_letQUERY->bind_result($_setDi);
            if($_letQUERY->fetch()){
                $_letQUERY->close();
            } else{
                $_letQUERY->close();
                header("Location: layanan.php?error");
            }

            $_letQUERY = $_DC->prepare("INSERT INTO csdata VALUES(?,'Spiritual',?,?,?,?,?,'W')");
            $_letQUERY->bind_param("ssssss",$_setZi,$_setAi,$_setDi,$_setCi,$_setEi,$_setFi);
            if($_letQUERY->execute()){
                $_letQUERY->close();
                header ("Location: layanan.php?success");
            } else{
                $_letQUERY->close();
                header ("Location: layanan.php?failed");
            }
        }
        include_once "___STRUCTURE/spiritual.php";
        exit;
    } else if(isset($_GET['jadwal'])){
        include "___SCRIPT/systemChecker.php";
        include_once "___STRUCTURE/schdule.php";
        exit;
    } else if(isset($_GET['jadwalku'])){
        include "___SCRIPT/systemChecker.php";
        include_once "___STRUCTURE/myschdule.php";
        exit;
    } else if(isset($_GET['konseling'])){
        $pageAUTHORITY = "O";
        include "___SCRIPT/systemChecker.php";
        include_once "___STRUCTURE/konseling.php";
        exit;
    }
    include "___SCRIPT/systemChecker.php";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "___SCRIPT/GoogleAnalytics.php" ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Konseling</title>
    <link rel="shortcut icon" href="assets/img/unika-logo.png" type="image/x-icon">
    <style>
    <?php
        include_once "___DESIGN/layanan.css";
    ?>
            
        /* Alert Message */
        #alert-message{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1;
            transform: scale(0);
            transition: .3s;
        }
        #alert-message .contents{
            padding: 20px;
            max-width: 40%;
            min-width: 40%;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #ffe7e7;
            border-radius: 20px;
        }
        #alert-message .contents .icon{
            font-size: 88px;
        }
        #alert-message .contents .alerts{
            font-size: 27px;
            font-weight: 700;
        }
        #alert-message .contents .messages{
            font-size: 20px;
            text-align: center;
        }
        #alert-message .contents #close{
            margin-top: 20px;
            padding: 2px 10px;
            cursor: pointer;
            border: none;
            border-radius: 10px;
            box-shadow: inset 2px 0 0 #0e0000,inset -2px 0 0 #0e0000,
            inset 0 2px 0 #0e0000,inset 0 -2px 0 #0e0000;
            color: #ffffffb2;
            font-size: 27px;
            font-weight: 700;
            background: #098b09;
        }
        #alert-message .contents #close:hover{
            color: #ffffff;
            background: #0cbd0c;
        }
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
                    <span>Konseling</span>
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
                <div class="service-options">
                    <div class="service-visual">
                        <img src="assets/img/psikologi.png" alt="">
                    </div>
                    <div class="service-labels">
                        <span>Layanan Psikologi</span>
                    </div>
                    <div class="service-navigations">
                        <a href="<?php echo $_URL?>/layanan.php?psikologi">Pilih</a>
                    </div>
                </div>
                <div class="service-options">
                    <div class="service-visual">
                        <img src="assets/img/kesehatan.png" alt="">
                    </div>
                    <div class="service-labels">
                        <span>Layanan Kesehatan</span>
                    </div>
                    <div class="service-navigations">
                        <a href="<?php echo $_URL?>/layanan.php?kesehatan">Pilih</a>
                    </div>
                </div>
                <div class="service-options">
                    <div class="service-visual">
                        <img src="assets/img/spiritual.png" alt="">
                    </div>
                    <div class="service-labels">
                        <span>Layanan Spiritual</span>
                    </div>
                    <div class="service-navigations">
                        <a href="<?php echo $_URL?>/layanan.php?spiritual">Pilih</a>
                    </div>
                </div>
                <div class="service-options">
                    <div class="service-visual">
                        <img src="assets/img/jadwal-konseling.png" alt="">
                    </div>
                    <div class="service-labels">
                        <span>Jadwal Konseling</span>
                    </div>
                    <div class="service-navigations">
                        <a href="<?php echo $_URL?>/layanan.php?jadwal" disable>Pilih</a>
                    </div>
                </div>
                <div class="service-options">
                    <div class="service-visual">
                        <img src="assets/img/jadwal-pribadi.png" alt="">
                    </div>
                    <div class="service-labels">
                        <span>Jadwal Konseling Saya</span>
                    </div>
                    <div class="service-navigations">
                        <a href="<?php echo $_URL?>/layanan.php?jadwalku">Pilih</a>
                    </div>
                </div>
                <div id='alert-message'>
                    <div class='contents'>
                        <div class='icon'><ion-icon name='checkmark-circle-outline'></ion-icon></div>
                        <div class='alerts'></div>
                        <div class='messages'></div>
                        <button id='close' onclick='closeThisWindow()'>OK</button>
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
            <?php
                if(isset($_GET["success"])){
                    echo "var response = 'success';\n";
                } else if(isset($_GET["failed"])){
                    echo "var response = 'failed';\n";
                } else if(isset($_GET["error"])){
                    echo "var response = 'error';\n";
                } else{
                    echo "var response = false;\n";
                }
            ?>
            $(".container").css('opacity','1');
            if(response == "success"){
                $("#alert-message ion-icon").attr('name','checkmark-circle-outline');
                $("#alert-message .alerts").html("Permintaan terkirim!");
                $("#alert-message .messages").html("Kami akan mengabari Anda melalui Inbox!");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                },500);
            } else if(response == "failed"){
                $("#alert-message ion-icon").attr('name','close-circle-outline');
                $("#alert-message .alerts").html("Permintaan gagal dikirim!");
                $("#alert-message .messages").html("Terjadi kesalahan saat mencoba mengirimkan Permintaan Anda. Silahkan coba lagi.");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                },500);
            } else if(response == "error"){
                $("#alert-message ion-icon").attr('name','close-circle-outline');
                $("#alert-message .alerts").html("Telah terjadi Kesalahan!");
                $("#alert-message .messages").html("Mohon maaf Permintaan anda saat ini tidak dapat diproses. Silahkan coba kembali dan pastikan data yang Anda masukkan valid!");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                },500);
            }
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
        function closeThisWindow(){
            $("#alert-message").css('transform','scale(0)');
            setTimeout(function(){
                $("#alert-message").css('display','none');
            },300);
        };
    </script>
</body>
</html>