<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_website extends CI_Model {
	public function __construct(){
		parent::__construct();
		
		date_default_timezone_set('Asia/Jakarta');

	}

    public function myPagination($count,$page){
//        $count = $this->M_crud->count_data($table, $field, $where);
        $config = array();
        $config["base_url"] 				= "#";
        $config["total_rows"] 			= $count;
        $config["per_page"] 				= $page;
        $config["uri_segment"] 			= 4;
        $config["num_links"] 				= 1;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination pagination-sm">';
        $config["full_tag_close"] = '</ul>';
        $config['first_link'] = '&laquo;';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config['last_link'] = '&raquo;';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $this->pagination->initialize($config);
        $hal  	 = $this->uri->segment(4);
        return $data = array(
            'start'  => ($hal - 1) * $config["per_page"],
            'per_page'=> $config["per_page"],
            'pagination_link' => $this->pagination->create_links()
        );
    }

}
