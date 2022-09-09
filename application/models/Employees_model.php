<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Employees_model extends CI_Model 
{
    public function employees()
    {
        $sql = "SELECT * FROM emp ORDER BY created DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }
    
    public function active_employee($id)
    {
        $sql = "UPDATE emp SET status=1 WHERE id='$id'";
        $query = $this->db->query($sql);
    }

    public function inactive_employee($id)
    {
        $sql = "UPDATE emp SET status=0 WHERE id='$id'";
        $query = $this->db->query($sql);
    }

    public function delete_employee($id){
        $sql = "DELETE FROM emp WHERE id='$id'";
        $query = $this->db->query($sql);
    }

    public function insert_employee($id,$name,$loc,$des,$salary){
        $data = array(
            'emp_id' => $id,
            'emp_name' => $name,
            'emp_loc' => $loc,
            'emp_des' => $des,
            'emp_salary' => $salary
        );
    
        $this->db->insert('emp', $data);
    }

    public function get_empolyee($id){
        $sql = "SELECT * FROM emp WHERE id = '$id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function update_employee($id,$name,$loc,$des,$salary){
        $data = array(
            'emp_loc' => $loc,
            'emp_name' => $name,
            'emp_des' => $des,
            'emp_salary' => $salary
        );
        
        $this->db->where('id', $id);
        $this->db->update('emp', $data);
    }

    public function location(){
        $sql = "SELECT * FROM location";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }
                        
}


/* End of file Employees_model.php and path /application/models/Employees_model.php */

