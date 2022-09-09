<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Booking extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Load Model
        $this->load->model('Dashboard_model');
        $data['username'] = $this->Dashboard_model->username();
        
        //Load Model
        $this->load->model('Booking_model');
        //Already logged In
        if (!$this->session->has_userdata('user_id')) {
            redirect('/LoginController/logout');
        }
    }

    public function sent_msg($msg,$contact_no){
        // sent message
        function get_web_page( $url )
        {
        $options = array(
        CURLOPT_RETURNTRANSFER => true, // return web page
        CURLOPT_HEADER => false, // don't return headers
        );
        
        $ch = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $header = curl_getinfo( $ch );
        curl_close( $ch );
        
        return $content;
        }

        $user = "94770280956";
        $password = "";
        $text = urlencode($msg);
        $to = $contact_no;
        
        $baseurl ="http://www.textit.biz/sendmsg";
        $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
        $ret = get_web_page($url);
        $res= explode(":",$ret);
    }
    public function pending()
    {
        $data['page_title'] = 'Pending Booking';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['pendings'] = $this->Booking_model->pending();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        //$data['pending_count'] = $this->Booking_model->pending_bookings();

        $this->load->view('dashboard/layout/header',$data);
        //$this->load->view('aside',$data);
        $this->load->view('booking/pending',$data);
        //$this->load->view('footer');
        $this->load->view('booking/footer');
    }

    public function confirmed()
    {
        $data['page_title'] = 'Confirmed Booking';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['confirmed'] = $this->Booking_model->confirmed();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        //$data['pending_count'] = $this->Booking_model->pending_bookings();

        $this->load->view('dashboard/layout/header',$data);
        //$this->load->view('aside',$data);
        $this->load->view('booking/confirm',$data);
        //$this->load->view('footer');
        $this->load->view('booking/footer');
    }

    public function cancelled()
    {
        $data['page_title'] = 'Cancelled Booking';
        //Logged User
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['cancelled'] = $this->Booking_model->cancelled();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        //$data['pending_count'] = $this->Booking_model->pending_bookings();

        $this->load->view('dashboard/layout/header',$data);
        //$this->load->view('aside',$data);
        $this->load->view('booking/cancel',$data);
        //$this->load->view('footer');
        $this->load->view('booking/footer');
    }

    public function cancel(){
        $id =  $this->uri->segment('3');
        $name =  $this->uri->segment('4');
        $vehicle_no =  $this->uri->segment('5');
        $book_date =  $this->uri->segment('6');
        $book_date =  $this->uri->segment('7');
        $contact_no =  $this->uri->segment('8');
        $this->Booking_model->cancel_booking($id);

        $msg = "";
        $msg .= "Hello ".$owner_name.",<br>Sorry for inconvenience, Your booking has been cancelled.<br>";
		$msg .= "Vehicle No :".$vehicle_no."<br>";
		$msg .= "Any Inquires - 077 2395 955";

        $this->sent_msg($msg,$contact_no);

        redirect('Booking/pending');
    }

    public function cancel_confirm(){
        $id =  $this->uri->segment('3');
        $this->Booking_model->cancel_booking($id);

        redirect('Booking/confirmed');
    }

    public function update(){

        $book_id = $this->input->post('book_id');
        $book_time = $this->input->post('book_time');
        $book_date = $this->input->post('book_date');
        $this->Booking_model->update_booking($book_id,$book_time,$book_date);
    }

    public function confirm(){
        $id =  $this->uri->segment('3');
        $name =  $this->uri->segment('4');
        $vehicle_no =  $this->uri->segment('5');
        $book_date =  $this->uri->segment('6');
        $book_date =  $this->uri->segment('7');
        $contact_no =  $this->uri->segment('8');

        $msg = "";
        if ($this->Booking_model->confirm_booking($id)) {
            $msg .= "Hello ".$name.",<br>Thank you for find us! Your Booking has been confirmed<br>";
            $msg .= "Vehicle No :".$vehicle_no."<br>";
            $msg .= "Date :".$book_date."<br>";
            $msg .= "Time :".$book_date."<br>";
            $msg .= "Any Inquires - 077 2395 955";
        }

        $this->sent_msg($msg,$contact_no);

        //Flash Msg
        $this->session->set_flashdata('message',"<div class='alert alert-success'>Booking has been confirmed of $name</div>");
        
        redirect('Booking/pending');
        
        
    }

    public function done(){
        $id =  $this->uri->segment('3');
        $name =  $this->uri->segment('4');
        $this->Booking_model->done_booking($id);

        
        //Flash Msg
        $this->session->set_flashdata('message',"<div class='alert alert-success'>Booking has been Finished of $name</div>");
            
        redirect('Booking/confirmed');
    }
}

/* End of file Employees.php and path /application/controllers/Employees.php */


