<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 修改Apply数据接口
 */
require './Response.php';
require './DbOperator.php';
header("Content-Type:application/json; charset=utf-8");
$data = file_get_contents('php://input');
$json = json_decode($data,true);
$apply_id = $json['apply_id'];$result = $json['result'];
if ($apply_id == NULL || $apply_id == ""){
    return Response::json(401, '数据不合法(apply_id)');
}
if ($result == NULL || $result == ""){
    return Response::json(401, '数据不合法(result)');
}
try {
    $mysql_conn = DbOperator::getInstance()->connect();
} catch (Exception $ex) {
    return Response::json(403, '数据库连接失败');
}
$sql_apply = "update apply set result = '$result' where apply_id = '$apply_id'";
$result_apply = DbOperator::getInstance()->query($sql_apply);
if($result_apply){
    if(mysql_affected_rows() == 1){
        return Response::json(200, '提交成功');
    }else {
        return Response::json(400, '提交失败，请稍后重试');
    }
}else {
    return Response::json(400, '提交失败，请稍后重试');
}
DbOperator::getInstance()->close($mysql_conn);