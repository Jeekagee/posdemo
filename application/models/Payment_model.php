<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Payment_model extends CI_Model 
{
    public function employee($id){
        
        $sql = "SELECT * FROM emp WHERE id = $id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
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

    public function insert_payments($id,$payfor,$amount,$type){
        $data = array(
            'emp_id' => $id,
            'type' => $type,
            'amount' => $amount,
            'payfor' => $payfor
        );
        $this->db->insert('payments', $data);
    }
}
?>