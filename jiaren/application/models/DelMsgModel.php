<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2018/3/26
 * Time: 20:51
 */
class DelMsgModel extends CI_Model
{
    public function del($id, $table)
    {
        $sum = 0;
        $delNum = 0;
        foreach ($id as $value) {
            $sum++;
            $condition['id'] = $value;
            $this->db->delete($table, $condition);
            $delNum += $this->db->affected_rows();
        }
        return $sum == $delNum;
    }

    public function returnCourse( $course,$member){
        $this->db->query("delete from elective where course={$course} and member = {$member}");
        return $this->db->affected_rows();
    }
}