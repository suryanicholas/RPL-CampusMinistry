<?php
    session_start();
    include_once "___ROOT/___CONFIG.php";
    if(isset($_SESSION["___SESSIONKEEP"])){
        header("Location: $_URL/dashboard.php");
    }
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(isset($_POST["signin"])){
            $_dataAi = $_POST["username"];
            $_dataBi = $_POST["password"];

            $_letQUERY = $_DC->prepare("SELECT cmAccessKey, cmAuthority FROM cmuserdata WHERE cmUserID = ?");
            $_letQUERY->bind_param("s",$_dataAi);
            $_letQUERY->execute();
            $_letQUERY->bind_result($_dataAr,$_dataBr);
            if(!$_letQUERY->fetch()){
                $_letQUERY->close();
                header("Location: ?signin=false");
            }
            $_letQUERY->close();

            if(password_verify($_dataBi, $_dataAr)){
                if($_dataBr == "W"){
                    header("Location: ?signin=rejected");
                } else if($_dataBr == "B"){
                    header("Location: ?signin=blocked");
                } else{
                    $_dataSi = openssl_random_pseudo_bytes(32);
                    $_letQUERY = $_DC->prepare("UPDATE cmuserdata SET cmSessionID = ? WHERE cmUserID = ?");
                    $_letQUERY->bind_param("ss",$_dataSi,$_dataAi);
                    $_letQUERY->execute();
                    $_letQUERY->close();
                    $_SESSION["___SESSIONKEEP"] = $_dataSi;
                    header("Location: $_URL/dashboard.php");
                }
            } else {
                header("Location: ?signin=false");
            }
        } else if(isset($_POST["signup"])){
            $_dataAi = $_POST["userid"];
            $_dataBi = password_hash($_POST["userid"], PASSWORD_BCRYPT);
            $_dataCi = "W";
            $_dataDi = "Not Set";

            $_letQUERY = $_DC->prepare("INSERT INTO cmuserdata VALUES(?,?,?,?)");
            $_letQUERY->bind_param("ssss",$_dataAi,$_dataBi,$_dataCi,$_dataDi);
            if($_letQUERY->execute()){
                $_letQUERY->close();
                $_dataEi = $_POST["userid"];
                $_dataFi = $_POST["username"];
                if($_POST["gender"] == "male"){
                    $_dataGi = "m";
                } else{
                    $_dataGi = "f";
                }
                $_dataHi = $_POST["userborn"];
                $_dataIi = $_POST["usermail"];
                $_dataJi = $_POST["usercontact"];
                $_dataKi = $_POST["useraddr"];
                $_dataLi = $_POST["userfaculty"];
                $_dataMi = $_POST["userstudy"];
                $_dataNi = file_get_contents($_FILES["userphoto"]["tmp_name"]);
                $_dataOi = file_get_contents($_FILES["studentid"]["tmp_name"]);

                $_letQUERY = $_DC->prepare("INSERT INTO cmuserinfo VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                $_letQUERY->bind_param("sssssssssss",$_dataEi,$_dataFi,$_dataGi,$_dataHi,$_dataIi,$_dataJi,$_dataKi,$_dataLi,$_dataMi,$_dataNi,$_dataOi);
                if($_letQUERY->execute()){
                    $_letQUERY->close();
                    header("Location: ?signup=true");
                } else{
                    $_letQUERY->close();
                    $_dataAi = $_POST["userid"];
                    $_letQUERY = $_DC->prepare("DELETE FROM cmuserdata WHERE cmUserID = ?");
                    $_letQUERY->bind_param("s",$_dataAi);
                    $_letQUERY->execute();
                    $_letQUERY->close();
                    header("Location: ?signup=error");
                }
            } else{
                $_letQUERY->close();
                header("Location: ?signup=false");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "___SCRIPT/GoogleAnalytics.php" ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,">
    <title>Campus Ministry</title>
    <link rel="stylesheet" href="<?php echo $_URL ?>/assets/style.css">
    <link rel="shortcut icon" href="<?php echo $_URL ?>/assets/img/unika-logo.png" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="campus-ministry">
            <div class="campus-ministry-text">
                <span>WELCOME TO</span>
            </div>
            <div class="campus-ministry-logo">
                <img src="<?php echo $_URL?>/assets/img/campus-ministry.png">
            </div>
        </div>
        <div class="canvas-navigations">
            <div class="navigation-options">
                <button onclick="enterSignIn()">Masuk</button>
            </div>
            <div class="navigation-options">
                <button onclick="enterSignUp()">Daftar</button>
            </div>
        </div>
        <div class="canvas-signin">
            <div class="signin-forms">
                <form method="post" autocomplete="off" onsubmit="return preventEmpty(0)">
                    <div class="forSignin-data-required">
                        <input id="username" type="text" name="username" maxlength="9" placeholder="Username">
                    </div>
                    <div class="forSignin-data-required">
                        <input id="password" type="password" name="password" maxlength="20" placeholder="Password">
                        <ion-icon id="forSignin-features" name="eye-outline"></ion-icon>
                    </div>
                    <div class="signin-message"></div>
                    <div class="signin-form-button">
                        <button type="submit" name="signin">Masuk</button>
                    </div>
                </form>
                <div class="signin-navigation">
                    <div class="signin-navigation-options">
                        <button onclick="enterHome()">Kembali</button>
                    </div>
                    <div class="signin-navigation-options">
                        <button onclick="enterSignUp()">Daftar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="canvas-signup">
            <div class="signup-forms">
                <form method="post" autocomplete="off" onsubmit="return preventEmpty(1)" enctype="multipart/form-data">
                    <div class="forSignup-data-required">
                        <div class="labels">Nama</div>
                        <input type="text" name="username" maxlength="50">
                        <div class="messages"></div>
                    </div>
                    <div class="forSignup-data-required">
                        <div class="labels">NPM</div>
                        <input type="text" name="userid" maxlength="9">
                        <div class="messages"></div>
                    </div>
                    <div class="forSignup-data-required">
                        <div class="labels">Jenis Kelamin</div>
                        <div class="gender-selection">
                            <label class="select-option">
                                <input type="radio" name="gender" value="male" checked>
                                Laki - Laki
                            </label>
                            <label class="select-option">
                                <input type="radio" name="gender" value="female">
                                Perempuan
                            </label>
                        </div>
                        <div class="messages"></div>
                    </div>
                    <div class="forSignup-data-required">
                        <div class="labels">Tanggal Lahir</div>
                        <input type="date" name="userborn">
                        <div class="messages"></div>
                    </div>
                    <div class="forSignup-data-required">
                        <div class="labels">Alamat</div>
                        <textarea name="useraddr" maxlength="250"></textarea>
                        <div class="messages"></div>
                    </div>
                    <div class="forSignup-data-required">
                        <div class="labels">No. Telepon</div>
                        <input type="text" name="usercontact" maxlength="16">
                        <div class="messages"></div>
                    </div>
                    <div class="forSignup-data-required">
                        <div class="labels">Email</div>
                        <input type="email" name="usermail" maxlength="50">
                        <div class="messages"></div>
                    </div>
                    <div class="forSignup-data-required">
                        <div class="labels">Fakultas</div>
                        <select name="userfaculty">
                            <option value="" selected>-- Pilih Fakultas --</option>
                            <option value="Ekonomi dan Bisnis">Ekonomi dan Bisnis</option>
                            <option value="Filsafat">Filsafat</option>
                            <option value="Hukum">Hukum</option>
                            <option value="Ilmu Budaya">Ilmu Budaya</option>
                            <option value="Ilmu Komputer">Ilmu Komputer</option>
                            <option value="Keguruan dan Ilmu Pendidikan">Keguruan dan Ilmu Pendidikan</option>
                            <option value="Pertanian">Pertanian</option>
                            <option value="Teknik">Teknik</option>
                        </select>
                        <div class="messages"></div>
                    </div>
                    <div class="forSignup-data-required">
                        <div class="labels">Program Studi</div>
                        <select name="userstudy">
                            <option value="" selected>-- Pilih Program Studi --</option>
                        </select>
                        <div class="messages"></div>
                    </div>
                    <div class="forSignup-data-required">
                        <div class="labels">Pasphoto</div>
                        <div class="canvas-images">
                            <label class="images-selection">
                                <img id="previewUser" src="" alt="">
                                <input type="file" name="userphoto" accept=".jpg" onchange="previewImage(event, 'previewUser');">
                            </label>
                            <div>
                                <span>Ukuran file maksimal 5mb!</span>
                                <span>Format gambar .jpg atau .jpeg!</span>
                                <span>Aspect Ratio 1:1 atau persegi</span>
                            </div>
                        </div>
                        <div class="messages"></div>
                    </div>
                    <div class="forSignup-data-required">
                        <div class="labels">Foto KTM</div>
                        <div class="canvas-images">
                            <label class="images-selection">
                                <img id="previewKTM" src="" alt="">
                                <input type="file" name="studentid" accept=".jpg" onchange="previewImage(event, 'previewKTM');">
                            </label>
                            <div>
                                <span>Ukuran file maksimal 5mb!</span>
                                <span>Format gambar .jpg atau .jpeg!</span>
                            </div>
                        </div>
                        <div class="messages"></div>
                    </div>
                    <div class="signup-form-button">
                        <button type="submit" name="signup">Daftar</button>
                    </div>
                </form>
                <div class="signup-navigation">
                    <div class="signup-navigation-options">
                        <button onclick="enterHome()">Kembali</button>
                    </div>
                    <div class="signup-navigation-options">
                        <button onclick="enterSignIn()">Masuk</button>
                    </div>
                </div>
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            <?php
                if(isset($_GET["signin"])){
                    echo 'var response = "'.$_GET["signin"].'";'."\n";
                } else if(isset($_GET["signup"])){
                    echo 'var response = "'.$_GET["signup"].'";'."\n";
                } else if(isset($_GET["token"])){
                    echo 'var response = "'.$_GET["token"].'";'."\n";
                } else{
                    echo 'var response = "none";'."\n";
                }
            ?>
            $(".container").fadeIn(1000);
            <?php if(isset($_GET["signup"])){ ?>
                if(response == "true"){
                    $("#alert-message ion-icon").attr('name','checkmark-circle-outline');
                    $("#alert-message .alerts").html("Pendaftaran Berhasil!");
                    $("#alert-message .messages").html("Kami akan mengabari Anda hasil Validasi dari Admin melalui Email.");
                    setTimeout(function(){
                        $("#alert-message").css('transform','scale(1)');
                    },500);
                } else if(response == "false"){
                    $("#alert-message ion-icon").attr('name','close-circle-outline');
                    $("#alert-message .alerts").html("Pendaftaran Gagal!");
                    $("#alert-message .messages").html("Data ini telah didaftarkan sebelumnya. Jika anda mengalami masalah Lupa Password atau merasa tidak pernah mendaftar silahkan hubungi Admin Campus Ministry.");
                    setTimeout(function(){
                        $("#alert-message").css('transform','scale(1)');
                    },500);
                } else if(response == "error"){
                    $("#alert-message ion-icon").attr('name','close-circle-outline');
                    $("#alert-message .alerts").html("Telah terjadi Kesalahan!");
                    $("#alert-message .messages").html("Mohon maaf pendaftaran anda mengalami masalah teknis. Silahkan coba kembali dan pastikan data yang Anda masukkan valid!");
                    setTimeout(function(){
                        $("#alert-message").css('transform','scale(1)');
                    },500);
                }
            <?php } else if(isset($_GET["signin"])){?>
            if(response == "false"){
                $("#alert-message ion-icon").attr('name','close-circle-outline');
                $("#alert-message .alerts").html("Akses ditolak!");
                $("#alert-message .messages").html("Username atau Password yang anda masukkan tidak valid!");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                },500);
            } else if(response == "rejected"){
                $("#alert-message ion-icon").attr('name','alert-circle-outline');
                $("#alert-message .alerts").html("Akses ditolak!");
                $("#alert-message .messages").html("Akun anda belum divalidasi oleh Admin. Silahkan coba kembali setelah akun divalidasi.");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                },500);
            } else if(response == "terminated"){
                $("#alert-message ion-icon").attr('name','alert-circle-outline');
                $("#alert-message .alerts").html("Sesi Anda berakhir!");
                $("#alert-message .messages").html("Tampaknya akun Anda telah Login ditempat lain. Silahkan masuk kembali untuk mengakses Layanan.");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                },500);
            } else if(response == "blocked"){
                $("#alert-message ion-icon").attr('name','alert-circle-outline');
                $("#alert-message .alerts").html("Akun Anda telah diblokir");
                $("#alert-message .messages").html("Mungkin dikarenakan sebuah pelanggaran fatal seperti aktivitas spam, berkata kasar dan tindakan tidak menyenangkan lainnya. Jika ini adalah sebuah kesalahpahaman, mohon menghubungi pihak Campus Ministry");
                setTimeout(function(){
                    $("#alert-message").css('transform','scale(1)');
                },500);
            }
            <?php } else if(isset($_GET["token"])){?>
                if(response == "false"){
                    $("#alert-message ion-icon").attr('name','alert-circle-outline');
                    $("#alert-message .alerts").html("Sesi Anda berakhir!");
                    $("#alert-message .messages").html("Tampaknya akun Anda telah Login ditempat lain. Silahkan masuk kembali untuk mengakses Layanan.");
                    setTimeout(function(){
                        $("#alert-message").css('transform','scale(1)');
                    },500);
                }
            <?php }?>
            $('select[name="userfaculty"]').change(function() {
                const selectedFaculty = $(this).val();
                $('select[name="userstudy"]').empty().append($('<option>', {
                    value: '',
                    text: '-- Pilih Program Studi --'
                }));

                $.getJSON('assets/datajurusan.json', function(data) {
                    $.each(data, function(index, option) {
                        if (option.Fakultas === selectedFaculty) {
                            const optionElement = $('<option>');
                            optionElement.val(option.Studi).text(option.Studi);
                            $('select[name="userstudy"]').append(optionElement);
                        }
                    });
                });
            });
        });
        $("#forSignin-features").click(function(){
            const passwordInput = $("#password");
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                $("#forSignin-features").attr('name', 'eye-off-outline');
            } else {
                passwordInput.attr('type', 'password');
                $("#forSignin-features").attr('name', 'eye-outline');
            }
        });
        $("#password").on('input', function(){
            const forSigninFeatures = $("#forSignin-features");
            if ($(this).val() === "") {
                forSigninFeatures.css('display', 'none');
            } else {
                forSigninFeatures.css('display', 'block');
            }
        });
        function focusScreen() {
            const firstErrorElement = document.querySelector(".forSignup-data-required .messages:not(:empty)");
            if (firstErrorElement) {
                const parentDiv = firstErrorElement.closest(".forSignup-data-required");
                parentDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        };
        function preventEmpty(forms) {
            var isSubmit = true;
            if (forms === 0) {
                $(".signin-message").css('display', 'none');

                if ($("#username").val().trim() === '' || $("#password").val().trim() === '') {
                    $(".signin-message").html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Username dan Password kosong!</span>');
                    $(".signin-message").css('display', 'flex');
                    isSubmit = false;
                }
            }
            $(".forSignup-data-required .messages").each(function(index, element){
                $(element).html("");
            });
            if(forms === 1){
                if($(".forSignup-data-required input[name='username']").val().trim() === ""){
                    $(".forSignup-data-required .messages").eq(0).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Data kosong!</span>');
                    isSubmit = false;
                }
                if($(".forSignup-data-required input[name='userid']").val().trim() === ""){
                    $(".forSignup-data-required .messages").eq(1).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Data kosong!</span>');
                    isSubmit = false;
                }
                if(!$(".forSignup-data-required input[name='userborn']").val()){
                    $(".forSignup-data-required .messages").eq(3).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Tentukan tanggal lahir Anda!</span>');
                    isSubmit = false;
                }
                var isDate = new Date($("input[name='userborn']").val());
                var isNow = new Date();
                if(isDate > isNow){
                    $(".forSignup-data-required .messages").eq(3).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Pilih tanggal yang valid!</span>');
                    isSubmit = false;
                }
                if($(".forSignup-data-required textarea").val().trim() === ""){
                    $(".forSignup-data-required .messages").eq(4).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Data kosong!</span>');
                    isSubmit = false;
                }
                if($(".forSignup-data-required input[name='usercontact']").val().trim() === ""){
                    $(".forSignup-data-required .messages").eq(5).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Data kosong!</span>');
                    isSubmit = false;
                }
                if($(".forSignup-data-required input[name='usermail']").val().trim() === ""){
                    $(".forSignup-data-required .messages").eq(6).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Data kosong!</span>');
                    isSubmit = false;
                }
                if($(".forSignup-data-required select[name='userfaculty']").val().trim() === ""){
                    $(".forSignup-data-required .messages").eq(7).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Pilih salah satu!</span>');
                    isSubmit = false;
                }
                if($(".forSignup-data-required select[name='userstudy']").val().trim() === ""){
                    $(".forSignup-data-required .messages").eq(8).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Pilih salah satu!</span>');
                    isSubmit = false;
                }
                const isAllowed = ["image/jpeg", "image/jpg"];
                if($(".forSignup-data-required input[name='userphoto']").val().trim() === ""){
                    $(".forSignup-data-required .messages").eq(9).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Pilih gambar!</span>');
                    isSubmit = false;
                } else if($(".forSignup-data-required input[name='userphoto']")[0].files[0].size > 2 * 1024 * 1024){
                    $(".forSignup-data-required .messages").eq(9).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Ukuran gambar terlalu besar!</span>');
                    isSubmit = false;
                } else if(!isAllowed.includes($(".forSignup-data-required input[name='userphoto']")[0].files[0].type)){
                    $(".forSignup-data-required .messages").eq(9).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Format gambar tidak sesuai!</span>');
                    isSubmit = false;
                } else if($("#previewUser").width() != $("#previewUser").height()){
                    $(".forSignup-data-required .messages").eq(9).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Aspect Ratio harus 1:1 atau persegi!</span>');
                    isSubmit = false;
                }
                if($(".forSignup-data-required input[name='studentid']").val().trim() === ""){
                    $(".forSignup-data-required .messages").eq(10).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Pilih gambar!</span>');
                    isSubmit = false;
                } else if($(".forSignup-data-required input[name='studentid']")[0].files[0].size > 2 * 1024 * 1024){
                    $(".forSignup-data-required .messages").eq(10).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Ukuran gambar terlalu besar!</span>');
                    isSubmit = false;
                } else if(!isAllowed.includes($(".forSignup-data-required input[name='studentid']")[0].files[0].type)){
                    $(".forSignup-data-required .messages").eq(10).html('<ion-icon name="alert-circle-outline"></ion-icon> <span>Format gambar tidak sesuai!</span>');
                    isSubmit = false;
                }
            }
            return isSubmit;
        };
        function enterHome() {
            switchCanvas('', 'signin signup', '.canvas-navigations', '.canvas-signin, .canvas-signup');
        };
        function enterSignIn() {
            switchCanvas('signin', 'signup', '.canvas-signin', '.canvas-navigations, .canvas-signup');
        };
        function enterSignUp() {
            switchCanvas('signup', 'signin', '.canvas-signup', '.canvas-navigations, .canvas-signin');
        };
        function previewImage(event, target){
            if(event.target.files.length > 0){
                var src = URL.createObjectURL(event.target.files[0]);
                var previewUser = $("#" + target);
                previewUser.attr('src', src);
                previewUser.css('display', 'block');
            }
        };
        function switchCanvas(classToAdd, classToRemove, canvasToShow, canvasToHide) {
            $(".container").addClass(classToAdd).removeClass(classToRemove);
            $(canvasToHide).css('opacity', '0');
            setTimeout(function() {
                $(canvasToHide).css('display', 'none');
                $(canvasToShow).css('display', 'flex');
                setTimeout(function() {
                    $(canvasToShow).css('opacity', '1');
                }, 100)
            }, 500);
        };
        function closeThisWindow(){
            $("#alert-message").css('transform','scale(0)');
            setTimeout(function(){
                $("#alert-message").css('display','none');
            },300);
        };
    </script>
</body>
</html>