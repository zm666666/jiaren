<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL & ~E_NOTICE);

/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2018/3/26
 * Time: 20:51
 */
class GetMsgModel extends CI_Model
{

    //单表查询
    public function getMsgFromSingleTable($table, $searchArr,$otherCondition)
    {
        //获取列的信息（列名，类型，长度）
        $res[$table] = $this->db->query("SELECT  *  FROM information_schema.COLUMNS WHERE table_schema='jiaren' AND table_name='{$table}'")->result_array();
        $tableKey = '';
        $searchKey = '';
        $condition = '';
        $tableArr = array($table);
        $fk = array();
        $interface = array();
        foreach ($res[$table] as $value) {
            //键名获取
            $tableKey .= $value['COLUMN_NAME'] . ',';
            //sql数据类型转换成h5input数据类型
            switch ($value['DATA_TYPE']) {
                case 'int':
                    $msg['type'][$value['COLUMN_NAME']] = 'el-input';
                    break;
                case 'varchar':
                    $msg['type'][$value['COLUMN_NAME']] = 'el-input';
                    break;
                case 'date':
                    $msg['type'][$value['COLUMN_NAME']] = 'el-date-picker';
                    break;
                case 'time':
                    $msg['type'][$value['COLUMN_NAME']] = 'el-time-picker';
                    break;
//                case 'tinyint':
//                    $msg['type'][$value['COLUMN_NAME']] = 'checkbox';
//                    break;
            }
            //获取字段长度
            $temp = explode('(', $value['COLUMN_TYPE']);
            $temp = explode(')', $temp[1]);
            $msg['length'][$value['COLUMN_NAME']] = $temp[0];
            //获取宽度和中文，在sql注释写好的
            $temp = explode('|', $value['COLUMN_COMMENT']);
            $msg['value'][$value['COLUMN_NAME']] = $temp[0];
            $msg['width'][$value['COLUMN_NAME']] = $temp[1];
            array_shift($temp);
            array_shift($temp);
            if ($temp) {
                $condition .= $temp[0] . '.' . $temp[1] . '=' . $table . '.' . $value['COLUMN_NAME'] . ' and ';
                if( $searchArr[$value['COLUMN_NAME']]){
                    $condition .= $temp[0] . '.' . $temp[1] . '=' . $searchArr[$value['COLUMN_NAME']] . ' and ';
                }
                $flag = true;
                foreach ($tableArr as $val) {
                    if ($val == $temp[0]) {
                        $flag = false;
                        break;
                    }
                }
                if ($flag)
                    array_push($tableArr, $temp[0]);
                $searchKey .= $temp[0].'.'.$temp[2] . ' as ' . $value['COLUMN_NAME'] . ',';
                array_push($fk, $value['COLUMN_NAME']);
                $tempArray['table'] = $temp[0];
                $tempArray['fk'] = $temp[1];
                $tempArray['value'] = $temp[2];
                $tempArray['selectValue']=$temp[2];
                $interface[$value['COLUMN_NAME']] = $tempArray;
            } else {
                $condition .= $table . '.' . $value['COLUMN_NAME'] . ' like "%' . $searchArr[$value['COLUMN_NAME']] . '%" and ';
                $searchKey .= $table . '.' . $value['COLUMN_NAME'] . ',';
            }
        }
        $data['fk'] = $fk;
        $data['interface'] = $interface;
        //搜索条件去掉最后一个and并加上where，键去掉最后一个逗号,表格名数组转字符串
        $condition = ' where ' . $condition;
        $condition = substr($condition, 0, -4);
        $tableKey = substr($tableKey, 0, -1);
        $searchKey = substr($searchKey, 0, -1);
        $tableArr = implode(',', $tableArr);
//        //去掉msg数组中关于id的信息
//        array_shift($msg['length']);
//        array_shift($msg['value']);
//        array_shift($msg['width']);
//        array_shift($msg['type']);
        $data['sql'] = "select  {$searchKey} from {$tableArr} {$condition}{$otherCondition}";
        $data['data'] = $this->db->query("select  {$searchKey} from {$tableArr} {$condition}{$otherCondition}")->result_array();
        $data['total'] = $this->db->query("select count('id') as total from {$tableArr}{$condition}{$otherCondition} ")->row()->total;
        $tableKey = explode(",", $tableKey);
        array_shift($tableKey);
        $data['key'] = $tableKey;
//        $msg['width']=$this->getWidth($tableKey);
        $data['msg'] = $msg;
        return $data;
    }

    //外键接口查询，返回数组用来渲染下拉框
    public function getInterfaceMsg($table, $fk, $value,$condition)
    {
//        return "select  {$fk},{$value} from {$table}";
        return $this->db->query("select  {$fk},{$value} as val from {$table} {$condition}")->result_array();
    }

    public function login($username, $password,$tableName){
        return $this->db->query("select  id from {$tableName} where name='{$username}' AND  psd = '{$password}'")->row();
    }

    public function userMsg($id){
        return $this->db->query("select * from charge_msg where userName={$id}")->result_array();
    }

    public function getProductsMsg( $condition, $sort, $limit){
        $data['data']=$this->db->query("select $ from product where {$condition} {$sort} {$limit}")->result_array();
    }

    public function checkCourseMsg( $userId,$condition,$courseIndexId){
        $data['res']=$this->db->query("select course.name,course.weekWorkDay,teacher.name as teacher,course.address from course,elective,teacher where teacher.id=course.teacher
 and elective.member={$userId} and elective.course=course.id and elective.allow=1 
 and course.courseIndexId = {$courseIndexId}{$condition}")->result_array();
        $data['sql']="select course.name,course.weekWorkDay,teacher.name as teacher,course.address from course,elective,teacher where teacher.id=course.teacher
 and elective.member={$userId} and elective.course=course.id and elective.allow=1 
 and course.courseIndexId = {$courseIndexId}{$condition}";
        return $data;
    }

    public function getCourseIndex($id){
        return $this->db->query("select value from course_time where id = {$id}")->row()->value;
    }

    public function getCourseEvaluation($id){
        return $this->db->query("select evaluationCourse.id,evaluationCourse.evaluation,member.name,evaluationCourse.date from evaluationCourse,course,member 
where evaluationCourse.courseId=course.id and evaluationCourse.memberId=member.id and  course.id={$id}")->result_array();
    }
}