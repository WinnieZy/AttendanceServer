<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 修改staff数据接口
 */
require './Response.php';
require './DbOperator.php';
header("Content-Type:application/json; charset=utf-8");
$data = file_get_contents('php://input');
$json = json_decode($data,true);
$staff_id = $json['staff_id'];$tel_num = $json['tel_num'];$email = $json['email'];
if ($staff_id == NULL || $staff_id == ""){
    return Response::json(401, '数据不合法(staff_id)');
}
if ($tel_num == NULL && $email == NULL){
    return Response::json(401, '数据不合法(NULL)');
}
if ("" == $tel_num && "" == $email){
    return Response::json(401, '数据不合法("")');
}
try {
    $mysql_conn = DbOperator::getInstance()->connect();
} catch (Exception $ex) {
    return Response::json(403, '数据库连接失败');
}
if($tel_num != NULL && "" != $tel_num){
    $sql_staff = "update staff set tel_num = '$tel_num' where staff_id = '$staff_id'";
}
if($email != NULL && "" != $email) {
    $sql_staff = "update staff set email = '$email' where staff_id = '$staff_id'";
}
$result_staff = DbOperator::getInstance()->query($sql_staff);
if($result_staff){
    return Response::json(200, '修改成功');
}else {
    return Response::json(400, '修改失败，请稍后重试');
}
DbOperator::getInstance()->close($mysql_conn);