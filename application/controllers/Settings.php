<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Settings extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        //Load Model
        $this->load->model('Dashboard_model');
        $data['username'] = $this->Dashboard_model->username();
        //Load Model
        $this->load->model('Setting_model');
        //Already logged In
        if (!$this->session->has_userdata('user_id')) {
            redirect('/LoginController/logout');
        }
    }

    public function BookingService(){
        $data['page_title'] = 'Booking Service';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['services'] = $this->Setting_model->services();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('settings/booking_services',$data);
        //$this->load->view('footer');
        $this->load->view('settings/footer');
    }

    public function Change(){
        $data['page_title'] = 'Change Password';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['services'] = $this->Setting_model->services();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Settings";
        $data['subnav'] = "Change Password";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('settings/change_pwd',$data);
        //$this->load->view('footer');
        $this->load->view('settings/footer');
    }


    public function delete_service(){
        $id =  $this->uri->segment('3');

        $this->Setting_model->delete('booking_service',$id);

        //Flash Msg
        $this->session->set_flashdata('msg',"<div class='alert alert-danger'>Service is deleted!</div>");
        
        // Redirect to Service
        redirect('Settings/BookingService');
    }

    public function add_service(){
        $service = $this->input->post('service');
        $this->Setting_model->insert_service($service);

        //Flash Msg
        $this->session->set_flashdata('msg',"<div class='alert alert-success'>Service is added!</div>");

        // Redirect to Service
        redirect('/Settings/BookingService');
    }

    public function ChangePassword(){

        $this->form_validation->set_rules('pwd', 'Current Password', 'required');
        $this->form_validation->set_rules('npwd', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('cpwd', 'Confirm Password', 'required|matches[npwd]');

        if ($this->form_validation->run() == FALSE){
            $this->Change();
        }
        else{
            $pwd = $this->input->post('pwd');
            $npwd = $this->input->post('npwd');
            $cpwd = $this->input->post('cpwd');
            $uname = $this->session->userdata('user_id');

            if ($this->Setting_model->pwdiscorrect($uname,$pwd) == TRUE) {
                $this->Setting_model->update_pwd($uname,$npwd);
                // Redirect to Login
                redirect('LoginController/logout');
            }
            else{
                $this->session->set_flashdata('msg', '<div style="font-size:13px;" class="alert alert-warning">Invalid Current Password</div>');
                $this->Change();
            }
        }
    }

    public function InventorySetting()
    {
            $data['page_title'] = 'Inventory Settings';
            $data['username'] = $this->Dashboard_model->username();

            $data['pending_count'] = $this->Dashboard_model->pending_count();
            $data['confirm_count'] = $this->Dashboard_model->confirm_count();

            $data['services'] = $this->Setting_model->services();            

            $data['nav'] = "Settings";
            $data['subnav'] = "Inventory Setting";

            $this->load->view('dashboard/layout/header',$data);
            $this->load->view('dashboard/layout/aside',$data);
            //$this->load->view('aside',$data);
            $this->load->view('settings/inventory_settings',$data);
            $this->load->view('settings/footer');
    }

    public function show_service_items()
    {
        $service_id = $this->input->post('service_id');
        $available = $this->Setting_model->items_available($service_id);

        if ($available > 0) {
            ?>
            <table class="table table-hover">
                <thead>
                    <th class="text-center">Item</th>
                    <th class="text-center">Quanity</th>
                    <th class="text-center" >Action</th>
                </thead>
                <tbody>
                    <?php 
                    $service_items = $this->Setting_model->service_items($service_id); 
                    foreach ($service_items as $sitms) {
                        ?>
                            <tr class="text-center" >
                                <td><?php echo $sitms->item_id; ?></td>
                                <td><?php echo $sitms->quantity; ?></td>
                                <td class="text-danger" id="del_item">
                                    <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>Settings/delete_inv_setting/<?php echo $sitms->id; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

            <script>
                $(document).ready(function(){
                    $("#service").change(function(){
                        var service_id = $(this).val();
                        $.ajax({
                        url:"<?php echo base_url(); ?>Settings/show_service_items", //52
                        type:"POST",
                        cache:false,
                        data:{service_id:service_id},
                        success:function(data){
                            //alert(data);
                            $("#service_items").html(data);
                        }
                        });
                    }); 
                });
            </script>

            <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#catogery">
                        <i class="fa fa-plus"></i> Add Item
                    </button>
            </div>

            <!-- Modal -->
            <div id="catogery" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Item</h4>
                </div>

                <form method="post" action="<?php echo base_url(); ?>Settings/insert_item">
                    <div class="modal-body">
                    <div>
                        <label>Select Item</label>
                    </div>
                    <div>
                        <select name="item_id" id="item_id" class="form-control">
                            <option value="">Select Item</option>
                            <?php
                                $items = $this->Setting_model->items();
                                foreach ($items as $itm) {
                                   echo "<option value='$itm->item_id'>$itm->item_id</option>";
                                }
                            ?>
                        </select> 
                    </div>
                    <input type="text" name="service_id" value="<?php echo $service_id; ?>" hidden> 
                    <div>
                        <label>Quantity</label>
                    </div>

                    <div>
                        <input type="text" name="qty" id="qty" class="form-control" placeholder="Quanity">
                    </div>
                    
                    </div>
                    <div class="modal-footer">
                    <input type="submit" name="save_catogery" value="Save" class="btn btn-success">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
                </div>

            </div>
            </div>
            <!-- Catogery Modal -->
            <?php
        }
        else{
            ?>
            <div class="row">
                <div class="col-md-6">
                    No Items available for this Service
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#catogery">
                        <i class="fa fa-plus"></i> Add Item
                    </button>
                </div>
            </div>
            
            <div id="item_form" style="display:none;">
                <h4>Select Item for Service</h4>
                <div class="row">
                    <div class="col-sm-4">
                        <select name="item_id" id="item_id" class="form-control">
                            <option value="">Select Item</option>
                            <?php
                                $items = $this->Setting_model->items();
                                foreach ($items as $itm) {
                                   echo "<option value='$itm->item_id'>$itm->item_id</option>";
                                }
                            ?>
                        </select>
                    </div>
                                  
                    <div class="col-sm-4">
                        <input type="text" name="qty" id="qty" class="form-control" placeholder="Quanity">
                    </div>

                    <div class="col-sm-4">
                        <a class="btn btn-success" id="submit"><i class="fa fa-plus"></i> Add</a>
                    </div>

                </div>
            </div>



            <!-- Modal -->
            <div id="catogery" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Item</h4>
                </div>

                <form method="post" action="<?php echo base_url(); ?>Settings/insert_item">
                    <div class="modal-body">
                    <div>
                        <label>Select Item</label>
                    </div>
                    <div>
                        <select name="item_id" id="item_id" class="form-control">
                            <option value="">Select Item</option>
                            <?php
                                $items = $this->Setting_model->items();
                                foreach ($items as $itm) {
                                   echo "<option value='$itm->item_id'>$itm->item_id</option>";
                                }
                            ?>
                        </select> 
                    </div>
                    <input type="text" name="service_id" value="<?php echo $service_id; ?>" hidden> 
                    <div>
                        <label>Quantity</label>
                    </div>

                    <div>
                        <input type="text" name="qty" id="qty" class="form-control" placeholder="Quanity">
                    </div>
                    
                    </div>
                    <div class="modal-footer">
                    <input type="submit" name="save_catogery" value="Save" class="btn btn-success">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
                </div>

            </div>
            </div>
            <!-- Catogery Modal -->

            <script>
                function show_form(){
                    $("#item_form").show();
                }
            </script>
            <?php
        }
    }

    public function insert_item(){
        $item_id = $this->input->post('item_id');
        $service_id = $this->input->post('service_id');
        $quantity = $this->input->post('qty');

        $this->Setting_model->insert_items($service_id,$item_id,$quantity);

        redirect('Settings/InventorySetting');
    }

    public function AddService(){
            $data['page_title'] = 'Add Service';
            $data['username'] = $this->Dashboard_model->username();

            $data['pending_count'] = $this->Dashboard_model->pending_count();
            $data['confirm_count'] = $this->Dashboard_model->confirm_count();

            $data['services'] = $this->Setting_model->services();
            $data['locations'] = $this->Setting_model->locations();            

            $data['nav'] = "Settings";
            $data['subnav'] = "Add Service";

            $this->load->view('dashboard/layout/header',$data);
            $this->load->view('dashboard/layout/aside',$data);
            //$this->load->view('aside',$data);
            $this->load->view('settings/add-service',$data);
            $this->load->view('settings/footer');
    }

    public function insert_service(){

        $this->form_validation->set_rules('service', 'Service', 'required|is_unique[service.service]');

        if ($this->form_validation->run() == FALSE){
            $this->AddService();
        }
        else{
            $service = $this->input->post('service');
            $this->Setting_model->insert_services($service);
            $locations = $this->Setting_model->locations();
            
            foreach ($locations as $loc) {
                $location_id = $loc->id;
                $service_id = $this->Setting_model->last_service_id();
                $location_amount = "location".$location_id;
                $amount = $_POST[$location_amount];
                $this->Setting_model->insert_service_amount($service_id,$location_id,$amount);
            }
            $this->session->set_flashdata('msg', '<div style="font-size:13px;" class="alert alert-success">Added Successfully</div>');
            redirect('Settings/AddService');
        }
    }

    public function update_service(){
        $service_id = $this->input->post('service_id');
        $service = $this->input->post('service');
        $this->Setting_model->update_services($service_id,$service);
        $locations = $this->Setting_model->locations();
        
        foreach ($locations as $loc) {
            $location_id = $loc->id;
            $service_id = $this->input->post('service_id');
            $location_amount = "location".$location_id;
            $amount = $_POST[$location_amount]; 
            echo $this->Setting_model->update_service_amount($service_id,$location_id,$amount);
        }
        
        $this->session->set_flashdata('msg', '<div style="font-size:13px;" class="alert alert-success">Added Successfully</div>');
        redirect('Settings/AddService');
    }

    public function edit_service(){
            $data['page_title'] = 'Edit Service';
            $data['username'] = $this->Dashboard_model->username();

            $data['pending_count'] = $this->Dashboard_model->pending_count();
            $data['confirm_count'] = $this->Dashboard_model->confirm_count();

            $data['services'] = $this->Setting_model->services();
            $data['locations'] = $this->Setting_model->locations();
            $data['service_id'] =  $this->uri->segment('3');         

            $data['nav'] = "Settings";
            $data['subnav'] = "Add Service";

            $this->load->view('dashboard/layout/header',$data);
            $this->load->view('dashboard/layout/aside',$data);
            //$this->load->view('aside',$data);
            $this->load->view('settings/edit-service',$data);
            $this->load->view('settings/footer');
    }

    public function deleteService(){
        $id =  $this->uri->segment('3');
        
        $this->Setting_model->deleteService($id);
        $this->session->set_flashdata('msg', '<div style="font-size:13px;" class="alert alert-danger">Service Deleted</div>');
        redirect('Settings/AddService');
    }

    // Delete inventory setting Item
    public function delete_inv_setting(){
        $inv_setting_id =  $this->uri->segment('3');
        $this->Setting_model->del_inv_setting($inv_setting_id);
        redirect('Settings/InventorySetting');
    }
}
?>