<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2018/3/26
 * Time: 20:13
 */
class SaveMsg extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('saveMsgModel');
        header('Access-Control-Allow-Origin: *');
    }

    public function saveMsgFromSingleTable()
    {
        $data = $this->input->post('data');
        $temp=array();
        foreach ($data as $key => $value){
            $temp[$key]=$value;
        }
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $data = $this->saveMsgModel->insertOrUpdate($id, $table, $temp);
        if ($data) {
            $res['code'] = 200;
            $res['msg'] = '保存成功';
        } else {
            $res['code'] = 300;
            $res['msg'] = '信息保存失败，请确认网络畅通后再次尝试';
        }
        echo json_encode($res);
    }

    public function updatePsd(){
        $psd=$this->input->post('psd');
        $res=$this->saveMsgModel->updatePsd($psd);
        $data['code']=200;
        $data['data']=$res;
        $this->session->unset_userdata('userMsg');
        echo json_encode($data);
    }

    public function saveFile(){
        $config['upload_path'] = '././upload';
        $config['allowed_types'] = 'jpg|png|jpeg|gif';
        $config['max_size'] = '1024000';
        $this->load->library('upload', $config);
        if ($this -> upload -> do_upload('file')) { //上传成功
            $data['code']=200;
            $data['data'] = array('upload_data' => $this -> upload -> data()); //将文件信息存入数组
            echo json_encode($data); //打印文件信息
        } else { //上传失败
            $error = array('error' => $this -> upload -> display_errors());//将错误信息存入数组
            echo json_encode($error);
        }
    }

    public function checkCourse(){
        $sum = 0;
        $saveNum = 0;
        $courseId=$this->input->post('courseId');
        $data['member']=$this->input->post('memberId');
        $data['allow']=2;
        foreach ($courseId as $value) {
            $sum++;
            $data['course']= $value;
            $res = $this->saveMsgModel->insertOrUpdate(0,'elective', $data);
            if($res)
                $saveNum++;
        }
        if ($saveNum==$sum) {
            $res['code'] = 200;
            $res['msg'] = '保存成功';
        } else {
            $res['code'] = 300;
            $res['msg'] = '信息保存失败，请确认网络畅通后再次尝试';
        }
        echo json_encode($res);
    }

    public function evaluationCourse(){
        $data['courseId']=$this->input->post('courseId');
        $data['memberId']=$this->input->post('memberId');
        $data['date']=$this->input->post('date');
        $data['evaluation']=$this->input->post('evaluation');
        $data = $this->saveMsgModel->insertOrUpdate(0, 'evaluationCourse', $data);
        if ($data) {
            $res['code'] = 200;
            $res['msg'] = '保存成功';
        } else {
            $res['code'] = 300;
            $res['msg'] = '信息保存失败，请确认网络畅通后再次尝试';
        }
        echo json_encode($res);
    }
}