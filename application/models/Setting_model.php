<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Setting_model extends CI_Model 
{
    public function services(){
        
        $sql = "SELECT * FROM service ORDER BY service ASC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function locations(){
        
        $sql = "SELECT * FROM location ORDER BY location ASC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function location_amount($location_id,$service_id){
        
        $sql = "SELECT * FROM service_amount WHERE service_id = $service_id AND location_id = $location_id ";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->amount;
    }

    public function location_avaiable($location_id,$service_id){
        $sql = "SELECT * FROM service_amount WHERE service_id = $service_id AND location_id = $location_id ";
        $query = $this->db->query($sql);
        return $count = $query->num_rows();
    }

    public function last_service_id(){
        $sql = "SELECT * FROM service ORDER BY updated DESC";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->service_id;
    }

    public function items(){
        
        $sql = "SELECT * FROM int_items ORDER BY item_id ASC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    

    public function delete($table,$id){
        $this->db->where('service_id', $id);
        $this->db->delete($table);
    }

    public function insert_service($service){
        $data = array(
            'service' => $service
        );
        $this->db->insert('booking_service', $data);
    }

    public function pwdiscorrect($uname,$pwd){
        $epassword = md5($pwd);
        $sql = "SELECT * FROM admin WHERE id = '$uname' AND password = '$epassword'";
        $query = $this->db->query($sql);

        if ($query->num_rows()  == 1) {
            return true;
        }
        else{
            return false;
        }
    }

    public function update_pwd($uname,$npwd){
        $epwd = md5($npwd);
        $data = array(
            'password' => $epwd
        );
        
        $this->db->where('id', $uname);
        $this->db->update('admin', $data);
    }

    public function items_available($service_id){
        
        $sql = "SELECT * FROM int_setting WHERE service_id = $service_id";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function insert_items($service_id,$item_id,$quantity){
        $data = array(
            'service_id' => $service_id,
            'item_id' => $item_id,
            'quantity' => $quantity
        );
        $this->db->insert('int_setting', $data);
    }

    public function service_items($service_id){
        $sql = "SELECT * FROM int_setting WHERE service_id = $service_id";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function insert_services($service){
        $data = array(
            'service' => $service
        );
        $this->db->insert('service', $data);
    }

    public function update_services($id,$service){
        $data = array(
            'service' => $service
        );
        $this->db->where('service_id',$id);
        $this->db->update('service', $data);
    }

    public function insert_service_amount($service_id,$location_id,$amount){
        $data = array(
            'service_id' => $service_id,
            'location_id' => $location_id,
            'amount' => $amount
        );
        $this->db->insert('service_amount', $data);
    }

    public function get_service_amount_id($service_id,$location_id){
        $sql = "SELECT * FROM service_amount WHERE service_id = $service_id AND location_id = $location_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->id;
    }

    public function update_service_amount($service_id,$location_id,$amount){
        $id = $this->get_service_amount_id($service_id,$location_id);
        $data = array(
            'amount' => $amount,
        );
        $this->db->where('id',$id);
        $this->db->update('service_amount', $data);
    }

    public function get_amount($service_id,$location_id){
        $sql = "SELECT * FROM service_amount WHERE service_id = $service_id AND location_id = $location_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->amount;
    }

    public function service_name($service_id){
        $sql = "SELECT * FROM service WHERE service_id = $service_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->service;
    }
    

    public function deleteService($id){
        $sql = "DELETE FROM service WHERE service_id=$id";
        $query = $this->db->query($sql);
        $this->delete_location_service($id);
    }

    public function delete_location_service($id){
        $sql = "DELETE FROM service_amount WHERE service_id=$id";
        $query = $this->db->query($sql);
    }

    public function del_inv_setting($id){
        $this->db->where('id', $id);
        $this->db->delete('int_setting');
    }
}
?>