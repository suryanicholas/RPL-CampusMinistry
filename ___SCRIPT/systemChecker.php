<?php
    session_start();

    if(!isset($_SESSION["___SESSIONKEEP"])){
        header("Location: $_URL/index.php");
    } else{
        include_once "___ROOT/___CONFIG.php";
        $ownSESSION = $_SESSION["___SESSIONKEEP"];
        $_letQUERY = $_DC->prepare("SELECT cmUserID, cmAuthority FROM cmuserdata WHERE cmSessionID = ?");
        $_letQUERY->bind_param("s",$ownSESSION);
        $_letQUERY->execute();
        $_letQUERY->bind_result($ownUSERID,$ownLICENCE);
        if(!$_letQUERY->fetch()){
            $_letQUERY->close();
            session_destroy();
            header("Location: $_URL/?token=false");
        }
        $_letQUERY->close();

        if(isset($pageAUTHORITY)){
            if($ownLICENCE != $pageAUTHORITY){
                header("Location: $_URL/dashboard.php");
            }
        }
        $_letQUERY = $_DC->prepare("SELECT cmUsername,cmUsergender,cmUserbirth,cmUsermail,cmUserphone,cmUseraddress,cmFacultyName,cmStudyName,cmUserphoto,cmUsercard FROM cmuserinfo WHERE cmUserID = ?");
        $_letQUERY->bind_param("s",$ownUSERID);
        $_letQUERY->execute();
        $_letQUERY->bind_result($ownNAME,$ownGENDER,$ownBIRTH,$ownMAIL,$ownPHONE,$ownADDRESS,$ownFAKULTAS,$ownJURUSAN,$ownPHOTO,$ownCARD);
        $_letQUERY->fetch();
        $_letQUERY->close();
        if($ownGENDER == "m"){
            $ownSEX = "Laki - Laki";
        } else {
            $ownSEX = "Perempuan";
        }
    }
?>