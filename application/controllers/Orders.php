<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Orders extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Load Model
        $this->load->model('Dashboard_model');
        $data['username'] = $this->Dashboard_model->username();
        //Load Model
        $this->load->model('Orders_model');
        //Already logged In
        if (!$this->session->has_userdata('user_id')) {
            redirect('/LoginController/logout');
        }
    }
    public function export_excel()
    {
        $this->load->view('orders/excel');
    }

    public function index()
    {
        $data['page_title'] = 'Orders';
        $data['username'] = $this->Dashboard_model->username();

        $data['orders'] = $this->Orders_model->orders();
        $data['today_sale'] = $this->Orders_model->today_sale();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Orders";
        $data['subnav'] = "Orders";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('orders/orders',$data);
        $this->load->view('orders/footer');
    }

    public function insert(){

        $data['page_title'] = 'Add Order';
        $data['nav'] = 'Orders';

        $data['username'] = $this->Dashboard_model->username();

        $data['items'] = $this->Orders_model->purchase_items();

        //create a order
        $this->Orders_model->create_order(); //20

        // Order items
        $data['order_items'] = $this->Orders_model->order_items(); //36

        //current order id
        $data['order_id'] = $this->Orders_model->last_order_id();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Orders";
        $data['subnav'] = "Add Order";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('orders/add-order',$data);
        $this->load->view('orders/footer');
    }

    public function order_items_ui($order_items,$order_id)
    {
        ?>
        <div class="add_items">
                      <div class="m-top-10">
                        <table class="table">
                          <thead>
                            <th class="text-center">No</th>
                            <th class="text-center">Item</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Total</th>
                            <th class="text-center"></th>
                          </thead>
                          <tbody>
                            <?php
                            $CI =& get_instance();
                            $i = 1;
                            $sub_total = 0;
                            foreach ($order_items as $o_itm) {
                              ?>
                              <tr data-toggle="modal" data-target="#update<?php echo $o_itm->id; ?>">
                                <td class="text-center"><?php echo $i; ?></td>
                                <td class="text-left"><?php echo $o_itm->item_name; ?></td>
                                <td class="text-right"><?php echo $itm_amt =  $o_itm->amount; ?>.00</td>
                                <td class="text-center"><?php echo $itm_qty = $o_itm->qty; ?></td>
                                <td class="text-right"><?php echo $item_total = $itm_amt*$itm_qty; ?>.00</td>
                                <td>
                                  <a href="<?php echo base_url(); ?>Orders/delete_order_item/<?php echo $o_itm->id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                </td>
                              </tr>

                              <!-- Qunatity Update Modal -->
                              <div id="update<?php echo $o_itm->id; ?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">Update</h4>
                                    </div>
                                    <div class="modal-body">
                                      <form action="<?php echo base_url(); ?>Orders/update_order_qty" method="post">
                                        <div class="row">
                                        <input name="order_id" type="hidden" class="form-control" value="<?php echo $o_itm->id; ?>" >
                                          <div class="col-sm-4">
                                            <label for="">Quantity</label>
                                            <input id="update_qty" style="height:90px; font-size:40px;" name="update_qty" type="text" class="form-control" value="<?php echo $itm_qty = $o_itm->qty; ?>">
                                          </div>
                                          
                                          <div class="col-sm-4">
                                          <label for="">Price (Selling Price)</label>
                                          <input style="height:90px; font-size:40px;" name="price" type="text" class="form-control" value="<?php echo $o_itm->amount; ?>">
                                          </div>

                                          <div class="col-sm-4">
                                          <label for="">Discount</label>
                                          <input style="height:90px; font-size:40px;" name="update_dis" type="text" class="form-control" value="0">
                                          </div>

                                        </div>
                                        <div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <input type="submit" class="btn btn-primary" value="Update">
                                    </form>
                                    </div>
                                  </div>

                                </div>
                              </div>

                              <script>
                                window.onload = function() {
                                  document.getElementById("update_qty").focus();
                                };
                              </script>
                              <?php
                              $sub_total = $sub_total+$item_total;
                              $i++;
                            }
                            // update total in order tbl
                            $CI->Orders_model->update_total($order_id,$sub_total);
                            ?>
                          </tbody>
                        </table>
                      </div>
                  </div>

                  <div style="margin-top:10px;">
                    <div class="row fnt-15 fnt-bold">
                      <div class="col-md-6">
                        <div class="item_m">
                          Sub Total
                        </div>
                        <div class="item_m">
                          Discount
                        </div>
                        <div class="item_m">
                          Total
                        </div>
                      </div>
                      <div class="col-md-6 text-right">
                        <div class="item_m">
                          <?php echo $sub_total; ?>.00
                        </div>
                        <div class="item_m">
                        <?php
                        // Discount from order
                        echo $discount = $CI->Orders_model->order_discount($order_id); //83
                        ?>.00
                        </div>
                        <div class="item_m">
                        <?php echo $sub_total-$discount; ?>.00
                        </div>
                      </div>
                    </div>
                  </div>

                  <div style="margin-top:10px;">
                    <div class="row fnt-15 fnt-bold">
                      <div class="col-xs-3 col-md-6 col-lg-3">
                        <a class="btn btn-order btn-wt-100" href="<?php echo base_url(); ?>Orders/clear_items/<?php echo $order_id; ?>">Clear</a>
                      </div>
                      <div class="col-xs-3 col-md-6 col-lg-3">
                        <button type="button" class="btn btn-order btn-wt-100" data-toggle="modal" data-target="#discount">Discount</button>
                      </div>
                      <div class="col-xs-3 col-md-6 col-lg-3">
                        <a class="btn btn-order btn-wt-100" href="<?php echo base_url(); ?>Orders/hold_order/<?php echo $order_id; ?>">Hold</a>
                      </div>
                      <div class="col-xs-3 col-md-6 col-lg-3">
                        <button type="button" class="btn btn-order btn-wt-100" data-toggle="modal" data-target="#pay">Pay</button>
                      </div>
                    </div>
                  </div>

                  <!-- Modal -->
                  <div id="discount" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Add Discount</h4>
                        </div>
                        <form action="<?php echo base_url(); ?>Orders/add_discount" method="post">
                        <div class="modal-body">
                          <input type="text" value="<?php echo $order_id; ?>" name="order_id" hidden>
                          <div class="row">
                            <div class="col-sm-8">
                              <input type="text" name="discount" class="form-control">
                            </div>
                            <div class="col-sm-4">
                              <select name="discount_type" class="form-control">
                                <option value="1">Amount</option>
                                <option value="2">Percentage</option>
                              </select>
                            </div>
                          </div>
                          
                        </div>
                        <div class="modal-footer">
                          <input type="submit" class="btn btn-success" value="Add">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </form>
                        </div>
                      </div>

                    </div>
                  </div>

                  <!-- Modal -->
                  <div id="pay" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Payment</h4>
                        </div>
                        <form action="<?php echo base_url(); ?>Orders/add_bill" method="post">
                        <div class="modal-body">
                          <input type="text" value="<?php echo $order_id; ?>" name="p_order_id" hidden>
                          <input type="text" value="<?php echo $sub_total; ?>" name="sub_total" hidden>
                          <input type="text" value="<?php echo $discount; ?>" name="discount" hidden>

                          <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                              <label>Total Amount:</label>
                            </div>
                            <div class="col-sm-7">
                              <input class="form-control" type="text" name="total_amount" id="t_amount" value="<?php echo $sub_total-$discount; ?>" disabled>
                            </div>
                          </div>

                          <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                              <label>Payment:</label>
                            </div>
                            <div class="col-sm-7">
                              <input class="form-control" type="number" name="p_amount" id="p_amount" value="">
                            </div>
                          </div>

                          <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                              <label>Balance:</label>
                            </div>
                            <div class="col-sm-7">
                              <input class="form-control has-error" type="text" name="balance" id="balance" disabled>
                            </div>
                          </div>

                          <div class="row fnt-15 m-top-10">

                            <div class="col-sm-5">
                              Payment Method
                            </div>
                            <div class="col-sm-7">
                              <input value="1" type="radio" class="custom-control-input"  name="p_method" checked>
                              <label class="custom-control-label">Cash</label>

                              <input value="2" type="radio" class="custom-control-input" id="defaultChecked" name="p_method">
                              <label class="custom-control-label">Card</label>
                            </div>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <input type="submit" class="btn btn-primary" value="Pay" id="btn_pay" disabled>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </form>
                        </div>
                      </div>

                    </div>
                  </div>

                  <script type="text/javascript">
                    $(document).ready(function(){
                        $("#search_item").on("keyup", function(){
                            var search_text = $(this).val();
                            $.ajax({
                                url:"<?php echo base_url(); ?>Orders/item_search", //756
                                type:"POST",
                                cache:false,
                                data:{search_text:search_text},
                                success:function(data){
                                //alert(data);
                                $("#items").html(data);
                                $("#items").fadeIn();
                                }
                            });
                        });


                        $("#p_amount").on("keyup", function(){
                            var p_amount = $(this).val();
                            var t_amount = $("#t_amount").val();

                            var balance = p_amount - t_amount;
                            $("#balance").val(balance);

                            if (balance >= 0){
                            $("#btn_pay").removeAttr("disabled");
                            $("#balance").css("border", "2px solid green");
                            }
                            else{
                            $("#btn_pay").prop("disabled",true);
                            $("#balance").css("border", "2px solid red");
                            }
                        });
                    });
                    </script>

                <script>
                    function clear_search(){
                      $("#search_item").val("");
                    }
                    $(document).ready(function(){
                      // Get the input field
                      var input = document.getElementById("search_item");

                      // Execute a function when the user releases a key on the keyboard
                      input.addEventListener("keyup", function(event) {
                        // Number 13 is the "Enter" key on the keyboard
                        if (event.keyCode === 13) {
                          // Cancel the default action, if needed
                          event.preventDefault();
                          // Trigger the button element with a click
                          document.getElementById("clear_btn").click();
                        }
                      });
                    });
                </script>
        <?php
    }


    public function insert_order_item(){
        $order_id = $this->input->post('order_id');
        $id = $this->input->post('id');

        //Get item id from purchase_items table
        $int_qty_data = $this->Orders_model->int_qty_data($id);
        $item_id = $int_qty_data->item_id; // Item ID
        $v_id = $int_qty_data->variation_id; // Variation ID

        // Insert into order_items
        $this->Orders_model->insert_order_item($item_id,$order_id,$v_id);
        $order_items = $this->Orders_model->order_items();
        $this->order_items_ui($order_items,$order_id);
        // Redirect to Add Orders
        //redirect('/Orders/insert');
    }

    public function delete_order_item(){
        $id =  $this->uri->segment('3');
        $this->Orders_model->delete_order_item($id); //90
        // Redirect to Add Order
        redirect('/Orders/insert');
    }
    
    public function delete_pending_order_item(){
        $id =  $this->uri->segment('3');
        $oid = $this->uri->segment('4');
        $this->Orders_model->delete_order_item($id); //90
        // Redirect to Add Order
        redirect('/Orders/pending/'.$oid);
    }

    public function clear_items(){
        $order_id =  $this->uri->segment('3');
        $this->Orders_model->clear_items($order_id);
        // Redirect to Add Order //95
        redirect('/Orders/insert');
    }

    public function add_discount(){
        $order_id =  $this->input->post('order_id');
        $discount =  $this->input->post('discount');
        $type =  $this->input->post('discount_type');
        $this->Orders_model->add_discount($order_id,$discount,$type); //107
        // Redirect to Add Order
        redirect('/Orders/insert');
    }

    public function hold_order($order_id){
        $this->Orders_model->hold_order($order_id); //124
        // Redirect to Add Order //95
        redirect('/Orders/insert');
    }

    public function add_bill()
  {
    $p_cash = 0; $p_card = 0; 
    $total_amount = $this->input->post('total_amount');
    $order_id =  $this->input->post('p_order_id');
    $sub_total =  $this->input->post('sub_total');
    $discount =  $this->input->post('discount');
    $p_amount =  $this->input->post('p_amount');
    $p_method =  $this->input->post('p_method');

    if($this->input->post('p_cash') > 0)
    {
      $p_cash = $this->input->post('p_cash');
    }
    else if($p_method == 1)
    {
      $p_cash = $total_amount;
    }

    if($this->input->post('p_card') > 0)
    {
      $p_card = $this->input->post('p_card');
    }
    else if($p_method == 2)
    {
      $p_card = $total_amount;
    }

    // Bill No
    $bill_no = $this->Orders_model->last_bill_no() + 1;
    
    //insert multi pay
    // $this->Orders_model->insert_multipay($order_id, $bill_no, $p_cash, $p_card, $sub_total);
   
    // Insert New Bill
    $bill_added = $this->Orders_model->insert_order($order_id, $bill_no, $sub_total, $discount, $p_amount, $p_method); //172
    
    if ($bill_added == true) {
      // Update Order Table
      $this->Orders_model->paid_order($order_id);

      // Api
      //$this->trakeesApi($bill_no);

      //Subtract from int_qty
      $this->Orders_model->reduce_qty($order_id);

      // Redirect to Add Order
      //redirect('/Orders/print_bill/'.$bill_no);
      redirect('/Orders');
    } else {
      $this->session->set_flashdata('ordermsg', "<div class='alert alert-danger'>Order Already Exist!</div>");
      redirect('/Orders');
    }
  }

    public function trakeesApi($bill_no)
    {
        $billTbl = $this->Orders_model->billData($bill_no);
        $order_id = $billTbl->order_id;

        $order_items = $this->Orders_model->orderItems($order_id);

        $orderTbl = $this->Orders_model->OrderData($order_id);
 
        // Mobile number with 0
        $customer_mobile_0 = $orderTbl->customer_mobile;

        $customerTbl = $this->Orders_model->CustomerData($customer_mobile_0);

        // Mobile number Without 0
        $customer_mobile = substr($customer_mobile_0, 1);

        if ($order_items == null) {
            $items = null;
        }
        else{
            // set array
            $items = array();

            $i = 0;
            foreach ($order_items as $itm) {
                $items[$i]['item'] = $itm->item_name;
                $items[$i]['description'] = '';
                $items[$i]['quantity'] = $itm->qty;
                $items[$i]['unitPrice'] = $itm->amount;
                $items[$i]['total'] = $itm->qty*$itm->amount;
                $items[$i]['tax'] = 0;
                $items[$i]['discount'] = $itm->discount;
                $i++;
            }
        }
        $subtotal = $billTbl->total;
        $data = array (
            'token' => 'eyJzdWIiOiJQYXJ0eXdvcmxkQWRtaW4iLCJpYXQiOjE2NTcwMjY0MzR9',
            'print' => true,
            'digital' => true,
            'invoice' => 
            array (
              'subject' => '',
              'reference' => $order_id,
              'invoiceNo' => $bill_no,
              'note' => '',
              'currency' => 'LKR',
              'subTotal' => $subtotal,
              'discount' => $discount = $billTbl->discount,
              'total' => $subtotal - $discount,
              'paid' => $billTbl->payment,
              'receivable' => '',
              'dueDate' => '',
              'imageUrl' => '',
              'documentUrl' => '',
              'invoiceItems' => $items,
              'invoiceService' => 
                array (
                
                ),
            ),
            'customer' => 
            array (
              'firstName' => $customerTbl->fname,
              'lastName' => '',
              'name' => '',
              'customerPhone' => '+94'.$customer_mobile,
              'address' => '',
              'email' => '',
              'dateOfBirth' => '',
              'nickName' => '',
              'civilStatus' => '',
              'imageUrl' => '',
              'vehicleNumber' => '',
              'nic' => '',
              'identifier' => '',
            ),
        );

        $jsondata = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://party-world-api.trakee.com/v1/orders/addOrder");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $jsondata);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        redirect('Orders');
    }

    public function print_bill($bill_no){
        //$bill_no =  $this->uri->segment('3');
        $data['bill_data'] = $this->Orders_model->bill_data($bill_no);
        $this->load->view('orders/print_bill',$data);
    }

    public function edit()
  {
    $bill_no =  $this->uri->segment('3');
    $data['page_title'] = 'Edit Order';
    $data['username'] = $this->Dashboard_model->username();
    // $data['vehicle_types'] = $this->Orders_model->vehicle_types();
    // $data['vehicle_makes'] = $this->Orders_model->vehicle_makes();
    // $data['services'] = $this->Orders_model->services();


    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['order'] = $this->Orders_model->edit_order($bill_no);

    $data['nav'] = "Orders";
    $data['subnav'] = "Add Order";

    $this->load->view('dashboard/layout/header', $data);
    $this->load->view('dashboard/layout/aside', $data);
    //$this->load->view('aside',$data);
    $this->load->view('orders/edit', $data);
    $this->load->view('orders/footer');
  }

    public function update()
  {

    $order_id = $this->input->post('order_id');
    $contact_no = $this->input->post('customer_mobile');
    // $cus_name = $this->input->post('cus_name');
    $bill_no = $this->input->post('bill_no');
    // $bill_date = $this->input->post('bill_date');
    $discount = $this->input->post('discount');


    $this->Orders_model->update_order($contact_no, $bill_no, $discount);
    //New Vehicle for Order
    if ($this->Orders_model->new_vehicle($vehicle_no) == 0) {
      //Insert Vehicle
      $this->Orders_model->insert_vehicle($vehicle_no, $contact_no, $cus_name);
    } else {
      // Update Contact Number
      $this->Orders_model->update_contact_no($vehicle_no, $contact_no, $cus_name);
    }

    redirect('Orders');
  }

    public function vehicle_search(){

        if ($this->input->post('vehicle_no')) {
            
            $output = "";
            $vehicle_no = $this->input->post('vehicle_no');
            $result = $this->Orders_model->vehicle_list($vehicle_no);
            $output = '<ul class="list-unstyled">';	
            foreach ($result as $row)
            {
                    $output .= '<li class="li-style">'.$row->vehicle_no.'</li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    public function contact_no(){
        $order_id = $this->input->post('order_id');
        echo $contact_no = $this->Orders_model->get_contact_no($order_id);
    }

    public function customername(){
        $order_id = $this->input->post('order_id');
        echo $customername = $this->Orders_model->get_customername($order_id);
    }

    public function validation(){

        $this->form_validation->set_rules('vehicle_no', 'Vehicle Number', 'required');
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('contact_no', 'Contact Number', 'required|numeric|max_length[10]');
        $this->form_validation->set_rules('discount', 'Discount', 'numeric');
        if ($this->input->post('ckm')) {
            $this->form_validation->set_rules('ckm', 'Current km', 'numeric');
        }
        if ($this->input->post('nkm')) {
            $this->form_validation->set_rules('nkm', 'Next km', 'numeric');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->insert();
        }
        else{

            //Set Bill No
            $last_bill_no = $this->Orders_model->last_bill();

            $bill_no = $last_bill_no+1;

            $vehicle_no = $this->input->post('vehicle_no');
            $cus_name = $this->input->post('customer_name');
            $contact_no = $this->input->post('contact_no');
            $bill_date = $this->input->post('bill_date');
            $type = $this->input->post('type');
            $make = $this->input->post('make');

            if ($this->input->post('ckm')) {
                $ckm = $this->input->post('ckm');
            }
            else{
                $ckm = 0;
            }

            if ($this->input->post('nkm')) {
                $nkm = $this->input->post('nkm');
            }
            else{
                $nkm = 0;
            }
            
            
            $reminder = $this->input->post('reminder');
            $discount = $this->input->post('discount');
            $bay = implode(",",$this->input->post('bay'));

            if ($this->Orders_model->insert_order($vehicle_no,$cus_name,$contact_no,$bill_no,$bill_date,$type,$make,$bay,$discount,$reminder,$ckm,$nkm)) {
                //Line 104

                //Image Upload
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 3000;
                $config['max_width']            = 2000;
                $config['max_height']           = 2000;
                $config['file_name'] = "order_".$bill_no;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('img'))
                {
                       
                }
                else
                {
                        $order_img = $this->upload->data('file_name');
                        $this->Orders_model->update_img($bill_no,$order_img);
                }
               
                //Confirm Services and Items
                $this->Orders_model->update_order_service($bill_no); //545
                $this->Orders_model->update_order_item($bill_no); //554

                // Reduce from purchase items
                $this->Orders_model->update_quantity($bill_no); //661

                //Reminder Table
                if ($this->Orders_model->reminder_available($vehicle_no,$contact_no) > 0) {
                    //Update Reminder Table
                    $this->Orders_model->update_reminder($vehicle_no,$reminder);
                }
                else{
                    // Inser New Row
                    $this->Orders_model->insert_reminder($vehicle_no,$contact_no,$reminder);
                }
                
                //New Vehicle for Order
                if ($this->Orders_model->new_vehicle($vehicle_no) == 0) {
                    //Insert Vehicle
                    $this->Orders_model->insert_vehicle($vehicle_no, $contact_no,$cus_name); //198
                }
                else{
                    // Update Contact Number
                    $this->Orders_model->update_contact_no($vehicle_no, $contact_no,$cus_name);
                }

                $this->session->set_flashdata('addordersuccess',"<div class='alert alert-success'>Order Added Successfully!</div>");
                redirect('Orders/View/'.$bill_no);
            }

        }
    }

    public function printBill($bill_no){
        $data['basic'] = $this->Orders_model->order_data($bill_no);
        $data['services'] = $this->Orders_model->order_service($bill_no);
        $data['items'] = $this->Orders_model->order_item($bill_no);
        $this->load->view('orders/print_bill',$data);
    }

    public function viewprintBill(){
        $bill_no =  $this->uri->segment('3');
        $data['basic'] = $this->Orders_model->order_data($bill_no);
        $data['services'] = $this->Orders_model->order_service($bill_no);
        $data['items'] = $this->Orders_model->order_item($bill_no);
        $this->load->view('orders/print_bill',$data);
    }

    //Service Amount for Order
    public function service_amount(){
        $service = $this->input->post('service');
        echo $this->Orders_model->service_amount($service); //138

    }

   

    public function view(){

        $bill_no =  $this->uri->segment('3');

        $data['page_title'] = 'View Order';
        $data['username'] = $this->Dashboard_model->username();

        $data['order'] = $this->Orders_model->view_order($bill_no);

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Orders";
        $data['subnav'] = "Orders";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('orders/view-order');
        $this->load->view('footer');
        $this->load->view('orders/footer');
    }

    public function Confirm_Bills(){
        $data['page_title'] = 'Confirm Bills';
        $data['username'] = $this->Dashboard_model->username();
        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['bills'] = $this->Orders_model->bills_confirmed();

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('orders/confirm_bills',$data);
        $this->load->view('orders/footer');
    }

    public function AddExpenses(){
        $data['page_title'] = 'Add Expenses';
        $data['username'] = $this->Dashboard_model->username();
        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        //Load Model
        $this->load->model('Inventory_model');

        //Item Catogiries
        $data['catogories'] = $this->Inventory_model->item_catogories();

        $data['location'] = $this->Orders_model->locations();

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('orders/add-expenses',$data);
        $this->load->view('orders/footer');
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
            $sub_cat = $this->input->post('subcat');
            $method = $this->input->post('method');
            $check_date = $this->input->post('check_date');
            $amount = $this->input->post('amount');

            if ($method == "credit") {
                $paid = 0;
            }
            else{
                $paid = 1;
            }
            
            $this->Orders_model->insert_expense($ex_date,$location,$ref_no,$name,$des,$cat,$sub_cat,$method,$amount,$check_date,$paid);

            $this->session->set_flashdata('success',"<div class='alert alert-success'>Expense Added Successfully!</div>");
            redirect('Orders/AddExpenses');
        }

    }

    public function Add_Service(){
        if ($this->input->post('service')) {
            $service_id = $this->input->post('service');
        }
        $bill_no = $this->input->post('bill_no');
        //insert order service into temperary table
        if ($this->input->post('service')) {
            if ($this->Orders_model->order_service_available($service_id,$bill_no) > 0) { //562
                echo "<div class='alert alert-warning'>Please Add New Service</div>"; //for show error
            }
            else{
                $this->Orders_model->insert_order_service($service_id,$bill_no); //452
            }
        }
        
        //Show selected service
        if ($this->Orders_model->is_selected_services($bill_no) > 0) { //476

            $order_service = $this->Orders_model->order_service($bill_no);
            ?>

                <table class="table table-striped">
                    <thead>
                        <th>Service</th>
                        <th class="text-right">Amount</th>
                        <th class="text-center">Action</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                            foreach ($order_service as $order_ser) {
                        ?>
                            <tr id="row<?php echo $order_ser->id; ?>">
                                <td><?php echo $order_ser->service; ?></td>
                                <td class="text-right"><?php echo $order_ser->amount; ?>.00</td>
                                <td class="text-center">
                                    <a class="btn btn-danger delete_service" id="<?php echo $order_ser->id; ?>"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php
                        $i++;
                        }
                        ?>
                    </tbody>
                </table>

                <script>
                    $(document).ready(function() {
                        $('.delete_service').click(function() {
                            var id = $(this).attr("id");
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url(); ?>Orders/deleteOrderService", //490
                                    data: ({
                                        id: id
                                    }),
                                    cache: false,
                                    success: function(html) {
                                        //alert("hi");
                                        $("#row" + id).fadeOut('slow');
                                    }
                                });
                        });
                    });
                </script>
            <?php
            
        }
    }

    public function deleteOrderService(){
        $id = $this->input->post('id');
        $this->Orders_model->deleteOrderService($id); // 490
    }

    public function deleteService(){
        $id =  $this->uri->segment('3');
        $orderid =  $this->uri->segment('4');
        $this->Orders_model->deleteOrderService($id); // 490
        // Redirect to Orders
        redirect('Orders/edit/'.$orderid);

    }

    public function deleteItem(){
        $id =  $this->uri->segment('3');
        $orderid =  $this->uri->segment('4');
        $this->Orders_model->deleteOrderItem($id); // 490
        // Redirect to Orders
        redirect('Orders/edit/'.$orderid);

    }

    public function Add_item(){
        if ($this->input->post('p_id')) {
            $p_id = $this->input->post('p_id');
            $item_id = $this->Orders_model->get_item_id($p_id);
        }
        $bill_no = $this->input->post('bill_no');
        $qty = $this->input->post('qty');

        //insert order service into temperary table
        if ($this->input->post('p_id')) {
            if ($this->Orders_model->order_item_available($item_id,$bill_no) > 0) { //568
             //   $this->Orders_model->update_qty($item_id,$bill_no,$qty); //582
                // Reduce from purchase items
                $this->Orders_model->update_quantity($bill_no);
            }
            else{
                $this->Orders_model->insert_order_item($item_id,$bill_no,$qty,$p_id); //503
            }
            
        }
        
        if ($this->Orders_model->is_selected_item($bill_no) > 0) { //521

            $order_item = $this->Orders_model->order_item($bill_no);//531

            ?>

                <table class="table table-striped">
                    <thead>
                        <th>Item</th>
                        <th class="text-right">Amount</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-right">Total</th>
                        <th class="text-center">Action</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                            foreach ($order_item as $order_itm) {
                        ?>
                            <tr id="item<?php echo $order_itm->id; ?>">
                                <td><?php echo $order_itm->item_name; ?></td>
                                <td class="text-right"><?php echo $order_itm->amount; ?>.00</td>
                                <td class="text-center"><?php echo $order_itm->qty; ?></td>
                                <td class="text-right"><?php echo $order_itm->qty*$order_itm->amount; ?>.00</td>
                                <td class="text-center">
                                    <a class="btn btn-danger delete_item" id="<?php echo $order_itm->id; ?>"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php
                        $i++;
                        }
                        ?>
                    </tbody>
                </table>

                <script>
                    $(document).ready(function() {
                        $('.delete_item').click(function() {
                            var id = $(this).attr("id");
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url(); ?>Orders/deleteOrderItem", //629
                                    data: ({
                                        id: id
                                    }),
                                    cache: false,
                                    success: function(html) {
                                        //alert("hi");
                                        $("#item" + id).fadeOut('slow');
                                    }
                                });
                        });
                    });
                </script>
            <?php
            
        }
    }

    public function deleteOrderItem(){
        $id = $this->input->post('id');
        $this->Orders_model->deleteOrderItem($id); // 539
    }

    public function add_vehicle_type(){
        $v_type = $this->input->post('v_type');

        if ($v_type != "") {
            $this->Orders_model->insert_vehicle_type($v_type); //688
        }

        // Redirect to Add Order
        redirect('/Orders/insert');
    }

    public function add_vehicle_make(){
        $v_make = $this->input->post('v_make');

        if ($v_make != "") {
            $this->Orders_model->insert_vehicle_make($v_make); //695
        }

        // Redirect to Add Order
        redirect('/Orders/insert');
    }

    public function item_suggestion()
    {
        $output = "";
        $item = $this->input->post('item');
        $result = $this->Orders_model->item_names($item);
        $output = '<ul class="list-unstyled">';	
        foreach ($result as $row)
        {
                $item_name = $row->item_name;
                $item_id = $row->item_id;
                $output .= '<li data-id='.$item_id.' class="li-style">'.$item_name.'</li>';
        }
        $output .= '</ul>';
        echo $output;
    }

    public function item_search(){
            $search_text = $this->input->post('search_txt');
            $item_ok = $this->Orders_model->search_items_available($search_text);
            $order_id = $this->Orders_model->last_order_id();
            if ($search_text == "") {
                $items = $this->Orders_model->purchase_items();
                foreach ($items as $itm) {
                  $int_qty_id = $itm->id; // id from int_qty tbl
                  ?>
                  <a id="single_item<?php echo $int_qty_id; ?>">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                      <div class="item_box">
                        <div class="item_m">
                          <?php
                          $item_id = $itm->item_id; // Item_ID
                          echo $this->Orders_model->barcode($item_id); 
                          ?>
                        </div>
                        <div class="item_m">
                          <?php echo $item_id = $itm->item_id; ?>
                        </div>
                        <?php $var_id = $itm->variation_id; ?>
                        <div class="item_m fnt-bold" style="color:#313552;">
                          <?php echo $this->Orders_model->item_name($item_id); ?> - <?php echo $this->Orders_model->selling_price($item_id,$var_id); ?>
                        </div>
                        <div class="item_m">
                          Qty : <?php echo $itm->qty; ?>
                        </div>
                      </div>
                    </div>
                  </a>
                  <input hidden type="text" id="id<?php echo $int_qty_id; ?>" value="<?php echo $int_qty_id; ?>">
                  <input hidden type="text" id="order_id<?php echo $int_qty_id; ?>" value="<?php echo $order_id; ?>">
                 
                  <script>
                    $(document).ready(function(){
                      $("#single_item<?php echo $int_qty_id; ?>").click(function(){
                        var order_id = $("#order_id<?php echo $int_qty_id; ?>").val();
                        var id = $("#id<?php echo $int_qty_id; ?>").val();
                          $.ajax({
                            url:"<?php echo base_url(); ?>Orders/insert_order_item", //803
                            type:"POST",
                            cache:false,
                            data:{order_id:order_id,id:id},
                            success:function(data){
                              //alert(data);
                              $("#add_items").html(data);
                              location.reload();
                            }
                          });
                      }); 
                    });
                  </script>

                  <?php
                }
            }
            else{
                
                $result = $this->Orders_model->search_items($search_text);
                foreach ($result as $itm) {
                  $int_qty_id = $itm->id; // id from int_qty tbl
                  ?>
                  <a id="single_item<?php echo $int_qty_id; ?>">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                      <div class="item_box">
                        <div class="item_m">
                          <?php
                          $item_id = $itm->item_id; // Item_ID
                          echo $this->Orders_model->barcode($item_id); 
                          ?>
                        </div>
                        <div class="item_m">
                          <?php echo $item_id = $itm->item_id; ?>
                        </div>
                        <?php $var_id = $itm->variation_id; ?>
                        <div class="item_m fnt-bold" style="color:#313552;">
                          <?php echo $this->Orders_model->item_name($item_id); ?> - <?php echo $this->Orders_model->selling_price($item_id,$var_id); ?>
                        </div>
                        <div class="item_m">
                          Qty : <?php echo $itm->qty; ?>
                        </div>
                      </div>
                    </div>
                  </a>
                  <input hidden type="text" id="id<?php echo $int_qty_id; ?>" value="<?php echo $int_qty_id; ?>">
                  <input hidden type="text" id="order_id<?php echo $int_qty_id; ?>" value="<?php echo $order_id; ?>">
                 
                  <script>
                    $(document).ready(function(){
                      $("#single_item<?php echo $int_qty_id; ?>").click(function(){
                        var order_id = $("#order_id<?php echo $int_qty_id; ?>").val();
                        var id = $("#id<?php echo $int_qty_id; ?>").val();
                          $.ajax({
                            url:"<?php echo base_url(); ?>Orders/insert_order_item", //803
                            type:"POST",
                            cache:false,
                            data:{order_id:order_id,id:id},
                            success:function(data){
                              //alert(data);
                              $("#add_items").html(data);
                              location.reload();
                            }
                          });
                      }); 
                    });
                  </script>

                  <?php
                }
            }
    }

    public function item_id_search(){
      $search_text = $this->input->post('search_txt');
      
      $item_ok = $this->Orders_model->search_items_available($search_text);
      $order_id = $this->Orders_model->last_order_id();
      if ($search_text == "") {
          $items = $this->Orders_model->purchase_items();
          foreach ($items as $itm) {
            $int_qty_id = $itm->id; // id from int_qty tbl
            ?>
            <a id="single_item<?php echo $int_qty_id; ?>">
              <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="item_box">
                  <div class="item_m">
                    <?php
                    $item_id = $itm->item_id; // Item_ID
                    echo $this->Orders_model->barcode($item_id); 
                    ?>
                  </div>
                  <div class="item_m">
                    <?php echo $item_id = $itm->item_id; ?>
                  </div>
                  <?php $var_id = $itm->variation_id; ?>
                  <div class="item_m fnt-bold" style="color:#313552;">
                    <?php echo $this->Orders_model->item_name($item_id); ?> - <?php echo $this->Orders_model->selling_price($item_id,$var_id); ?>
                  </div>
                  <div class="item_m">
                    Qty : <?php echo $itm->qty; ?>
                  </div>
                </div>
              </div>
            </a>
            <input hidden type="text" id="id<?php echo $int_qty_id; ?>" value="<?php echo $int_qty_id; ?>">
            <input hidden type="text" id="order_id<?php echo $int_qty_id; ?>" value="<?php echo $order_id; ?>">
           
            <script>
              $(document).ready(function(){
                $("#single_item<?php echo $int_qty_id; ?>").click(function(){
                  var order_id = $("#order_id<?php echo $int_qty_id; ?>").val();
                  var id = $("#id<?php echo $int_qty_id; ?>").val();
                    $.ajax({
                      url:"<?php echo base_url(); ?>Orders/insert_order_item", //803
                      type:"POST",
                      cache:false,
                      data:{order_id:order_id,id:id},
                      success:function(data){
                        //alert(data);
                        $("#add_items").html(data);
                        location.reload();
                      }
                    });
                }); 
              });
            </script>

            <?php
          }
      }
      else{
          
          $result = $this->Orders_model->search_item_id($search_text);
          foreach ($result as $itm) {
            $int_qty_id = $itm->id; // id from int_qty tbl
            ?>
            <a id="single_item<?php echo $int_qty_id; ?>">
              <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="item_box">
                  <div class="item_m">
                    <?php
                    $item_id = $itm->item_id; // Item_ID
                    echo $this->Orders_model->barcode($item_id); 
                    ?>
                  </div>
                  <div class="item_m">
                    <?php echo $item_id = $itm->item_id; ?>
                  </div>
                  <?php $var_id = $itm->variation_id; ?>
                  <div class="item_m fnt-bold" style="color:#313552;">
                    <?php echo $this->Orders_model->item_name($item_id); ?> - <?php echo $this->Orders_model->selling_price($item_id,$var_id); ?>
                  </div>
                  <div class="item_m">
                    Qty : <?php echo $itm->qty; ?>
                  </div>
                </div>
              </div>
            </a>
            <input hidden type="text" id="id<?php echo $int_qty_id; ?>" value="<?php echo $int_qty_id; ?>">
            <input hidden type="text" id="order_id<?php echo $int_qty_id; ?>" value="<?php echo $order_id; ?>">
           
            <script>
              $(document).ready(function(){
                $("#single_item<?php echo $int_qty_id; ?>").click(function(){
                  var order_id = $("#order_id<?php echo $int_qty_id; ?>").val();
                  var id = $("#id<?php echo $int_qty_id; ?>").val();
                    $.ajax({
                      url:"<?php echo base_url(); ?>Orders/insert_order_item", //803
                      type:"POST",
                      cache:false,
                      data:{order_id:order_id,id:id},
                      success:function(data){
                        //alert(data);
                        $("#add_items").html(data);
                        location.reload();
                      }
                    });
                }); 
              });
            </script>

            <?php
          }
      }
}

    public function update_order_qty()
    {
        $id = $this->input->post('order_id');
        $dis = $this->input->post('update_dis');
        $qty = $this->input->post('update_qty');
        $price = $this->input->post('price');
        $this->Orders_model->update_order_data($id,$dis,$qty,$price);
        // Redirect to Add Order
        redirect('/Orders/insert');
    }

    public function hold_orders()
    {
    $data['page_title'] = 'Hold Orders';
    $data['username'] = $this->Dashboard_model->username();

    $data['orders'] = $this->Orders_model->hold_orders();


    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['nav'] = "Orders";
    $data['subnav'] = "Orders";

    $this->load->view('dashboard/layout/header', $data);
    $this->load->view('dashboard/layout/aside', $data);
    //$this->load->view('aside',$data);
    $this->load->view('orders/hold_orders', $data);
    $this->load->view('orders/footer');
    }

    public function search_mobile()
    {
      $mobile = $this->input->post('mobile');

      $output = "";
      $result = $this->Orders_model->search_mobile($mobile);
      
      if ($result != NULL) {
        $output = '<ul class="list-unstyled">';	
        foreach ($result as $row)
        {
                $output .= '<li class="li-style">'.$row->mobile.'</li>';
        }
        $output .= '</ul>';
      }
      echo $output;
    }

    // get customer name for mobile number
    public function customer_name()
    {
      $mobile = $this->input->post('mobile');
      echo $this->Orders_model->customer_name($mobile);
    }

    // Add Customer to a Order
    public function add_customer()
    {
      $order_id = $this->Orders_model->last_order_id();
      $mobile = $this->input->post('mobile');
      $name = $this->input->post('name');

      if ($this->Orders_model->customer_available($mobile) == 1) {
        //Update Customer Name if even same or different
        $this->Orders_model->update_customer($mobile,$name);
      }
      if ($this->Orders_model->customer_available($mobile) == 0) {
        //Insert as a New Customer
        $this->Orders_model->insert_customer($mobile,$name);
      }

      // Add Customer to this Order
      $this->Orders_model->order_customer($order_id,$mobile);

      // Redirect to Add Order
      redirect('/Orders/insert');

    }

    public function add_customer_detail()
    {
      $order_id = $this->input->post('order_id');
      $mobile = $this->input->post('mobile');
      $name = $this->input->post('name');

      if ($this->Orders_model->customer_available($mobile) == 1) {
        //Update Customer Name if even same or different
        $this->Orders_model->update_customer($mobile,$name);
      }
      if ($this->Orders_model->customer_available($mobile) == 0) {
        //Insert as a New Customer
        $this->Orders_model->insert_customer($mobile,$name);
      }

      // Add Customer to this Order
      $this->Orders_model->order_customer($order_id,$mobile);

      // Redirect to Add Order
      redirect('/Orders');

    }

    public function SalesReturn()
    {
        $data['page_title'] = 'Sales Return';
        $data['username'] = $this->Dashboard_model->username();

        // $data['orders'] = $this->Orders_model->hold_orders();
        

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Orders";
        $data['subnav'] = "Orders";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('orders/sales-return',$data);
        $this->load->view('orders/footer');
    }
    
    public function delete_hold_order($order_id)
    {
        $this->Orders_model->delete_hold_order($order_id);
        // Redirect to Hold Orders
        redirect('/Orders/hold_orders');
    }
    
    // Edit Hold Orders
  public function pending($order_id)
  {
    $data['page_title'] = 'Add Order';
    $data['nav'] = 'Orders';
    $data['username'] = $this->Dashboard_model->username();
    $data['items'] = $this->Orders_model->purchase_items();
    // Order items
    $data['order_items'] = $this->Orders_model->hold_order_items($order_id); //36

    //current order id
    $data['order_id'] = $order_id;

    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['nav'] = "Orders";
    $data['subnav'] = "Add Order";

    $this->load->view('dashboard/layout/header', $data);
    $this->load->view('dashboard/layout/aside', $data);
    //$this->load->view('aside',$data);
    $this->load->view('orders/pending_order', $data);
    $this->load->view('orders/footer_pending');
  }
  
  public function pending_order_items($order_id = null)
  {
    if ($order_id == null) {
      $order_id = $this->input->post('order_id');
    }
    ?>
    <div class="add_items">
      <div class="m-top-10">
        <table class="table">
          <thead>
            <th class="text-center">No</th>
            <th class="text-center">Item</th>
            <th class="text-center">Price</th>
            <th class="text-center">Qty</th>
            <th class="text-center">Total</th>
            <th class="text-center"></th>
          </thead>
          <tbody id="tbl_body">
            <?php

            $items = $this->Orders_model->hold_order_items($order_id);
            $i = 1;
            $sub_total = 0;
            foreach ($items as $item) {

            ?>
              <tr>
                <td class="text-center"><?php echo $i; ?></td>
                <td data-toggle="modal" data-target="#update<?php echo $item->id; ?>" class="text-left"><?php echo $item->item_name; ?></td>
                <td class="text-right"><?php echo $itm_amt =  $item->amount; ?>.00</td>
                <td class="text-center"><?php echo $itm_qty = $item->qty; ?></td>
                <td class="text-right"><?php echo $item_total = $itm_amt * $itm_qty; ?>.00</td>
                <td>
                    <a href="<?php echo base_url(); ?>Orders/delete_pending_order_item/<?php echo $item->id; ?>/<?php echo $order_id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              
              <!-- Qunatity Update Modal -->
              <div id="update<?php echo $item->id; ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Update</h4>
                    </div>
                    <div class="modal-body">
                      <form action="<?php echo base_url(); ?>Orders/update_order_qty" method="post">
                        <div class="row">
                        <input name="order_id" type="hidden" class="form-control" value="<?php echo $item->id; ?>" >
                          <div class="col-sm-4">
                            <label for="">Quantity</label>
                            <input id="update_qty" style="height:90px; font-size:40px;" name="update_qty" type="text" class="form-control" value="<?php echo $itm_qty = $item->qty; ?>">
                          </div>
                          
                          <div class="col-sm-4">
                          <label for="">Price (Selling Price)</label>
                          <input style="height:90px; font-size:40px;" name="price" type="text" class="form-control" value="<?php echo $item->amount; ?>">
                          </div>

                          <div class="col-sm-4">
                          <label for="">Discount</label>
                          <input style="height:90px; font-size:40px;" name="update_dis" type="text" class="form-control" value="0">
                          </div>

                        </div>
                        <div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <input type="submit" class="btn btn-primary" value="Update">
                    </form>
                    </div>
                  </div>

                </div>
              </div>
              <script>
                window.onload = function() {
                  document.getElementById("update_qty").focus();
                };
              </script>
                              
            <?php
              $sub_total = $sub_total + $item_total;
              $i++;
              $this->Orders_model->update_total($order_id, $sub_total);
            }
            ?>

          </tbody>
        </table>
          
      </div>
    </div>

    <!-- Total -->
    <div style="margin-top:10px;">
      <div class="row fnt-15 fnt-bold">
        <div class="col-md-6">
          <div class="item_m">
            Sub Total
          </div>
          <div class="item_m">
            Discount
          </div>
          <div class="item_m">
            Total
          </div>
        </div>
        <div class="col-md-6 text-right">
          <div class="item_m">
            <?php echo $sub_total; ?>.00
          </div>
          <div class="item_m">
            <?php
            // Discount from order
            echo $discount = $this->Orders_model->order_discount($order_id); //83
            ?>.00
          </div>
          <div class="item_m">
            <?php echo $sub_total - $discount; ?>.00
          </div>
        </div>
      </div>
    </div>
    <!-- Total -->
    <?php
  }

  public function insert_hold_order_item()
  {
    $order_id = $this->input->post('order_id');
    $id = $this->input->post('id');

    //Get item id from purchase_items table
    $int_qty_data = $this->Orders_model->int_qty_data($id);
    $item_id = $int_qty_data->item_id; // Item ID
    $v_id = $int_qty_data->variation_id; // Variation ID

    // Insert into order_items
    $this->Orders_model->insert_order_item($item_id, $order_id, $v_id);
    $order_items = $this->Orders_model->order_items();
    $this->pending_order_items($order_id);
    // Redirect to Add Orders
    //redirect('/Orders/insert');
  }

  public function clear_hold_items()
  {
    $order_id = $this->input->post('order_id');
    $this->Orders_model->clear_items($order_id);
    $this->pending_order_items($order_id);
  }

  public function pending_item_search()
  { 
    $search_text = $this->input->post('search_txt');
    $order_id = $this->input->post('order_id');

    $item_ok = $this->Orders_model->search_items_available($search_text);
    
    if ($search_text == "") {
      $items = $this->Orders_model->purchase_items();
      foreach ($items as $itm) {
        $int_qty_id = $itm->id; // id from int_qty tbl
      ?>
        <a id="single_item<?php echo $int_qty_id; ?>">
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="item_box">
              <div class="item_m">
                <?php
                $item_id = $itm->item_id; // Item_ID
                echo $this->Orders_model->barcode($item_id);
                ?>
              </div>
              <div class="item_m">
                <?php echo $item_id = $itm->item_id; ?>
              </div>
              <?php $var_id = $itm->variation_id; ?>
              <div class="item_m fnt-bold" style="color:#313552;">
                <?php echo $this->Orders_model->item_name($item_id); ?> - <?php echo $this->Orders_model->selling_price($item_id, $var_id); ?>
              </div>
              <div class="item_m">
                Qty : <?php echo $itm->qty; ?>
              </div>
            </div>
          </div>
        </a>
        <input hidden type="text" id="id<?php echo $int_qty_id; ?>" value="<?php echo $int_qty_id; ?>">
        <input hidden type="text" id="order_id<?php echo $int_qty_id; ?>" value="<?php echo $order_id; ?>">

        <script>
          $(document).ready(function() {
            $("#single_item<?php echo $int_qty_id; ?>").click(function() {
              var order_id = $("#order_id<?php echo $int_qty_id; ?>").val();
              var id = $("#id<?php echo $int_qty_id; ?>").val();
              $.ajax({
                url: "<?php echo base_url(); ?>Orders/insert_hold_order_item",
                type: "POST",
                cache: false,
                data: {
                  order_id: order_id,
                  id: id
                },
                success: function(data) {
                  //alert(data);
                  $("#item_section").html(data);
                  //location.reload();
                }
              });
            });
          });
        </script>

      <?php
      }
    } else {

      $result = $this->Orders_model->search_items($search_text);
      foreach ($result as $itm) {
        $int_qty_id = $itm->id; // id from int_qty tbl
      ?>
        <a id="single_item<?php echo $int_qty_id; ?>">
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="item_box">
              <div class="item_m">
                <?php
                $item_id = $itm->item_id; // Item_ID
                echo $this->Orders_model->barcode($item_id);
                ?>
              </div>
              <div class="item_m">
                <?php echo $item_id = $itm->item_id; ?>
              </div>
              <?php $var_id = $itm->variation_id; ?>
              <div class="item_m fnt-bold" style="color:#313552;">
                <?php echo $this->Orders_model->item_name($item_id); ?> - <?php echo $this->Orders_model->selling_price($item_id, $var_id); ?>
              </div>
              <div class="item_m">
                Qty : <?php echo $itm->qty; ?>
              </div>
            </div>
          </div>
        </a>
        <input hidden type="text" id="id<?php echo $int_qty_id; ?>" value="<?php echo $int_qty_id; ?>">
        <input hidden type="text" id="order_id<?php echo $int_qty_id; ?>" value="<?php echo $order_id; ?>">

        <script>
          $(document).ready(function() {
            $("#single_item<?php echo $int_qty_id; ?>").click(function() {
              var order_id = $("#order_id<?php echo $int_qty_id; ?>").val();
              var id = $("#id<?php echo $int_qty_id; ?>").val();
              $.ajax({
                url: "<?php echo base_url(); ?>Orders/insert_hold_order_item", //803
                type: "POST",
                cache: false,
                data: {
                  order_id: order_id,
                  id: id
                },
                success: function(data) {
                  //alert(data);
                  $("#item_section").html(data);
                  //location.reload();
                }
              });
            });
          });
        </script>

      <?php
      }
    }
  }

  public function update_pay_model()
  {
    $order_id = $this->input->post('order_id');
    
    $order_data = $this->Orders_model->order_tbl_data($order_id);
    $sub_total = $order_data->total;
    $discount = $order_data->discount;
    ?>
    <!-- Pay Starts -->
    <div id="pay" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Payment</h4>
                </div>
                <form action="<?php echo base_url(); ?>Orders/add_bill" method="post">
                    <div class="modal-body">
                        <input type="text" value="<?php echo $order_id; ?>" name="p_order_id" hidden>
                        <input type="text" value="<?php echo $sub_total; ?>" name="sub_total" hidden>
                        <input type="text" value="<?php echo $discount; ?>" name="discount" hidden>

                        <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                                <label>Total Amount:</label>
                            </div>
                            <div class="col-sm-7">
                                <input class="form-control" type="text" name="total_amount" id="t_amount"
                                    value="<?php echo $sub_total-$discount; ?>" disabled>
                            </div>
                        </div>

                        <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                                <label>Payment:</label>
                            </div>
                            <div class="col-sm-7">
                                <input class="form-control" type="number" name="p_amount" id="p_amount" value="">
                            </div>
                        </div>

                        <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                                <label>Balance:</label>
                            </div>
                            <div class="col-sm-7">
                                <div></div>
                                <input class="form-control has-error" type="text" name="balance" id="balance" disabled>
                            </div>
                        </div>

                        <div class="row fnt-15 m-top-10">

                            <div class="col-sm-5">
                                Payment Method
                            </div>
                            <div class="col-sm-7">
                                <input value="1" type="radio" class="custom-control-input" name="p_method" checked>
                                <label class="custom-control-label">Cash</label>

                                <input value="2" type="radio" class="custom-control-input" id="defaultChecked"
                                    name="p_method">
                                <label class="custom-control-label">Card</label>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Pay" id="btn_pay" disabled>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>

    </div>
    </div>
    <!-- Pay Ends -->
    <?php
  }


}

/* End of file Orders.php and path /application/controllers/Orders.php */
