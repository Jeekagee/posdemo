<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Inventory_model extends CI_Model 
{
    public function show_items($cat_id){

        if ($cat_id == 0) {
            $sql = "SELECT * FROM int_items ORDER BY created_at DESC";
        }
        else{
            $sql = "SELECT * FROM int_items WHERE item_catogery = $cat_id ORDER BY created_at DESC";
        }
        
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }
    
    //All item Catogiries
    public function item_catogories(){
        $sql = "SELECT * FROM int_catogery ORDER BY catogery ASC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }


    public function item_catogery($cat_id){
        $sql = "SELECT * FROM int_catogery WHERE cat_id = $cat_id";
        $query = $this->db->query($sql);
        $result = $query->first_row();

        return $result;
    }

    public function item_sub_catogery($cat_id){
        $sql = "SELECT * FROM int_sub_catogery WHERE sub_cat_id = $cat_id";
        $query = $this->db->query($sql);
        $result = $query->first_row();

        return $result;
    }

    public function item_brand($brand_id){
        $sql = "SELECT * FROM int_brand WHERE brand_id = $brand_id";
        $query = $this->db->query($sql);
        $result = $query->first_row();

        return $result;
    }

    public function filter_range($filter_range_id){
        $sql = "SELECT * FROM int_filter_range WHERE filter_range_id = $filter_range_id";
        $query = $this->db->query($sql);
        $result = $query->first_row();

        return $result;
    }

    public function delete($id){
        $this->db->where('item_id', $id);
        $this->db->delete('int_items');
    }

    // validate if already linked with any purchase
    public function delete_items()
    {
        $sql = "SELECT item_id FROM int_items LEFT JOIN purchase_items ON int_items.item_id=purchase_items.item_id
        WHERE int_items.item_id=purchase_items.item_id";
        $query = $this->db->query($sql);
        if ($num_row >= 0) {
            return true;
        }
        else{
            return false;
        }
        
    }

    public function update_stock($item_id,$stock,$price){
        //$sql = "UPDATE int_items SET stock='$stock',price='$price' WHERE item_id=$item_id";
        //$query = $this->db->query($sql);
        $data = array(
            'stock' => $stock,
            'price' => $price
        );
        
        $this->db->where('item_id', $item_id);
        $this->db->update('int_items', $data);
    }

    public function show_sub_cat($catogery){
        $sql = "SELECT * FROM int_sub_catogery WHERE catogery = $catogery";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function show_brand(){
        $sql = "SELECT * FROM int_brand";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function show_frange($catogery){
        $sql = "SELECT * FROM int_filter_range WHERE catogery = $catogery";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function insert_item($barcode,$id,$name,$cat,$subcat,$filter_range,$capacity,$part_number,$brand){
        $data = array(
            'barcode' => $barcode,
            'item_id' => $id,
            'item_name' => $name,
            'item_catogery' => $cat,
            'item_sub_catogery' => $subcat,
            'item_brand' => $brand,
            'filter_range' => $filter_range,
            'part_number' => $part_number,
            'capacity' => $capacity
        );
    
        $this->db->insert('int_items', $data);
    }

    public function edit_inventory($item_id)
    {
        $sql = "SELECT * FROM int_items WHERE item_id=$item_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    public function insert_catogery($catogery){
        $data = array(
            'catogery' => $catogery
        );
        $this->db->insert('int_catogery', $data);
    }

    public function insert_sub_catogery($catogery,$subcatogery){
        $data = array(
            'sub_catogery' => $subcatogery,
            'catogery' => $catogery
        );
        $this->db->insert('int_sub_catogery', $data);
    }


    public function insert_brand($brand){
        $data = array(
            'brand' => $brand
        );
        $this->db->insert('int_brand', $data);
    }

    public function update_inventory($barcode,$item_id,$name,$cat,$subcat,$filter_range,$capacity,$part_number,$brand){
        $logged = $this->session->user_id;
        $data = array(
            'item_name' => $name,
            'barcode' => $barcode,
            'item_catogery' => $cat,
            'item_sub_catogery' => $subcat,
            'item_brand' => $brand,
            'filter_range' => $filter_range,
            'part_number' => $part_number,
            'capacity' => $capacity
            
        );

        $this->db->where('item_id', $item_id);
        $this->db->update('int_items', $data);
    }

    public function show_ret_pro($invoice_no){
        $sql = "SELECT o.id,o.item_name,o.qty,o.amount FROM order_item o LEFT JOIN bill_item b ON o.order_id=b.order_id 
        WHERE b.bill_no = $invoice_no";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function update_status($id,$qty){
        $data = array(
            'sales_return' => 1
        );

        $this->db->where('id', $id);
        $this->db->update('order_item', $data);

        $sql1 = "SELECT * FROM order_item,int_qty WHERE order_item.item_id = int_qty.item_id AND order_item.variation_id = int_qty.variation_id AND order_item.id = $id";
        $query1 = $this->db->query($sql1);
        $row = $query1->first_row();
        
        $item_id = $row->item_id;
        $var_id = $row->variation_id;

        $sql = "UPDATE int_qty set qty = qty+$qty WHERE item_id = $item_id AND variation_id = $var_id";
        $this->db->query($sql);

    }

    // Barcode
    // Purchase items to select
    public function items(){
        $sql = "SELECT * FROM int_qty GROUP BY item_id";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    //Item name
    public function item_data($id)
    {
        $sql = "SELECT * FROM int_items WHERE item_id=$id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    public function purchase_data($id)
    {
        $sql = "SELECT * FROM purchase_items WHERE item_id=$id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }
}


/* End of file Employees_model.php and path /application/models/Employees_model.php */

