<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Report
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Report extends CI_Controller
{
    
  public function __construct()
  {
      parent::__construct();
        //Load Model
        $this->load->model('Dashboard_model');
        $data['username'] = $this->Dashboard_model->username();
        //Load Model
        $this->load->model('Report_model');
        //Already logged In
        if (!$this->session->has_userdata('user_id')) {
            redirect('/LoginController/logout');
        }
   }


  public function InvReport(){
    $data['page_title'] = 'Inventory Report';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['inv_remains'] = $this->Report_model->inventory_summary();

        $data['nav'] = "Report";
        $data['subnav'] = "AddReport";

    $this->load->view('dashboard/layout/header-items',$data);
    $this->load->view('dashboard/layout/aside-items',$data);
    $this->load->view('reports/inventory_report',$data);
    $this->load->view('reports/footer-view');
  }

  public function delete(){
    $id =  $this->input->post('id');
    $this->Report_model->delete_item($id); //29
  }

  public function edit(){
    $expense_id =  $this->uri->segment('3');
    $data['page_title'] = 'Edit Inventory';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    //Total Expenses for this month
    $data['item_id'] = $this->Report_model->item_id(); //16

    //Expense data
    $data['item_name'] = $this->Report_model->item_name(); //35

    //Item Catogiries
    $data['qty'] = $this->Report_model->item_catogories();

    $data['nav'] = "Expense";
  $data['subnav'] = "Expenses";

    $this->load->view('dashboard/layout/header',$data);
    $this->load->view('dashboard/layout/aside',$data);
    $this->load->view('expense/edit-expense',$data);
    $this->load->view('expense/footer',$data);
  }
  public function index()
  {
        $data['page_title'] = 'Reports';
        $data['username'] = $this->Dashboard_model->username();
        //$data['orders'] = $this->Orders_model->orders();
        //$data['bill_years'] = $this->Orders_model->get_bill_years();
        

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Reports";
        $data['subnav'] = "Reports";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('reports/index',$data);
        $this->load->view('orders/footer');
  }

  public function OrderReport()
  {
        $data['page_title'] = 'Order - Report';
        $data['username'] = $this->Dashboard_model->username();
        //$data['bill_years'] = $this->Orders_model->get_bill_years();
        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['order_report'] = $this->Report_model->orders();

        $data['nav'] = "Reports";
        $data['subnav'] = "Reports";

        $this->load->view('dashboard/layout/header-items',$data);
        $this->load->view('dashboard/layout/aside-items',$data);
        //$this->load->view('aside',$data);
        $this->load->view('reports/order_report',$data);
        $this->load->view('orders/footer-view');
  }

  public function PurchaseSummary(){
    $data['page_title'] = 'Purchase Summary';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['fromDate'] = $fromDate = date("Y-m-d");
    $data['toDate'] = $toDate = date("Y-m-d");
    $data['suppliers'] = $this->Report_model->suppiler();

    $data['nav'] = "Reports";
    $data['subnav'] = "PurchaseSummary";

    $this->load->view('dashboard/layout/header-items',$data);
    $this->load->view('dashboard/layout/aside-items',$data);
    $this->load->view('reports/purchase/purchase_summary',$data);
    $this->load->view('reports/purchase/footer-view');
  }

  public function LoadPurchaseSummary(){
    $sup_id = $this->input->post('sup_id');
    $fromDate = $this->input->post('fromDate');
    $toDate = $this->input->post('toDate');

    $purchase_summary = $this->Report_model->purchase_summary($sup_id,$fromDate,$toDate);
    $i =1;
    ?>
      <table id="example" class="display nowrap" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Ref No</th>
            <th>Supplier</th>
            <th>Payment Method</th>
            <th class="text-right">Total Cost</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($purchase_summary as $pur){
              $purchase_id = $pur->id;
              $total_cost =  $this->Report_model->purchase_total_cost($purchase_id);
              ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $pur->rec_date; ?></td>
                  <td><?php echo $pur->ref_no; ?></td>
                  <td><?php echo $pur->supplier_name;  ?></td>
                  <td><?php echo $pur->method;  ?></td>
                  <td class="text-right"><?php echo $total_cost; ?>.00</td>
                  <td class="text-center">
                    <a href="javascript:viewDetails(<?php echo $purchase_id; ?>)" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                  </td>
                </tr>
              <?php
              $i++;
            }
          ?>
        </tbody>
      </table>
    
    <script>
        $('#example').DataTable({
            ordering: false,
            dom: 'Bfrtip',
            buttons: [
            'excel'
            ]
        });
    </script>
    <?php
  }

  public function SupplierWisePurchase(){
    $data['page_title'] = 'Supplier Wise Purchase Summary';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['fromDate'] = $fromDate = date("Y-m-d");
    $data['toDate'] = $toDate = date("Y-m-d");
    $data['suppliers'] = $this->Report_model->suppiler();

    $data['nav'] = "Report";
    $data['subnav'] = "SupplierWisePurchase";

    $this->load->view('dashboard/layout/header-items',$data);
    $this->load->view('dashboard/layout/aside-items',$data);
    $this->load->view('reports/purchase/supplier_wise_purchase',$data);
    $this->load->view('reports/purchase/footer-view');
  }

  public function LoadSupplierPurchase(){
    $sup_id = $this->input->post('sup_id');
    $fromDate = $this->input->post('fromDate');
    $toDate = $this->input->post('toDate');

    $purchase_summary = $this->Report_model->supplier_purchase($sup_id,$fromDate,$toDate);
    $i =1;
    foreach ($purchase_summary as $pur){
    ?>
        <tr id="pur<?php echo $pur->id; ?>">
          <td><?php echo $i; ?></td>
          <td><?php echo $pur->rec_date; ?></td>
          <td><?php echo $pur->ref_no; ?></td>
          <td><?php echo $pur->item_id; ?></td>
          <td class="text-center"><?php echo $qty = $pur->quantity; ?></td>
          <td class="text-right"><?php echo $price = $pur->purchase_price; ?>.00</td>
          <td class="text-right"><?php echo $pur->selling_price; ?>.00</td>
          <td class="text-right"><?php echo $price * $qty; ?>.00</td>
        </tr>
      <?php
      $i++;
    }
  }

  public function PurchaseSummaryReport(){
    $data['page_title'] = 'Purchase Summary';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    

    $data['fromDate'] = $fromDate = $this->input->post('fromDate');
    $data['toDate'] = $toDate = $this->input->post('toDate');

    $data['purchase_summary'] = $this->Report_model->purchase_summary($fromDate,$toDate);

    $data['nav'] = "Report";
    $data['subnav'] = "AddReport";

    $this->load->view('dashboard/layout/header-items',$data);
    $this->load->view('dashboard/layout/aside-items',$data);
    $this->load->view('reports/purchase/purchase_summary',$data);
    $this->load->view('reports/purchase/footer-view');
  }

  public function PurchaseItems()
  {
    $purchase_id = $this->input->post('id');
    $purchase_details = $this->Report_model->purchase_details($purchase_id);
    $purchases = $this->Report_model->purchase_data($purchase_id);
    ?>
      <h4><b>Purchase Details Report : </b><?php echo $purchases->ref_no; ?></h4> <hr>
      <table id="example" class="display nowrap" class="table" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Item</th>
            <th>Barcode</th>
            <th class="text-center" style="color:#33b5e5;">Purchase Quantity</th>
            <th class="text-right">Purchase Price</th>
            <th class="text-right">Selling Price</th>
            <th class="text-right" style="color:#33b5e5;">Purchase Amount</th>
            <th class="text-right" style="color:#ff4444;">Return Quantity</th>
            <th class="text-right" style="color:#ff4444;">Return Amount</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $i =1;
            foreach ($purchase_details as $pur){
              ?>
                <tr style="height:30px;">
                  <td><?php echo $i; ?></td>
                  <td><?php echo $pur->item_name; ?></td>
                  <td><?php echo $pur->barcode; ?></td>
                  <td class="text-center" style="color:#33b5e5;"><?php echo $qty = $pur->quantity; ?></td>
                  <td class="text-right"><?php echo $price = $pur->purchase_price; ?>.00</td>
                  <td class="text-right"><?php echo $pur->selling_price; ?>.00</td>
                  <td class="text-right" style="color:#33b5e5;"><?php echo $price* $qty; ?>.00</td>
                  <td class="text-center" style="color:#ff4444;">
                    <?php 
                      if($pur->purchase_return == 1)
                      {
                        echo $pur->return_quantity;
                      }
                      else
                      {
                        echo "-";
                      }
                    ?>
                  </td>
                  <td class="text-right" style="color:#ff4444;">
                    <?php 
                      if($pur->purchase_return == 1)
                      {
                        echo $pur->return_quantity * $price. ".00";
                      }
                      else
                      {
                        echo "-";
                      }
                    ?>
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
  
  public function InventoryItems()
  {
    $item_id = $this->input->post('id');
    $item_details = $this->Report_model->inventory_details($item_id);
    $item_name = $this->Report_model->item_name($item_id);
    ?>
      <h4><b>Item Purchase Details Report : </b><?php echo $item_name->item_name; ?></h4> <hr>
      <table id="example" class="display nowrap" class="table" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th class="text-center">Purchase Quantity</th>
            <th class="text-right">Purchase Price</th>
            <th class="text-center">Remaining Quantity</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $i =1;
            foreach ($item_details as $itm){
              ?>
                <tr style="height:30px;">
                  <td><?php echo $i; ?></td>
                  <td class="text-center"><?php echo $itm->qty; ?></td>
                  <td class="text-right"><?php echo $itm->purchase_price; ?>.00</td>
                  <td class="text-center">
                    <?php 
                      $item_remain = $this->Report_model->sales_qty($item_id, $itm->variation_id);
                      echo $item_remain; 
                    ?>
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

  public function SalesSummary(){
    $data['page_title'] = 'Sale Summary';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['fromDate'] = $fromDate = date("Y-m-d");
    $data['toDate'] = $toDate = date("Y-m-d");
    // $data['customers'] = $this->Report_model->customer();
    
    $data['nav'] = "Reports";
    $data['subnav'] = "SalesSummary";

    $this->load->view('dashboard/layout/header-items',$data);
    $this->load->view('dashboard/layout/aside-items',$data);
    $this->load->view('reports/sale/sales_summary_report',$data);
    $this->load->view('reports/sale/footer-view');
  }

  public function LoadTotalSales(){
    $fromDate = $this->input->post('fromDate');
    $toDate = $this->input->post('toDate');

    $tot_sales = $this->Report_model->t_sales($fromDate,$toDate);

    ?>
    <p><?php echo $tot_sales; ?>.00</p>
    <?php
  }

  public function LoadorderCount(){
    $fromDate = $this->input->post('fromDate');
    $toDate = $this->input->post('toDate');

    $no_of_orders = $this->Report_model->no_of_orders($fromDate,$toDate);

    ?>
    <p><?php echo $no_of_orders; ?></p>
    <?php
  }

  public function LoadSalesSummary(){
    $fromDate = $this->input->post('fromDate');
    $toDate = $this->input->post('toDate');

    $sales_summary = $this->Report_model->sales_summary($fromDate,$toDate);
    
    ?>
      <table id="example" class="display nowrap" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Invoice No</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Discount</th>
                    <th class="text-center">Payment</th>
                    <th class="text-center">Net Amount</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $CI =& get_instance();
                  $i =1;
                  foreach ($sales_summary as $sale){
                    // $order_id = $sale->order_id;
                    $bill_no = $sale->bill_no;
                    ?>
                      <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td ><?php echo $sale->created; ?></td>
                        <td class="text-center"><?php echo $sale->bill_no; ?></td>
                        <td class="text-right"><?php echo $total = $sale->total; ?>.00</td>
                        <td class="text-right"><?php echo $discount = $sale->discount; ?>.00</td>
                        <td class="text-right"><?php echo $sale->payment; ?>.00</td>
                        <td class="text-right"><?php echo $total-$discount; ?>.00</td>
                        <td class="text-center">
                          <a href="<?php echo base_url(); ?>Report/view_sales/<?php echo $bill_no = $sale->bill_no; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                        </td>
                      </tr>
                    <?php
                    $i++;
                  }
                ?>
                </tbody>
              </table>
    
    <script>
        $('#example').DataTable({
            ordering: false,
            dom: 'Bfrtip',
            buttons: [
            'excel'
            ]
        });

      

    </script>
    <?php
  }

  public function SalesSummaryReport(){
    $data['page_title'] = 'Purchase Summary';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    

    $data['fromDate'] = $fromDate = $this->input->post('fromDate');
    $data['toDate'] = $toDate = $this->input->post('toDate');

    $data['sales_summary'] = $this->Report_model->sales_summary($fromDate,$toDate);

    $data['nav'] = "Report";
    $data['subnav'] = "AddReport";

    $this->load->view('dashboard/layout/header-items',$data);
    $this->load->view('dashboard/layout/aside-items',$data);
    $this->load->view('reports/sale/sale_summary_report',$data);
    $this->load->view('reports/sale/footer-view');
  }

  public function CustomerReport(){
    $data['page_title'] = 'Customer Report';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['customer_report'] = $this->Report_model->customer_report();

        $data['nav'] = "Report";
        $data['subnav'] = "AddReport";

    $this->load->view('dashboard/layout/header-items',$data);
    $this->load->view('dashboard/layout/aside-items',$data);
    $this->load->view('reports/customer_report',$data);
    $this->load->view('reports/footer-view');
  }

  public function ExpenseSummary(){
    $fromDate = $this->input->post('fromDate');
    $toDate = $this->input->post('toDate');

    $expense_report = $this->Report_model->expense_report($fromDate,$toDate);
    
    ?>
      <table id="example" class="display nowrap" style="width:100%">
      <thead>
                  <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Payee</th>
                    <th>Description</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($expense_report as $expense){
                    ?>
                      <tr id="exp<?php echo $expense->id; ?>">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $expense->ex_date; ?></td>
                        <td><?php echo $expense->location; ?></td>
                        <td><?php echo $expense->payee_name; ?></td>
                        <td><?php echo $expense->description; ?></td>
                        <td><?php echo $expense->method; ?></td>
                        <td><?php echo $expense->amount; ?></td>
                      </tr>
                    <?php
                    $i++;
                  }
                ?>
                </tbody>
              </table>
    
    <script>
        $('#example').DataTable({
            ordering: false,
            dom: 'Bfrtip',
            buttons: [
            'excel'
            ]
        });

      

    </script>
    <?php
  }

  public function ExpenseReport(){
    $data['page_title'] = 'Expense Report';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['fromDate'] = $fromDate = date("Y-m-d");
    $data['toDate'] = $toDate = date("Y-m-d");

    // $data['expense_report'] = $this->Report_model->expense_report();

        $data['nav'] = "Report";
        $data['subnav'] = "AddReport";

    $this->load->view('dashboard/layout/header-items',$data);
    $this->load->view('dashboard/layout/aside-items',$data);
    $this->load->view('reports/expense_report',$data);
    $this->load->view('reports/footer-view');
  }

  public function ProfitReport(){
    $from_date=null;
    $to_date=null;
  if ($this->input->post('submit')) {
    $from_date=$this->input->post('from_date');
    $to_date=$this->input->post('to_date');
  }

  $data['page_title'] = 'Profit & Lost Report';
  $data['username'] = $this->Dashboard_model->username();
  $data['pending_count'] = $this->Dashboard_model->pending_count();
  $data['confirm_count'] = $this->Dashboard_model->confirm_count();

  $data['total_expense'] = $this->Report_model->total_expense($from_date,$to_date);
  $data['total_sales'] = $this->Report_model->total_sales($from_date,$to_date);
  $data['total_cog'] = $this->Report_model->total_cog($from_date,$to_date);
  // $data['profit_lost_report'] = $this->Report_model->total_revenue();

      $data['nav'] = "Report";
      $data['subnav'] = "AddReport";

  $this->load->view('dashboard/layout/header-items',$data);
  $this->load->view('dashboard/layout/aside-items',$data);
  $this->load->view('reports/profit_lost_report',$data);
  $this->load->view('reports/footer-view');
}

  public function AccountReport(){

    $data['page_title'] = 'Accounts Report';
    $data['username'] = $this->Dashboard_model->username();
    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['account_expense'] = $this->Report_model->account_expense();
    $data['account_sales'] = $this->Report_model->account_sales();
    $data['opening_balance'] = $this->Report_model->opening_balance();
    $data['obalance_date'] = $this->Report_model->obalance_date();
    $data['account_purchase'] = $this->Report_model->account_purchase();

        $data['nav'] = "Report";
        $data['subnav'] = "AddReport";

    $this->load->view('dashboard/layout/header-items',$data);
    $this->load->view('dashboard/layout/aside-items',$data);
    $this->load->view('reports/account_summary',$data);
    $this->load->view('reports/footer-view');
  }

  public function viewpurchaseReports()
  {
        $data['page_title'] = 'Reports';
        $data['username'] = $this->Dashboard_model->username();        

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Reports";
        $data['subnav'] = "Reports";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('reports/view_purchase_reports',$data);
        $this->load->view('orders/footer');
  }

  public function viewsupplierReports()
  {
        $data['page_title'] = 'Reports';
        $data['username'] = $this->Dashboard_model->username();        

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Reports";
        $data['subnav'] = "Reports";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('reports/view_supplier_report',$data);
        $this->load->view('orders/footer');
  }
  public function viewsaleReports()
  {
        $data['page_title'] = 'Reports';
        $data['username'] = $this->Dashboard_model->username();        

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Reports";
        $data['subnav'] = "Reports";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('reports/view_sale_report',$data);
        $this->load->view('orders/footer');
  }
  
  public function view_sales(){

    $bill_no =  $this->uri->segment('3');

    $data['page_title'] = 'Reports';
    $data['username'] = $this->Dashboard_model->username();

    $data['sale'] = $this->Report_model->view_sales($bill_no);

    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['nav'] = "Reports";
    $data['subnav'] = "Reports";

    $this->load->view('dashboard/layout/header',$data);
    $this->load->view('dashboard/layout/aside',$data);
    $this->load->view('reports/sale/view_sales_summary',$data);
    $this->load->view('reports/sale/footer-view');
}

}


/* End of file Report.php */
/* Location: ./application/controllers/Report.php */