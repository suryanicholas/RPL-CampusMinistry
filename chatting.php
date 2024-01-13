<?php
    if(isset($_GET["info"])){
        $pageAUTHORITY = "O";
        include "___SCRIPT/systemChecker.php";
        include_once "___STRUCTURE/info.php";
        exit;
    }
    include "___SCRIPT/systemChecker.php";
    if(isset($_GET["ministry"])){
        $_DataAi = $_GET["ministry"];
        $letQUERY = $_DC->prepare("SELECT info.cmUsername, info.cmUserphoto, dat.cmSessionID FROM cmuserinfo info JOIN cmuserdata dat ON info.cmUserID = dat.cmUserID WHERE info.cmUserID = ?");
        $letQUERY->bind_param("s",$_DataAi);
        $letQUERY->execute();
        $letQUERY->bind_result($curNAME,$curPHOTO,$curSESSION);
        $letQUERY->fetch();
        $letQUERY->close();
        if($curSESSION == "Not Set" OR $curSESSION == "Offline"){
            $curSTATUS = "Offline";
            $curCOLOR = "gray";
        } else{
            $curSTATUS = "Online";
            $curCOLOR = "green";
        }
    }
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        include_once "___ROOT/___CONFIG.php";
        $_CMD = $_POST["action"];
        if($_CMD === "SRC"){
            $_SEARCH = $_POST["search"];
            if($_SEARCH === ""){
                $letQUERY = $_DC->prepare("SELECT info.cmUsername, data.cmUserID, info.cmUserphoto FROM cmuserinfo info JOIN cmuserdata data ON info.cmUserID = data.cmUserID WHERE info.cmUserID <> $ownUSERID AND data.cmSessionID NOT IN('Not Set','Offline')");
                $letQUERY->execute();
                $letRESULT = $letQUERY->get_result();
                
                while($row = $letRESULT->fetch_assoc()){
                    echo '<div class="chat-user">'."\n";
                    echo '<a href="'.$_URL.'/chatting.php?ministry='.$row["cmUserID"].'">'."\n";
                    echo '<img src="data:image/jpeg;base64,'.base64_encode($row["cmUserphoto"]).'" alt="">'."\n";
                    echo '<span>'.$row["cmUsername"].'</span>'."\n";
                    echo "</a>\n";
                    echo "</div>\n";
                }
                $letQUERY->close();
                exit();
            } else if(is_numeric($_SEARCH)){
                $_SEARCH = $_POST["search"].'%';
                $letQUERY = $_DC->prepare("SELECT info.cmUsername, dt.cmUserID, info.cmUserphoto FROM cmuserinfo info JOIN cmuserdata dt ON info.cmUserID = dt.cmUserID WHERE dt.cmUserID <> $ownUSERID AND info.cmUserID LIKE ? ");
                $letQUERY->bind_param("s",$_SEARCH);
                $letQUERY->execute();
                $letRESULT = $letQUERY->get_result();
                
                if($letRESULT->num_rows === 0){
                    echo '<div class="ministry-search">'."\n";
                    echo '<div class="ministry-search-text">Pengguna tidak ditemukan!</div>'."\n";
                    echo '</div>'."\n";
                } else{
                    while($row = $letRESULT->fetch_assoc()){
                        echo '<div class="chat-user">'."\n";
                        echo '<a href="'.$_URL.'/chatting.php?ministry='.$row["cmUserID"].'">'."\n";
                        echo '<img src="data:image/jpeg;base64,'.base64_encode($row["cmUserphoto"]).'" alt="">'."\n";
                        echo '<span>'.$row["cmUsername"].'</span>'."\n";
                        echo "</a>\n";
                        echo "</div>\n";
                    }
                }
                $letQUERY->close();
                exit();
            } else{
                $_SEARCH = $_POST["search"].'%';
                $letQUERY = $_DC->prepare("SELECT info.cmUsername, data.cmUserID, info.cmUserphoto FROM cmuserinfo info JOIN cmuserdata data ON info.cmUserID = data.cmUserID WHERE info.cmUserID <> $ownUSERID AND info.cmUsername LIKE ?");
                $letQUERY->bind_param("s",$_SEARCH);
                $letQUERY->execute();
                $letRESULT = $letQUERY->get_result();
                
                if($letRESULT->num_rows === 0){
                    echo '<div class="ministry-search">'."\n";
                    echo '<div class="ministry-search-text">Pengguna tidak ditemukan!</div>'."\n";
                    echo '</div>'."\n";
                } else{
                    while($row = $letRESULT->fetch_assoc()){
                        echo '<div class="chat-user">'."\n";
                        echo '<a href="'.$_URL.'/chatting.php?ministry='.$row["cmUserID"].'">'."\n";
                        echo '<img src="data:image/jpeg;base64,'.base64_encode($row["cmUserphoto"]).'" alt="">'."\n";
                        echo '<span>'.$row["cmUsername"].'</span>'."\n";
                        echo "</a>\n";
                        echo "</div>\n";
                    }
                }
                $letQUERY->close();
                exit();
            }
        } else if($_CMD === "SEND"){
            $_SENDER = $ownUSERID;
            $_RECEIVER = $_POST["sentTo"];
            $_MESSAGES = $_POST["message"];
            $_TIMES = date('Y-m-d H:i:s');

            $letQUERY = $_DC->prepare("INSERT INTO chdata VALUES(?,?,?,?)");
            $letQUERY->bind_param("ssss",$_SENDER,$_RECEIVER,$_MESSAGES,$_TIMES);
            if($letQUERY->execute()){
                echo '<div class="chat-message post">'."\n";
                echo '<div class="message-details">'."\n";
                echo $_MESSAGES;
                echo "</div>\n";
                echo '<img src="data:image/jpeg;base64,'.base64_encode($ownPHOTO).'" alt="">'."\n";
                echo "</div>\n";
            } else{
                echo "error";
            }
            $letQUERY->close();
            exit();
        } else if($_CMD === "GET"){
            $_chatID = $_POST["getFrom"];
            $letQUERY = $_DC->prepare("SELECT info.cmUsername, info.cmUserphoto, dat.cmSessionID FROM cmuserinfo info JOIN cmuserdata dat ON info.cmUserID = dat.cmUserID WHERE info.cmUserID = ?");
            $letQUERY->bind_param("s",$_chatID);
            $letQUERY->execute();
            $letQUERY->bind_result($curNAME,$curPHOTO,$curSESSION);
            $letQUERY->fetch();
            $letQUERY->close();
            if($curSESSION == "Not Set" OR $curSESSION == "Offline"){
                $curSTATUS = "Offline";
                $curCOLOR = "gray";
            } else{
                $curSTATUS = "Online";
                $curCOLOR = "green";
            }
            $letQUERY = $_DC->prepare("SELECT * FROM chdata WHERE (chDataSID = $ownUSERID AND chDataRID = $_chatID) OR (chDataSID = $_chatID AND chDataRID = $ownUSERID) ORDER BY chDate ASC");
            $letQUERY->execute();
            $letRESULT = $letQUERY->get_result();
            
            while($row = $letRESULT->fetch_assoc()){
                if($row["chDataSID"] === $ownUSERID){
                    echo '<div class="chat-message post">'."\n";
                    echo '<div class="message-details">'."\n";
                    echo $row["chMessage"];
                    echo "</div>\n";
                    echo '<img src="data:image/jpeg;base64,'.base64_encode($ownPHOTO).'" alt="">'."\n";
                    echo "</div>\n";
                } else{
                    echo '<div class="chat-message get">'."\n";
                    echo '<img src="data:image/jpeg;base64,'.base64_encode($curPHOTO).'" alt="">'."\n";
                    echo '<div class="message-details">'."\n";
                    echo $row["chMessage"];
                    echo "</div>\n";
                    echo "</div>\n";
                }
            }
            $letQUERY->close();
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "___SCRIPT/GoogleAnalytics.php" ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatting</title>
    <link rel="shortcut icon" href="assets/img/unika-logo.png" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');
        :root{
            --col-status: <?php echo $curCOLOR ?>;
        }
    <?php
        include_once "___DESIGN/chatting.css";
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
                <div class="sidebar-menu-items active">
                    <a href="#">
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
                    <span>Chatting</span>
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
                <div class="chat-sidebar">
                    <div class="chat-search">
                        <label>
                            <ion-icon name="search-sharp"></ion-icon>
                            <input type="text" name="search" maxlength="35" placeholder="Cari Pengguna...">
                        </label>
                    </div>
                    <div class="chat-userlist">
                        <?php
                            $letQUERY = $_DC->prepare("SELECT info.cmUsername, info.cmUserID, info.cmUserphoto FROM cmuserinfo info JOIN cmuserdata data ON info.cmUserID = data.cmUserID WHERE info.cmUserID <> $ownUSERID AND data.cmSessionID NOT IN('Not Set','Offline')");
                            $letQUERY->execute();
                            $letRESULT = $letQUERY->get_result();
                            
                            while($row = $letRESULT->fetch_assoc()){
                        ?>
                        <div class="chat-user">
                            <a href="<?php echo $_URL.'/chatting.php?ministry='.$row["cmUserID"] ?>">
                                <div><img src="data:image/jpeg;base64,<?php echo base64_encode($row["cmUserphoto"])?>" alt=""></div>
                                <span><?php echo $row["cmUsername"] ?></span>
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="chat-contents">
                    <div class="chat-header">
                        <?php
                            if(isset($_GET["ministry"])){
                        ?>
                        <div class="chat-info">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($curPHOTO) ?>" alt="">
                            <div class="chat-details">
                                <div class="username"><?php echo $curNAME ?></div>
                                <div class="status">
                                    <ion-icon name="ellipse"></ion-icon>
                                    <span><?php echo $curSTATUS ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="chat-navbar">
                            <ion-icon name="ellipsis-vertical"></ion-icon>
                        </div>
                        <?php } else{ ?>
                            <div class="ministry-chat">
                                <img src="<?php echo $_URL ?>/assets/img/campus-ministry.png" alt="">
                            </div>
                        <?php } ?>
                    </div>
                    <div class="menu-sections">
                        <div class="chat-menu">
                            <div class="chat-menu-items">
                                <a href="#">Akhiri Obrolan</a>
                            </div>
                            <div class="chat-menu-items">
                                <a href="#">Hapus Obrolan</a>
                            </div>
                        <?php if($ownLICENCE == "O"){ ?>
                            <div class="chat-menu-items">
                                <a href="<?php echo $_URL."/chatting.php?info=".$_GET['ministry'] ?>">Lihat Profil</a>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="chat-body">
                        <?php if(isset($_GET["ministry"])){ 
                            $_chatID = $_GET["ministry"];
                            $letQUERY = $_DC->prepare("SELECT * FROM chdata WHERE (chDataSID = $ownUSERID AND chDataRID = $_chatID) OR (chDataSID = $_chatID AND chDataRID = $ownUSERID) ORDER BY chDate ASC");
                            $letQUERY->execute();
                            $letRESULT = $letQUERY->get_result();
                            
                            while($row = $letRESULT->fetch_assoc()){
                                if($row["chDataSID"] == $ownUSERID){
                                    echo '<div class="chat-message post">'."\n";
                                    echo '<div class="message-details">'."\n";
                                    echo $row["chMessage"];
                                    echo "</div>\n";
                                    echo '<img src="data:image/jpeg;base64,'.base64_encode($ownPHOTO).'" alt="">'."\n";
                                    echo "</div>\n";
                                } else{
                                    echo '<div class="chat-message get">'."\n";
                                    echo '<img src="data:image/jpeg;base64,'.base64_encode($curPHOTO).'" alt="">'."\n";
                                    echo '<div class="message-details">'."\n";
                                    echo $row["chMessage"];
                                    echo "</div>\n";
                                    echo "</div>\n";
                                }
                            }
                        ?>
                        <?php } else{ ?>
                            <div class="ministry-messages">
                                <div class="ministry-text">
                                    Mulai percakapan...
                                </div>
                                <div class="ministry-text">
                                    (Pilih dengan siapa Anda ingin mengobrol dari menu samping)
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if(isset($_GET["ministry"])){ ?>
                    <form id="reply-forms" method="post" class="chat-footer" onsubmit="function sentMessages()">
                        <label class="attach-button" title="Fitur ini belum tersedia">
                            <ion-icon name="attach-outline"></ion-icon>
                            <!-- <input type="file" name="attachfile" hidden> -->
                        </label>
                        <div class="message-input">
                            <input type="text" name="messages" placeholder="Ketikkan pesan disini...">
                            <label class="camera-button" title="Fitur ini belum tersedia">
                                <ion-icon name="camera-outline"></ion-icon>
                                <!-- <input type="file" name="camerafile" accept="image/*" hidden> -->
                            </label>
                        </div>
                        <div class="reply-button">
                            <ion-icon name="send"></ion-icon>
                        </div>
                    </form>
                    <?php } ?>
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
            $(".chat-body").scrollTop($(".chat-body").prop("scrollHeight"));
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
        $(".chat-navbar ion-icon").click(function(){
            if($(".chat-menu").hasClass("show")){
                $(".chat-menu").removeClass("show");
            } else{
                $(".chat-menu").addClass("show");
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
        $(".chat-search input").on("keyup", function(){
            $.ajax({
                type: 'POST',
                url: 'chatting.php',
                data: {
                    action: 'SRC',
                    search: $(".chat-search input").val()
                },
                success: function(response){
                    $(".chat-userlist").html(response);
                }
            })
        });
        <?php if(isset($_GET["ministry"])){ ?>
            function replyMessages(){
                if($(".message-input input[name='messages']").val() == ""){
                    $(".message-input").css('border-color','#ff0000');
                    $(".message-input").addClass('empty');
                    setTimeout(() => {
                        $(".message-input").removeClass('empty');
                    }, 400);
                } else {
                    $.ajax({
                        type: 'POST',
                        url: 'chatting.php',
                        data: {
                            action: 'SEND',
                            sentTo: <?php echo $_GET["ministry"] ?>,
                            message: $(".message-input input[name='messages']").val()
                        },
                        success: function(response){
                            if(response == "error"){
                                console.log(response);
                            } else{
                                $(".chat-body").append(response);
                                $(".chat-body").scrollTop($(".chat-body").prop("scrollHeight"));
                                $(".message-input input[name='messages']").val("");
                            }
                        }
                    });
                    $(".message-input").css('border-color','#000000');
                }
            };
            $(".reply-button ion-icon").click(function(){
                replyMessages();
            });
            $("#reply-forms").on("submit", function(event){
                event.preventDefault();
                replyMessages();
            });
            setInterval(() => {
                $.ajax({
                    type: 'POST',
                    url: 'chatting.php',
                    data: {
                        action: 'GET',
                        getFrom: <?php echo $_GET["ministry"] ?>,
                        message: $(".message-input input[name='messages']").val()
                    },
                    success: function(response){
                        if(response == "error"){
                            console.log(response);
                        } else{
                            $(".chat-body").html(response);
                        }
                    }
                })
            }, 1000);
        <?php } ?>
    </script>
</body>
</html>