<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class LoginController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        //Already logged In
        if ($this->session->has_userdata('user_id')) {
            // Redirect to Dashboard
            redirect('/Dashboard');
            //echo "ÿes";
            //echo $this->session->has_userdata('user_id');
        }
        else{
            //echo $this->session->has_userdata('user_id');
            $this->load->view('login');
        }
        
    }

    public function validation()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE){
            $this->load->view('login');
        }
        else{
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $this->load->model('LoginModel');

            if ($this->LoginModel->is_login($username, $password)) {

                $user_level = $this->LoginModel->user_level($username, $password);
                $user_id = $this->LoginModel->user_id($username, $password);
                $user_location = $this->LoginModel->user_location($username, $password);

                $logged_data = array(
                    'user_id'  => $user_id,
                    'user_level'     => $user_level,
                    'user_location'     => $user_location
                );
            
                $this->session->set_userdata($logged_data);

                //Create Login_log
                $this->LoginModel->insert_log($user_id,$username);
                // Redirect to Dashboard
                redirect('/Dashboard');
            }
            else{
                $this->session->set_flashdata('error', '<div style="font-size:13px;" class="alert alert-warning">Invalid Username or Password</div>');
                $this->load->view('login');
            }
        }
    }

    public function logout(){
        $this->load->model('LoginModel');
        $this->LoginModel->update_log();

        $destroy_items = array('user_id', 'user_level');
        $this->session->unset_userdata($destroy_items);

        // Redirect to Login
        redirect('/');
    }
    
}
        
    /* End of file  LoginController.php */
        
                            