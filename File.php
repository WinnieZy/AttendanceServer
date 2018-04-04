<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 静态缓存
 *
 * @author lenovo
 */
class File {
    //put your code here
    private $_dir;
    const EXT = '.txt';
    public function __construct() {
        $this->_dir = dirname(__FILE__).'/files/';
    }
    
    public function cacheData($key,$value='',$path=''){
        $filename = $this->_dir.$path.$key.self::EXT;
        
        if($value !== ''){//将value值写入缓存
            if(is_null($value)){//value传null时删除缓存
                return @unlink($filename);
            }
            $dir = dirname($filename);
            if(!is_dir($dir)){
                mkdir($dir,0777);
            }
            return file_put_contents($filename, json_encode($value));
        }
        //没有传值时表示读取缓存
        if(!is_file($filename)){
            return FALSE;
        }  else {
            return json_decode(file_get_contents($filename),true);
        }
    }
}
