<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2018/3/26
 * Time: 20:13
 */
class GetMsg extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('getMsgModel');
        $this->load->library('session');
        // 设置允许其他域名访问
        header('Access-Control-Allow-Origin:*');
// 设置允许的响应类型
        header('Access-Control-Allow-Methods:POST, GET');
// 设置允许的响应头
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
    }

    public function getMsgFromSingleTable()
    {
        $searchArr = $this->input->post('searchArr');
        $sortAsc = $this->input->post('sortAsc');
        $sortName = $this->input->post('sortName');
        $pageSize = $this->input->post('pageSize');
        $page = $this->input->post('page');
        $table = $this->input->post('table');
        $otherCondition = $this->input->post('otherCondition');
        //排序参数转化成sql语法
        if ($sortName != '') {
            $sort = 'order by ' . $sortName . ' ' . $sortAsc;

        } else {
            $sort = '';
        }
        //分页参数转化成sql语法
        $limt = $pageSize * ($page - 1);
        $limt = 'limit ' . $limt . ',' . $pageSize;
        //返回总条数和查询结果
        $res = $this->getMsgModel->getMsgFromSingleTable($table, $searchArr,$otherCondition);
        echo json_encode($res);
    }

    public function getInterfaceMsg()
    {
        $table = $this->input->post('table');
        $fk = $this->input->post('fk');
        $value = $this->input->post('selectValue');
        $condition = $this->input->post('condition');
        $res = $this->getMsgModel->getInterfaceMsg($table, $fk, $value,$condition);
        if ($res!==false) {
            $data['code'] = 200;
            $data['data'] = $res;
        } else {
            $data['code'] = 500;
            $data['msg'] = '服务器错误，未找到相关数据，请检查网络后重试';
        }
        echo json_encode($data);
    }


    public function login(){
        $username=$this->input->post('username');
        $password=$this->input->post('password');
        $tableName=$this->input->post('tableName');
        $res = $this->getMsgModel->login($username, $password,$tableName);
        if ($res) {
            $data['code'] = 200;
            $data['userName']=$username;
            $data['id']=$res->id;
            $data['type']=$tableName=='admin'?1:0;
            $data['msg']='登陆成功，即将跳转至相应界面';
        } else {
            $data['code'] = 500;
            $data['msg'] = '用户名或密码错误，请检查后重试';
        }
        echo json_encode($data);
    }

    public function getProductsMsg()
    {
        $searchArr = $this->input->post('searchArr');
        $sortAsc = $this->input->post('sortAsc');
        $sortName = $this->input->post('sortName');
        $pageSize = $this->input->post('pageSize');
        $page = $this->input->post('page');
        //排序参数转化成sql语法
        if ($sortName != '') {
            $sort = 'order by ' . $sortName . ' ' . $sortAsc;

        } else {
            $sort = '';
        }
        //分页参数转化成sql语法
        $limit = $pageSize * ($page - 1);
        $limit = 'limit ' . $limit . ',' . $pageSize;
        $condition='';
        if($searchArr){
            foreach ($searchArr as $key=>$value){
                $condition .=$key . ' like "%' . $value . '%" and ';
            }
            $condition = ' and ' . $condition;
            $condition = substr($condition, 0, -4);
        }
        //返回总条数和查询结果
        $res = $this->getMsgModel->getProductsMsg( $condition, $sort, $limit);
        echo json_encode($res);
    }

    public function checkCourseMsg(){
        $userId = $this->input->post('userId');
        $startDate = $this->input->post('startDate');
        $finishDate = $this->input->post('finishDate');
        $condition='';
        if($finishDate!=''){
            $condition.=' and course.startDate <= \''.$finishDate.'\'';
        }
        if($startDate!=''){
            $condition.=' and course.finishDate >= \''.$startDate.'\'';
        }
        $data=array();
        for ($i=1;$i<=5;$i++){
            $courseIndexId=$i;
            $res=$this->getMsgModel->checkCourseMsg( $userId,$condition,$courseIndexId);
            $temp=array();
            $temp['courseIndex']=$this->getMsgModel->getCourseIndex($i);
            $temp['sql']=$res['sql'];
            $res=$res['res'];
            foreach ($res as $value){
                $str=$value['weekWorkDay'];
                unset($value['weekWorkDay']);
                foreach ($value as $key=>$val){
                    $temp['day'.$str.$key]=$val;
                }
            }
            array_push($data,$temp);
        }
        echo json_encode($data);
    }

    public function getCourseEvaluation(){
        $courseId = $this->input->post('courseId');
        $res=$this->getMsgModel->getCourseEvaluation($courseId);
        if ($res) {
            $data['code'] = 200;
            $data['data'] = $res;
        } else {
            $data['code'] = 500;
            $data['msg'] = '服务器错误，未找到相关数据，请检查网络后重试';
        }
        echo json_encode($data);
    }
}