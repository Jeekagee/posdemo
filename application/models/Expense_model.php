<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Expense_model extends CI_Model 
{
    public function expense_summery()
    {
        $sql = "SELECT * FROM expense";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }
    
    public function total_expense()
    {
        $sql = "SELECT *
        FROM expense
        WHERE MONTH(ex_date) = MONTH(CURRENT_DATE())
        AND YEAR(ex_date) = YEAR(CURRENT_DATE())";

        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function delete_expense($id)
    {
        $sql = "DELETE FROM expense WHERE id=$id";
        $query = $this->db->query($sql);
    }

    public function edit_expense($id)
    {
        $sql = "SELECT * FROM expense WHERE id=$id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    //All item Catogiries
    public function exp_catogories(){
        $sql = "SELECT * FROM exp_category ORDER BY category ASC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function sub_catogery($catogery){
        $sql = "SELECT * FROM int_sub_catogery WHERE catogery = $catogery";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }
    public function exp_catogery($cat_id){
        $sql = "SELECT * FROM exp_category WHERE id = $cat_id";
        $query = $this->db->query($sql);
        $result = $query->first_row();

        return $result;
    }

    public function update_expense($expenseid,$ex_date,$location,$ref_no,$name,$des,$cat,$method,$amount,$check_date,$paid){
        $logged = $this->session->user_id;
        $data = array(
            'ex_date' => $ex_date,
            'location' => $location,
            'ref_no' => $ref_no,
            'payee_name' => $name,
            'description' => $des,
            'catogery' => $cat,
            'method' => $method,
            'amount' => $amount,
            'entered' => $logged,
            'check_date' => $check_date,
            'paid' => $paid
        );

        $this->db->where('id', $expenseid);
        $this->db->update('expense', $data);
    }
                        
}


/* End of file Expense_model.php and path /application/models/Expense_model.php */

