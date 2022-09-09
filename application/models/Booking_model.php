<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Booking_model extends CI_Model 
{
    public function pending()
    {
        $sql = "SELECT * FROM booking WHERE status = 0 AND cancel = 0 ORDER BY created_at DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function pending_count()
    {
        $sql = "SELECT * FROM booking WHERE status = 0 AND cancel = 0 ORDER BY created_at DESC";
        $query = $this->db->query($sql);
        $result = $query->num_rows();

        return $result;
    }

    public function confirmed()
    {
        $sql = "SELECT * FROM booking WHERE status = 1 AND action = 0 AND cancel = 0 ORDER BY created_at DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function cancelled()
    {
        $sql = "SELECT * FROM booking WHERE cancel = 1 ORDER BY updated_at DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function pending_bookings()
    {
        $sql = "SELECT * FROM booking WHERE status = 0 AND cancel = 0 ORDER BY created_at DESC";
        $query = $this->db->query($sql);
        return $query->num_rows();
        
    }

    public function cancel_booking($id){
        $sql = "UPDATE booking SET cancel=1 WHERE book_id=$id";
        $query = $this->db->query($sql);
    }

    public function update_booking($id,$book_time,$book_date){
        $sql = "UPDATE booking SET book_date='$book_date',book_time='$book_time' WHERE book_id=$id";
        $query = $this->db->query($sql);
    }

    public function confirm_booking($id){
        $sql = "UPDATE booking SET status=1 WHERE book_id=$id";
        $query = $this->db->query($sql);
        return $query;
    }

    public function done_booking($id){
        $sql = "UPDATE booking SET action=1 WHERE book_id=$id";
        $query = $this->db->query($sql);
    }
               
}


/* End of file Employees_model.php and path /application/models/Employees_model.php */

