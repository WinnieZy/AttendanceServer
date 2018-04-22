<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 添加apply数据接口
 */
require './Response.php';
require './DbOperator.php';
header("Content-Type:application/json; charset=utf-8");
$data = file_get_contents('php://input');
$json = json_decode($data,true);
$staff_id = $json['staff_id'];$staff_name = $json['staff_name'];$leader_id = $json['leader_id'];$type = $json['type'];
$apply_time_for = $json['apply_time_for'];$apply_time_at = $json['apply_time_at'];$reason = $json['reason'];
if ($staff_id == NULL || $staff_name == NULL || $leader_id == NULL || $type == NULL || $apply_time_for == NULL || $apply_time_at == NULL || $reason == NULL ){
    return Response::json(401, '数据不合法(NULL)');
}
if ($staff_id == 0 || $staff_name == "" || $leader_id == 0 || $type == 0 || $apply_time_for == "" || $apply_time_at == ""){
    return Response::json(401, '数据不合法(0)');
}
try {
    $mysql_conn = DbOperator::getInstance()->connect();
} catch (Exception $ex) {
    return Response::json(403, '数据库连接失败');
}
if($reason != NULL && "" != $reason){
    $sql = "insert into apply(staff_id,staff_name,leader_id,type,apply_time_for,apply_time_at,reason) VALUES ($staff_id, '$staff_name',$leader_id,$type,'$apply_time_for','$apply_time_at','$reason')";
}  else {
    $sql = "insert into apply(staff_id,staff_name,leader_id,type,apply_time_for,apply_time_at) VALUES ($staff_id, '$staff_name',$leader_id,$type,'$apply_time_for','$apply_time_at')";
}
$result = DbOperator::getInstance()->query($sql);
if($result){
    if(mysql_affected_rows() > 0){
        $json_data = array();
        $json_data[] = mysql_insert_id();
        return Response::json(200, 'success',$json_data);
    }  else {
        return Response::json(400, '执行成功插入失败');
    }
}else {
    return Response::json(400, '执行失败，请稍后重试');
}
DbOperator::getInstance()->close($mysql_conn);