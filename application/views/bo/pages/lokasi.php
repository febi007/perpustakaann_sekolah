<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 noPadding">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Cari</label>
                                <input type="text" name="any" class="form-control pull-right" id="any" value="<?=isset($this->session->search['any'])?$this->session->search['any']:''?>" placeholder="Cari disini ...">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-1 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary bg-blue" onclick="cari()" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cari" style="margin-top: 25px;"><i class="fa fa-search"></i></button>
                                <button type="button" class="btn waves-effect waves-light btn-primary" onclick="add(); validasi('add');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah" style="margin-top: 25px;"><i class="fa fa-plus"></i></button>
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
                            <table class="table table-responsive table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
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

<!--********************************** MODAL FORM ******************************-->
<div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" id="modal_form" style="display: none">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header noPadding">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title">Tambah</h4>
            </div>
            <form id="form_input">
                <div class="modal-body">
                    <div class="form-group">
                        <?php $label="nama";?>
                        <label>Judul</label>
                        <input type="text" name="<?=$label?>" id="<?=$label?>" class="form-control">
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button></div>
                <input type="hidden" name="param" id="param" value="add">
                <input type="hidden" name="id" id="id">
            </form>
        </div>
    </div>
</div>

<input type="hidden" name="page" id="page">

<script type="text/javascript">
	var url = "<?=base_url('bo/lokasi/')?>"; //** url assets **//
	var img = "<?=base_url('assets/')?>";    //** url images **//
	$(document).ready(function(){
		load_data(1);
	}).on("click", ".pagination li a", function(event){
		event.preventDefault();
		var page = $(this).data("ci-pagination-page");
		load_data(page);
	});
	function add() {
		$("#modal_title").text("Tambah Lokasi");
		$("#param").val("add");
		$("#modal_form").modal("show");
		setTimeout(function () {
			$("#nama").focus();
		}, 600);
	}
	function validasi(action=''){}
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

	//************* PENCARIAN ***********************//
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
	//************* SHOW MODAL **********************//
	function edit(id) {
		$.ajax({
			url: url+"edit",
			type: "POST",
			data: {id: id},
			dataType: "JSON",
			beforeSend: function() {$('body').append('<div class="first-loader"><img src="'+img+'spin.svg"></div>')},
			complete  : function() {$('.first-loader').remove()},
			success: function (res) {
				if (res.status) {
					console.log(res.res_data);
					$("#modal_title").text("Edit Buku");
					$("#param").val("edit");
					$("#id").val(id);
					$("#nama").val(res.res_data['nama']);
					$("#modal_form").modal("show");
					setTimeout(function () {
						$("#nama").focus();
					}, 600);
				} else {
					alert("Error getting data!")
				}
			}
		});
	}
	//************* HIDE ****************************//

	//************* DETAIL **************************//

	//************* TAMBAH && UPDATE ****************//
	$('#form_input').validate({
		rules: {
			nama: {
				required: true,
				remote: {
					url: url+"isExist",
					type: "post",
					data: {
						param: function() {
							return $("#param").val();
						}
					}
				}
			}

		},
		//For custom messages
		messages: {
			nama:{
				required: "Nama Lokasi Tidak Boleh Kosong!",
				remote  : "Nama Lokasi Sudah Tersedia"
			}
		},
		errorElement : 'div',
		errorPlacement: function(error, element) {
			var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			} else {
				error.insertAfter(element);
			}
		},
		submitHandler: function (form) {
			var myForm = document.getElementById('form_input');
			$.ajax({
				url: url+"simpan",
				type: "POST",
				dataType:"JSON",
				data: new FormData(myForm),
				mimeType: "multipart/form-data",
				contentType: false,
				processData: false,
				beforeSend: function() {$('body').append('<div class="first-loader"><img src="'+img+'spin.svg"></div>')},
				complete  : function() {$('.first-loader').remove()},
				success: function (res) {
					if (res.error===false) {
						console.log(res.pesan);
						swal("Kerja Bagus!","Data Berhasil Disimpan!","success");
						$("#modal_form").modal('hide');
						load_data($("#page").val());

					} else {
						console.log(res.pesan);
						alert("Data gagal disimpan!");
					}
				}
			});
		}
	});


	//************* HAPUS DATA **********************//
	function hapus(id){

		swal({
			title             : 'Anda Yakin?',
			text              : "Anda Tidak Dapat Mengembalikan Data Ini!",
			type              : 'warning',
			showCancelButton  : true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor : '#d33',
			confirmButtonText : 'Yakin !',
			closeOnConfirm    : false,
			cancelButtonText: 'Batal'
		}).then(function(result){
			if(result.value){
				$.ajax({
					url : url+"hapus",
					type: "POST",
					dataType: "JSON",
					data:{id: id},
					beforeSend: function() {$('body').append('<div class="first-loader"><img src="'+img+'spin.svg"></div>')},
					complete  : function() {$('.first-loader').remove()},
					success:function(res){

						swal(
							'Success!',
							'Data Anda Berhasil Dihapus.',
							'success'
						);
						load_data($("#page").val());
					},error: function(xhr, status, error) {
						alert("Data tidak bisa dihapus!");
						console.log(xhr.responseText);
					}
				});
			}else if(result.dismiss === 'cancel'){
				swal('Cancel','Data Tidak Jadi Dihapus.','success');
			}

		});

	}
	$("#modal_form").on("hide.bs.modal", function () {
		document.getElementById("form_input").reset();
		$( "#form_input" ).validate().resetForm();
	});




</script>