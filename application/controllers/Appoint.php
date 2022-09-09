<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Appoint extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Load Model
        $this->load->model('Dashboard_model');
        $data['username'] = $this->Dashboard_model->username();
        //Do
        
        //Load Model
        $this->load->model('Booking_model');
        $this->load->model('Appoint_model');
        $this->load->model('Setting_model');
        //Already logged In
        if (!$this->session->has_userdata('user_id')) {
            redirect('/LoginController/logout');
        }
    }

    public function addnew(){
        $data['page_title'] = 'Appoinment';
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['pendings'] = $this->Booking_model->pending();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['locations'] = $this->Setting_model->locations();

        //Show Spelizations
        $data['specials'] = $this->Appoint_model->specials(); //28

        //Invoice No
        $data['invoice_no'] = $this->Appoint_model->invoice_no(); //
        
        $data['nav'] = "Appointment";
        $data['subnav'] = "New Appoinment";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('App/addnew',$data);
        $this->load->view('App/footer');
    }

    public function insert(){
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('nic', 'NIC Number', 'required');
        $this->form_validation->set_rules('pname', 'Patient Name', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required');
        $this->form_validation->set_rules('area', 'Area', 'required');
        $this->form_validation->set_rules('doctor', 'Doctor', 'required');
        $this->form_validation->set_rules('dcharge', 'Doctor Charge', 'required');
        $this->form_validation->set_rules('app_date', 'Date', 'required');
        $this->form_validation->set_rules('tym', 'Time', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->addnew();
        }
        else{
            $id = $this->input->post('invoice_no');
            $nic = $this->input->post('nic');
            $pname = $this->input->post('pname');
            $mobile = $this->input->post('mobile');
            $address = $this->input->post('address');
            $area = $this->input->post('area');
            $doctor = $this->input->post('doctor');
            $dcharge = $this->input->post('dcharge');
            $app_date = $this->input->post('app_date');
            $tym = $this->input->post('tym');
            $comment = $this->input->post('comment');
            $location = $this->input->post('location');

            $this->Appoint_model->insert_appoint($id,$nic,$pname,$mobile,$address,$area,$doctor,$dcharge,$app_date,$tym,$comment,$location);
            
            if ($this->Appoint_model->patient_available($nic) > 0) {
                $this->Appoint_model->update_patient($nic,$pname,$mobile,$address);
            }
            else{
                $this->Appoint_model->insert_patient($nic,$pname,$mobile,$address);
            }
            redirect('Appoint/appointments');
        }
    }

    public function appointments(){
        $data['page_title'] = 'Appoinment';
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['pendings'] = $this->Booking_model->pending();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['apps'] = $this->Appoint_model->appoints();
        
        $data['nav'] = "Appointment";
        $data['subnav'] = "Appoinments";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('App/appoints',$data);
        $this->load->view('App/footer');
    }

    public function doctors(){
        $area = $this->input->post('area');
        $doctors = $this->Appoint_model->doctors($area); //36

        echo "<option value=''>Select Doctor</option>";
        foreach ($doctors as $doctor) {
            echo "<option value='$doctor->id'>$doctor->name</option>";
        }
    }

    public function doctors_charge(){
        $doctor = $this->input->post('doctor');
        $charge = $this->Appoint_model->doctors_charge($doctor); //44
        echo $charge;
    }

    public function Add_other(){
        $other = $this->input->post('other');
        $amount = $this->input->post('amount');
        $invoice_no = $this->input->post('invoice_no');

        $this->Appoint_model->insert_other($other,$amount,$invoice_no);

        $o_charges = $this->Appoint_model->other_charges($invoice_no);

        ?>
        <table class="table table-striped">
            <thead>
                <th>Description</th>
                <th class="text-right">Amount</th>
                <th class="text-center">Action</th>
            </thead>
            <tbody>
                <?php
                $i = 1;
                    foreach ($o_charges as $o_char) {
                ?>
                    <tr id="row<?php echo $o_char->id; ?>">
                        <td><?php echo $o_char->description; ?></td>
                        <td class="text-right"><?php echo $o_char->charge; ?>.00</td>
                        <td class="text-center">
                            <a class="btn btn-danger delete_service" id="<?php echo $o_char->id; ?>"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php
                $i++;
                }
                ?>
            </tbody>
        </table>
        <?php

    }

    public function view_other(){
        $invoice_no = $this->input->post('invoice_no');
        $o_charges = $this->Appoint_model->other_charges($invoice_no);

        ?>
        <table class="table table-striped">
            <thead>
                <th>Description</th>
                <th class="text-right">Amount</th>
                <th class="text-center">Action</th>
            </thead>
            <tbody>
                <?php
                $i = 1;
                    foreach ($o_charges as $o_char) {
                ?>
                    <tr id="row<?php echo $o_char->id; ?>">
                        <td><?php echo $o_char->description; ?></td>
                        <td class="text-right"><?php echo $o_char->charge; ?>.00</td>
                        <td class="text-center">
                            <a class="btn btn-danger delete_service" id="<?php echo $o_char->id; ?>"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php
                $i++;
                }
                ?>
            </tbody>
        </table>
        <?php

    }

    public function nic_search(){
        if ($this->input->post('nic')) {
            
            $output = "";
            $nic = $this->input->post('nic');
            $result = $this->Appoint_model->nic_list($nic);
            $output = '<ul class="list-unstyled">';	
            foreach ($result as $row)
            {
                    $output .= '<li class="li-style">'.$row->nic.'</li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    public function patient_name(){
        $nic = $this->input->post('nic');
        echo $this->Appoint_model->patient_name($nic);
    }

    public function patient_mobile(){
        $nic = $this->input->post('nic');
        echo $this->Appoint_model->patient_mobile($nic);
    }

    public function patient_address(){
        $nic = $this->input->post('nic');
        echo $this->Appoint_model->patient_address($nic);
    }

    public function view(){
        $data['page_title'] = 'View Appoinment';
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['pendings'] = $this->Booking_model->pending();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['locations'] = $this->Setting_model->locations();
        //Show Spelizations
        $data['specials'] = $this->Appoint_model->specials(); //28

        //Invoice No
        $data['invoice_no'] = $this->Appoint_model->invoice_no(); //
        
        $data['nav'] = "Appointment";
        $data['subnav'] = "Appointment";

        if ($this->uri->segment('3')) {
            $id =  $this->uri->segment('3');
            $data['apps'] = $this->Appoint_model->view($id);
        }

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('App/view',$data);
        $this->load->view('App/footer');
    }

    public function update(){
        $this->form_validation->set_rules('nic', 'NIC Number', 'required');
        $this->form_validation->set_rules('pname', 'Patient Name', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required');
        $this->form_validation->set_rules('area', 'Area', 'required');
        $this->form_validation->set_rules('doctor', 'Doctor', 'required');
        $this->form_validation->set_rules('dcharge', 'Doctor Charge', 'required');
        $this->form_validation->set_rules('app_date', 'Date', 'required');
        $this->form_validation->set_rules('tym', 'Time', 'required');


        if ($this->form_validation->run() == FALSE) {
            
        }
        else{
            $id = $this->input->post('invoice_no');
            $nic = $this->input->post('nic');
            $pname = $this->input->post('pname');
            $mobile = $this->input->post('mobile');
            $address = $this->input->post('address');
            $area = $this->input->post('area');
            $doctor = $this->input->post('doctor');
            $dcharge = $this->input->post('dcharge');
            $app_date = $this->input->post('app_date');
            $tym = $this->input->post('tym');
            $comment = $this->input->post('comment');

            $this->Appoint_model->update_appoint($id,$nic,$pname,$mobile,$address,$area,$doctor,$dcharge,$app_date,$tym,$comment);
            
            if ($this->Appoint_model->patient_available($nic) > 0) {
                $this->Appoint_model->update_patient($nic,$pname,$mobile,$address);
            }
            else{
                $this->Appoint_model->insert_patient($nic,$pname,$mobile,$address);
            }
            redirect('Appoint/appointments');
        }
    }
    // Add new Specilization
    public function add_area(){
        $area = $this->input->post('area');
        $this->Appoint_model->insert_area($area);//191


        if ($this->uri->segment('3')) {
            redirect('Doctor/Add');
        }
        redirect('Appoint/addnew');
    }

}

/* End of file Employees.php and path /application/controllers/Employees.php */


