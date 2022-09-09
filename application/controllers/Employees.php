<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Employees extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Load Model
        $this->load->model('Dashboard_model');
        $data['username'] = $this->Dashboard_model->username();
        //Load Model
        $this->load->model('Employees_model');
        //Already logged In
        if (!$this->session->has_userdata('user_id')) {
            redirect('/LoginController/logout');
        }
    }
    public function index()
    {
        $data['page_title'] = 'Employees';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['employees'] = $this->Employees_model->employees();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Employees";
        $data['subnav'] = "Employees";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('employees/employees',$data);
        //$this->load->view('footer');
        $this->load->view('customers/footer');
    }

    public function Add()
    {
        $data['page_title'] = 'Add Employees';
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

    public function insert(){
        $this->form_validation->set_rules('emp_id', 'Employee ID', 'required|is_unique[emp.emp_id]');
        $this->form_validation->set_rules('emp_name', 'Employee Name', 'required');
        $this->form_validation->set_rules('emp_loc', 'Employee Location', 'required');
        $this->form_validation->set_rules('emp_des', 'Employee Desgination', 'required');
        $this->form_validation->set_rules('salary', 'Employee Salary', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE){
            $this->Add();
        }
        else{
            $id = $this->input->post('emp_id');
            $name = $this->input->post('emp_name');
            $loc = $this->input->post('emp_loc');
            $des = $this->input->post('emp_des');
            $salary = $this->input->post('salary');

            $this->Employees_model->insert_employee($id,$name,$loc,$des,$salary);

            //Flash Msg
            $this->session->set_flashdata('delete',"<div class='alert alert-success'> New Employee has been assigned!</div>");
            
            // Redirect to Employees
            redirect('/Employees');
        }
    }

    public function inactive(){
        $id =  $this->uri->segment('3');
        $this->Employees_model->inactive_employee($id);
        // Redirect to Employees
        redirect('/Employees');
    }

    public function active(){
        $id =  $this->uri->segment('3');
        $this->Employees_model->active_employee($id);
        // Redirect to Employees
        redirect('/Employees');
    }

    public function delete(){
        $id =  $this->uri->segment('3');
        $emp_name =  $this->uri->segment('4');
        $this->Employees_model->delete_employee($id);

        //Flash Msg
        $this->session->set_flashdata('delete',"<div class='alert alert-warning'>".$emp_name." is deleted!</div>");
        
        // Redirect to Employees
        redirect('/Employees');
    }

    public function edit(){
        $id =  $this->uri->segment('3');

        $data['page_title'] = 'Edit Empolyee';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['employee'] = $this->Employees_model->get_empolyee($id); //44
        $data['location'] = $this->Employees_model->location(); //64

        $data['nav'] = "Employees";
        $data['subnav'] = "Employees";
        
        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('employees/edit-employee',$data);
        //$this->load->view('footer');
        $this->load->view('employees/footer');

    }

    public function update(){
        $id =  $this->input->post('id');

        $this->form_validation->set_rules('emp_name', 'Employee Name', 'required');
        $this->form_validation->set_rules('emp_des', 'Employee Desgination', 'required');
        $this->form_validation->set_rules('emp_loc', 'Employee Location', 'required');
        $this->form_validation->set_rules('salary', 'Employee Salary', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE){
            //Flash Msg
            $this->session->set_flashdata('delete',"<div class='alert alert-warning'>Please fill required!</div>");
            // Redirect to Employees
            redirect('Employees/edit/'.$id);
        }
        else{
            $name = $this->input->post('emp_name');
            $loc = $this->input->post('emp_loc');
            $des = $this->input->post('emp_des');
            $salary = $this->input->post('salary');

            $this->Employees_model->update_employee($id,$name,$loc,$des,$salary);//53

            //Flash Msg
            $this->session->set_flashdata('delete',"<div class='alert alert-success'> Employee has been updated!</div>");
            
            // Redirect to Employees
            redirect('/Employees');
        }
    }
}

/* End of file Employees.php and path /application/controllers/Employees.php */


