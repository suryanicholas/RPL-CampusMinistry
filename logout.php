<?php
    session_start();
    include "___ROOT/___CONFIG.php";
    $_dataAi = $_SESSION["___SESSIONKEEP"];
    $_dataSi = "Offline";
    $_letQUERY = $_DC->prepare("UPDATE cmuserdata SET cmSessionID = ? WHERE cmSessionID = ?");
    $_letQUERY->bind_param("ss",$_dataSi,$_dataAi);
    $_letQUERY->execute();
    session_destroy();
    header("Location: $_URL");
?>