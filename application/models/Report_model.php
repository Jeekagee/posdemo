<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Report_model extends CI_Model 
{
    public function inventory(){
        $sql = "SELECT id, item_id, purchase_id, SUM(quantity) as totalqty FROM int_qty WHERE item_id  IN (SELECT item_id FROM int_items) GROUP BY item_id";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function inventory_summary(){
        $sql = "SELECT id, item_id, SUM(quantity) as totalqty , SUM(return_quantity) as totalreturn 
        FROM purchase_items GROUP BY item_id";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function purchase_cost($item_id){
        $cost = 0;
        $sql = "SELECT quantity, purchase_price FROM purchase_items WHERE item_id='$item_id'";
        $query = $this->db->query($sql);
        $result = $query->result();

        foreach($result as $row)
        {
            $cost = $cost + ($row->quantity * $row->purchase_price);
        }

        return $cost;
    }

    public function item_remains($item_id){
        $sql = "SELECT SUM(qty) as totalremain FROM int_qty WHERE item_id = $item_id GROUP BY item_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->totalremain;
    }

    function fetch_data()
    {
    $this->db->order_by("item_id", "DESC");
    $query = $this->db->get("int_qty");
    return $query->result();
    }

    public function purchase_summary($sup_id,$fromDate,$toDate){
        if($sup_id > 0)
        {
            $sql = "SELECT purchase.* , supplier.supplier as supplier_name
            FROM purchase , supplier
            WHERE purchase.supplier = supplier.id AND purchase.supplier = $sup_id AND rec_date BETWEEN  '$fromDate' AND '$toDate' 
            ORDER BY created_at DESC";
        }
        else
        {
            $sql = "SELECT purchase.* , supplier.supplier as supplier_name
            FROM purchase , supplier
            WHERE purchase.supplier = supplier.id AND rec_date BETWEEN  '$fromDate' AND '$toDate' 
            ORDER BY created_at DESC";
        }
        
        $query = $this->db->query($sql);

        //die($this->db->last_query());
        //exit();
        $result = $query->result();

        return $result;
    }

    public function supplier_purchase($sup_id,$fromDate,$toDate){
        $sql = "SELECT i.*, p.rec_date, p.ref_no 
            FROM purchase p , purchase_items i
            WHERE p.id = i.purchase_id AND p.supplier = $sup_id AND p.rec_date BETWEEN '$fromDate' AND '$toDate' 
            ORDER BY p.created_at DESC";
        $query = $this->db->query($sql);

        //die($this->db->last_query());
        //exit();
        $result = $query->result();

        return $result;
    }
    
      public function purchase_data($pur_id){
        $sql = "SELECT id, rec_date, ref_no, supplier FROM purchase WHERE id = $pur_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }
    
    public function customer()
    {
        $sql = "SELECT * FROM customer";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }  
    
    public function suppiler()
    {
        $sql = "SELECT * FROM supplier";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }  

    public function total_expense($from_date,$to_date){
        
        $newDate = date("d-m-Y", strtotime($from_date));
        if ($from_date==null && $to_date==null) {
            $sql = "SELECT amount, ex_date FROM expense  WHERE created >= CURRENT_DATE()";
        }
        elseif($from_date!=null && $to_date==null) {
          $sql = "SELECT amount, created FROM expense  WHERE created = '$newDate'";
        //   die();
        }
        elseif($from_date!=null && $to_date!=null){
            $sql = "SELECT amount, created FROM expense  WHERE created BETWEEN  '$from_date' AND '$to_date'";
        }

       
        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();

        $total = 0;

        if ($count > 0) {
            foreach ($result as $amt) {
                $total = $total+$amt->amount;
            }
        }
        return $total;
    }

    public function total_sales($from_date,$to_date){
        
        $newDate = date("d-m-Y", strtotime($from_date));
        if ($from_date==null && $to_date==null) {
            $sql = "SELECT total, created FROM bill_item WHERE created >= CURRENT_DATE()";
        }
        elseif($from_date!=null && $to_date==null) {
          $sql = "SELECT total, created FROM bill_item  WHERE created = '$newDate'";
        }
        elseif($from_date!=null && $to_date!=null){
            $sql = "SELECT total, created FROM bill_item  WHERE created BETWEEN  '$from_date' AND '$to_date'";
        }
        
        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();
    
        $total = 0;

        if ($count > 0) {
            foreach ($result as $amt) {
                $total = $total+$amt->total;
            }
        }

        return $total;
    }
    
    public function total_cog($from_date,$to_date){
        $newDate = date("d-m-Y", strtotime($from_date));
        if ($from_date==null && $to_date==null) {
            $sql = "SELECT purchase_price, created_at FROM purchase_items  WHERE created_at >= CURRENT_DATE()";
        }
        elseif($from_date!=null && $to_date==null) {
          $sql = "SELECT purchase_price, created_at FROM purchase_items  WHERE created_at = '$newDate'";
        }
        elseif($from_date!=null && $to_date!=null){
            $sql = "SELECT purchase_price, created_at FROM purchase_items  WHERE created_at BETWEEN  '$from_date' AND '$to_date'";
        }

        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();

        $total = 0;

        if ($count > 0) {
            foreach ($result as $amt) {
                $total = $total+$amt->purchase_price;
            }
        }

        return $total;
    }
    

    public function orders(){
        $sql = "SELECT * FROM bill_item";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    public function expense_report($fromDate,$toDate){
        $sql = "SELECT * FROM expense WHERE DATE(created) BETWEEN '$fromDate' AND '$toDate' ORDER BY payee_name DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }
    
    public function customer_report(){
        $sql = "SELECT customer_id, fname, email, mobile FROM customer";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function data_transfer(){
        $sql = "SELECT id, item_id, quantity FROM purchase_items";
        $query = $this->db->query($sql);
        //$result = $query->num_rows();
        $result = $query->result();
        foreach ($result as $i) {
            $data = array(
                'purchase_id' => $i->id,
                'item_id' => $i->item_id,
                'qty' => $i->quantity,
            );
    
            $this->db->insert('int_qty', $data);
            # code...
        }
    }

    public function item_name($item_id){
        $sql = "SELECT item_name FROM int_items WHERE item_id='$item_id'";
        $query = $this->db->query($sql);
        return $row = $query->first_row();
    }
    
    public function delete_inventory($id)
    {
        $sql = "DELETE FROM purchase_items WHERE id=$id";
        $query = $this->db->query($sql);
    }

    public function edit_inventory($id)
    {
        $sql = "SELECT * FROM purchase_items WHERE id=$id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    public function total_qty(){
        $sql = "SELECT COUNT(item_id), item_name * FROM int_aty GROUP BY qty ORDER BY(item_id) DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        
        return $result;
    }
    
    public function date_filter($from_date, $to_date){
        $sql = "SELECT total, created FROM bill_item  WHERE created >= '$from_date' to created <= '$to_date'";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }


    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    } 
    
    public function account_sales(){
        $sql = "SELECT total, created FROM bill_item";
        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();
    
        $total = 0;

        if ($count > 0) {
            foreach ($result as $amt) {
                $total = $total+$amt->total;
            }
        }

        return $total;
    }

    public function account_expense(){
        $sql = "SELECT amount, ex_date FROM expense";
        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();

        $total = 0;

        if ($count > 0) {
            foreach ($result as $amt) {
                $total = $total+$amt->amount;
            }
        }
        return $total;
    }

    public function account_purchase(){
        $sql = "SELECT t.purchase_price, t.created_at FROM purchase_items t 
        LEFT JOIN purchase p ON t.purchase_id=p.id WHERE p.status='1'";
        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();

        $total = 0;

        if ($count > 0) {
            foreach ($result as $amt) {
                $total = $total+$amt->purchase_price;
            }
        }

        return $total;
    }


    public function opening_balance(){
        $sql = "SELECT balance,created_at FROM o_balance";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->balance;
    }
   
    public function obalance_date(){
        $sql = "SELECT created_at FROM o_balance";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->created_at;
    }

    public function purchase_total_cost($purchase_id){
        $sql = "SELECT sum(purchase_price*quantity) as cost FROM purchase_items WHERE purchase_id = $purchase_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->cost;
    }

    public function purchase_details($purchase_id){
        $sql = "SELECT purchase_items.*, int_items.item_name, int_items.barcode 
            FROM purchase_items , int_items
            WHERE purchase_items.item_id = int_items.item_id AND purchase_id = $purchase_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function sales_summary($fromDate,$toDate){
        $sql = "SELECT * FROM bill_item WHERE DATE(created) BETWEEN '$fromDate' AND '$toDate' 
        ORDER BY created DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function t_sales($fromDate,$toDate){
        $sql = "SELECT * FROM bill_item 
            WHERE DATE(created) BETWEEN '$fromDate' AND '$toDate'";
        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();

        $total = 0;

        if ($count > 0) {
            foreach ($result as $amt) {
                $total = $total+$amt->total-$amt->discount;
            }
        }

        return $total;
    }

    public function no_of_orders($fromDate,$toDate){
        $sql = "SELECT * FROM bill_item WHERE DATE(created) BETWEEN '$fromDate' AND '$toDate'";
        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();
        
        return $count;
    }

    public function view_sales($bill_no){
        $sql = "SELECT * FROM orders o LEFT JOIN bill_item b ON o.id=b.order_id WHERE b.bill_no = $bill_no";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }
    public function sale_item($bill_no){
        $sql = "SELECT * FROM order_item o LEFT JOIN bill_item b ON o.order_id=b.order_id
        WHERE b.bill_no = $bill_no";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function inventory_details($item_id){
        $sql = "SELECT *, SUM(quantity) as qty
            FROM purchase_items
            WHERE item_id = $item_id GROUP BY variation_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function sales_qty($item_id, $variation_id){
        $sql = "SELECT SUM(qty) as totalremain FROM int_qty WHERE item_id = $item_id AND variation_id = $variation_id GROUP BY item_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->totalremain;
    }
}

/* End of file Report_model.php and path /application/models/Report_model.php */

