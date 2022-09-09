<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Customers_model extends CI_Model 
{
    public function customers()
    {
        $sql = "SELECT * FROM customer ORDER BY created DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM vehicles WHERE vehicle_id=$id";
        $query = $this->db->query($sql);
    }

    public function delete_msg($id)
    {
        $sql = "DELETE FROM default_msg WHERE msg_id=$id";
        $query = $this->db->query($sql);
    }

    public function default_msg(){
        $sql = "SELECT * FROM default_msg";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function insert_chat_history($numbers,$msg){
        $data = array(
            'mobile' => $numbers,
            'msg' => $msg
        );
    
        $this->db->insert('chat_history', $data);
    }

    public function insert_msg($msg){
        $data = array(
            'msg' => $msg
        );
    
        $this->db->insert('default_msg', $data);
    }

    public function block($vehicle_id){
        $data = array(
            'status' => 0
        );
        
        $this->db->where('vehicle_id', $vehicle_id);
        $this->db->update('vehicles', $data);
    }

    public function blacklist()
    {
        $sql = "SELECT * FROM vehicles WHERE status = 0 ORDER BY updated DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function active_customer($vehicle_id){
        $data = array(
            'status' => 1
        );
        
        $this->db->where('vehicle_id', $vehicle_id);
        $this->db->update('vehicles', $data);
    }
    
}

