<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 18/12/2019
 * Time: 21:44
 */

class Auth extends CI_Controller
{
    public function index(){
        if($this->session->loggedin == true){
            redirect('bo/buku');
        }else{
            $this->load->view("auth");
        }

    }


    function login(){
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($this->form_validation->run() != FALSE){
            $cek = $this->m_crud->get_data('v_user','*',array('username'=>$username));
            if($cek){
                if ($this->bcrypt->check_password($password , $cek['password'])){
                    // dd($cek);
                    $session=array(
                        'id'=>$cek['id'],
                        'nama'=>$cek['nama'],
                        'username'=>$cek['username'],
                        'id_level'=>$cek['id_level'],
                        'level'=>$cek['level'],
                        'access_level'=>$cek['access_level'],
                        'grant_access'=>$cek['grant_access'],
                        'loggedin'=>true,
                        'akses'=>"admin"
                    );
                    $this->session->set_userdata($session);
                    redirect('bo/buku');
                }else{
                    $this->session->set_flashdata('error', 'Password salah.');
                    redirect('auth');
                }
            }
            else{
                $this->session->set_flashdata('error', 'Username tidak dikenali.');
                redirect('auth');
            }

        }
        else{
            $this->session->set_flashdata('error', 'Username/Password tidak valid.');
            redirect('auth');
        }

    }

    function logout(){
//        $this->m_crud->update_data("tbl_siswa",array("isLogin"=>0),"nis='".$this->session->nis."'");
        $this->session->sess_destroy();
        redirect($this->config->item('web'));
    }

    function auth_siswa(){
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($this->form_validation->run() != FALSE){
            $cek_ = $this->m_crud->get_data('tbl_siswa','*',"nis='$username' and nis='$password'");
            if($cek_){
                $data = array(
                    "id"=>$cek_['id'],
                    "id_kelas"=>$cek_['id_kelas'],
                    "nis"=>$cek_['nis'],
                    "nama"=>$cek_['nama'],
                    "jenis_kelamin"=>$cek_['jenis_kelamin'],
                    "no_hp"=>$cek_['no_hp'],
                    "alamat"=>$cek_['alamat'],
                    'loggedin'=>true,
                    'akses'=>'siswa',
                    'level'=>'siswa',
                );
                $this->session->set_userdata($data);
                redirect('bo/peminjaman');

            }else{
                $this->session->set_flashdata('error', 'Username atau password tidak dikenali.');
                redirect('auth/auth_siswa');
            }
        }
        else{
            $this->load->view("auth_siswa");
        }

    }

}