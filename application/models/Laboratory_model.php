<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Laboratory_model extends CI_Model 
{
    public function invoice_no(){
        $sql = "SELECT id FROM lab_service ORDER BY created DESC";
        $query = $this->db->query($sql);
        $conut = $query->num_rows();
        $row = $query->first_row();

        if ($conut == 0) {
            return 1;
        }
        else{
            return $row->id+1;
        }
    }   
    
    public function locations(){
        $sql = "SELECT * FROM location";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function titles(){
        $sql = "SELECT * FROM title";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function services(){
        $sql = "SELECT * FROM service";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function doctors(){
        $sql = "SELECT * FROM doctor";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function service_charge($service,$location){
        $sql = "SELECT * FROM service_amount WHERE service_id = $service AND location_id = $location";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->amount;
    }

    public function insert_lab_service($id,$nic,$location,$doctor,$comment){
        $data = array(
            'invoice_no' => $id,
            'user_id' => $this->session->user_id,
            'patient_nic' => $nic,
            'location_id' => $location,
            'doctor_id' => $doctor,
            'comment' => $comment,
        );
    
        $this->db->insert('lab_service', $data);
    }

    public function view_services(){
        $sql = "SELECT * FROM lab_service ORDER BY updated DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function patient_detail($nic){
        $sql = "SELECT * FROM patient WHERE nic = '$nic' LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    public function get_location($id){
        $sql = "SELECT * FROM location WHERE id = $id LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->location;
    }

    public function get_service($id){
        $sql = "SELECT service FROM service WHERE service_id = $id LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->service;
    }

    public function get_doctor($id){
        $sql = "SELECT * FROM doctor WHERE id = $id LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    public function single_service($id){
        $sql = "SELECT * FROM lab_service WHERE id = $id LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    public function update_lab_service($id,$nic,$location,$service,$charge,$doctor,$comment){
        $data = array(
            'user_id' => $this->session->user_id,
            'patient_nic' => $nic,
            'lab_service_id' => $service,
            'location_id' => $location,
            'amount' => $charge,
            'doctor_id' => $doctor,
            'comment' => $comment,
        );
        
        $this->db->where('id', $id);
        $this->db->update('lab_service', $data);
    }

    public function delete_service($id)
    {
        $sql = "DELETE FROM lab_service WHERE id=$id";
        $query = $this->db->query($sql);
    }
    public function update_services($invoice_no,$service_id,$location_id,$charge)
    {
        $data = array(
            'invoice_no' => $invoice_no,
            'service_id' => $service_id,
            'location_id' => $location_id,
            'charge' => $charge
        );
    
        $this->db->update('lab_services', $data);
    }
    public function insert_services($invoice_no,$service_id,$location_id,$charge)
    {
        $data = array(
            'invoice_no' => $invoice_no,
            'service_id' => $service_id,
            'location_id' => $location_id,
            'charge' => $charge
        );
    
        $this->db->insert('lab_services', $data);
    }
    public function lab_services($invoice_no){
        $sql = "SELECT * FROM lab_services WHERE invoice_no=$invoice_no";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function addedServices($invoice_no)
    {
        $sql = "SELECT * FROM lab_services WHERE invoice_no = $invoice_no ORDER BY created DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function is_service($invoice_no)
    {
        $sql = "SELECT id FROM lab_services WHERE invoice_no = $invoice_no";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function deleteService($id)
    {
        $sql = "DELETE FROM lab_services WHERE id=$id";
        $query = $this->db->query($sql);
    }

    public function printbill_details($invoice_no)
    {
        $sql = "SELECT lab_service.invoice_no,doctor.name,patient.* FROM lab_service,patient,doctor 
        WHERE lab_service.patient_nic = patient.nic AND lab_service.invoice_no = $invoice_no AND lab_service.doctor_id = doctor.id";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function mobile_list($mobile)
    {
        $sql = "SELECT * FROM patient WHERE mobile LIKE '%$mobile%'";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function patient_name($mobile){
        $sql = "SELECT name FROM patient WHERE mobile = '$mobile'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->name;
    }

    public function patient_nic($mobile){
        $sql = "SELECT nic FROM patient WHERE mobile = '$mobile'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->nic;
    }

    public function patient_address($mobile){
        $sql = "SELECT address FROM patient WHERE mobile = '$mobile'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->address;
    }
}


/* End of file Laboratory_model.php and path \application\models\Laboratory_model.php */