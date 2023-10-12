<!-- Top Bar Start -->
<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <!--<a href="index.html" class="logo"><i class="md md-terrain"></i> <span>Moltran </span></a>-->
            <a href="<?=base_url()?>" class="logo logo-top-bar"><img style="max-height:50px;" src="<?=$this->config->item('logo')?>" /></a>
        </div>
    </div>
    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                <div class="pull-left">
                    <button class="button-menu-mobile open-left">
                        <i class="fa fa-bars"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>
                <ul class="nav navbar-nav navbar-right pull-right">

                    <li>
                        <a href="<?=base_url().'auth/logout'?>"  class="waves-effect waves-light"><i class="fa fa-sign-out"></i></a>
                    </li>

                    <li class="dropdown">
                        <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true" id="img-top">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=base_url('auth/logout')?>"><i class="md md-settings-power"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- Top Bar End -->
