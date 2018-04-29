<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 修改user数据接口
 */
require './Response.php';
require './DbOperator.php';
header("Content-Type:application/json; charset=utf-8");
$data = file_get_contents('php://input');
$json = json_decode($data,true);
$staff_id = $json['staff_id'];$password = $json['password'];$mac = $json['mac'];
if ($staff_id == NULL || $staff_id == ""){
    return Response::json(401, '数据不合法(staff_id)');
}
if ($password == NULL && $mac == NULL){
    return Response::json(401, '数据不合法(NULL)');
}
if ("" == $password && "" == $mac){
    return Response::json(401, '数据不合法("")');
}
try {
    $mysql_conn = DbOperator::getInstance()->connect();
} catch (Exception $ex) {
    return Response::json(403, '数据库连接失败');
}
if($mac != NULL && "" != $mac){
    $sql_user = "update user set mac = '$mac' where staff_id = '$staff_id'";
}
if($password != NULL && "" != $password) {
    $sql_user = "update user set password = '$password' where staff_id = '$staff_id'";
}
$result_user = DbOperator::getInstance()->query($sql_user);
if($result_user){
    if(mysql_affected_rows() == 1){
        return Response::json(200, '修改成功');
    }else {
        return Response::json(400, '修改失败，请稍后重试');
    }
}else {
    return Response::json(400, '修改失败，请稍后重试');
}
DbOperator::getInstance()->close($mysql_conn);