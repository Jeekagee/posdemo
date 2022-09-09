<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchase extends CI_Controller
{
    
  public function __construct()
  {
      parent::__construct();
      //Load Model
      $this->load->model('Dashboard_model');
      $data['username'] = $this->Dashboard_model->username();
      //Load Model
      $this->load->model('Purchase_model');
      //Already logged In
      if (!$this->session->has_userdata('user_id')) {
          redirect('/LoginController/logout');
      }
  }

  // New Purchase UI
  public function AddNew()
  {
        $data['page_title'] = 'New Purchase';
        $data['username'] = $this->Dashboard_model->username();

        $data['suppliers'] = $this->Purchase_model->suppiler();
        $data['location'] = $this->Purchase_model->locations();
        //$data['bill_years'] = $this->Orders_model->get_bill_years();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Purchase";
        $data['subnav'] = "New Purchase";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('purchase/addnew',$data);
        $this->load->view('purchase/footer');
  }

  public function AddItems()
  {
        $data['page_title'] = 'Add Items';
        $data['username'] = $this->Dashboard_model->username();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['suppliers'] = $this->Purchase_model->last_purchase();

        $data['nav'] = "Purchase";
        $data['subnav'] = "New Purchase";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('purchase/add-items',$data);
        $this->load->view('purchase/footer');
  }

  // Add Suppiler Details for Purchase
  public function AddItem()
  {
      $this->form_validation->set_rules('supplier', 'Supplier', 'required');
      $this->form_validation->set_rules('rec_date', 'Date', 'required');
      $this->form_validation->set_rules('ref_no', 'Ref_No', 'required|is_unique[purchase.ref_no]');
      $this->form_validation->set_rules('method', 'Payment Method', 'required');
      $method = $this->input->post('method');
      if ($method == "credit") {
        $this->form_validation->set_rules('check_date', 'Cheque Date', 'required');
      }

      if ($this->form_validation->run() == FALSE) {
          $this->AddNew();
      }
      else{
            $supplier = $this->input->post('supplier');
            $rec_date = $this->input->post('rec_date');
            $location = $this->input->post('location');
            $notes = $this->input->post('notes');
            $ref_no = $this->input->post('ref_no');
            $method = $this->input->post('method');
            $check_date = $this->input->post('check_date');
            
          if ($method == "credit") {
              $status = 0;
          }
          else{
              $status = 1;
          }

            $this->Purchase_model->insert_purchase($supplier,$rec_date,$location,$notes,$ref_no,$method,$check_date,$status); //23

            redirect('Purchase/AddItems');
      }
  }

  public function insert_items(){
            $item_txt = $this->input->post('item');
            $quantity = $this->input->post('quantity');
            $purchase_id = $this->input->post('purchase_id');
            $s_price = $this->input->post('s_price');
            $p_price = $this->input->post('p_price');
            $ex_date = $this->input->post('ex_date');

            //get item_id is barcode or item_id
            $item = $this->Purchase_model->get_item_id($item_txt);

            // item avaiable on int_item table
            if ($this->Purchase_model->item_available($item) == 0) {
              $error =  "<div class='alert alert-danger'>Please Select Available Item. Add new item <a href='../Inventory/Add'>Click Here</a></div>";
            }
            else{
              $error = "";
              // Variation ID
              $var_id = $this->Purchase_model->variation_id($s_price,$p_price,$item);
              // Not Same item in a purchase
              if ($this->Purchase_model->same_item($purchase_id,$s_price,$p_price,$ex_date,$item) == 0) {
                // Insert Purchase Item
                $this->Purchase_model->insert_purchase_item($item,$quantity,$purchase_id,$s_price,$p_price,$ex_date,$var_id);
              }
              // Same item in a purchase
              else{
                //get id to do update
                $item_purchase_id = $this->Purchase_model->item_purchase_id($purchase_id,$s_price,$p_price,$ex_date,$item);
                $this->Purchase_model->update_qty($item_purchase_id,$quantity);
              }
              
            }

            
            $items = $this->Purchase_model->items($purchase_id);
            
            ?>
              <h4>Purchase Items</h4>     
              <?php
                echo $error;
              ?>
                     
                <table style="width:80%; margin:auto" class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">Item</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Purchase Price</th>
                        <th class="text-center">Selling Price</th>
                        <th class="text-center">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                        $total = 0;
                        foreach ($items as $item) {
                          ?>
                          <tr>
                              <td><?php echo $item->item_id; ?></td>
                              <td class="text-center"><?php echo $item->quantity; ?></td>
                              <td class="text-right"><?php echo $item->purchase_price; ?>.00</td>
                              <td class="text-right"><?php echo $item->selling_price; ?>.00</td>
                              <td class="text-right"><?php echo $tot = $item->quantity*$item->purchase_price; ?>.00</td>
                          </tr>
                          <?php $total = $total + $tot; ?>
                          <?php
                        }
                      ?>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right" style="font-size:16px;">Sub Total </td>
                        <td class="text-right" style="font-size:16px;"><?php echo $total; ?>.00</td>
                      </tr>
                    </tbody>
                </table>

                <div>
                    <a  class="btn btn-primary" href="<?php echo base_url(); ?>Purchase/save_purchase/<?php echo $purchase_id; ?>">Save</a>
                    <a  class="btn btn-danger" href="<?php echo base_url(); ?>Purchase/cancel_purchase/<?php echo $purchase_id; ?>">Cancel</a>
                </div>
            <?php
  }
  public function AddSupplier()
    {
        $data['page_title'] = 'Add Supplier';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();
        $data['location'] = $this->Purchase_model->locations();
        $data['supplier'] = $this->Purchase_model->suppiler(); 

        $data['nav'] = "Purchase";
        $data['subnav'] = "Purchase Invoice";
        
        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('purchase/add-supplier',$data);
        //$this->load->view('footer');
        $this->load->view('purchase/footer');
    }

    public function insertSupplier(){
      // $this->form_validation->set_rules('id', 'Supplier ID', 'required|is_unique[supplier.id]');
      $this->form_validation->set_rules('supplier', 'Supplier Name', 'required');
      $this->form_validation->set_rules('description', 'Supplier Description', 'required');
      //$this->form_validation->set_rules('location_id', 'Supplier Location', 'required');
      
      if ($this->form_validation->run() == FALSE){
          $this->AddSupplier();
      }
      else{
          // $id = $this->input->post('id');
          $name = $this->input->post('supplier');
          $description = $this->input->post('description');

          $this->Purchase_model->insert_supplier($name,$description);

          //Flash Msg
          $this->session->set_flashdata('delete',"<div class='alert alert-success'> New Employee has been assigned!</div>");
          
          // Redirect to Add Purchase
          redirect('/Purchase/AddSupplier');
      }
  }
  public function AddLocation()
    {
        $data['page_title'] = 'Add Location';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();
        $data['location'] = $this->Purchase_model->locations();
        //$data['location'] = $this->Employees_model->location(); //64

        $data['nav'] = "Purchase";
        $data['subnav'] = "Purchase Invoice";
        
        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('purchase/add-location',$data);
        //$this->load->view('footer');
        $this->load->view('purchase/footer');
    }

  public function insertLocation(){
    // $this->form_validation->set_rules('id', 'Location ID', 'required|is_unique[location.id]');
    $this->form_validation->set_rules('location', 'Location Name', 'required');
    //$this->form_validation->set_rules('emp_loc', 'Employee Location', 'required');
    
    if ($this->form_validation->run() == FALSE){
        $this->AddLocation();
    }
    else{
        // $id = $this->input->post('id');
        $name = $this->input->post('location');
       // $loc = $this->input->post('emp_loc');

        $this->Purchase_model->insert_location($name);

        //Flash Msg
        $this->session->set_flashdata('delete',"<div class='alert alert-success'> New Employee has been assigned!</div>");
        
        // Redirect to Employees
        redirect('/Purchase/AddLocation');
    }
}

public function deleteLocation(){
  $id =  $this->uri->segment('3');
  $location =  $this->uri->segment('4');
  $this->Purchase_model->delete_location($id);

  //Flash Msg
  $this->session->set_flashdata('delete',"<div class='alert alert-warning'>".$location." is deleted!</div>");
  
  // Redirect to Employees
  redirect('/Purchase/AddNew');
}
  public function show_purchase_items(){
    $purchase_id = $this->input->post('purchase_id');

    if ($this->Purchase_model->avai_items($purchase_id) > 0){
      $items = $this->Purchase_model->items($purchase_id);
    
    ?>
      <h4>Purchase Items</h4>            
        <table style="width:80%; margin:auto" class="table table-hover">
            <thead>
            <tr>
                <th class="text-center">Item</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Purchase Price</th>
                <th class="text-center">Selling Price</th>
                <th class="text-center">Total</th>
            </tr>
            </thead>
            <tbody>
              <?php
                $total = 0;
                foreach ($items as $item) {
                  ?>
                  <tr>
                      <td><?php echo $item->item_id; ?></td>
                      <td class="text-center"><?php echo $item->quantity; ?></td>
                      <td class="text-right"><?php echo $item->purchase_price; ?></td>
                      <td class="text-right"><?php echo $item->selling_price; ?>.00</td>
                      <td class="text-right"><?php echo $tot = $item->quantity*$item->purchase_price; ?></td>
                  </tr>
                  <?php $total = $total + $tot; ?>
                  <?php
                }
              ?>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right" style="font-size:16px;">Sub Total </td>
                <td class="text-right" style="font-size:16px;"><?php echo $total; ?></td>
              </tr>
            </tbody>
        </table>

        <div>
            <a  class="btn btn-primary" href="<?php echo base_url(); ?>Purchase/save_purchase/<?php echo $purchase_id; ?>">Save</a>
            <a  class="btn btn-danger" href="<?php echo base_url(); ?>Purchase/cancel_purchase/<?php echo $purchase_id; ?>">Cancel</a>
        </div>
    <?php
    }
    else{
      echo "";
    }
    
    
}

  

  public function save_purchase($pur_id){
    $this->Purchase_model->save_items($pur_id);
    $this->Purchase_model->update_item_qty_tbl($pur_id);
    redirect('Purchase/AddNew');
  }

  public function cancel_purchase($pur_id){
    $this->Purchase_model->cancel_items($pur_id);
    redirect('Purchase/AddNew');
  }

  public function Summery(){
    $data['page_title'] = 'Purchase Summery';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['purchases'] = $this->Purchase_model->purchase_summery();

        $data['nav'] = "Purchase";
        $data['subnav'] = "Purchases";

    $this->load->view('dashboard/layout/header',$data);
    $this->load->view('dashboard/layout/aside',$data);
    $this->load->view('purchase/purchase-summery',$data);
    $this->load->view('purchase/footer');
  }

  public function item_search(){

    if ($this->input->post('item')) {
        
        $output = "";
        $item = $this->input->post('item');
        $result = $this->Purchase_model->item_list($item);
        $output = '<ul class="list-unstyled">';	
        foreach ($result as $row)
        {
                $output .= '<li class="li-style">'.$row->item_id.'</li>';
        }
        $output .= '</ul>';
        echo $output;
    }
  }

  public function item_price(){
    $item_id = $this->input->post('item_id');
    echo $price = $this->Purchase_model->get_item_price($item_id);
  }

  public function item_name(){
    $item_id = $this->input->post('item_id');
    echo $price = $this->Purchase_model->get_item_name($item_id); //116
  }

  public function delete(){
    $id =  $this->input->post('id');
    $this->Purchase_model->delete_purchase($id); //115
  }

  public function view(){

    $puritem_id =  $this->uri->segment('3');
    $data['page_title'] = 'View';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    //purchase data
    $data['purchase_item'] = $this->Purchase_model->view_purchase($puritem_id); //122

    $data['nav'] = "Purchase";
    $data['subnav'] = "Purchases";

    $this->load->view('dashboard/layout/header',$data);
    $this->load->view('dashboard/layout/aside',$data);
    $this->load->view('purchase/view-purchase',$data);
    $this->load->view('purchase/footer',$data);
  }

  public function item_name_fill(){
    $item_id = $this->input->post('item_id');

    echo $this->Purchase_model->fill_item_name($item_id); //116
  }

  public function SupplierSummary(){
    $data['page_title'] = 'Supplier Summary';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['supplier_summary'] = $this->Purchase_model->supplier_summary();

    $data['nav'] = "Purchase";
    $data['subnav'] = "Purchase";

    $this->load->view('dashboard/layout/header',$data);
    $this->load->view('dashboard/layout/aside',$data);
    $this->load->view('purchase/supplier-summary',$data);
    $this->load->view('purchase/footer');
  }

  public function ViewSummary(){
    $supplier_id =  $this->uri->segment('3');
    $data['page_title'] = 'Supplier View';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['view_summary'] = $this->Purchase_model->view_summary($supplier_id);
    // $data['total_purchase'] = $this->Purchase_model->total_purchase($supplier_id);

    $data['nav'] = "Purchase";
    $data['subnav'] = "Purchase";

    $this->load->view('dashboard/layout/header',$data);
    $this->load->view('dashboard/layout/aside',$data);
    $this->load->view('purchase/view-summary',$data);
    $this->load->view('purchase/footer');
  }

  public function update_sellingprice()
  {
    $id =  $this->input->post('id');
    $price =  $this->input->post('price');
    $quantity =  $this->input->post('quantity');
    $this->Purchase_model->update_sellingprice($id,$price,$quantity);
    redirect('Purchase/Summery');
  }

  public function credit_pay(){
    // $id =  $this->uri->segment('3');
    $id = $this->input->post('id');
    $this->Purchase_model->credit_pay($id); 
    // Redirect to supplier summary
    redirect('/Purchase/SupplierSummary');
  }

  public function PurchaseReturn()
    {
        $data['page_title'] = 'Purchase Return';
        $data['username'] = $this->Dashboard_model->username();
        

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Purchase";
        $data['subnav'] = "Purchase";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('purchase/purchase-return',$data);
        $this->load->view('purchase/footer');
    }

    public function show_purchasereturn(){
      $ref_no = $this->input->post('ref_no');
      $show_pur_return = $this->Purchase_model->show_pur_return($ref_no);

      
  ?>
      <table>
              <thead>
                  <tr>
                      <th>Rec Date</th>
                      <th>Item_id</th>
                      <th>Purchase price</th>
                      <th>Purchase Quantity</th>
                      <th>Current Quantity</th>
                      <th>Method</th>
                      <th>Return Quantity</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
      <?php 
      foreach ($show_pur_return as $pur)
      $pur_qty=$pur->quantity;
      $cur_qty=$pur->return_quantity;
      $currentqty=$pur_qty-$cur_qty;
      {
      ?>
                  <tr>
                      <td><?php echo $pur->rec_date; ?></td>
                      <td><?php echo $pur->item_id; ?></td>
                      <td><?php echo $pur->purchase_price; ?></td>
                      <td><?php echo $pur->quantity; ?></td>
                      <td><?php echo $currentqty; ?></td>
                      <td><?php echo $pur->method; ?></td>
                      <td><input type="number" id="qty"  ></td>
                      <td><input type="checkbox" id="myCheck" onclick="myFunction(<?php echo $pur->id; ?>)"></td>
                  </tr>
              </tbody>
      <?php
      }
      ?>
          </table>
          <a href="PurchaseReturn" style="margin-top: 10px; margin-left: 90%; margin-bottom: 5px;" class="btn btn-danger">Close</a>
      <?php
      
  }
  
  public function update_purchasereturn(){
    $id = $this->input->post('id');
    $qty = $this->input->post('quantity');
    // $curqty = $this->input->post('return_quantity');
    $this->Purchase_model->update_purchasereturn($id,$qty,$curqty);
    $this->Purchase_model->update_purchasquantity($id,$qty);

    // Redirect to Employees
    // redirect('/Inventory/Add');
  }

}


/* End of file Purchase.php */
/* Location: ./application/controllers/Purchase.php */