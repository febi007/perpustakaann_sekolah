<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: anash
 * Date: 13/11/2018
 * Time: 04.51
 */

class Bo extends CI_Controller{
	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->output->set_header("Cache-Control: no-store, no-cache, max-age=0, post-check=0, pre-check=0");

	}

    /*
     * 11111 11111 11111 11111 11111 11111 11111 11111 // super && ketua
     * 11111 11111 11111 00000 00000 11111 11111 11111 // sekretaris
     * 00000 00000 00000 11111 11111 00000 00000 00000 // bendahara
     */



    public function access_denied(){
        if($this->session->akses == 'siswa'){
            $this->session->sess_destroy();
            redirect("auth/auth_siswa");
        }
    }


	public function dashboard(){
//        $this->access_denied();
		$page = 'dashboard';
		$data = array(
			'page'=>$page,
			'user'=>'a',
			'isi'=>'bo/pages/'.$page,
        );
		$this->load->view('bo/layout/wrapper',$data);
	}

    public function buku($action=null){
        $page	= 'buku';
        $table	= 'tbl_buku';
        $where	= null;
        $data 	= array('page'=>$page,'isi'=>'bo/pages/'.$page);
        $response = array();
        $this->session->unset_userdata('search');
        isset($_POST["search"]) ? $this->session->set_userdata('search', array('any' => $_POST['any'],'any_jurusan'=> $_POST['any_jurusan'])) : null;
        $search = $this->session->search['any'];
        $jurusan = $this->session->search['any_jurusan'];
        if(isset($search)&&$search!=null) {
            ($where == null) ? null : $where .= " AND ";
            $where .= "tb.nama like '%".$search."%'";
        }
        if(isset($jurusan)&&$jurusan!=null) {
            ($where == null) ? null : $where .= " AND ";
            $where .= "tb.id_jurusan='".$jurusan."'";
        }
        $join = array(
            array("type"=>"LEFT","table"=>"tbl_category_buku tcb"),
            array("type"=>"LEFT","table"=>"tbl_lokasi tl"),
            array("type"=>"LEFT","table"=>"tbl_jurusan tj"),
        );
        $on = array("tcb.id=tb.id_category_buku","tl.id=tb.id_lokasi","tj.id=tb.id_jurusan");
        $count = $this->m_crud->count_data_join($table." tb", 'tb.id', $join, $on, $where);
        if($action == "get"){
            $pagin = $this->m_website->myPagination($count,8);
            $read_data = $this->m_crud->join_data(
                "$table tb",
                "tb.*,tcb.nama nama_kategori,tl.nama nama_lokasi,tj.title nama_jurusan",
                $join,$on,$where,"tb.id desc",null,$pagin["per_page"], $pagin['start']
            );
            $res_index = "";
            if($read_data != null){


                foreach ($read_data as $row):
                    if($row['gambar']!=null || $row['gambar']!= ''){
                        $gambar = base_url().$row['gambar'];
                    }else{
                        $gambar = base_url().'assets/no_image.png';
                    }
                    if($this->session->akses != 'siswa'){
                        $display = '
                        <button onclick="edit('."'".$row['id']."'".')" class="btn btn-default" role="button">Edit</button> 
                        <button onclick="hapus('."'".$row['id']."'".')" class="btn btn-default" role="button">Hapus</button>
                        <button onclick="readPdf('."'".$row['id']."'".')" class="btn btn-default" role="button">Baca</button>
                    ';
                    }else{
                        $display = '
                        <button onclick="readPdf('."'".$row['id']."'".')" class="btn btn-default" role="button">Baca</button>
                    ';
                    }
                    $res_index.=/** @lang text */
                    '
                    <div class="col-sm-6 col-md-3 col-xs-12">
                        <div class="thumbnail">
                           <img src="'.$gambar.'" alt="..." style="height:150px;width:100%;" id="gbr-book">
                           <div class="caption">
                               <h3>'.$row["nama"].'</h3>
                               <p>'.$row["nama_kategori"].' | '.$row["nama_lokasi"].' | '.$row["nama_jurusan"].'</p>
                               <p>'.$row["keterangan"].'</p>
                               <p>
                                   '.$display.'
                               </p>
                              
                           </div>
                        </div>
                    </div>    
                    
                    
					';
                endforeach;
            }else{
                $res_index .=
                /**@lang text */
                '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h3 class="text-center">Tidak Ada Data</h3>
				</div>';
            }
            $data = array(
                "pagination_link"   => $pagin['pagination_link'],
                "result_project" 	=> $res_index,
                "hal"               => $this->uri->segment(4)
            );
            echo json_encode($data);
        }
        elseif($action == "isExist"){
            $where = "nama='".$_POST['nama']."'";
            $_POST['param']=='edit'?$where.=" AND nama<>'".$_POST['nama']."'":null;
            $isExist = $this->m_crud->get_data($table, "nama", $where);
            echo $isExist==null?'true':'false';
        }
        elseif ($action == 'simpan'){
            $this->db->trans_begin();
            $path = 'assets/upload/buku';
            $config['upload_path']          = './'.$path;
            $config['allowed_types']        = 'bmp|gif|jpg|jpeg|png|pdf';
            $config['max_size']             = 5120;
            $this->load->library('upload', $config);
            $input_file = array('1'=>'file_upload','2'=>'file_reader');
            $valid = true;

            foreach($input_file as $row){
                if( (! $this->upload->do_upload($row)) && $_FILES[$row]['name']!=null){
                    $file[$row]['file_name']=null;
                    $file[$row] = $this->upload->data();
                    $valid = false;
                    $data['error_'.$row] = $this->upload->display_errors();
                    break;
                } else{
                    $file[$row] = $this->upload->data();
                    $data[$row] = $file;
                    if($file[$row]['file_name']!=null){
                        $manipulasi['image_library']    = 'gd2';
                        $manipulasi['source_image']     = $file[$row]['full_path'];
                        $manipulasi['maintain_ratio']   = true;
                        $manipulasi['width']            = 500;
                        $manipulasi['new_image']        = $file[$row]['full_path'];
                        $this->load->library('image_lib', $manipulasi);
                        $this->image_lib->resize();
                    }
                }
            }
            if($valid==true) {
                $data_buku = array(
                    'nama'         => $this->input->post('nama'),
                    'keterangan'   => $this->input->post('keterangan'),
                    'id_category_buku'   => $this->input->post('id_category_buku'),
                    'id_lokasi'   => $this->input->post('id_lokasi'),
                    'id_jurusan'   => $this->input->post('id_jurusan'),
                );

                if($_FILES['file_upload']['name']!=null) {
                    $data_buku['gambar' ] = ($_FILES['file_upload']['name']!=null)?($path.'/'.$file['file_upload']['file_name']):null;
                    if($_POST['file_uploaded']!=null||$_POST['file_uploaded']!=''){
                        unlink($_POST['file_uploaded']);
                    }
                }
                if($_FILES['file_reader']['name']!=null) {
                    $data_buku['files' ] = ($_FILES['file_reader']['name']!=null)?($path.'/'.$file['file_reader']['file_name']):null;
                    if($_POST['file_readered']!=null||$_POST['file_readered']!=''){
                        unlink($_POST['file_readered']);
                    }
                }

                if ($_POST['param'] == 'add') {
                    $response['error']  = false;
                    $response['pesan']  = "berhasil di insert ke table buku";
                    $this->m_crud->create_data($table, $data_buku);
                } else {
                    $id = $this->input->post('id');
                    if($this->input->post('id')){
                        $this->m_crud->update_data($table, $data_buku, "id='".$id."'");
                        $response['error'] = false;
                        $response['pesan'] = "berhasil di update ke table buku";
                    }
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
            echo json_encode($response);
        }
        elseif ($action == 'edit'){
            $get_data = $this->m_crud->get_data($table, "*", "id='".$_POST['id']."'");
            $result = array();
            if ($get_data != null) {
                $result['status'] = true;
                $result['res_data'] = $get_data;
            } else {
                $result['status'] = false;
            }

            echo json_encode($result);
        }
        elseif ($action == 'hapus'){
            $read_data = $this->m_crud->get_data($table,"$table.*","id='".$_POST['id']."'");
            $read_data != "" ? unlink($read_data['gambar']) : NULL;
            $read_data != "" ? unlink($read_data['files']) : NULL;
            $where 	= array('id' => $_POST['id']);
            $result = $this->m_crud->delete_data($table, $where);
            echo json_encode($result);
        }
        elseif ($action == 'get_dropdown'){
            $kategori='';$lokasi='';$jurusan='';
            $read_kategori = $this->m_crud->read_data("tbl_category_buku tc","tc.id id_category,tc.nama nama_kategori");
            $read_lokasi = $this->m_crud->read_data("tbl_lokasi tl","tl.id id_lokasi,tl.nama nama_lokasi");
            $read_jurusan = $this->m_crud->read_data("tbl_jurusan","*");
            $kategori.='<option value="">Pilih Kategori Buku</option>';
            $lokasi.='<option value="">Pilih Lokasi Buku</option>';
            $jurusan.='<option value="">Pilih Jurusan</option>';
            foreach ($read_kategori as $row){
                $kategori.='<option value="'.$row["id_category"].'">'.$row["nama_kategori"].'</option>';
            }
            foreach ($read_lokasi as $row){
                $lokasi.='<option value="'.$row["id_lokasi"].'">'.$row["nama_lokasi"].'</option>';
            }
            foreach ($read_jurusan as $row){
                $jurusan.='<option value="'.$row["id"].'">'.$row["title"].'</option>';
            }
            echo json_encode(array('kategori'=>$kategori,'lokasi'=>$lokasi,'jurusan'=>$jurusan));
        }
        elseif ($action == 'pinjam'){

            $read_data = $this->m_crud->get_join_data(
                "$table tb", "tb.*,tcb.nama nama_kategori,tl.nama nama_lokasi",
                array(array("type"=>"LEFT","table"=>"tbl_category_buku tcb"),array("type"=>"LEFT","table"=>"tbl_lokasi tl")),
                array("tcb.id=tb.id_category_buku","tl.id=tb.id_lokasi"),
                "tcb.id='".$_POST['id']."'",
                "tcb.id desc",null
            );
            $output = '
                <div class="col-sm-3">
                    <img src="https://upload.wikimedia.org/wikipedia/en/2/25/Abbie_hoffman_steal_this_book.jpg" alt="" style="height: 100px;width: 100px;">
                </div>
                <div class="col-sm-4">
                    <p class="text-left">Lokasi : '.$read_data["nama_lokasi"].'</p>
                    <p class="text-left">Kategori : '.$read_data["nama_kategori"].'</p>
                    <p class="text-left">Catatan : '.$read_data["keterangan"].'</p>
                </div>
            ';

            echo json_encode(array('result'=>$read_data));

        }
        elseif ($action == 'reader_pdf'){
            $id = $_POST['id'];
            $read_data = $this->db->query("select * from tbl_buku where id=$id")->row_array();
            $title = 'Buku '.$read_data['nama'];
            $result='

                <object data="'.base_url().$read_data['files'].'#toolbar=0" type="application/pdf" width="actual-width.px" height="actual-height.px"></object>    
            ';
            echo json_encode(array('title'=>$title,'result'=>$result));
        }
        else{
            $this->load->view('bo/layout/wrapper',$data);
        }
    }

    public function readerpdf($id){
        $read_data = $this->m_crud->get_data("tbl_buku","*","id='".$id."'");
        $data 	= array('read_data'=>$read_data);
        $this->load->view('bo/pages/readerpdf',$data);
    }

    public function kategori($action=null){
        $this->access_denied();
        $page	= 'kategori';
        $table	= 'tbl_category_buku';
        $where	= null;
        $data 	= array('page'=>$page,'isi'=>'bo/pages/'.$page);
        $response = array();
        $this->session->unset_userdata('search');
        isset($_POST["search"]) ? $this->session->set_userdata('search', array('any' => $_POST['any'])) : null;
        $search = $this->session->search['any'];
        if(isset($search)&&$search!=null) {
            ($where == null) ? null : $where .= " AND ";
            $where .= "nama like '%".$search."%'";
        }
        $count = $this->m_crud->count_data($table, "id", $where);
        if($action == "get"){
            $pagin = $this->m_website->myPagination($count,10);
            $read_data = $this->m_crud->read_data(
                $table,"$table.*",
                $where,"id desc",null,$pagin["per_page"], $pagin["start"]
            );
            $res_index = ""; $no = ($this->uri->segment(4) - 1) * $pagin["per_page"]+1;
            if($read_data != null){
                foreach ($read_data as $row):
                    $res_index.='
                        <tr>
                            <td>'.$no++.'</td>
                            <td>'.$row["nama"].'</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Pilihan <span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><div class="col-sm-12"><a href="#!" class="btn btn-default col-sm-12" onclick="edit('."'".$row['id']."'".')"><i class="fa fa-edit"></i> Edit</a></div></li>
                                        <li><div class="col-sm-12"><button class="btn btn-default col-sm-12" onclick="hapus('."'".$row['id']."'".')"><i class="fa fa-trash"></i> Delete</button></div></li>
                                    </ul>
                                </div>
                             </td>
                        </tr>
                    ';
                endforeach;
            }
            else{
                $res_index .=/**@lang text */
                    '<td colspan="3"><p class="text-center">Data Tida Ada</p></td>';
            }
            $data = array(
                "pagination_link"   => $pagin['pagination_link'],
                "result_table" 	    => $res_index,
                "hal"               => $this->uri->segment(4)
            );
            echo json_encode($data);
        }
        elseif($action == "isExist"){
            $where = "nama='".$_POST['nama']."'";
            $_POST['param']=='edit'?$where.=" AND nama<>'".$_POST['nama']."'":null;
            $isExist = $this->m_crud->get_data($table, "nama", $where);
            echo $isExist==null?'true':'false';
        }
        elseif ($action == 'simpan'){
            $this->db->trans_begin();
            $valid = true;
            if($valid==true) {
                $data_buku = array(
                    'nama'         => $this->input->post('nama'),
                );
                if ($_POST['param'] == 'add') {
                    $response['error']  = false;
                    $response['pesan']  = "berhasil di insert ke table lokasi";
                    $this->m_crud->create_data($table, $data_buku);
                } else {
                    $id = $this->input->post('id');
                    if($this->input->post('id')){
                        $this->m_crud->update_data($table, $data_buku, "id='".$id."'");
                        $response['error'] = false;
                        $response['pesan'] = "berhasil di update ke table lokasi";
                    }
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
            echo json_encode($response);
        }
        elseif ($action == 'edit'){
            $get_data = $this->m_crud->get_data($table, "*", "id='".$_POST['id']."'");
            $result = array();
            if ($get_data != null) {
                $result['status'] = true;
                $result['res_data'] = $get_data;
            } else {
                $result['status'] = false;
            }

            echo json_encode($result);
        }
        elseif ($action == 'hapus'){
            $where 	= array('id' => $_POST['id']);
            $result = $this->m_crud->delete_data($table, $where);
            echo json_encode($result);
        }
        else{
            $this->load->view('bo/layout/wrapper',$data);
        }
    }

    public function lokasi($action=null){
        $this->access_denied();
        $page	= 'lokasi';
        $table	= 'tbl_lokasi';
        $where	= null;
        $data 	= array('page'=>$page,'isi'=>'bo/pages/'.$page);
        $response = array();
        $this->session->unset_userdata('search');
        isset($_POST["search"]) ? $this->session->set_userdata('search', array('any' => $_POST['any'])) : null;
        $search = $this->session->search['any'];
        if(isset($search)&&$search!=null) {
            ($where == null) ? null : $where .= " AND ";
            $where .= "nama like '%".$search."%'";
        }
        $count = $this->m_crud->count_data($table, "id", $where);
        if($action == "get"){
            $pagin = $this->m_website->myPagination($count,10);
            $read_data = $this->m_crud->read_data(
                $table,"$table.*",
                $where,"id desc",null,$pagin["per_page"], $pagin["start"]
            );
            $res_index = ""; $no = ($this->uri->segment(4) - 1) * $pagin["per_page"]+1;
            if($read_data != null){
                foreach ($read_data as $row):
                    $res_index.='
                        <tr>
                            <td>'.$no++.'</td>
                            <td>'.$row["nama"].'</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Pilihan <span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><div class="col-sm-12"><a href="#!" class="btn btn-default col-sm-12" onclick="edit('."'".$row['id']."'".')"><i class="fa fa-edit"></i> Edit</a></div></li>
                                        <li><div class="col-sm-12"><button class="btn btn-default col-sm-12" onclick="hapus('."'".$row['id']."'".')"><i class="fa fa-trash"></i> Delete</button></div></li>
                                    </ul>
                                </div>
                             </td>
                        </tr>
                    ';
                endforeach;
            }else{
                $res_index .=/**@lang text */
                    '<td colspan="3"><p class="text-center">Data Tida Ada</p></td>';
            }
            $data = array(
                "pagination_link"   => $pagin['pagination_link'],
                "result_table" 	    => $res_index,
                "hal"               => $this->uri->segment(4)
            );
            echo json_encode($data);
        }
        elseif($action == "isExist"){
            $where = "nama='".$_POST['nama']."'";
            $_POST['param']=='edit'?$where.=" AND nama<>'".$_POST['nama']."'":null;
            $isExist = $this->m_crud->get_data($table, "nama", $where);
            echo $isExist==null?'true':'false';
        }
        elseif ($action == 'simpan'){
            $this->db->trans_begin();
            $valid = true;
            if($valid==true) {
                $data_buku = array(
                    'nama'         => $this->input->post('nama'),
                );
                if ($_POST['param'] == 'add') {
                    $response['error']  = false;
                    $response['pesan']  = "berhasil di insert ke table lokasi";
                    $this->m_crud->create_data($table, $data_buku);
                } else {
                    $id = $this->input->post('id');
                    if($this->input->post('id')){
                        $this->m_crud->update_data($table, $data_buku, "id='".$id."'");
                        $response['error'] = false;
                        $response['pesan'] = "berhasil di update ke table lokasi";
                    }
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
            echo json_encode($response);
        }
        elseif ($action == 'edit'){
            $get_data = $this->m_crud->get_data($table, "*", "id='".$_POST['id']."'");
            $result = array();
            if ($get_data != null) {
                $result['status'] = true;
                $result['res_data'] = $get_data;
            } else {
                $result['status'] = false;
            }

            echo json_encode($result);
        }
        elseif ($action == 'hapus'){
            $where 	= array('id' => $_POST['id']);
            $result = $this->m_crud->delete_data($table, $where);
            echo json_encode($result);
        }
        else{
            $this->load->view('bo/layout/wrapper',$data);
        }
    }

    public function peminjaman(){
        $page	= 'peminjaman';
        $where	= null;
        $data 	= array('page'=>$page,'isi'=>'bo/pages/'.$page);
//        $limit = $this->m_crud->get_data("tbl_config","limit_per_siswa");
//        $read_data = $this->db->query("select count(*) item from tbl_master_peminjaman where id_siswa=".$this->session->id." and status=0")->row_array();
//        if($read_data['item'] > $limit['limit_per_siswa']){
//            $this->load->view('welcome_message');
//        }else{
//
//        }
        $this->load->view('bo/layout/wrapper',$data);

    }

    public function riwayat($action=null){

        $table = 'tbl_master_peminjaman';
        $page	= 'riwayat_peminjaman';
        $where	= $this->session->akses == 'admin' ? null : "id_siswa='".$this->session->id."'";
        $data 	= array('page'=>$page,'isi'=>'bo/pages/'.$page);
        $this->session->unset_userdata('search');
        isset($_POST["search"]) ? $this->session->set_userdata('search', array('any' => $_POST['any'])) : null;
        $search = $this->session->search['any'];
        if(isset($search)&&$search!=null) {
            ($where == null) ? null : $where .= " AND ";
            $where .= "ts.nama like '%".$search."%' or ts.nis like '%".$search."%' or tmp.kd_trx like '%".$search."%'";
        }
        $count = $this->m_crud->count_join_data($table. " tmp", "tmp.id", "tbl_siswa ts", "ts.id=tmp.id_siswa", $where);

        if($action == "get"){
            $pagin = $this->m_website->myPagination($count,10);
            $read_data = $this->m_crud->join_data(
                $table." tmp","tmp.id id_tmp,tmp.kd_trx kd_trx, tmp.status,tmp.keterangan,tmp.tgl_pinjam,tmp.tgl_kembali,ts.id id_siswa,ts.nama,ts.nis",
                array(array("table"=>"tbl_siswa ts","type"=>"LEFT")),
                array("ts.id=tmp.id_siswa"),
                $where,"tmp.id desc",null,$pagin["per_page"], $pagin["start"]
            );
            $res_index = ""; $no = ($this->uri->segment(4) - 1) * $pagin["per_page"]+1;

            if($read_data != null){
                foreach ($read_data as $row):
                    if($row["status"] == 0){
                        if($this->session->akses == 'admin'){
                            $status = '<button class="btn btn-danger btn-xs" onclick="kembali('."'".$row['kd_trx']."'".')">Masih Dipinjam</button>';
                        }else{
                            $status = '<button class="btn btn-danger btn-xs">Masih Dipinjam</button>';
                        }
                    }else{
                        $status = '<button class="btn btn-primary btn-xs">Sudah Kembali</button>';
                    }
                    if($row['tgl_kembali'] == '0000-00-00'){
                        $tgl_kembali = '<p class="text-center">-</p>';
                    }else{
                        $tgl_kembali = $row['tgl_kembali'];
                    }
                    $res_index.='
                        <tr>
                            <td>'.$no++.'</td>
                            <td>'.$row["kd_trx"].'</td>
                            <td>'.$row["nis"].'</td>
                            <td>'.$row["nama"].'</td>
                            <td>'.$status.'</td>
                            <td>'.$row["tgl_pinjam"].'</td>
                            <td>'.$tgl_kembali.'</td>
                            <td>
                                <a href="#!" class="btn btn-default col-sm-12" onclick="detail('."'".$row['kd_trx']."','".$row['status']."','".$row['tgl_pinjam']."'".')"><i class="fa fa-edit"></i> Detail</a>
                             </td>
                        </tr>
                    ';
                endforeach;
            }
            else{
                $res_index .=/**@lang text */
                    '<td colspan="8"><p class="text-center">Data Tidak Ada</p></td>';
            }
            $data = array(
                "pagination_link"   => $pagin['pagination_link'],
                "result_table" 	    => $res_index,
                "hal"               => $this->uri->segment(4)
            );
            echo json_encode($data);
        }
        elseif ($action == 'kembali'){
            $this->m_crud->update_data("tbl_master_peminjaman", array("status"=>1,"tgl_kembali"=>date("Y-m-d")), "kd_trx='".$_POST['kdTrx']."'");
            echo json_encode(array("status"=>"success","msg"=>"berhasil"));
        }
        elseif ($action == 'detail'){
           $read_data = $this->m_crud->join_data(
               "tbl_detail_peminjaman tdp","tdp.kd_trx,tdp.tanggal,tb.isbn,tb.nama,tb.keterangan,tb.gambar",
               array(array("table"=>"tbl_buku tb","type"=>"LEFT")),
               array("tb.id=tdp.id_buku"),
               "tdp.kd_trx='".$_POST['kdTrx']."'"
           );
           if($_POST["status"] == 0){
               $status = 'Masih Dipinjam';
           }else{
               $status = 'Sudah Kembali';
           }
           $res_index='';$no=1;
           $res_index.='
            <table class="table table-hover">
                <tbody>
                <tr>
                    <td>Kd Trx</td><td>:</td><td>'.$_POST["kdTrx"].'</td>
                </tr>
                <tr>
                    <td>Tanggal Pinjam</td><td>:</td><td>'.$_POST["tglPinjam"].'</td>
                </tr>
                <tr>
                    <td>Status</td><td>:</td><td>'.$status.'</td>
                </tr>
                </tbody>

            </table>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <td>No</td>
                    <td>ISBN</td>
                    <td>Judul</td>
                    <td>Keterangan</td>
                </tr>
                </thead>
                <tbody>
                
           ';
           foreach ($read_data as $row){
               $res_index.='
                    <tr>
                        <td>'.$no++.'</td>
                        <td>'.$row['isbn'].'</td>
                        <td>'.$row['nama'].'</td>
                        <td>'.$row['keterangan'].'</td>
                    </tr>
               ';
           }
           $res_index.='
                </tbody>
            </table>
           ';
           echo json_encode(array("status"=>"success","msg"=>"berhasil","result_table"=>$res_index));
        }
        else{
            $this->load->view('bo/layout/wrapper',$data);
        }
    }


    public function cart_buku() {
        $where = null;
        $search = $_POST['query'];
        if ($search != null) {
            $cek_data = $this->m_crud->read_data("tbl_buku","*","nama like '%".$search."%' OR keterangan like '%".$search."%' OR isbn like '%".$search."%'");
            if($cek_data != null){
                $result = $this->m_crud->read_data("tbl_buku", "CONCAT(isbn, ' | ', nama) value, nama, keterangan, isbn,id", $where, null, null, 20);
            }else {
                $result = array(array('judul'=>'not_found', 'value'=>'Produk Tidak Tersedia!'));
            }
        }

        echo json_encode(array("suggestions"=>$result));
    }

    public function insert_tr(){
	    $response = array();
	    $read_data = $this->m_crud->get_data("tbl_buku","*","id='".$_POST['id']."'");
        $data = array(
            "field1"=>$read_data['id'],               //id buku
            "field2"=>$read_data['id_category_buku'], //id kategori buku
            "field3"=>$read_data['id_lokasi'],        //id lokasi
            "field4"=>$read_data['isbn'],             //isbn
            "field5"=>$read_data['nama'],             //nama buku
            "field6"=>$read_data['keterangan'],       //keterangan buku
            "field7"=>$read_data['gambar'],           //gambar buku
            "field8"=>$this->session->id,             //id siswa
            "field9"=>'1',                            //qty
        );
        $check_data = $this->m_crud->get_data("tbl_temporary","field1,field4,field9"," field1='".$_POST['id']."' and field8='".$this->session->id."'");
//        $check_qty = $this->db->query("select sum(field9) qty from tbl_temporary where field1='".$_POST['id']."' and field8='".$this->session->id."'")->row_array();
//        $check_item = $this->db->query("select count(*) item from tbl_temporary where  field8='".$this->session->id."'")->row_array();
//        if($check_item['item'] != 2){
//            if(count($check_data['field1']) == 1){
//                if($check_qty['qty'] == 2){
//                    $response['status']= false;
//                    $response['qty']=$check_qty['qty'];
//                    $response['msg']='jumlah quantiti buku tidak boleh lebih dari 2';
//                }else{
//                    $response['status']= true;
//                    $response['qty']=$check_qty['qty'];
//                    $response['msg']='berhasil update qty '.$check_qty['qty'];
//                    $qty = ((int)$check_data['field9']+1);
//                    $this->m_crud->update_data("tbl_temporary", array("field9"=>$qty), "field1='".$_POST['id']."' and field8='".$this->session->id."'");
//                }
//
//            }else{
//
//                $response['qty']=$check_qty['qty'];
//                $response['status']= true;
//                $response['msg']='berhasil menambah data';
//                $this->m_crud->create_data("tbl_temporary",$data);
//            }
//        }else{
//           if($check_qty['qty'] != 2){
//               $response['status']= true;
//               $response['qty']=$check_qty['qty'];
//               $response['msg']='berhasil update qty '.$check_qty['qty'];
//               $qty = ((int)$check_data['field9']+1);
//               $this->m_crud->update_data("tbl_temporary", array("field9"=>$qty), "field1='".$_POST['id']."' and field8='".$this->session->id."'");
//           }
//           else{
//               $response['status']= false;
//               $response['qty']=$check_qty['qty'];
//               $response['msg']='Peminjaman buku tidak boleh lebih dari 2';
//           }
//        }
        if(count($check_data['field1']) == 1){
            $response['status']= true;
            $response['qty']='';
            $response['msg']='berhasil update qty ';
            $qty = ((int)$check_data['field9']+1);
            $this->m_crud->update_data("tbl_temporary", array("field9"=>$qty), "field1='".$_POST['id']."' and field8='".$this->session->id."'");

        }else{
            $response['qty']='';
            $response['status']= true;
            $response['msg']='berhasil menambah data';
            $this->m_crud->create_data("tbl_temporary",$data);
        }


        echo json_encode($response);
    }

    public function get_buku(){
	    $response = array();
	    $read_data = $this->m_crud->read_data("tbl_temporary","*","field8='".$this->session->id."'");
	    $res_index='';$no=1;$col = 0;
	    if($read_data!=null){
	        foreach ($read_data as $row){

                $res_index.='
	            <tr>
	                <td>'.$no.'</td>    
	                <td><img src="'.base_url().$row["field7"].'" alt="" style="height: 50px;width: 50px;"></td>    
	                <td>'.$row["field4"].'</td>    
	                <td>'.$row["field5"].'</td>    
	                <td>'.$row["field6"].'</td>    
	                <td>
	                    <input onkeyup="update($(this).val(),'."'".$row['field1']."','".$no."'".')" type="number" name="qty" id="qty'.$no.'" value="'.$row["field9"].'" class="form-control">
                    </td>  
                    <td>
	                    <button onclick="hapus('."'".$row['field1']."'".')" class="btn btn-danger"><i class="fa fa-close"></i></button>
                    </td> 
                </tr>
	            ';
                $col = $no;
                $no++;
            }
            $response['no'] = $col;
            $response['col'] = '<input type="text" class="form-control" id="col" value="'.$col.'">';
            $response['result'] = $res_index;
            $response['status'] = 'success';
            $response['msg'] = 'berhasil mengambil data';
        }else{
            $response['no'] = '';
            $response['col'] = '<input type="text" class="form-control" id="col" value="0">';
            $response['result'] = '<tr><td colspan="7"><p class="text-center">Data Tidak Ada</p></td></tr>';
            $response['status'] = 'failed';
            $response['msg']    = 'gagal mengambil data';
        }

        echo json_encode($response);
    }

    public function insertDetPeminjaman(){
        $read_data = $this->m_crud->read_data("tbl_temporary","*","field8='".$this->session->id."'");
        $this->db->trans_begin();
        if($read_data != null){
            foreach($read_data as $row){
                $dataDetail = array(
                    "id_buku"=>$row['field1'],
                    "kd_trx"=>$this->m_crud->getKodeTrx("PI"),
                );
                $this->m_crud->create_data("tbl_detail_peminjaman",$dataDetail);
            }
            $dataMaster=array(
                "kd_trx"=>$this->m_crud->getKodeTrx("PI"),
                "keterangan" =>$_POST['catatan'],
                "id_siswa"   =>$this->session->id,
                "tgl_pinjam" =>$_POST['tgl_peminjaman'],

            );
            $this->m_crud->create_data("tbl_master_peminjaman",$dataMaster);
            $this->m_crud->delete_data("tbl_temporary", array("field8"=>$this->session->id));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'failed'));
        } else {
            $this->db->trans_commit();
            echo json_encode(array('status' => 'success',));
        }
    }

    public function updateTr(){
        $update = $this->m_crud->update_data("tbl_temporary", array("field9"=>$_POST['qty']), "field1='".$_POST['id']."' and field8='".$this->session->id."'");
        if($update == true){
            echo json_encode(array('status'=>'success','msg'=>'Berhasil'));
        }
    }

    public function deleteAllTr(){
        $delete = $this->m_crud->delete_data("tbl_temporary", "field8='".$this->session->id."'");

        if($delete == true){
            echo json_encode(array('status'=>'success','msg'=>'Berhasil'));
        }
    }


    public function deleteOne(){
        $delete = $this->m_crud->delete_data("tbl_temporary", "field8='".$this->session->id."' and field1='".$_POST['id']."'");
        if($delete == true){
            echo json_encode(array('status'=>'success','msg'=>'Berhasil'));
        }
    }
}