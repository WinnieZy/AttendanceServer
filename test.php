<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//require ('./File.php');
//$arr = array(
//    'id' => 1,
//    'name' => 'zy'
//);
////
////Response::json(200,'success',$arr);
//
//$file = new File();
//if($file->cacheData('cache',null)){
//    var_dump($file->cacheData('cache'));exit;
//    echo "success";
//}  else {
//    echo "error";
//}

/**
 * 获取mac接口数据
 */
require './DbOperator.php';
require './Response.php';
//$username = isset($_GET['mac']) ? $_GET['mac'] : NULL;
//$entryDate = isset($_GET['date']) ? $_GET['date'] : NULL;
//if ($username == NULL){
//    return Response::json(401, '数据不合法');
//}
//$sql = "select * from mac where mac = '$username'";
//if ($entryDate != NULL){
//    $sql .= " and date = '$entryDate'";
//}
//echo $sql;
//$split_array = explode('_','周泳_14',2);
//print_r($split_array);
//echo $split_array[1];
try {
    $mysql_conn = DbOperator::getInstance()->connect();
} catch (Exception $ex) {
    return Response::json(403, '数据库连接失败');
}
//清除员工14的数据
$sql_user = "update user set mac = '',last_login_time = '',isMacChecked = false where staff_id = 9";
$sql_staff = "update staff set tel_num = '',email = '' where staff_id = 9";
//$sql_staff = "update user set mac = '0C:8F:FF:82:19:67' where staff_id = 14";
//$sql_mac1 = "update mac set date = '2018-04-09(一)' where id=2";
//$sql_mac2 = "update mac set date = '2018-04-10(二)' where id=4";
$result_user = DbOperator::getInstance()->query($sql_user);
$result_staff = DbOperator::getInstance()->query($sql_staff);
echo $result_user . '</br>' .$result_staff;
$today = DbOperator::getInstance()->get_today();
$weekday = DbOperator::getInstance()->get_weekday();
$date = $today.'('.$weekday.')';
echo $date;

//$ret = DbOperator::getInstance()->query("update mac set date = '2018-03-19(一)' where date = '2018-03-30(五)'");
//$ret = DbOperator::getInstance()->query("update mac set date = '2018-04-08(日)' where id = 30");
//$ret = DbOperator::getInstance()->query("update mac set date = '2018-04-08(日)' where id = 31");
//$ret = DbOperator::getInstance()->query("update mac set date = '2018-04-08(日)' where id = 32");
//$ret = DbOperator::getInstance()->query("update mac set date = '2018-04-09(一)' where id = 33");
//$ret = DbOperator::getInstance()->query("update mac set date = '2018-04-09(一)' where id = 34");
//$ret = DbOperator::getInstance()->query("update mac set date = '2018-04-09(一)' where id = 35");

//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('8C:BE:BE:CA:FE:AB', '2018-04-02(一)', '18:40:37','22:23:15')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('0C:8F:FF:82:19:67', '2018-04-02(一)', '10:46:27','21:13:19')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('8C:BE:BE:CA:FE:AB', '2018-04-03(二)', '18:40:37','22:23:15')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('0C:8F:FF:82:19:67', '2018-04-03(二)', '10:46:27','21:13:19')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('8C:BE:BE:CA:FE:AB', '2018-04-04(三)', '18:40:37','22:23:15')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('0C:8F:FF:82:19:67', '2018-04-04(三)', '08:15:48','18:35:26')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('8C:BE:BE:CA:FE:AB', '2018-04-05(四)', '09:18:23','19:23:42')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('0C:8F:FF:82:19:67', '2018-04-05(四)', '08:40:37','20:41:32')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('8C:BE:BE:CA:FE:AB', '2018-04-06(五)', '09:10:39','21:54:23')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('0C:8F:FF:82:19:67', '2018-04-06(五)', '09:48:32','17:15:07')");

//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('8C:BE:BE:CA:FE:AB', '2018-04-09(一)', '09:42:18','20:41:38')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('0C:8F:FF:82:19:67', '2018-04-09(一)', '10:46:27','21:13:19')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('8C:BE:BE:CA:FE:AB', '2018-04-10(二)', '07:28:19','22:22:00')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('0C:8F:FF:82:19:67', '2018-04-10(二)', '08:38:15','20:48:35')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('8C:BE:BE:CA:FE:AB', '2018-04-11(三)', '10:42:57','20:41:36')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('0C:8F:FF:82:19:67', '2018-04-11(三)', '10:15:33','18:27:39')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('8C:BE:BE:CA:FE:AB', '2018-04-12(四)', '09:30:45','22:37:20')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('0C:8F:FF:82:19:67', '2018-04-12(四)', '10:22:59','19:25:30')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('8C:BE:BE:CA:FE:AB', '2018-04-13(五)', '14:33:54','22:00:15')");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('0C:8F:FF:82:19:67', '2018-04-13(五)', '11:22:49','18:30:56')");