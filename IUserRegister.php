<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 处理user接口数据
 */
require './Response.php';
require './DbOperator.php';
header("Content-Type:application/json; charset=utf-8");
$data = file_get_contents('php://input');
$json = json_decode($data,true);
//$username = isset($_POST['username']) ? $_POST['username'] : NULL;
//$password = isset($_POST['password']) ? $_POST['password'] : NULL;
$username = $json['username'];$password = $json['password'];$mac = $json['mac'];$phone = $json['phone'];$email = $json['email'];
if ($password == NULL || $password == ""){
    return Response::json(401, '数据不合法(password)');
}
if ($username == NULL || $username == ""){
    return Response::json(401, '数据不合法(username)');
}
if ($phone == NULL || $phone == ""){
    return Response::json(401, '数据不合法(phone)');
}
if ($email == NULL || $email == ""){
    return Response::json(401, '数据不合法(email)');
}
//echo $sql .'</br>';
try {
    $mysql_conn = DbOperator::getInstance()->connect();
} catch (Exception $ex) {
    return Response::json(403, '数据库连接失败');
}
$now = DbOperator::getInstance()->get_today_time();
$split_array = explode('_',$username,2);
$staff_id = $split_array[1];
if($mac != NULL && "" != $mac){
    $sql_user = "update user set password = '$password', mac = '$mac', last_login_time = '$now', isMacChecked = true where username = '$username'";
}  else {
    $sql_user = "update user set password = '$password', last_login_time = '$now' where username = '$username'";
}
$sql_staff = "update staff set tel_num = '$phone', email = '$email' where staff_id = '$staff_id'";
$result_user = DbOperator::getInstance()->query($sql_user);
$result_staff = DbOperator::getInstance()->query($sql_staff);
if($result_user && $result_staff){
    return Response::json(200, $now);
}else {
    return Response::json(400, '注册失败，请稍后重试');
}
DbOperator::getInstance()->close($mysql_conn);