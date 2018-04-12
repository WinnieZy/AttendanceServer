<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require ('./DbOperator.php');
try {
    $mysql_conn = DbOperator::getInstance()->connect();
} catch (Exception $ex) {
    return Response::json(403, '数据库连接失败');
}
set_time_limit(0);
//服务器信息
$server = 'udp://192.168.191.5:6006';
$socket = stream_socket_server($server, $errno, $errstr, STREAM_SERVER_BIND);
if (!$socket) {
    die("$errstr ($errno)");
}
do {
    //接收客户端发来的信息
    $inMsg = stream_socket_recvfrom($socket, 1024, 0, $peer);
    $result_arr = explode("\n", "{$inMsg}");
    foreach ($result_arr as $arr) {
        if (strlen($arr) < 17) {
            continue;
        }
        $mac = substr($arr, 0, 17);
        $today = DbOperator::getInstance()->get_today();
        $weekday = DbOperator::getInstance()->get_weekday();
        $date = $today.'('.$weekday.')';
        $result_user = DbOperator::getInstance()->query("SELECT user_id FROM user where mac = '$mac'");
        echo  '$result_user:'. $result_user . "<br />";
        if($result_user){
            //在员工表中找到了对应mac的员工，有记录的mac才用进行下一步判断，无则直接忽略
            $row = mysql_fetch_assoc($result_user);
            if($row){//有
                //输出员工信息
                do {
                    echo json_encode($row) .'<br/>';
                }while ($row = mysql_fetch_assoc($result_user));
                //查询及更新该员工mac的出现时间
                $result_mac_date = DbOperator::getInstance()->query("SELECT id FROM mac where mac = '$mac' AND date = '$date'");
                if ($result_mac_date) {//如果查询到该mac今天有记录，则更新last_time
                    $row = mysql_fetch_assoc($result_mac_date);
                    if($row){//今天已有mac记录
                        do {
                            echo json_encode($row) .'<br/>';
                        }while ($row = mysql_fetch_assoc($result_mac_date));
                        $time = DbOperator::getInstance()->get_now();
                        $ret = DbOperator::getInstance()->query("UPDATE mac SET last_time = '$time'
                        WHERE mac = '$mac' AND date = '$date'");
                        echo  'today mac found and update:'. $ret . "<br />";
                    }else {//该mac没有今天的记录，则直接插入
//                        $result_mac = DbOperator::getInstance()->query("SELECT id FROM mac where mac = '$mac' limit 0,1 ");
//                        if($result_mac){
//                            $row = mysql_fetch_assoc($result_mac);
//                            if($row){//该mac有记录但并非今天，则直接插入当天的记录条目
//                                do{
//                                    echo json_encode($row) .'<br/>';
//                                }while ($row = mysql_fetch_assoc($result_mac));
                                $time = DbOperator::getInstance()->get_now();
                                $ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
                                VALUES ('$mac', '$date', '$time','$time')");
                                echo  'today mac not found and insert:'.$ret . "<br />";
//                            }
//                        }//该mac无记录时不操作
        //                $ret = DbOperator::getInstance()->query("INSERT INTO mac (mac, date, first_time, last_time) 
        //                VALUES ('$mac', '$date', '$time','$time')");
        //                echo $res ."<br />";
                    }
                }
            }else{//test用：找不到该mac对应的员工，则新建员工
                if (strcasecmp("0C:8F:FF:82:19:67", $mac) == 0){
                    $res = DbOperator::getInstance()->query("INSERT INTO staff (name, staff_id, tel_num, email, mac) 
                    VALUES ('周泳', '20141002303', '18826103586','897531071@qq.com','0C:8F:FF:82:19:67')");
                    echo 'findstaff fail and insert:'.$res ."<br />";
                }
            }
        }
            
        if (strcasecmp("0C:8F:FF:82:19:67", $mac) == 0) {
            $mac .= " 我的华为";
        } else if (strcasecmp("8C:BE:BE:CA:FE:AB", $mac) == 0) {
            $mac .= " 老妈小米";
        } else if (strcasecmp("50:01:D9:4E:FB:41", $mac) == 0) {
            $mac .= " 老爸华为";
//        }else {
//            continue;
        }
        echo date("Y-m-d h:i:s") . " : " . $mac . '</br>';
    }
    //给客户端发送信息
    $bytes = array();
    $bytes[] = ord(1);
    $outMsg = chr($bytes);
    stream_socket_sendto($socket, $outMsg, 0, $peer);
} while ($inMsg !== false);
DbOperator::getInstance()->close($mysql_conn);
