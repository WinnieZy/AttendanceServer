<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Response
 *
 * @author lenovo
 */
class Response {
    /**
     * 按json方式输出通信数据
     * @param type $code 状态妈
     * @param type $message 提示信息
     * @param type $data 数据
     */
    public static function json($code,$message = '',$data = array()){
        if(!is_numeric($code)){
            return '';
        }
        
        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );
        
        echo json_encode($result);
//        exit;
    }
}
