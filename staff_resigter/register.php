<?php

require ('../DbOperator.php');
header("Content-Type:text/html; charset=utf-8");

try {
    $mysql_conn = DbOperator::getInstance()->connect();
} catch (Exception $ex) {
    echo "<script type='text/javascript'>alert('数据库连接失败！');</script>";	
    return;
}
$staffName = $_POST["staffName"];
$IDcard = $_POST["IDcard"];
$result_staff = DbOperator::getInstance()->query("SELECT * FROM staff where IDcard = '$IDcard'");
$row = mysql_fetch_assoc($result_staff);
if($row){
    echo $row['staff_id'].$row['staff_name'].$row['IDcard'].$row['tel_num'].$row['email'].$row['leader'].$row['entry_date'];
    echo "<script type='text/javascript'>alert('注册失败！该员工已存在！');location.href='staff_register.html';</script>";
    exit();
}else{
    $today = DbOperator::getInstance()->get_today();
    $result = DbOperator::getInstance()->query("INSERT INTO staff(staff_name,IDcard,approval_auth,leader_id,leader,entry_date) VALUES ('$staffName','$IDcard',false,9,'默认领导','$today')");
    if($result){
        $result_staff = DbOperator::getInstance()->query("SELECT * FROM staff where IDcard = '$IDcard'");
        $row = mysql_fetch_assoc($result_staff);
        if($row){
            $staff_id = $row['staff_id'];
            $username = $staffName.'_'.$staff_id;
            $password = substr($IDcard, 12,6);
            $result = DbOperator::getInstance()->query("INSERT INTO user(username,password,staff_id) VALUES ('$username','$password',$staff_id)");
            if($result){
                $result_user = DbOperator::getInstance()->query("SELECT * FROM user where staff_id = '$staff_id'");
                $row = mysql_fetch_assoc($result_user);
                if($row){
                    echo "<script type='text/javascript'>alert('注册成功，欢迎成为本公司一员！你的员工ID是：$staff_id\\n用户信息初始化成功！');location.href='staff_register.html';</script>";
                    exit();
                }  else {
                    echo "<script type='text/javascript'>alert('注册成功，欢迎成为本公司一员！你的员工ID是：$staff_id\\n用户信息初始化失败，需手动注册用户信息！');location.href='staff_register.html';</script>";
                    exit();
                }
            } else {
                    echo "<script type='text/javascript'>alert('注册成功，欢迎成为本公司一员！你的员工ID是：$staff_id\\n用户信息初始化失败，需手动注册用户信息！');location.href='staff_register.html';</script>";
                    exit();
            }
        }else{
            echo "<script type='text/javascript'>alert('注册失败！');location.href='staff_register.html';</script>";	
            exit();
        }
    }else{
        echo "<script type='text/javascript'>alert('注册失败！');location.href='staff_register.html';</script>";
        exit();
    }
}
DbOperator::getInstance()->close($mysql_conn);



