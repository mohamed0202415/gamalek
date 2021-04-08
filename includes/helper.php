<?php 
function get_all_rows($connection,$table,$order=NULL){
    if($order){
    }else{
        $order = 'asc';
    }
    $query = "select * from ".$table." order by id ".$order;
    $sql = $connection->prepare($query);
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function get_all_rows_with_parent($connection,$table,$parent){
    $query = "select * from ".$table." where parent_id = ".$parent;
    $sql = $connection->prepare($query);
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_all_column_data($connection,$column,$table){
    $query = "select ".$column." from ".$table;
    $sql = $connection->prepare($query);
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function get_row($connection,$table,$column,$value){
    $query = "select * from ".$table." where ".$column." = ".$value;
    $sql = $connection->prepare($query);
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    return $result;
}
function get_value($connection,$output,$table,$column,$input){
    $query = "select ".$output." from ".$table." where ".$column." = ".$input;
    $sql = $connection->prepare($query);
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    return $result[$output];
}
function get_count($connection,$table){
    $query = "select count(*) count from ".$table;
    $sql = $connection->prepare($query);
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}
function get_datetime(){
    return date("Y-m-d H:i:s");
}
function get_date(){
    return date("Y-m-d");
}
function get_time(){
    return date("H:i:s");
}
function main_image($connection,$id){
    $query = "select image from product_images where main = 1 and product_id =".$id;
    $sql = $connection->prepare($query);
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    return $result['image'];
}
$user_ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() {

    global $user_agent;

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
        '/windows nt 10/i'      =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {

    global $user_agent;

    $browser        = "Unknown Browser";

    $browser_array = array(
        '/msie/i'      => 'Internet Explorer',
        '/firefox/i'   => 'Firefox',
        '/safari/i'    => 'Safari',
        '/chrome/i'    => 'Chrome',
        '/edge/i'      => 'Edge',
        '/opera/i'     => 'Opera',
        '/netscape/i'  => 'Netscape',
        '/maxthon/i'   => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i'    => 'Handheld Browser'
    );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}
$user_os        = getOS();
$user_browser   = getBrowser();
?>