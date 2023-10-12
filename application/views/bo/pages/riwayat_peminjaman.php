<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 noPadding">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Cari</label>
                                <input type="text" name="any" class="form-control pull-right" id="any" value="<?=isset($this->session->search['any'])?$this->session->search['any']:''?>" placeholder="Cari kd trx, nama, nis">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-1 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary bg-blue" onclick="cari()" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cari" style="margin-top: 25px;"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="container m-t-md">
                        <!-- First row -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kd Trx</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Tgl Kembali</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody id="result_table"></tbody>
                            </table>
                        </div>
                        <!-- Second row -->
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <nav aria-label="..." id="pagination_link"></nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<input type="hidden" name="page" id="page">
<div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" id="modal_detail" style="display: none">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header noPadding">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title">Detail Peminjaman</h4>
            </div>
            <div class="modal-body" id="result_detail">

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
	var url = "<?=base_url('bo/riwayat/')?>"; //** url assets **//
	var img = "<?=base_url('assets/')?>";    //** url images **//
	$(document).ready(function(){
		load_data(1);
	}).on("click", ".pagination li a", function(event){
		event.preventDefault();
		var page = $(this).data("ci-pagination-page");
		load_data(page);
	});

	//************* LOAD DATA ***********************//
	function load_data(page,data={}) {
		$.ajax({
			url       : url+"get/"+page,
			method    : "POST",
			data      : data,
			dataType  : "JSON",
			beforeSend: function() {$('body').append('<div class="first-loader"><img src="'+img+'spin.svg"></div>')},
			complete  : function() {$('.first-loader').remove()},
			success   : function(data) {
				$('#result_table').html(data.result_table);
				$('#pagination_link').html(data.pagination_link);
				$("#page").val(data.hal);
				console.log(data);
			}
		});
	}

	function cari() {
		var any = $("#any").val();
		load_data(1, {search: true, any: any});
	}
	$("#any").on("keyup keypress",function(e){
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			var any = $("#any").val();
			load_data(1, {search: true, any: any});
		}
	});

	function kembali(kdTrx){
		$.ajax({
			url       : url+"kembali",
			method    : "POST",
			data      : {kdTrx:kdTrx},
			dataType  : "JSON",
			beforeSend: function() {$('body').append('<div class="first-loader"><img src="'+img+'spin.svg"></div>')},
			complete  : function() {$('.first-loader').remove()},
			success   : function(data) {
				if(data.status === 'success'){
					load_data(1);
                }

				console.log(data);
			}
		});
    }

	function detail(kdTrx,status,tglPinjam){
		$.ajax({
			url       : url+"detail",
			method    : "POST",
			data      : {kdTrx:kdTrx,status:status,tglPinjam:tglPinjam},
			dataType  : "JSON",
			beforeSend: function() {$('body').append('<div class="first-loader"><img src="'+img+'spin.svg"></div>')},
			complete  : function() {$('.first-loader').remove()},
			success   : function(data) {
				if(data.status === 'success'){
					$("#modal_detail").modal("show");
					$("#result_detail").html(data.result_table);
				}

				console.log(data);
			}
		});
	}

</script>