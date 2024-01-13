<?php
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