<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$_mysqli = new mysqli('localhost','root','','attendance');
class DbOperator{
    
    private static $_instance;
    private static $con;
    private $_dbConfig = array(
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'attendance'
    );
    private function __construct() {
        ;
    }
    public static function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function connect(){
        if (!self::$con){
            self::$con = mysql_connect($this->_dbConfig['host'],$this->_dbConfig['user'],$this->_dbConfig['password']);
            if (!self::$con){
//                die('Could not connect: ' . mysql_error());
                throw new Exception('mysql connect error',  mysql_error());
            }
            mysql_select_db($this->_dbConfig['database'], self::$con);//"attendance"
            mysql_query("set character set 'utf8'");//读库
            mysql_query("set names 'utf8'");//写库
        }
        return self::$con;
    }
    
    public function query($sql){
        return mysql_query($sql);
    }
    
    //预处理
    public function doPrepareSQL($connect,$sql,$bind_param,$type){
        $stmt = $connect->prepare($sql);
        $stmt->bind_param($type,$bind_param);
        $stmt->execute();
        return $stmt;
    }
    
    public function close($con){
        mysql_close($con);
    }
    
    public function get_today(){
        date_default_timezone_set("Asia/Shanghai");
        $date = date("Y-m-d");
        return $date;
    }
    
    public function get_today_time(){
        date_default_timezone_set("Asia/Shanghai");
        $today_time = date("Y-m-d H:i:s");
        return $today_time;
    }
    
    public function get_weekday(){
        $weekarray=array("日","一","二","三","四","五","六"); //先定义一个数组
//        echo "星期".$weekarray[date("w")];
        return $weekarray[date("w")];
    }


    public function get_now(){
        date_default_timezone_set("Asia/Shanghai");
        $time = date("H:i:s");
        return $time;
    }
}
//header("Content-Type: text/html;charset=utf-8");
//$con = mysql_connect("localhost","root","");
//if (!$con){
//    die('Could not connect: ' . mysql_error());
//}
//mysql_query("set character set 'utf8'");//读库
//mysql_query("set names 'utf8'");//写库
//mysql_select_db("attendance", $con);
//$mac = "0C:8F:FF:82:19:67";
//date_default_timezone_set("Asia/Shanghai");
//$time = date("H:i:s");
//$result = mysql_query("SELECT * FROM mac where mac = '$mac'");
//while($row = mysql_fetch_assoc($result)){   
//    echo json_encode($row) .'<br/>';
//}
//echo '<br/>';
//$result2 = mysql_query("SELECT * FROM staff where mac = '$mac'");
//while($row = mysql_fetch_assoc($result2)){
//    echo json_encode($row) .'<br/>';
//}
////if($result){
////    $res = mysql_query("UPDATE mac SET first_time = '16:11:10'
////    WHERE mac = '$mac' AND date = '2018-03-21'");
////    echo $res ."<br />";
////    while($row = mysql_fetch_array($result)){
////        echo $row['mac'] . " " . $row['date'] . " " . $row['first_time'] . " " . $row['last_time'] ."<br />";
////    }
////}else {    
////    $res = mysql_query("INSERT INTO mac (mac, date, first_time, last_time) 
////    VALUES ('$mac', '$date', '$time','$time')");
////    echo $res ."<br />";
////}
//mysql_close($con);
