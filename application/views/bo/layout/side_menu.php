<!-- ========== Left Sidebar Start ========== -->
<style>
    .slimScrollBar{background: #141414!important;border-radius: 0px!important;}
</style>
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <div class="user-details">
            <div class="pull-left" id="img-left">
                <img src="<?=$this->config->item('logo')?>" alt="" class="thumb-md img-circle">
            </div>
            <div class="user-info">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle name-left" data-toggle="dropdown" aria-expanded="false"><?=$this->session->nama?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=base_url('auth/logout')?>"><i class="md md-settings-power"></i> Logout</a></li>
                        <li><a href="#!" ><i class="md md-settings"></i> Profile</a></li>
                    </ul>
                </div>
                <p class="text-muted m-0" id="role-left"><?=$this->session->level?></p>
            </div>
        </div>
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="<?=base_url().'bo/buku'?>" class="waves-effect <?=($page=='buku')?'active':null?>">
                        <i class="md md-dashboard"></i><span>Buku</span>
                    </a>
                </li>
                <li style="<?=$this->session->akses=='admin'?'display:block':'display:none'?>">
                    <a href="<?=base_url().'bo/lokasi'?>" class="waves-effect <?=($page=='lokasi')?'active':null?>">
                        <i class="md md-dashboard"></i><span>Lokasi Buku</span>
                    </a>
                </li>
                <li style="<?=$this->session->akses=='admin'?'display:block':'display:none'?>">
                    <a href="<?=base_url().'bo/kategori'?>" class="waves-effect <?=($page=='kategori')?'active':null?>">
                        <i class="md md-dashboard"></i><span>Kategori Buku</span>
                    </a>
                </li>
                <li>
                    <a href="<?=base_url().'bo/peminjaman'?>" class="waves-effect <?=($page=='peminjaman')?'active':null?>">
                        <i class="md md-dashboard"></i><span>Peminjaman</span>
                    </a>
                </li>
<!--                <li>-->
<!--                    <a href="--><?//=base_url().'bo/pengembalian'?><!--" class="waves-effect --><?//=($page=='pengembalian')?'active':null?><!--">-->
<!--                        <i class="md md-dashboard"></i><span>Pengembalian</span>-->
<!--                    </a>-->
<!--                </li>-->
                <li>
                    <a href="<?=base_url().'bo/riwayat'?>" class="waves-effect <?=($page=='riwayat_peminjaman')?'active':null?>">
                        <i class="md md-dashboard"></i><span>Riwayat Peminjaman</span>
                    </a>
                </li>
<!--                <li>-->
<!--                    <a href="--><?//=base_url().'bo/riwayat?type=pengembalian'?><!--" class="waves-effect --><?//=($page=='riwayat_pengembalian')?'active':null?><!--">-->
<!--                        <i class="md md-dashboard"></i><span>Riwayat Pengembalian</span>-->
<!--                    </a>-->
<!--                </li>-->
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Left Sidebar End -->
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">

                    <ol class="breadcrumb pull-right">
                        <li><a href="#" id="titlemasjid"><?=$config['site_title']?></a></li>
                        <li class="active"><?=str_replace('_', ' ', strtoupper($page)) ?></li>
                    </ol>
                </div>
            </div>



