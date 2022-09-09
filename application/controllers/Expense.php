<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expense extends CI_Controller
{
    
  public function __construct()
  {
      parent::__construct();
      //Load Model
      $this->load->model('Dashboard_model');
      $data['username'] = $this->Dashboard_model->username();
      //Load Model
      $this->load->model('Orders_model');
      //Load Model
      $this->load->model('Expense_model');
      //Already logged In
      if (!$this->session->has_userdata('user_id')) {
          redirect('/LoginController/logout');
      }
  }

  public function AddExpenses(){
    $data['page_title'] = 'Add Expenses';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    //Load Model
    $this->load->model('Inventory_model');

    //Total Expenses for this month
    $data['total_expense'] = $this->Expense_model->total_expense(); //16

    //Item Catogiries
    $data['catogories'] = $this->Expense_model->exp_catogories();

    $data['location'] = $this->Orders_model->locations();

    $data['nav'] = "Expense";
    $data['subnav'] = "Add Expenses";

    $this->load->view('dashboard/layout/header',$data);
    $this->load->view('dashboard/layout/aside',$data);
    $this->load->view('expense/add-expense',$data);
    $this->load->view('expense/footer');
  }

  public function Summery(){
    $data['page_title'] = 'Expense Summery';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['expenses'] = $this->Expense_model->expense_summery();

    $data['nav'] = "Expense";
    $data['subnav'] = "Expenses";

    $this->load->view('dashboard/layout/header',$data);
    $this->load->view('dashboard/layout/aside',$data);
    $this->load->view('expense/expense-summery',$data);
    $this->load->view('expense/footer');
  }

  public function insert_expense(){

        $this->form_validation->set_rules('ex_date', 'Date', 'required');
        $this->form_validation->set_rules('ref_no', 'Ref_No', 'required|is_unique[expense.ref_no]');
        $this->form_validation->set_rules('name', 'Payee Name', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->AddExpenses();
        }
        else{

            $ex_date = $this->input->post('ex_date');
            $location = $this->input->post('location');
            $ref_no = $this->input->post('ref_no');
            $name = $this->input->post('name');
            $des = $this->input->post('des');
            $cat = $this->input->post('cat');
            $method = $this->input->post('method');
            $check_date = $this->input->post('check_date');
            $amount = $this->input->post('amount');

            if ($method == "credit") {
                $paid = 0;
            }
            else{
                $paid = 1;
            }
            
            $this->Orders_model->insert_expense($ex_date,$location,$ref_no,$name,$des,$cat,$method,$amount,$check_date,$paid);

            $this->session->set_flashdata('adexsuccess',"<div class='alert alert-success'>Expense Added Successfully!</div>");
            redirect('Expense/AddExpenses');
        }

    }

    public function delete(){
      $id =  $this->input->post('id');
      $this->Expense_model->delete_expense($id); //29
    }

    public function edit(){
      $expense_id =  $this->uri->segment('3');
      $data['page_title'] = 'Edit Expenses';
      $data['username'] = $this->Dashboard_model->username();
      $data['pending_count'] = $this->Dashboard_model->pending_count();
      $data['confirm_count'] = $this->Dashboard_model->confirm_count();

      //Load Model
      $this->load->model('Inventory_model');

      //Total Expenses for this month
      $data['total_expense'] = $this->Expense_model->total_expense(); //16

      //Expense data
      $data['expenses'] = $this->Expense_model->edit_expense($expense_id); //35

      //Item Catogiries
      $data['catogories'] = $this->Expense_model->exp_catogories();

      $data['location'] = $this->Orders_model->locations();

      $data['nav'] = "Expense";
    $data['subnav'] = "Expenses";

      $this->load->view('dashboard/layout/header',$data);
      $this->load->view('dashboard/layout/aside',$data);
      $this->load->view('expense/edit-expense',$data);
      $this->load->view('expense/footer',$data);
    }

    public function update(){

      $this->form_validation->set_rules('ex_date', 'Date', 'required');
      $this->form_validation->set_rules('name', 'Payee Name', 'required');
      $this->form_validation->set_rules('location', 'Location', 'required');
      $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');
      $this->form_validation->set_rules('cat', 'Catogery', 'required');

      if ($this->form_validation->run() == FALSE) {
        $expenseid = $this->input->post('expenseid');
        redirect('Expense/edit/'.$expenseid);
      }
      else{
          $expenseid = $this->input->post('expenseid');
          $ex_date = $this->input->post('ex_date');
          $location = $this->input->post('location');
          $ref_no = $this->input->post('ref_no');
          $name = $this->input->post('name');
          $des = $this->input->post('des');
          $cat = $this->input->post('cat');
          $method = $this->input->post('method');
          $check_date = $this->input->post('check_date');
          $amount = $this->input->post('amount');

          if ($method == "credit") {
              $paid = 0;
          }
          else{
              $paid = 1;
          }
          //51
          $this->Expense_model->update_expense($expenseid,$ex_date,$location,$ref_no,$name,$des,$cat,$method,$amount,$check_date,$paid);
          $this->session->set_flashdata('success',"<div class='alert alert-success'>Expense Updated Successfully!</div>");
          redirect('Expense/summery');
      }

  }

  public function view(){
    //Load Model
    $this->load->model('Inventory_model');
    $expense_id =  $this->uri->segment('3');
    $data['page_title'] = 'View';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    //Expense data
    $data['expenses'] = $this->Expense_model->edit_expense($expense_id); //35

    $data['nav'] = "Expense";
    $data['subnav'] = "Expenses";

    $this->load->view('dashboard/layout/header',$data);
    $this->load->view('dashboard/layout/aside',$data);
    $this->load->view('expense/view-expense',$data);
    $this->load->view('expense/footer',$data);
  }

}


/* End of file Expense.php */
/* Location: ./application/controllers/Expense.php */