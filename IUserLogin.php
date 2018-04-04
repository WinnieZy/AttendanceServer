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
$username = $json['username'];$password = $json['password'];$reviewMac = $json['reviewMac'];$getMac = $json['getMac'];
if ($password == NULL || $password == ""){
    return Response::json(401, '数据不合法');
}
if ($username == NULL || $username == ""){
    return Response::json(401, '数据不合法');
}
try {
    $mysql_conn = DbOperator::getInstance()->connect();
} catch (Exception $ex) {
    return Response::json(403, '数据库连接失败');
}
$sql = "select password from user where username = '$username'";
$result = DbOperator::getInstance()->query($sql);
if($result){
    $row = mysql_fetch_assoc($result);
    if($row){//有，输出mac信息
        $pw = $row['password'];
        if($password == $pw){
            $sql = "select staff_id,mac,last_login_time from user where username = '$username' and password = '$password'";
            $result = DbOperator::getInstance()->query($sql);
            if($result){
                $row = mysql_fetch_assoc($result);
                if($row){//有，输出mac信息
                    $staff_id = $row['staff_id'];
                    $last_login_time = $row['last_login_time'];
                    $mac = $row['mac'];
                    $sql = "select * from staff where staff_id = '$staff_id'";
                    $result = DbOperator::getInstance()->query($sql);
                    if($result){
                        $row = mysql_fetch_assoc($result);
                        if($row){//有，输出mac信息
                            $login_time = DbOperator::getInstance()->get_today_time();
                            if($reviewMac != NULL && "" != $reviewMac){
                                if($mac != $reviewMac){
                                    $sql = "update user set mac = '$reviewMac', last_login_time = '$login_time',isMacChecked = true where staff_id = '$staff_id'";
                                    DbOperator::getInstance()->query($sql);
                                }  else {
                                    $sql = "update user set last_login_time = '$login_time' where staff_id = '$staff_id'";
                                    DbOperator::getInstance()->query($sql);
                                }
                            }else {
                                $sql = "update user set last_login_time = '$login_time' where staff_id = '$staff_id'";
                                DbOperator::getInstance()->query($sql);
                            }
                            $json_data = array();
                            do {
                                $json_data[] = $row;
                            }while ($row = mysql_fetch_assoc($result));
                            if ($json_data){
                                if($last_login_time == NULL || $last_login_time == ""){
                                    return Response::json(200, 'first_login',$json_data);
                                }  else {
                                    if($getMac != 'false' && $getMac != NULL){
                                        return Response::json(200, $mac, $json_data);
                                    }else{
                                        return Response::json(200, 'success',$json_data);
                                    }
                                }
                            }  else {
                                return Response::json(400, 'staff json error');
                            }
                        }else {
                            return Response::json(203, '查无该用户对应员工');
                        }
                    }else {
                        return Response::json(400, 'staff result error');
                    }
                }  else {
                    return Response::json(203, '查无该用户对应员工ID');
                }
            }else {
                return Response::json(400, 'user staff_id result error');
            }
        }else {
            return Response::json(203, '密码错误');
        }
    }  else {
        return Response::json(203, '查询不到该用户');
    }
}  else {
        return Response::json(400, 'user password result error');
   }
DbOperator::getInstance()->close($mysql_conn);