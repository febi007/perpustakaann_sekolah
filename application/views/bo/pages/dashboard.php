
<div class="row">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-4">
            <label>Periode</label>
            <?php $field = 'field-date';?>
            <div id="daterange" style="cursor: pointer;">
                <div class="input-group">
                    <input type="text" name="periode" id="<?=$field?>" class="form-control" style="height: 40px;" value="<?=isset($this->session->search['periode'])?$this->session->search['periode']:(set_value('periode')?set_value('periode'):date("Y-m-d")." - ".date("Y-m-d"))?>">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>

        </div>
        <div class="col-sm-1">
            <div class="form-group">
                <label for="">&nbsp;</label>
                <button type="button" class="btn btn-primary bg-blue" onclick="cari()" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cari" style="margin-top: 25px;"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <canvas id="grafik_kas"  width="900" height="380"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        @media(max-width:767px){
                            #grafik_kas{
                                width: 100%;
                                height: auto;
                            }
                            #jumlah_uang{
                                width: 100%!important;
                                height: auto!important;
                            }
                            #jumlah_beras{
                                width: 100%!important;
                                height: auto!important;
                            }
                        }
                    </style>
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs tabs">
                                <li class="active tab">
                                    <a href="#uang" data-toggle="tab" aria-expanded="false">
<!--                                        <span class="visible-xs"><i class="fa fa-bar-chart"></i></span>-->
                                        <span>Uang</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#beras" data-toggle="tab" aria-expanded="false">
<!--                                        <span class="visible-xs"><i class="fa fa-bar-chart"></i></span>-->
                                        <span>Beras</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="uang">
                                    <canvas id="jumlah_uang"  width="900" height="380"></canvas>
                                </div>
                                <div class="tab-pane" id="beras">
                                    <canvas id="jumlah_beras"  width="900" height="380"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

