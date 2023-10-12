<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

        redirect('bo/dashboard');

	}



	public function set_session_date($session_name_, $value_) {
		$value = base64_decode($value_);
		$session_name = base64_decode($session_name_);
		$this->session->set_userdata('search', array($session_name=>$value));
	}
	public function get_session_date($type) {
		$field = 'field-date';
		$date = $this->session->search[$field];
		
		$explode_date = explode(' - ', $date);
		$get_date_1 = explode('/', $explode_date[0]);
		$get_date_2 = explode('/', $explode_date[1]);
		
		$date1 = $get_date_1[1].'-'.$get_date_1[2].'-'.$get_date_1[0];
		$date2 = $get_date_2[1].'-'.$get_date_2[2].'-'.$get_date_2[0];
		
		if (isset($date) && $date!=null) {
			if ($type == 'startDate') {
				echo $date1;
			} else {
				echo $date2;
			}
		} else {
			echo date('m/d/Y');
		}
	}
	
}
