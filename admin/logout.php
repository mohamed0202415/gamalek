<?php
session_start();
if($_SESSION[$site]['type'] == 'user'){
    $update = $db->prepare("update users set status = 'offline' where id = ?");
    $update->execute([$_SESSION[$site]['user_id']]);
}elseif($_SESSION[$site]['type'] == 'doctor'){
    $update = $db->prepare("update doctors set status = 'offline' where id = ?");
    $update->execute([$_SESSION[$site]['user_id']]);
}
unset($_SESSION[$site]['username']);
unset($_SESSION[$site]['user_id']);
unset($_SESSION[$site]['user_ip']);
unset($_SESSION[$site]['time']);

session_destroy();
if(isset($_GET['url'])){
    header("Location: index.php?url=".$_GET['url']);
}else{
    header("Location: index.php");
}
exit;
?>