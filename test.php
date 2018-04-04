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
$sql_user = "update user set mac = '',last_login_time = '',isMacChecked = false where staff_id = 14";
$sql_staff = "update staff set tel_num = '',email = '' where staff_id = 14";
$result_user = DbOperator::getInstance()->query($sql_user);
$result_staff = DbOperator::getInstance()->query($sql_staff);
echo $result_user . '</br>' .$result_staff;