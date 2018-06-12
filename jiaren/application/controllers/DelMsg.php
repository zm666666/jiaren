<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2018/3/26
 * Time: 20:13
 */
class DelMsg extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('delMsgModel');
        header('Access-Control-Allow-Origin: *');
    }

    public function delMsgFromSingleTable()
    {
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $data = $this->delMsgModel->del($id, $table);
        if ($data) {
            $res['code'] = 200;
            $res['msg'] = '删除成功';
        } else {
            $res['code'] = 300;
            $res['msg'] = '删除失败';
        }
        echo json_encode($res);
    }

    public function returnCourse(){
        $sum = 0;
        $delNum = 0;
        $courseId=$this->input->post('courseId');
        $member=$this->input->post('memberId');
        foreach ($courseId as $value) {
            $sum++;
            $course= $value;
            $res = $this->delMsgModel->returnCourse( $course,$member);
            if($res)
                $delNum++;
        }
        if ($delNum==$sum) {
            $res['code'] = 200;
            $res['msg'] = '保存成功';
        } else {
            $res['code'] = 300;
            $res['msg'] = '信息保存失败，请确认网络畅通后再次尝试';
        }
        echo json_encode($res);
    }
}