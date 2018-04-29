<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 查找apply数据更新接口
 */
require './Response.php';
require './DbOperator.php';
header("Content-Type:application/json; charset=utf-8");
$data = file_get_contents('php://input');
$json = json_decode($data,true);
$apply_id = split(",",$json['apply_id']);
if ($apply_id == NULL || $apply_id == ""){
    return Response::json(401, '数据不合法');
}
try {
    $mysql_conn = DbOperator::getInstance()->connect();
} catch (Exception $ex) {
    return Response::json(403, '数据库连接失败');
}
$json_data = array();
foreach($apply_id as $id){
    $result = DbOperator::getInstance()->query("select apply_id,result from apply where apply_id = '$id'");
    if($result){
        $row = mysql_fetch_assoc($result);
        if($row){
            $json_data[] = $row;
        }
    }
}
if ($json_data){
    return Response::json(200, 'success',$json_data);
}  else {
    return Response::json(400, 'error');
}
DbOperator::getInstance()->close($mysql_conn);