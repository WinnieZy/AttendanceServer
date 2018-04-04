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
$staff_id = $json['staff_id'];
if ($staff_id == NULL || $staff_id == 0){
    return Response::json(401, '数据不合法');
}
$sql = "select * from staff where staff_id = $staff_id";
//echo $sql .'</br>';
try {
    $mysql_conn = DbOperator::getInstance()->connect();
} catch (Exception $ex) {
    return Response::json(403, '数据库连接失败');
}
$result = DbOperator::getInstance()->query($sql);
if($result){
    $row = mysql_fetch_assoc($result);
    if($row){//有，输出mac信息
        $json_data = array();
        do {
            $json_data[] = $row;
        }while ($row = mysql_fetch_assoc($result));
        if ($json_data){
            return Response::json(200, 'success',$json_data);
        }  else {
            return Response::json(400, 'error');
        }
    }  else {
        return Response::json(200, '无对应数据');
    }
}  else {
        return Response::json(400, 'error');
   }
DbOperator::getInstance()->close($mysql_conn);