<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2018/3/26
 * Time: 20:51
 */
class SaveMsgModel extends CI_Model
{
    public function insertOrUpdate($id, $table, $data)
    {
        if ($id) {
            $this->db->where("id", $id);
            $this->db->update($table, $data);
            return $this->db->affected_rows();
        } else {
            $this->db->insert($table, $data);
            return $this->db->affected_rows();
        }
    }

    public function updatePsd($psd){
        $data['psd']=$psd;
        $temp=$this->session->userdata('userMsg');
        $this->db->where('id', $temp['id']);
        $this->db->update('user', $data);
        return $temp['id'];
    }

    public function eat_people($buyer,$other){
        $res='';
        foreach ($other as $value){
            $temp=$this->db->query("select * from eat_people where id={$value}")->row();
            $data['eatTimes']=$temp->eatTimes+1;
            if($buyer==$value){
                $data['buyTimes']=$temp->buyTimes+1;
                $data['helpPeople']=$temp->helpPeople+count($other)-1;
            }
            else{
                $data['buyTimes']=$temp->buyTimes;
                $data['helpPeople']=$temp->helpPeople;
            }
            $this->db->where("id", $value);
            $this->db->update('eat_people', $data);
            $res.=$temp->name.',';
        }
        $res = substr($res, 0, -1);
        return $res;
    }

    public function eat_msg($data){
        $this->db->insert('eat_msg', $data);
        return $this->db->affected_rows();
    }
}