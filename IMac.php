<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 获取mac接口数据,未传date表示获取该mac的全部数据，type==0表示select date，type==1表示add before date
 */
require './Response.php';
require './DbOperator.php';

header("Content-Type:application/json; charset=utf-8");
$data = file_get_contents('php://input');
$json = json_decode($data,true);
//$username = isset($_POST['username']) ? $_POST['username'] : NULL;
//$password = isset($_POST['password']) ? $_POST['password'] : NULL;
$mac = $json['mac'];$date = $json['date'];$isAdd = $json['isAdd'];

//$mac = isset($_GET['mac']) ? $_GET['mac'] : NULL;
//$date = isset($_GET['date']) ? $_GET['date'] : NULL;
//$isAdd = isset($_GET['isAdd']) ? $_GET['isAdd'] : NULL;
//echo $mac . $date .$isAdd . '</br>';
if ($mac == NULL){
    return Response::json(401, '数据不合法');
}
$sql = "select * from mac where mac = '$mac'";
//传过来的date是空的时候就直接将该mac的所有记录都返回
if ($date != NULL){
    $sql .= " and date = '$date'";
    if ($isAdd != NULL && $isAdd == "true"){
        $sql = "select id from mac where mac = '$mac' and date = '$date'";
    }
}
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
        if ($date != NULL && $isAdd != NULL && $isAdd == "true"){
            $id = $row['id'];
            $sql = "select * from mac where id > '$id' and mac = '$mac'";
            $result = DbOperator::getInstance()->query($sql);
            if(!$result){
                return Response::json(400, 'error');
            }  else {
                $row = mysql_fetch_assoc($result);
                if(!$row){//没有查到匹配数据
                    return Response::json(200, 'no data matched');
                }
            }
        }
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
        return Response::json(200, 'no data matched');
    }
}  else {
        return Response::json(400, 'error');
   }
DbOperator::getInstance()->close($mysql_conn);