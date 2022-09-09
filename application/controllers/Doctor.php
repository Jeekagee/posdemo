<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Doctor extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    //Load Model
    $this->load->model('Dashboard_model');
    $data['username'] = $this->Dashboard_model->username();
    //Load Model
    $this->load->model('Doctor_model');
    //Load Model
    $this->load->model('Booking_model');
    //Load Model
    $this->load->model('Appoint_model');
    //Already logged In
    if (!$this->session->has_userdata('user_id')) {
        redirect('/LoginController/logout');
    }
  }

  // Add Doctor Form
  public function Add()
  {
        $data['page_title'] = 'Add Doctor';
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['pendings'] = $this->Booking_model->pending();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        //Show Spelizations
        $data['specials'] = $this->Appoint_model->specials(); //28

        
        $data['nav'] = "Doctor";
        $data['subnav'] = "Add Doctor";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('Doctor/add',$data);
        $this->load->view('Doctor/footer');
  }

  public function insert(){
    $this->form_validation->set_rules('d_name', 'Doctor Name', 'required');
    $this->form_validation->set_rules('d_mobile', 'Mobile Number', 'required');
    $this->form_validation->set_rules('d_special', 'Specilization', 'required');
    $this->form_validation->set_rules('d_charge', 'Doctor Fees', 'required|numeric');

    if ($this->form_validation->run() == FALSE) {
        $this->Add();
    }
    else{
        // Form Values
        $d_name = $this->input->post('d_name');
        $d_mobile = $this->input->post('d_mobile');
        $d_special = $this->input->post('d_special');
        $d_charge = $this->input->post('d_charge');
        $d_commision = $this->input->post('d_commision');
        $com_type = $this->input->post('com_type');

        if ($d_commision == "") {
          $com_type = NULL;
          $d_commision = NULL;
        }
        else{
          $com_type = $this->input->post('com_type');
        }

        // Insert Doctor Details into DB
        $this->Doctor_model->insert_doctor($d_name,$d_mobile,$d_special,$d_charge,$d_commision,$com_type);
        $this->session->set_flashdata('docmsg',"<div class='alert alert-success'>Doctor Added Successfully!</div>");
        redirect('Doctor/Add');
    }
  }

  public function View()
  {
        $data['page_title'] = 'Doctor';
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['pendings'] = $this->Booking_model->pending();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        //Show Spelizations
        $data['specials'] = $this->Appoint_model->specials(); //28

        //Show Doctors
        $data['doctors'] = $this->Doctor_model->doctors(); //28

        
        $data['nav'] = "Doctor";
        $data['subnav'] = "Doctor";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('Doctor/view',$data);
        $this->load->view('Doctor/footer');
  }

}


/* End of file Doctor.php */
/* Location: ./application/controllers/Doctor.php */