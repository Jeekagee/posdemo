<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Purchase_model extends CI_Model 
{
    public function suppiler()
    {
        $sql = "SELECT * FROM supplier";
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
    public function insert_supplier($name,$description){
        $data = array(
            // 'id' => $id,
            'supplier' => $name,
            'description' => $description,
           // 'location_id' => $loc,
        );
    
        $this->db->insert('supplier', $data);
    }
    public function insert_location($name){
        $data = array(
            'location' => $name,
        );
    
        $this->db->insert('location', $data);
    }
    public function delete_location($id){
        $sql = "DELETE FROM location WHERE id='$id'";
        $query = $this->db->query($sql);
    }
    public function get_location($id){
        $sql = "SELECT * FROM location WHERE id = '$id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }
    public function insert_purchase($supplier,$rec_date,$location,$notes,$ref_no,$method,$check_date,$status){
        $data = array(
            'supplier' => $supplier,
            'rec_date' => $rec_date,
            'location' => $location,
            'notes' => $notes,
            'ref_no' => $ref_no,
            'method' => $method,
            'check_date' => $check_date,
            'status' => $status
        );
        $this->db->insert('purchase', $data);
    }

    public function same_item($purchase_id,$s_price,$p_price,$ex_date,$item_id){
        $sql = "SELECT * FROM purchase_items WHERE purchase_id = $purchase_id AND selling_price = $s_price AND purchase_price = $p_price AND ex_date = '$ex_date' AND item_id = '$item_id'";
        $query = $this->db->query($sql);
        $result = $query->num_rows();

        return $result;
    }

    public function same_variation($s_price,$p_price,$item_id)
    {
        $sql = "SELECT * FROM purchase_items WHERE selling_price = $s_price AND purchase_price = $p_price AND item_id = '$item_id'";
        $query = $this->db->query($sql);
        $count = $query->num_rows();

        return $count;
    }

    public function get_variation_id($s_price,$p_price,$item_id)
    {
        $sql = "SELECT * FROM purchase_items WHERE selling_price = $s_price AND purchase_price = $p_price AND item_id = '$item_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->variation_id;
    }

    public function item_id_avaiable($item_id)
    {
        $sql = "SELECT * FROM purchase_items WHERE item_id = '$item_id'";
        $query = $this->db->query($sql);
        $count = $query->num_rows();

        return $count;
    }

    public function last_varient_id($s_price,$p_price,$item_id)
    {
        $sql = "SELECT * FROM purchase_items WHERE item_id = '$item_id' ORDER BY variation_id DESC";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->variation_id;
    }

    // Variation ID Creation
    public function variation_id($s_price,$p_price,$item_id)
    {
        if ($this->item_id_avaiable($item_id) == 0) { // New Item
            $var_id = 1;
        }
        else{
            if ($this->same_variation($s_price,$p_price,$item_id) > 0) { // Same Variant Item
                $var_id = $this->get_variation_id($s_price,$p_price,$item_id);
            }
            else{ // New Varient
                $var_id = $this->last_varient_id($s_price,$p_price,$item_id)+1;
            }
        }
        return $var_id;
    }
    

    public function item_available($item_id){
        $sql = "SELECT * FROM int_items WHERE item_id = '$item_id'";
        $query = $this->db->query($sql);
        $result = $query->num_rows();

        return $result;
    }

    public function get_qty($s_price,$p_price,$ex_date,$item_id){
        $sql = "SELECT * FROM purchase_items WHERE selling_price = $s_price AND purchase_price = $p_price AND ex_date = '$ex_date' AND item_id = '$item_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row->quantity;
    }

    public function update_qty($id,$qty){
        $sql = "UPDATE purchase_items SET quantity = quantity + $qty WHERE id = $id";
        $query = $this->db->query($sql);
    }

    public function insert_purchase_item($item,$quantity,$purchase_id,$s_price,$p_price,$ex_date,$var_id){
        $data = array(
            'purchase_id' => $purchase_id,
            'item_id' => $item,
            'quantity' => $quantity,
            'selling_price' => $s_price,
            'purchase_price' => $p_price,
            'ex_date' => $ex_date,
            'variation_id' => $var_id
        );

        $this->db->insert('purchase_items', $data);
    }

    public function last_purchase(){
        $sql = "SELECT * FROM purchase ORDER BY created_at DESC LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function items($id){
        $sql = "SELECT * FROM purchase_items WHERE purchase_id = $id";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function avai_items($id){
        $sql = "SELECT * FROM purchase_items WHERE purchase_id = $id";
        $query = $this->db->query($sql);
        $result = $query->num_rows();

        return $result;
    }

    public function save_items($id){
        $data = array(
            'status' => 1
        );
        
        $this->db->where('purchase_id', $id);
        $this->db->update('purchase_items', $data);
    }

    public function new_int_qty($item_id,$var_id)
    {
        $sql = "SELECT * FROM int_qty WHERE item_id = $item_id AND variation_id = $var_id";
        $query = $this->db->query($sql);
        $count = $query->num_rows();

        return $count;
    }

    public function insert_int_qty($item_id,$var_id,$qty)
    {
        $data = array(
            'item_id' => $item_id,
            'qty' => $qty,
            'variation_id' => $var_id
        );
        $this->db->insert('int_qty', $data);
    }

    public function update_item_qty($item_id,$var_id,$qty)
    {
        if ($this->new_int_qty($item_id,$var_id) == 0) { // New item 
            $this->insert_int_qty($item_id,$var_id,$qty); // Insert int_qty
        }
        else{ // Update qty of the varient
            $sql = "UPDATE int_qty SET qty = qty + $qty WHERE item_id = $item_id AND variation_id = $var_id";
            $query = $this->db->query($sql);
        }
        
    }
    

    public function update_item_qty_tbl($pur_id)
    {
        $sql = "SELECT * FROM purchase_items WHERE purchase_id = $pur_id";
        $query = $this->db->query($sql);
        $result = $query->result();

        foreach ($result as $items) {
            $item_id = $items->item_id;
            $var_id = $items->variation_id;
            $qty = $items->quantity;

            $this->update_item_qty($item_id,$var_id,$qty);
        }
    }

    public function cancel_items($id){
        $sql = "DELETE FROM purchase_items WHERE purchase_id=$id";
        $query = $this->db->query($sql);
    }

    public function purchase_summery(){
        $sql = "SELECT * FROM purchase_items p LEFT JOIN int_items i ON p.item_id=i.item_id 
        ORDER BY p.created_at DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function purchase_data($pur_id){
        $sql = "SELECT * FROM purchase WHERE id = $pur_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    
    }

    public function intqty_data($id,$var_id){
        $sql = "SELECT qty FROM int_qty WHERE item_id = '$id' AND variation_id= '$var_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    
    }

    public function supplier($id){
        $sql = "SELECT * FROM supplier WHERE id = $id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    }

    public function item_list($item){
        $sql = "SELECT * FROM int_items WHERE item_id LIKE '%$item%'";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function get_item_price($item_id){
        $sql = "SELECT * FROM int_items WHERE item_id = '$item_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->price;
    }

    public function get_item_name($item_id){
        $sql = "SELECT item_name FROM int_items WHERE item_id = '$item_id'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->item_name;
    }

    public function delete_purchase($id)
    {
        $sql = "DELETE FROM purchase_items WHERE id=$id";
        $query = $this->db->query($sql);
    }

    public function view_purchase($id)
    {
        $sql = "SELECT * FROM purchase_items WHERE id=$id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    public function update_sellingprice($id,$price,$quantity)
    {
        $data = array(
            'selling_price' => $price
        );
        
        $this->db->where('id', $id);
        $this->db->update('purchase_items', $data);

        $sql1 = "SELECT * FROM purchase_items,int_qty WHERE purchase_items.item_id = int_qty.item_id AND purchase_items.variation_id = int_qty.variation_id AND purchase_items.id = $id";
        $query1 = $this->db->query($sql1);
        $row = $query1->first_row();

        $item_id = $row->item_id;
        $var_id = $row->variation_id;

        $sql = "UPDATE int_qty set qty = $quantity WHERE item_id = $item_id AND variation_id = $var_id";
        $this->db->query($sql);
    }
    
    public function fill_item_name($item_id){
        $sql = "SELECT item_name FROM int_items WHERE item_id = '$item_id' OR barcode = '$item_id'";
        $query = $this->db->query($sql);
        $count = $query->num_rows();
        $row = $query->first_row();

        if ($count == 1) {
            return $row->item_name;
        }
        else{
            return null;
        }
        
    }
    

    public function last_purchase_id(){
        $sql = "SELECT * FROM purchase_items ORDER BY created_at DESC";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->id;
    }

    public function insert_item_qty($item,$last_purchase_id,$quantity){
        $data = array(
            'purchase_id' => $last_purchase_id,
            'qty' => $quantity,
            'item_id' => $item
        );

        $this->db->insert('int_qty', $data);
    }

    
    public function item_purchase_id($purchase_id,$s_price,$p_price,$ex_date,$item){
        $sql = "SELECT * FROM purchase_items WHERE purchase_id = $purchase_id AND selling_price = $s_price AND purchase_price = $p_price AND ex_date = '$ex_date' AND item_id = '$item'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->id;
    }

    public function get_item_id($item)
    {
        $sql = "SELECT item_id FROM int_items WHERE item_id = '$item' OR barcode = '$item'";
        $query = $this->db->query($sql);
        $count = $query->num_rows();
        if ($count == 0) {
            return $count;
        }
        else{
            $row = $query->first_row();
            return $row->item_id;
        }
        
    }

    public function supplier_summary()
    {
        $sql = "SELECT * FROM supplier";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function view_summary($id)
    {
        $sql = "SELECT p.id, t.item_id, t.purchase_price, p.method, p.check_date, p.status,t.created_at
        FROM purchase p LEFT JOIN purchase_items t ON p.id=t.purchase_id WHERE supplier=$id ORDER BY p.created_at DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }
    
    public function total_purchase($id)
    {
        $sql = "SELECT p.id, t.purchase_price
        FROM purchase p LEFT JOIN purchase_items t ON p.id=t.purchase_id WHERE supplier=$id ORDER BY p.created_at DESC";
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

    public function credit_balance($id)
    {
        $sql = "SELECT p.id, t.purchase_price
        FROM purchase p LEFT JOIN purchase_items t ON p.id=t.purchase_id WHERE supplier=$id AND p.status='0' ORDER BY p.created_at DESC";
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
    
    public function credit_pay($id){
        $data = array(
            'status' => 1
        );
        
        $this->db->where('id', $id);
        $this->db->update('purchase', $data);
    }

    public function show_pur_return($ref_no){
        $sql = "SELECT i.id,i.purchase_id,i.item_id,i.quantity,i.purchase_price, p.method,p.rec_date,i.return_quantity FROM purchase_items i 
        LEFT JOIN purchase p ON i.purchase_id=p.id 
        WHERE p.ref_no = $ref_no";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function update_purchasereturn($id,$qty,$curqty){
        $data = array(
            'purchase_return' => 1,
            // 'return_quantity' => $curqty+$qty
        );

        $this->db->where('id', $id);
        $this->db->update('purchase_items', $data);

        $sql1 = "SELECT * FROM purchase_items,int_qty WHERE purchase_items.item_id = int_qty.item_id AND purchase_items.variation_id = int_qty.variation_id AND purchase_items.id = $id";
        $query1 = $this->db->query($sql1);
        $row = $query1->first_row();
        
        $item_id = $row->item_id;
        $var_id = $row->variation_id;

        $sql = "UPDATE int_qty set qty = qty-$qty WHERE item_id = $item_id AND variation_id = $var_id";
        $this->db->query($sql);

    }

    public function update_purchasquantity($id,$qty){


        $sql = "UPDATE purchase_items set return_quantity = return_quantity+$qty WHERE id = $id";
        $this->db->query($sql);

    }
                        
}


/* End of file Purchase_model.php and path /application/models/Purchase_model.php */

