<?php
    if($this->session->loggedin == false){
        redirect('auth');
    }else{
        $user_data = $this->m_crud->get_data("tbl_siswa","*","nis='".$this->session->nis."'");
        $config = $this->m_crud->get_data("tbl_config","*");
        include 'header.php';
        include 'top_menu.php';
        include 'side_menu.php';
        include 'content.php';
        include 'footer.php';
    }

?>
