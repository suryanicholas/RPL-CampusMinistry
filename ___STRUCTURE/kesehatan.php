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
    <title>Layanan Kesehatan</title>
    <link rel="shortcut icon" href="assets/img/unika-logo.png" type="image/x-icon">
    <style>
        <?php include_once "___DESIGN/layananform.css"; ?>
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
                    <span>Layanan Kesehatan</span>
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
                <form class="civitas-forms" method="post" onsubmit="return preventEmpty();">
                    <div class="civitas-data">
                        <div class="label">NPM</div>
                        <div class="value">
                            <input type="text" name="userid" value="<?php echo $ownUSERID ?>" maxlength="9">
                        </div>
                    </div>
                    <div class="civitas-data">
                        <div class="label">Nama</div>
                        <div class="value">
                            <input type="text" name="username" value="<?php echo $ownNAME ?>" maxlength="50">
                        </div>
                    </div>
                    <div class="civitas-data">
                        <div class="label">Tanggal Konseling</div>
                        <div class="value">
                            <input type="date" name="servicedate">
                        </div>
                    </div>
                    <div class="civitas-data">
                        <div class="label">Konselor</div>
                        <div class="value">
                            <select name="konselor">
                                <option value="">-- Pilih Konselor--</option>
                                <?php
                                    $_letQUERY = $_DC->prepare("SELECT info.cmUsername FROM cmuserinfo info JOIN cmuserdata data ON info.cmUserID = data.cmUserID WHERE data.cmAuthority = 'O'");
                                    $_letQUERY->execute();
                                    $_letRESULT = $_letQUERY->get_result();
                                    while($_letCATCH = $_letRESULT->fetch_assoc()){
                                        echo "\n".'<option value="'.$_letCATCH["cmUsername"].'">'.$_letCATCH["cmUsername"].'</option>';
                                    };
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="civitas-data">
                        <div class="label">Metode Konselor</div>
                        <div class="value">
                            <select name="metode">
                                <option value="">-- Pilih Metode--</option>
                                <option value="offline">Offline</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                    </div>
                    <div class="civitas-data">
                        <div class="label">Sesi Konseling</div>
                        <div class="value">
                            <label>
                                <input type="checkbox" name="session[]" value="A">
                                <span>Sesi 1</span>
                            </label>
                            <label>
                                <input type="checkbox" name="session[]" value="B">
                                <span>Sesi 2</span>
                            </label>
                            <label>
                                <input type="checkbox" name="session[]" value="C">
                                <span>Sesi 3</span>
                            </label>
                            <label>
                                <input type="checkbox" name="session[]" value="D">
                                <span>Sesi 4</span>
                            </label>
                            <label>
                                <input type="checkbox" name="session[]" value="E">
                                <span>Sesi 5</span>
                            </label>
                            <label>
                                <input type="checkbox" name="session[]" value="F">
                                <span>Sesi 6</span>
                            </label>
                            <label>
                                <input type="checkbox" name="session[]" value="G">
                                <span>Sesi 7</span>
                            </label>
                        </div>
                    </div>
                    <div class="civitas-forms-control">
                        <a href="<?php echo $_URL?>/layanan.php">Batal</a>
                        <button type="submit" name="kesehatan">Buat Janji</button>
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
                </form>
            </div>
            <div id='alert-message'>
                <div class='contents'>
                    <div class='icon'><ion-icon name='alert-circle-outline'></ion-icon></div>
                    <div class='alerts'>Data tidak Sesuai!</div>
                    <div class='messages'>Mohon mengisi formulir dengan benar!</div>
                    <button id='close' onclick='closeThisWindow()'>OK</button>
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
    <script>
        $(document).ready(function() {
            const checkboxes = $('input[type="checkbox"]');
            const limit = 3;

            checkboxes.on('change', function() {
                const checkedCheckboxes = $('input[type="checkbox"]:checked');

                if (checkedCheckboxes.length > limit) {
                    $(this).prop('checked', false);
                }
            });
        });
        function preventEmpty(){
            var checkForms = true;
            if($("input[name='userid']").val().trim() === ""){
                $("#alert-message").css('display','flex');
                $("#alert-message .alerts").html("Data tidak sesuai!");
                $("#alert-message .messages").html("Terdapat data yang kosong!");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                },50);
                checkForms = false;
                return checkForms;
            }
            if($("input[name='username']").val().trim() === ""){
                $("#alert-message").css('display','flex');
                $("#alert-message .alerts").html("Data tidak sesuai!");
                $("#alert-message .messages").html("Terdapat data yang kosong!");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                },50);
                checkForms = false;
                return checkForms;
            }
            if($("input[name='servicedate']").val().trim() === ""){
                $("#alert-message").css('display','flex');
                $("#alert-message .alerts").html("Data tidak sesuai!");
                $("#alert-message .messages").html("Terdapat data yang kosong!");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                },50);
                checkForms = false;
                return checkForms;
            }
            var isDate = new Date($("input[name='servicedate']").val());
            var isNow = new Date();
            if(isDate < isNow){
                $("#alert-message").css('display','flex');
                $("#alert-message .alerts").html("Kesalahan");
                $("#alert-message .messages").html("Tanggal yang anda pilih telah berlalu!");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                },50);
                checkForms = false;
                return checkForms;
            }
            if($("select[name='konselor']").val().trim() === ""){
                $("#alert-message").css('display','flex');
                $("#alert-message .alerts").html("Data tidak sesuai!");
                $("#alert-message .messages").html("Terdapat data yang kosong!");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                },50);
                checkForms = false;
                return checkForms;
            }
            if($("select[name='metode']").val().trim() === ""){
                $("#alert-message").css('display','flex');
                $("#alert-message .alerts").html("Data tidak sesuai!");
                $("#alert-message .messages").html("Terdapat data yang kosong!");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                },50);
                checkForms = false;
                return checkForms;
            }
            var selectedCheckboxes = $("input[name='session[]']:checked");

            if (selectedCheckboxes.length === 0) {
                $("#alert-message").css('display','flex');
                $("#alert-message .alerts").html("Data tidak sesuai!");
                $("#alert-message .messages").html("Pilih setidaknya 1 sesi konseling.");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                }, 50);
                checkForms = false;
                return checkForms;
            }
            return checkForms;
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