<?php 
        //fdf
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Customers extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Load Model
        $this->load->model('Dashboard_model');
        $data['username'] = $this->Dashboard_model->username();
        //Load Model
        $this->load->model('Customers_model');
        //Already logged In
        if (!$this->session->has_userdata('user_id')) {
            redirect('/LoginController/logout');
        }
    }
    public function index()
    {
        $data['page_title'] = 'Customers';
        $data['nav'] = 'Customer';
        $data['username'] = $this->Dashboard_model->username();
        $data['customers'] = $this->Customers_model->customers();
        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Customer";
        $data['subnav'] = "Customers";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('customers/customers',$data);
        $this->load->view('customers/footer');
    }
    public function Add()
    {
        $data['page_title'] = 'Add Customers';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();
        $data['location'] = $this->Employees_model->location(); //64

        $data['nav'] = "Employees";
        $data['subnav'] = "Add Employee";
        
        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('employees/add-employee',$data);
        //$this->load->view('footer');
        $this->load->view('employees/footer');
    }
    public function delete(){
        $vehicle_id =  $this->input->post('id');
        $vehicle_no =  $this->input->post('v_no');
        $this->Customers_model->delete($vehicle_id);
        echo "<div class='alert alert-danger'>Vehicle No-".$vehicle_no." is deleted!</div>";
    }

    public function delete_msg(){
        $msg_id =  $this->uri->segment('3');
        $this->Customers_model->delete_msg($msg_id);
        
        redirect('/Customers/Add_msg');
    }

    public function insert_msg(){
        $msg = $this->input->post('msg');

        $this->Customers_model->insert_msg($msg);
        
        redirect('/Customers/Add_msg');
    }

    public function Message()
    {
        $data['page_title'] = 'Message';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['customers'] = $this->Customers_model->customers();
        // Default Msg List
        $data['default_msg'] = $this->Customers_model->default_msg();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Customer";
        $data['subnav'] = "Message";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('customers/message',$data);
        $this->load->view('customers/footer');
    }

    public function Send_msg(){

        //$this->form_validation->set_rules('check', 'Numbers', 'required');
        $this->form_validation->set_rules('msg', 'Message', 'required');
        
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('sent_msg',"<div class='alert alert-danger'>Please Select a Number & Type Something</div>");
            // Redirect to Message
            redirect('Customers/Message');
        }
        else{

            $mobile = $this->input->post('check');
            $msg = $this->input->post('msg');

            // Number Seperate by Comma!
            $check_msg = implode(",", $mobile);
            echo $numbers = $check_msg;

                function get_web_page( $url )
                {
                $options = array(
                CURLOPT_RETURNTRANSFER => true, // return web page
                CURLOPT_HEADER => false, // don't return headers
                );
                
                $ch = curl_init( $url );
                curl_setopt_array( $ch, $options );
                $content = curl_exec( $ch );
                $header = curl_getinfo( $ch );
                curl_close( $ch );
                
                return $content;
                }
               
              $user = "94770280956";
              $password = "1624";
              $text = urlencode($msg);
              $to = $numbers;
               
              $baseurl ="http://www.textit.biz/sendmsg";
              $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
              $ret = get_web_page($url);
              $res= explode(":",$ret);

            if (trim($res[0])=="OK")
            {
                //Update Chat History
                $this->Customers_model->insert_chat_history($numbers,$msg);

                $this->session->set_flashdata('sent_msg',"<div class='alert alert-success'>Message has been sent Succesfully!</div>");
                // Redirect to Message
                redirect('Customers/Message');
            }
            else
            {
                $this->session->set_flashdata('sent_msg',"<div class='alert alert-warning'>Something Went Wrong</div>");
                // Redirect to Message
                redirect('Customers/Message');
            }
        }
    }

    public function Add_msg(){
        $data['page_title'] = 'Add Message';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();

        // Default Msg List
        $data['default_msg'] = $this->Customers_model->default_msg();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Customer";
        $data['subnav'] = "Message";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('customers/add_msg',$data);
        $this->load->view('customers/footer');
    }

    public function block(){
        $vehicle_id =  $this->uri->segment('3');
        $vehicle_no =  strval($this->uri->segment('4'));

        $this->Customers_model->block($vehicle_id); //53
        $this->session->set_flashdata('delete',"<div class='alert alert-warning'>Vehicle No-".$vehicle_no." is added to black list!</div>");
        // Redirect to Orders
        redirect('/Customers');
    }

    public function Blacklist()
    {
        $data['page_title'] = 'BlackList';
        $data['username'] = $this->Dashboard_model->username();
        $data['customers'] = $this->Customers_model->blacklist(); //62
        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Customer";
        $data['subnav'] = "Message";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('customers/blacklist',$data);
        $this->load->view('customers/footer');
    }

    public function Active(){
        $vehicle_id =  $this->input->post('id');
        $vehicle_no =  $this->input->post('v_no');
        $this->Customers_model->active_customer($vehicle_id); //71
        echo "<div class='alert alert-success'>Vehicle No-".$vehicle_no." is Activated!</div>";
    }
}

/* End of file DashboardController.php and path /application/controllers/DashboardController.php */


