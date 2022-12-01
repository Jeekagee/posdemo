<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Orders_model extends CI_Model 
{
    public function orders(){
        $sql = "SELECT * FROM bill_item ORDER BY created DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    public function today_sale(){
        $sql = "SELECT * FROM bill_item WHERE created >= CURRENT_DATE()";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function hold_orders(){
        $sql = "SELECT * FROM orders WHERE status = 2 ORDER BY updated DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function order_available(){
        $sql = "SELECT id FROM orders WHERE status = 0";
        $query = $this->db->query($sql);
        $count = $query->num_rows();

        if ($count > 0) {
            return true;
        }
        else{
            return false;
        }
    }

    public function create_order(){
        if ($this->order_available() == false) { //23
            $data = array(
                'status' => 0
            );
            $this->db->insert('orders', $data);
        }
    }

    public function last_order_id(){
        $sql = "SELECT id FROM orders WHERE status = 0 ORDER BY created DESC LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->id;
    }

    public function order_items(){
        $id = $this->last_order_id(); // 29
        $sql = "SELECT * FROM order_item WHERE order_id = $id ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    public function order_item_available($item_id,$order_id,$v_id){
        $sql = "SELECT * FROM order_item WHERE order_id = $order_id AND item_id = '$item_id' AND variation_id = $v_id";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function item_data($item_id){
        $sql = "SELECT * FROM int_items WHERE item_id = '$item_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function int_qty_data($id){
        $sql = "SELECT * FROM int_qty WHERE id = $id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    
    public function selling_price($item_id,$variation_id)
    {
        $sql = "SELECT * FROM purchase_items WHERE item_id = '$item_id' AND variation_id = $variation_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->selling_price;
    }

    public function purchase_price($item_id,$variation_id)
    {
        $sql = "SELECT * FROM purchase_items WHERE item_id = '$item_id' AND variation_id = $variation_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->purchase_price;
    }

    public function purchase_item_data($item_id,$variation_id)
    {
        $sql = "SELECT * FROM purchase_items WHERE item_id = '$item_id' AND variation_id = $variation_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function insert_order_item($item_id,$order_id,$v_id){
        $item_data = $this->item_data($item_id);
        $item_name = $item_data->item_name;
        $price = $this->purchase_item_data($item_id,$v_id)->selling_price;

        //same item click
        if ($this->order_item_available($item_id,$order_id,$v_id) > 0) {
            //update quantity by 1
            $sql = "UPDATE order_item set qty = qty + 1 WHERE item_id = '$item_id' AND order_id = $order_id AND variation_id = $v_id";
            $this->db->query($sql);
        }
        else{
            $data = array(
                'order_id' => $order_id,
                'item_id' => $item_id,
                'item_name' => $item_name,
                'amount' => $price,
                'variation_id' => $v_id
            );
            $this->db->insert('order_item', $data);
        }
    }

    public function update_total($order_id,$total){
        $data = array(
            'total' => $total
        );
        
        $this->db->where('id', $order_id);
        $this->db->update('orders', $data);
    }

    public function order_discount($order_id){
        $sql = "SELECT * FROM orders WHERE id = $order_id LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->discount;
    }

    public function delete_order_item($id){
        $sql = "DELETE FROM order_item WHERE id = $id";
        $query = $this->db->query($sql);
    }

    public function clear_items($order_id){
        $sql = "DELETE FROM order_item WHERE order_id = $order_id";
        $query = $this->db->query($sql);
    }

    public function order_total($order_id){
        $sql = "SELECT * FROM orders WHERE id = $order_id LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->total;
    }

    public function add_discount($order_id,$discount,$type){

        if ($type == 1) { //amount
            $dis = $discount;
        }
        if ($type == 2) { //%
            $dis = $this->order_total($order_id)*$discount/100;
        }

        $data = array(
            'discount' => $dis
        );
        
        $this->db->where('id', $order_id);
        $this->db->update('orders', $data);
    }
    
    // No of items of an Order
    public function item_count($order_id)
    {
        $sql = "SELECT * FROM order_item WHERE order_id = $order_id";
        $query = $this->db->query($sql);
        $count = $query->num_rows();
        return $count;
    }

    public function hold_order($order_id){
        $data = array(
            'status' => 2
        );

        // Hold an order if there are items
        if ($this->item_count($order_id) > 0) {
            $this->db->where('id', $order_id);
            $this->db->update('orders', $data);
        }
    }

    public function last_bill_no(){
        $sql = "SELECT bill_no FROM bill_item ORDER BY created DESC LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        $count = $query->num_rows();

        if ($count == 0) {
            return 999;
        }
        else{
            return $row->bill_no;
        }
    }

    public function paid_order($order_id){
        $data = array(
            'status' => 1
        );
        
        $this->db->where('id', $order_id);
        $this->db->update('orders', $data);
    }

    public function is_same_order_id($order_id){
        $sql = "SELECT order_id FROM bill_item WHERE order_id = $order_id";
        $query = $this->db->query($sql);
        $conut = $query->num_rows();

        return $conut;
    }

    public function insert_order($order_id,$bill_no,$sub_total,$discount,$p_amount,$p_method){
        // Same order in bill item is not acceptable
        if ($this->is_same_order_id($order_id) == 0) {
            $data = array(
                'order_id' => $order_id,
                'bill_no' => $bill_no,
                'total' => $sub_total,
                'discount' => $discount,
                'payment' => $p_amount,
                'payment_method' => $p_method
            );
            $this->db->insert('bill_item', $data);
            return true;
        }
        else{
            return false;
        }
    }
    
    public function insert_multipay($order_id,$bill_no,$p_cash,$p_card,$sub_total){
        if ($this->is_same_order_id($order_id) == 0) {
            $data = array(
                'order_id' => $order_id,
                'bill_no' => $bill_no,
                'cash' => $p_cash,
                'card' => $p_card,
                'total' => $sub_total
            );
            $this->db->insert('multi_pay', $data);
            return true;
        }
        else{
            return false;
        }
    }

    public function bill_data($bill_no){
        $sql = "SELECT * FROM bill_item WHERE bill_no = $bill_no LIMIT 1";
        $query = $this->db->query($sql);
        return $row = $query->first_row();
    }

    public function order_data($order_id){
        $sql = "SELECT * FROM orders WHERE order_id = $order_id LIMIT 1";
        $query = $this->db->query($sql);
        return $row = $query->first_row();
    }

    public function order_tbl_data($order_id){
        $sql = "SELECT * FROM orders WHERE id = $order_id LIMIT 1";
        $query = $this->db->query($sql);
        return $row = $query->first_row();
    }

    public function reminder_available($vehicle_no,$contact_no){
        $sql = "SELECT id FROM reminder WHERE vehicle_no = '$vehicle_no' AND contact_no = $contact_no";
        $query = $this->db->query($sql);
        $conut = $query->num_rows();

        return $conut;
    }


    public function last_order_no(){
        $sql = "SELECT order_no FROM orders ORDER BY created DESC LIMIT 1";
        $query = $this->db->query($sql);
        $count = $query->num_rows();

        if ($count == 0) {
            //First bill number
            return 1;
        }
        else{
            //last bill number
            $row = $query->first_row();
            return $row->order_no;
        }
    }

    public function service_amount($service){
        $sql = "SELECT amount FROM service WHERE service = '$service'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->amount;
    }

    public function insert_reminder($vehicle_no,$contact_no,$reminder){
        $data = array(
            'vehicle_no' => $vehicle_no,
            'contact_no' => $contact_no,
            'reminder' => $reminder
        );
        $this->db->insert('reminder', $data);
    }

    public function update_reminder($vehicle_no,$reminder){
        $data = array(
            'reminder' => $reminder
        );
        
        $this->db->where('vehicle_no', $vehicle_no);
        $this->db->update('reminder', $data);
    }

    public function update_contact_no($vehicle_no, $contact_no,$cus_name){
        $sql = "UPDATE vehicles SET contact_no = $contact_no, customername = '$cus_name' WHERE vehicle_no = '$vehicle_no'";
        $query = $this->db->query($sql);
    }

    public function insert_full_service($order_id,$oil_used,$oil_filter,$ofname,$air_filter,$afname,$c_filter,$cfname){
        $sql = "INSERT INTO full_service
        (order_id,oil_used,oil_filter,ofname,air_filter,afname,c_filter,cfname)
        VALUES ($order_id,'$oil_used','$oil_filter','$ofname','$air_filter','$afname','$c_filter','$cfname')";
        $query = $this->db->query($sql);

        return $query;
    }

    public function new_vehicle($vehicle_no){
        $sql = "SELECT * FROM vehicles WHERE vehicle_no = '$vehicle_no'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function insert_vehicle($vehicle_no, $contact_no,$cus_name){
        $sql = "INSERT INTO vehicles
        (vehicle_no,contact_no,customername)
        VALUES ('$vehicle_no', $contact_no,'$cus_name')";
        $query = $this->db->query($sql);
    }

    public function view_order($bill_no){
        $sql = "SELECT * FROM orders o LEFT JOIN bill_item b ON o.id=b.order_id WHERE b.bill_no = $bill_no";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }
    
    public function full_service($order_id){
        $sql = "SELECT * FROM full_service WHERE order_id = $order_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function get_bill_years(){
        $sql = "SELECT YEAR(bill_date) as bill_year FROM orders GROUP BY bill_year";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function edit_order($bill_no){
        $sql = "SELECT * FROM orders WHERE bill_no = $bill_no";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function update_order($cus_name,$bill_no,$vehicle_no,$contact_no,$bill_date,$type,$make,$discount){
        $data = array(
            'customer_name' => $cus_name,
            'vehicle_no' => $vehicle_no,
            'contact_no' => $contact_no,
            'bill_date' => $bill_date,
            'type' => $type,
            'make' => $make,
            'discount' => $discount
            
        );
        
        $this->db->where('bill_no', $bill_no);
        $this->db->update('orders', $data);
    }

    /*public function update_customer($vehicle_no,$contact_no){
        $data = array(
            'vehicle_no' => $vehicle_no,
            'contact_no' => $contact_no
        );
        
        $this->db->where('order_id', $order_id);
        $this->db->update('orders', $data);
    }*/


    public function update_int($item_id){

        $sql = "SELECT stock FROM int_items WHERE item_id = '$item_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        $current_stock = $row->stock;
        $new_stock = $current_stock-1;

        $data = array(
            'stock' => $new_stock
        );
        
        $this->db->where('item_id', $item_id);
        $this->db->update('int_items', $data);
    }

    public function reupdate_int($item_id){
        $sql = "SELECT stock FROM int_items WHERE item_id = '$item_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        $current_stock = $row->stock;
        $new_stock = $current_stock+1;

        $data = array(
            'stock' => $new_stock
        );
        
        $this->db->where('item_id', $item_id);
        $this->db->update('int_items', $data);
    }

    public function get_service($order_id){
        $sql = "SELECT service FROM orders WHERE order_id = '$order_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->service;
    }

    public function fullservice($order_id){
        $sql = "SELECT * FROM full_service WHERE order_id = '$order_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function delete_fullservice($order_id){
        $sql = "DELETE FROM full_service WHERE order_id=$order_id";
        $query = $this->db->query($sql);
    }

    public function delete_bill_item($order_id){
        $sql = "DELETE FROM bill WHERE order_id=$order_id";
        $query = $this->db->query($sql);
    }

    public function bill_order($order_id){
        $sql = "SELECT * FROM orders WHERE order_id = '$order_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }
    
    public function insert_bill($order_id,$bill_no,$bill_date,$vehicle_no,$service,$service_type,$quantity,$price,$discount){
        $data = array(
            'order_id' => $order_id,
            'bill_no' => $bill_no,
            'bill_date' => $bill_date,
            'vehicle_no' => $vehicle_no,
            'service' => $service,
            'service_type' => $service_type,
            'quantity' => $quantity,
            'price' => $price,
            'discount' => $discount
        );
        $this->db->insert('bill', $data);
    }

    public function is_bill_available($order_id){
        $sql = "SELECT * FROM bill WHERE order_id = $order_id";
        $query = $this->db->query($sql);
        
        if ($query->num_rows() >= 1) {
            return true;
        }
        else{
            return false;
        }
    }

    public function bill_items($order_id){
        $sql = "SELECT * FROM bill WHERE order_id = $order_id";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function insert_bill_item($order_id,$item,$price,$qty){
        $data = array(
            'order_id' => $order_id,
            'service' => $item,
            'service_type' => 2,
            'quantity' => $qty,
            'unit_price' => $price
        );
        $this->db->insert('bill', $data);
    }

    public function update_bill_status($order_id){
        $data = array(
            'status' => 1
        );
        
        $this->db->where('order_id', $order_id);
        $this->db->update('bill', $data);
    }

    //Bill Details for Print Page
    public function get_bill_details($order_id){
        $sql = "SELECT * FROM bill WHERE order_id = $order_id ORDER BY created ASC";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function order_bill_details($order_id){
        $sql = "SELECT * FROM orders WHERE order_id = $order_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function show_int_item($item_id){
        $sql = "SELECT * FROM int_items WHERE item_id = '$item_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function bill_status($order_id){
        $sql = "SELECT * FROM bill WHERE order_id = $order_id AND status = 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            return 1;
        }
        else{
            return 0;
        }
    }

    public function bills_confirmed(){
        $sql = "SELECT * FROM bill WHERE status = 1 GROUP BY order_id";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function locations(){
        $sql = "SELECT * FROM location";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function insert_expense($ex_date,$location,$ref_no,$name,$des,$cat,$method,$amount,$check_date,$paid){
        $logged = $this->session->user_id;
        $data = array(
            'ex_date' => $ex_date,
            'location' => $location,
            'ref_no' => $ref_no,
            'payee_name' => $name,
            'description' => $des,
            'catogery' => $cat,
            'method' => $method,
            'amount' => $amount,
            'entered' => $logged,
            'check_date' => $check_date,
            'paid' => $paid
        );
        $this->db->insert('expense', $data);
    }

    public function insert_order_service($service_id,$bill_no){
        $service_data = $this->service_data($service_id); //468

        $service_id = $service_id;
        $service =$service_data->service;
        $amount = $service_data->amount;

        $data = array(
            'bill_no' => $bill_no,
            'service_id' => $service_id,
            'service' => $service,
            'amount' => $amount
        );
        $this->db->insert('order_service', $data);
    }

    public function service_data($service_id){
        $sql = "SELECT * FROM service WHERE service_id = $service_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function is_selected_services($bill_no){
        $sql = "SELECT id FROM order_service WHERE bill_no = $bill_no";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function order_service($bill_no){
        $sql = "SELECT * FROM order_service WHERE bill_no = $bill_no";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function deleteOrderService($id){
        $sql = "DELETE FROM order_service WHERE id=$id";
        $query = $this->db->query($sql);
    }

    public function items(){
        $sql = "SELECT * FROM purchase_items
        INNER JOIN int_items ON int_items.item_id = purchase_items.item_id";

        //$sql = "SELECT * FROM purchase_items WHERE item_id IN (SELECT item_id FROM int_items)";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }


    public function purchase_data($p_id){
        $sql = "SELECT * FROM purchase_items WHERE id = $p_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function check_qunatity($item_id){
        $sql = "SELECT * FROM purchase_items WHERE item_id = '$item_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }


    public function is_selected_item($bill_no){
        $sql = "SELECT id FROM order_item WHERE bill_no = $bill_no";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function order_item($bill_no){
        $sql = "SELECT * FROM order_item o LEFT JOIN bill_item b ON o.order_id=b.order_id
        WHERE b.bill_no = $bill_no";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function deleteOrderItem($id){
        $sql = "DELETE FROM order_item WHERE id=$id";
        $query = $this->db->query($sql);
    }

    public function update_order_service($bill_no){
        $data = array(
            'status' => 1
        );
        
        $this->db->where('bill_no', $bill_no);
        $this->db->update('order_service', $data);
    }

    public function update_order_item($bill_no){
        $data = array(
            'status' => 1
        );
        
        $this->db->where('bill_no', $bill_no);
        $this->db->update('order_item', $data);
    }

    //Check  service for order validation
    public function order_service_available($service_id,$bill_no){
        $sql = "SELECT id FROM order_service WHERE bill_no = $bill_no AND service_id = $service_id";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function item_qty($item_id,$bill_no){
        $sql = "SELECT * FROM order_item WHERE bill_no = $bill_no AND item_id = '$item_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->qty;
    }

    public function update_qty($item_id,$bill_no,$qty){
        $total_qty = $qty + $this->item_qty($item_id,$bill_no);
        $data = array(
            'qty' => $total_qty
        );
        
        $this->db->where('bill_no', $bill_no);
        $this->db->where('item_id', $item_id);
        $this->db->update('order_item', $data);
    }


    public function update_img($bill_no,$img){
        $data = array(
            'image' => $img
        );
        
        $this->db->where('bill_no', $bill_no);
        $this->db->update('orders', $data);
    }

    public function get_order_items(){
        $order_no = $this->last_order_no()+1;
        $sql = "SELECT * FROM order_item WHERE order_no = $order_no";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_last_quantity($p_id){
        $sql = "SELECT * FROM int_qty WHERE purchase_id = $p_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->quantity;
    }

    public function get_order_quantity($bill_no,$p_id){
        $sql = "SELECT * FROM order_item WHERE purchase_id = $p_id AND bill_no = $bill_no";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->qty;
    }
    //Reduce quantity
    public function update_quantity($bill_no){

        $items = $this->get_order_items($bill_no);

        foreach ($items as $item) {
            $p_id = $item->purchase_id;
            $old_qty = $this->get_last_quantity($p_id);
            $qty = $this->get_order_quantity($bill_no,$p_id);
            $new_qty = $old_qty - $qty;

            $data = array(
            'quantity' => $new_qty
            );
            
            $this->db->where('purchase_id', $p_id);
            $this->db->update('int_qty', $data);
        }
    }
    //last purchase item id
    public function last_purchase_item(){
        $sql = "SELECT id FROM purchase_items ORDER BY created_at DESC LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->id;   
    }
    public function get_item_id($p_id){
        $sql = "SELECT * FROM purchase_items WHERE id = $p_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->item_id;
    }

    public function insert_vehicle_type($v_type){
        $data = array(
            'type' => $v_type
        );
        $this->db->insert('type', $data);
    }

    public function insert_vehicle_make($v_make){
        $data = array(
            'make' => $v_make
        );
        $this->db->insert('make', $data);
    }

    public function get_order_service($bill_no){
        $sql = "SELECT * FROM order_service WHERE bill_no = $bill_no";
        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();

        if ($count > 0) {
            return $result;
        }
        else{
            return null;
        }
        
    }

    public function items_for_service($service_id){
        $sql = "SELECT * FROM int_setting WHERE service_id = $service_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();

        if ($count > 0) {
            return $result;
        }
        else{
            return null;
        }
        
    }

    public function current_quantity($item_id){
        $sql = "SELECT * FROM purchase_items WHERE item_id = '$item_id' LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->quantity;
    }

    public function get_older_item($item_id){
        $sql = "SELECT * FROM purchase_items WHERE item_id = '$item_id' ORDER BY created_at ASC LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->id;
    }

    public function update_service_qty($new_qty,$item_id){
            $p_id = $this->get_older_item($item_id);
            $data = array(
                'quantity' => $new_qty
            );
            
            $this->db->where('id', $p_id);
            $this->db->update('quantity', $data);
    }

    public function item_name($id){
        $sql = "SELECT item_name FROM int_items WHERE item_id = '$id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->item_name;
    }

    public function purchase_items(){
        $sql = "SELECT * FROM int_qty ORDER BY item_id DESC LIMIT 12";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function search_items($search_text){
        $sql = "SELECT * FROM int_qty WHERE item_id IN (SELECT item_id FROM int_items WHERE item_name LIKE '%$search_text%')";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function item_names($keyword)
    {
        $sql = "SELECT * FROM int_items WHERE item_name LIKE '%$keyword%' LIMIT 6";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function search_item_id($search_text){
        $sql = "SELECT * FROM int_qty WHERE item_id LIKE '$search_text'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function order_item_data($order_id){
        $sql = "SELECT * FROM order_item WHERE order_id = $order_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function noofitems($order_id){
        $sql = "SELECT * FROM order_item WHERE order_id = $order_id";
        $query = $this->db->query($sql);
        $count = $query->num_rows();
        return $count;
    }

    public function noofpcs($order_id){
        $sql = "SELECT * FROM order_item WHERE order_id = $order_id";
        $query = $this->db->query($sql);
        $result = $query->result();

        $qty = 0;
        foreach ($result as $itm) {
            $qty = $qty+$itm->qty;
        }
        return $qty;
    }

    public function barcode($id){
        $sql = "SELECT barcode FROM int_items WHERE item_id = '$id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->barcode;
    }

    public function item_id_of_barcode($barcode)
    {
        $sql = "SELECT item_id FROM int_items WHERE barcode = '$barcode'";
        $query = $this->db->query($sql);
        $count = $query->num_rows();
        if ($count == 1) {
            $row = $query->first_row();
            return $row->item_id;
        }
        else{
            return 0;
        }
        
    }

    public function search_items_available($search_id)
    {
        $item_id = $this->item_id_of_barcode($search_id);
        $sql = "SELECT * FROM purchase_items WHERE item_id = '$item_id'";
        $query = $this->db->query($sql);
        $count = $query->num_rows();
        return $count;
    }

    public function get_purcase_id($item_id){
        $sql = "SELECT * FROM purchase_items WHERE item_id = '$item_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->id;
    }

    public function services(){
        $sql = "SELECT * FROM service";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function update_order_qty($id,$dis,$qty)
    {
        $sql = "UPDATE order_item set qty = $qty WHERE id = $id";
        $this->db->query($sql);
    }

    public function update_order_data($id,$dis,$qty,$price)
    {
        $data = array(
            'qty' => $qty,
            'discount' => $dis,
            'amount' => $price
        );
            
        $this->db->where('id', $id);
        $this->db->update('order_item', $data);
    }

    // Get ordered items using order ID 
    
    public function reduce_qty($order_id)
    {
        $sql = "SELECT * FROM order_item WHERE order_id = $order_id";
        $query = $this->db->query($sql);
        $result = $query->result();

        foreach ($result as $item) {
            $item_id = $item->item_id;
            $var_id = $item->variation_id;
            $qty = $item->qty;

            $this->reduce_int_qty($item_id,$var_id,$qty);
        }
    }

    // Update Int Qty 
    public function reduce_int_qty($item_id,$var_id,$qty)
    {
        $sql = "UPDATE int_qty set qty = qty-$qty WHERE item_id = '$item_id' AND variation_id = $var_id";
        $this->db->query($sql);
    }

    // Search Mobile for Order
    public function search_mobile($mobile)
    {
        $sql = "SELECT * FROM customer WHERE mobile LIKE '%$mobile%'";
        $query = $this->db->query($sql);
        $count = $query->num_rows();
        
        if ($count > 0) {
            $result = $query->result();
            return $result;
        }
        else{
            return null;
        }
    }

    public function customer_name($mobile)
    {
        $sql = "SELECT * FROM customer WHERE mobile = '$mobile'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->fname;
    }

    // Check customer is already in db
    public function customer_available($mobile)
    {
        $sql = "SELECT * FROM customer WHERE mobile = '$mobile'";
        $query = $this->db->query($sql);
        $count = $query->num_rows();
        return $count;
    }

    // Update Customer Name with Mobile
    public function update_customer($mobile,$name)
    {
        $data = array(
            'fname' => $name
        );
        
        $this->db->where('mobile', $mobile);
        $this->db->update('customer', $data);
    }

    // Inser Customer Name and Mobile
    public function insert_customer($mobile,$name)
    {
        $data = array(
            'mobile' => $mobile,
            'fname' => $name
        );
        $this->db->insert('customer', $data);
    }

    // Insert Customer Mobile for a Order
    public function order_customer($order_id,$mobile)
    {
        $data = array(
            'customer_mobile' => $mobile
        );
        
        $this->db->where('id', $order_id);
        $this->db->update('orders', $data);
    }
    
    // get order data for API
    public function billData($bill_no)
    {
        $sql = "SELECT * FROM bill_item WHERE bill_no = $bill_no";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    // order items using order_id
    public function orderItems($order_id)
    {
        $sql = "SELECT * FROM order_item WHERE order_id = $order_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    // Order Data
    public function OrderData($order_id)
    {
        $sql = "SELECT * FROM orders WHERE id = $order_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    public function CustomerData($mobile)
    {
        $sql = "SELECT * FROM customer WHERE mobile = '$mobile'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    public function order_customer_is($order_id)
    {
        $sql = "SELECT * FROM orders WHERE id = $order_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        
        if ($row->customer_mobile == NULL) {
            return 0;
        }
        else{
            return 1;
        }
    }

    // Hold Orders Count
    public function hold_order_count()
    {
        $sql = "SELECT * FROM orders WHERE status = 2";
        $query = $this->db->query($sql);
        $count = $query->num_rows();
        return $count;
    }

    // Delete order Items
    public function delete_order_items($order_id)
    {
        $sql = "DELETE FROM order_item WHERE order_id = $order_id";
        $query = $this->db->query($sql);
    }

    // Delete hold order 
    public function delete_hold_order($order_id)
    {
        $sql = "DELETE FROM orders WHERE id = $order_id";
        $query = $this->db->query($sql);

        $this->delete_order_items($order_id);
    }
    
    // Hold Order Items
    public function hold_order_items($order_id){
        $sql = "SELECT * FROM order_item WHERE order_id = $order_id ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

}
/* End of file Oders_model.php and path /application/models/Oders_model.php */
