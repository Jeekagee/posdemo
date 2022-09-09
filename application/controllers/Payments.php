<?php      
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Payments extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Load Model
        $this->load->model('Dashboard_model');
        $data['username'] = $this->Dashboard_model->username();
        //Load Model
        $this->load->model('Employees_model');
        $this->load->model('Payment_model');
        //Already logged In
        if (!$this->session->has_userdata('user_id')) {
            redirect('/LoginController/logout');
        }
    }

    public function Summery(){
        $data['page_title'] = 'Summery';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();
        // Employee List
        $data['employees'] = $this->Employees_model->employees();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Payments";
        $data['subnav'] = "Summery";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('payments/summery',$data);
        //$this->load->view('footer');
        $this->load->view('payments/footer');
    }

    public function Pay(){
        $data['page_title'] = 'Pay Salary';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();
        // Employee List
        $data['employees'] = $this->Employees_model->employees();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $emp_id =  $this->uri->segment('3');

        // Employee List
        $data['emp'] = $this->Payment_model->employee($emp_id);

        $data['nav'] = "Payments";
        $data['subnav'] = "Summery";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('payments/paytoemp',$data);
        //$this->load->view('footer');
        $this->load->view('payments/footer');
    }

    public function MakePayment(){
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');
        $this->form_validation->set_rules('pay_month', 'Pay month', 'required');

        if ($this->form_validation->run() == FALSE){
            $this->Pay();
        }
        else{
            $id = $this->input->post('id');
            $pay_month = $this->input->post('pay_month');
            $amount = $this->input->post('amount');
            $type = $this->input->post('payment_type');

            $this->Payment_model->insert_payments($id,$pay_month,$amount,$type);

            // Redirect to Summery
            redirect('/Payments/Summery');
        }
    }
}
?>