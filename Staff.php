<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 对应数据库员工表
 *
 * @author lenovo
 */
class Staff {
    private $name;
    private $staff_id;
    private $tel_num;
    private $email;
    private $mac;
    
    function __construct($name, $staff_id, $tel_num, $email, $mac) {
        $this->name = $name;
        $this->staff_id = $staff_id;
        $this->tel_num = $tel_num;
        $this->email = $email;
        $this->mac = $mac;
    }
    
    function getName() {
        return $this->name;
    }

    function getStaff_id() {
        return $this->staff_id;
    }

    function getTel_num() {
        return $this->tel_num;
    }

    function getEmail() {
        return $this->email;
    }

    function getMac() {
        return $this->mac;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setStaff_id($staff_id) {
        $this->staff_id = $staff_id;
    }

    function setTel_num($tel_num) {
        $this->tel_num = $tel_num;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setMac($mac) {
        $this->mac = $mac;
    }
    
    public function __toString() {
        echo  'findstaff result:'. $this->name . " " . $this->staff_id . " " . $this->tel_num . " " . $this->email . " " . $this->mac . " " . '</br>';
    }
}
