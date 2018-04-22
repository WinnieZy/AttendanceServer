<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 查找apply数据接口
 */
require './Response.php';
require './DbOperator.php';
header("Content-Type:application/json; charset=utf-8");
$data = file_get_contents('php://input');
$json = json_decode($data,true);
$apply_id = $json['apply_id'];$staff_id = $json['staff_id'];
if ($apply_id == NULL || $staff_id == NULL){
    return Response::json(401, '数据不合法(NULL)');
}
if ($staff_id == 0){
    return Response::json(401, '数据不合法(0)');
}
try {
    $mysql_conn = DbOperator::getInstance()->connect();
} catch (Exception $ex) {
    return Response::json(403, '数据库连接失败');
}
$sql = "select * from apply where apply_id > '$apply_id' and (staff_id = '$staff_id' or leader_id = '$staff_id')";
$result = DbOperator::getInstance()->query($sql);
if($result){
    $row = mysql_fetch_assoc($result);
    if(!$row){//没有查到匹配数据
        return Response::json(200, 'no data matched');
    }else{
        $json_data = array();
        do {
            $json_data[] = $row;
        }while ($row = mysql_fetch_assoc($result));
        if ($json_data){
            return Response::json(200, 'success',$json_data);
        }  else {
            return Response::json(400, 'error');
        }
    }
}else {
    return Response::json(400, 'error');
}
DbOperator::getInstance()->close($mysql_conn);