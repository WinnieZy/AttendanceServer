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
//require './DbOperator.php';
//require './Response.php';
////$username = isset($_GET['mac']) ? $_GET['mac'] : NULL;
////$entryDate = isset($_GET['date']) ? $_GET['date'] : NULL;
////if ($username == NULL){
////    return Response::json(401, '数据不合法');
////}
////$sql = "select * from mac where mac = '$username'";
////if ($entryDate != NULL){
////    $sql .= " and date = '$entryDate'";
////}
////echo $sql;
////$split_array = explode('_','周泳_14',2);
////print_r($split_array);
////echo $split_array[1];
//try {
//    $mysql_conn = DbOperator::getInstance()->connect();
//} catch (Exception $ex) {
//    return Response::json(403, '数据库连接失败');
//}
////清除员工14的数据
////$sql_user = "update user set mac = '',last_login_time = '',isMacChecked = false where staff_id = 9";
////$sql_staff = "update staff set tel_num = '',email = '' where staff_id = 9";
//////$sql_staff = "update user set mac = '0C:8F:FF:82:19:67' where staff_id = 14";
//////$sql_mac1 = "update mac set date = '2018-04-09(一)' where id=2";
//////$sql_mac2 = "update mac set date = '2018-04-10(二)' where id=4";
////$result_user = DbOperator::getInstance()->query($sql_user);
////$result_staff = DbOperator::getInstance()->query($sql_staff);
////echo $result_user . '</br>' .$result_staff;
////$today = DbOperator::getInstance()->get_today();
////$weekday = DbOperator::getInstance()->get_weekday();
////$date = $today.'('.$weekday.')';
////echo $date;
//
//$json_data = array();
//for ($x=0; $x<5; $x++) {
//    $result = DbOperator::getInstance()->query("select apply_id,result from apply where apply_id = 5");
////    $result = DbOperator::getInstance()->query("select * from mac where id > 1 and mac = '8C:BE:BE:CA:FE:AB'");
//    $row = mysql_fetch_assoc($result);
//    $json_data[] = $row;
//} 
//print_r($json_data);

//$ret = DbOperator::getInstance()->query("update mac set date = '2018-04-09(一)' where id = 35");
//$ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
//                                VALUES ('8C:BE:BE:CA:FE:AB', '2018-04-02(一)', '18:40:37','22:23:15')");
$myArray=array("1"=>"val1","2"=>"val2","3"=>"val3");
foreach($myArray as $val) {
print($val." ");
}