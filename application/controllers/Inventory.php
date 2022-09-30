<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Inventory extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Load Model
        $this->load->model('Dashboard_model');
        $data['username'] = $this->Dashboard_model->username();
        //Load Model
        $this->load->model('Inventory_model');
        //Already logged In
        if (!$this->session->has_userdata('user_id')) {
            redirect('/LoginController/logout');
        }
    }
    public function Items()
    {
        if ($this->uri->segment('3')) {
            $cat_id =  $this->uri->segment('3');
            $data['item_catogery'] = $this->Inventory_model->item_catogery($cat_id);
        }
        else{
            $cat_id =  0;
            $data['item_catogery'] = "";
        }

        $data['page_title'] = 'Items';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();
        // itme List
        $data['items'] = $this->Inventory_model->show_items($cat_id);
        //Item Catogiries
        $data['catogories'] = $this->Inventory_model->item_catogories();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Inventory";
        $data['subnav'] = "Show Items";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('inventory/show-item',$data);
        //$this->load->view('footer');
        $this->load->view('inventory/footer');
    }

    public function Add()
    {
        
        $data['page_title'] = 'Add Item';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();
        //Item Catogiries
        $data['catogories'] = $this->Inventory_model->item_catogories();
        $data['brands'] = $this->Inventory_model->show_brand();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Inventory";
        $data['subnav'] = "Add Item";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('inventory/add-item',$data);
        //$this->load->view('footer');
        $this->load->view('inventory/footer');
    }

    public function edit(){
        $item_id =  $this->uri->segment('3');
        if ($this->uri->segment('3')) {
            $cat_id =  $this->uri->segment('3');
            $data['item_catogery'] = $this->Inventory_model->item_catogery($cat_id);
        }
        else{
            $cat_id =  0;
            $data['item_catogery'] = "";
        }

        $data['page_title'] = 'Edit Inventory';
        $data['username'] = $this->Dashboard_model->username();
        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();
  
        //Load Model
        $this->load->model('Inventory_model');

        //Inventory data
        $data['items'] = $this->Inventory_model->edit_inventory($item_id); 
        $data['catogories'] = $this->Inventory_model->item_catogories();
        $data['brands'] = $this->Inventory_model->show_brand();
  
        $data['nav'] = "Inventory";
        $data['subnav'] = "Edit Items";
  
        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('inventory/edit-items',$data);
        $this->load->view('expense/footer',$data);
      }

      public function update(){

        $this->form_validation->set_rules('item_catogery', 'Item category', 'required');
  
        if ($this->form_validation->run() == FALSE) {
          $item_id = $this->input->post('item_id');
          redirect('Inventory/edit/'.$item_id);
        }
        else{
            $item_id = $this->input->post('item_id');
            $barcode = $this->input->post('barcode');
            $name = $this->input->post('item_name');
            $cat = $this->input->post('item_catogery');
            $subcat = $this->input->post('item_sub_catogery');
            $filter_range = $this->input->post('filter_range');
            $capacity = $this->input->post('capacity');
            $part_number = $this->input->post('part_number');
            $brand = $this->input->post('item_brand');
  
            $this->Inventory_model->update_inventory($barcode,$item_id,$name,$cat,$subcat,$filter_range,$capacity,$part_number,$brand);
            $this->session->set_flashdata('success',"<div class='alert alert-success'>Expense Updated Successfully!</div>");
            redirect('Inventory/Items');
        }
  
    }

    public function show_sub_cat(){
        $catogery = $this->input->post('catogery');
        $sub_cats = $this->Inventory_model->show_sub_cat($catogery);

        foreach($sub_cats as $sub_cat){
           echo "<option value='$sub_cat->sub_cat_id'>$sub_cat->sub_catogery</option>";
        }
    }

    public function show_brands(){
        $catogery = $this->input->post('catogery');
        $brands = $this->Inventory_model->show_brand($catogery);

        foreach($brands as $brand){
           echo "<option value='$brand->brand_id'>$brand->brand</option>";
        }
    }

    public function show_frange(){
        $catogery = $this->input->post('catogery');
        $ranges = $this->Inventory_model->show_frange($catogery);

        foreach($ranges as $range){
           echo "<option value='$range->filter_range_id'>$range->filter_range</option>";
        }
    }
    

    public function delete(){
        $item_id = $this->uri->segment('3');
        $item_name = $this->uri->segment('4');

        $this->Inventory_model->delete($item_id);

         //Flash Msg
         $this->session->set_flashdata('message',"<div class='alert alert-danger'>".$item_name." is deleted!</div>");
        
         // Redirect to Employees
         redirect('/Inventory/Items');
    }

    public function update_stock(){
        $item_id = $this->input->post('item_id');
        $stock = $this->input->post('stock');
        $price = $this->input->post('price');

        $this->Inventory_model->update_stock($item_id,$stock,$price);
    }

    public function insert(){
        $this->form_validation->set_rules('item_id', 'Item ID', 'required|is_unique[int_items.item_id]');
        $this->form_validation->set_rules('item_name', 'Item Name', 'required');
        $this->form_validation->set_rules('item_catogery', 'Item category', 'required');

        if ($this->form_validation->run() == FALSE){
            $this->Add();
        }
        else{
            $id = $this->input->post('item_id');
            $barcode = $this->input->post('barcode');
            $name = $this->input->post('item_name');
            $cat = $this->input->post('item_catogery');
            $subcat = $this->input->post('item_sub_catogery');
            $filter_range = $this->input->post('filter_range');
            $capacity = $this->input->post('capacity');
            $part_number = $this->input->post('part_number');
            $brand = $this->input->post('item_brand');


            $result = $this->Inventory_model->insert_item($barcode,$id,$name,$cat,$subcat,$filter_range,$capacity,$part_number,$brand);

            //Flash Msg
            $this->session->set_flashdata('invmsg',"<div class='alert alert-success'> New item is updated!</div>");
            
            // Redirect to Employees
            redirect('/Inventory/Add');
        }
    }

    public function add_catogery(){
        $catogery = $this->input->post('catogery');
        $this->Inventory_model->insert_catogery($catogery);

        // Redirect to Employees
        redirect('/Inventory/Add');
    }

    public function add_sub_catogery(){
        $catogery = $this->input->post('catogery');
        $subcatogery = $this->input->post('sub_catogery');
        $this->Inventory_model->insert_sub_catogery($catogery,$subcatogery);

        // Redirect to Employees
        redirect('/Inventory/Add');
    }

    public function add_brand(){
        $brand = $this->input->post('brand');
        $this->Inventory_model->insert_brand($brand);

        // Redirect to Employees
        redirect('/Inventory/Add');
    }

    public function show_returnproducts(){
        $invoice_no = $this->input->post('invoice_no');
        $show_ret_pro = $this->Inventory_model->show_ret_pro($invoice_no);

        
    ?>
        <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Return Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
        <?php 
        foreach ($show_ret_pro as $ret)
        {
        ?>
                    <tr>
                        <td><?php echo $ret->item_name; ?></td>
                        <td><?php echo $ret->qty; ?></td>
                        <td><?php echo $ret->amount; ?></td>
                        <td><input type="number" id="qty" ></td>
                        <td><input type="checkbox" id="myCheck" onclick="myFunction(<?php echo $ret->id; ?>)"></td>
                    </tr>
                </tbody>
        <?php
        }
        ?>
            </table>
            <a href="SalesReturn" style="margin-top: 10px; margin-left: 90%; margin-bottom: 5px;" class="btn btn-danger">Close</a>
        <?php
        
    }

    public function update_status(){
        $id = $this->input->post('id');
        $qty = $this->input->post('qty');
        $this->Inventory_model->update_status($id, $qty);

        // Redirect to Employees
        // redirect('/Inventory/Add');
    }

    // Start Barcode
    public function Create_barcode()
    {
        $data['page_title'] = 'Create Barcode';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();
        //Item Catogiries
        $data['catogories'] = $this->Inventory_model->item_catogories();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['items'] = $this->Inventory_model->items();

        $data['nav'] = "Inventory";
        $data['subnav'] = "Show Items";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('inventory/create_barcode',$data);
        //$this->load->view('footer');
        $this->load->view('inventory/footer');
    }

    // get name
    public function item_name()
    {
        $id = $this->input->post('item_id');
        $row = $this->Inventory_model->item_data($id);
        echo $row->item_name;
    }

    public function item_price()
    {
        $id = $this->input->post('item_id');
        $row = $this->Inventory_model->purchase_price($id);
        echo $row->selling_price;
    }

    public function get_barcode()
    {
        $this->form_validation->set_rules('item_id', 'Item Id', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->Create_barcode();
        }
        else{

            $item_id = $this->input->post('item_id');
            $item_name = $this->input->post('item_name');
            $item_price = $this->input->post('item_price');
            $count = $this->input->post('count');
            
            
            header("Location: ../barcode/index.php?id=$item_id&item_name=$item_name&price=$item_price&count=$count");
        }

        
    }


}




