<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class LoginModel extends CI_Model 
{
    public function is_login($username,$password)
    {
        $epassword = md5($password);
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $query = $this->db->query($sql);

        if ($query->num_rows()  == 1) {
            return true;
        }
        else{
            return false;
        }
    }
    
    // Logged User Level
    public function user_level($username,$password){
        $epassword = md5($password);
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $query = $this->db->query($sql);
        $row = $query->row();

        return $row->user_level;

    }

    // Logged User ID
    public function user_id($username,$password){
        $epassword = md5($password);
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $query = $this->db->query($sql);
        $row = $query->row();

        return $row->user_id;

    }

    // Logged User Location
    public function user_location($username,$password){
        $epassword = md5($password);
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $query = $this->db->query($sql);
        $row = $query->row();

        return $row->location_id;

    }

    public function insert_log($id,$name){
        $data = array(
            'user_id' => $id,
            'username' => $name
        );
    
        $this->db->insert('login_log', $data);
    }
    
    public function last_log_id(){
        $sql = "SELECT * FROM login_log ORDER BY login_at DESC LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function update_log(){

        $sql = "SELECT * FROM login_log ORDER BY login_at DESC LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        $id = $row->id;
        
        $data = array(
            'status' => 0
        );
        
        $this->db->where('id', $id);
        $this->db->update('login_log', $data);
    }
                        
}
                        
/* End of file LoginModel.php */
    
                        