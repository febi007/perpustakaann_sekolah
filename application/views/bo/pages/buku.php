<style>
    @media (max-width: 576px) {
        #gbr-book{height: 100%!important;}
    }
    @media (max-width: 300px) {
        #gbr-book{height: 100%!important;}
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 noPadding">

                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Jurusan</label>
                                <?php $field = 'any_jurusan';
                                $option = null; $option[''] = 'Semua';
                                //$option['all'] = 'All';
                                $data_option = $this->m_crud->read_data('tbl_jurusan', '*');
                                foreach($data_option as $row){ $option[$row['id']] = $row['title']; }
                                echo form_dropdown($field, $option, isset($this->session->search[$field])?$this->session->search[$field]:set_value($field), array('class' => 'select2', 'id'=>$field));
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Cari</label>
                                <input type="text" name="any" class="form-control pull-right" id="any" value="<?=isset($this->session->search['any'])?$this->session->search['any']:''?>" placeholder="Cari disini ...">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary bg-blue" onclick="cari()" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cari" style="margin-top: 25px;"><i class="fa fa-search"></i></button>
                                <?php if($this->session->akses != 'siswa'){ ?>
                                    <button type="button" class="btn btn-primary bg-blue" onclick="add(); validasi('add');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah" style="margin-top: 25px;">
                                        <i class="fa fa-plus" style=""></i>
                                    </button>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="container m-t-md">
                        <!-- First row -->
                        <div class="row" id="list_project"></div>
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
                    <div class="form-group">
                        <?php $label="id_category_buku";?>
                        <label>Kategori</label>
                        <select name="<?=$label?>" id="<?=$label?>" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <?php $label="id_lokasi";?>
                        <label>Lokasi</label>
                        <select name="<?=$label?>" id="<?=$label?>" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <?php $label="id_jurusan";?>
                        <label>Jurusan</label>
                        <select name="<?=$label?>" id="<?=$label?>" class="form-control"></select>
                    </div>

                    <div class="form-group">
                        <?php $field = 'keterangan';?>
                        <label>Keterangan</label>
                        <textarea name="<?=$field?>" id="<?=$field?>" cols="30" rows="10" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <?php $label = 'file_reader'; ?>
                        <label>Files <small id="title" style="color: #1e88e5;font-weight: bold"></small></label>
                        <input type="hidden" id="<?=$label?>ed" name="<?=$label?>ed" />
                        <input type="file" id="<?=$label?>" name="<?=$label?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <?php $label = 'file_upload'; ?>
                        <label>Gambar</label>
                        <input type="hidden" id="<?=$label?>ed" name="<?=$label?>ed" />
                        <input type="file" id="<?=$label?>" name="<?=$label?>" onchange="return ValidateFileUpload()" accept="image/*" class="form-control">
                        <p class="error" id="alr_<?=$label?>"></p>
                    </div>
                    <img src="<?=base_url().'assets/no_image.png'?>" id="result_image" class="img img-responsive" style="width: 100%!important;">
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button></div>
                <input type="hidden" name="param" id="param" value="add">
                <input type="hidden" name="id" id="id">
            </form>
        </div>
    </div>
</div>

<input type="hidden" name="page" id="page">

<!--********************************** MODAL PINJAM ******************************-->
<div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" id="modal_reader" style="display: none">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header noPadding">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title_pinjam"></h4>
            </div>
            <div class="modal-body">
                <div class='embed-responsive' style='padding-bottom:150%' id="result_reader">

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .embed-responsive {
        position: relative;
        display: block;
        height: 0;
        padding: 0;
        overflow: hidden;
    }
</style>

<script type="text/javascript">
	var url = "<?=base_url('bo/buku/')?>"; //** url assets **//
	var img = "<?=base_url('assets/')?>";    //** url images **//
	$(document).ready(function(){
		load_data(1);
		load_dropdown();
	}).on("click", ".pagination li a", function(event){
		event.preventDefault();
		var page = $(this).data("ci-pagination-page");
		load_data(page);
	});

	function readPdf(id){
		$.ajax({
			url       : url+"reader_pdf",
			method    : "POST",
			dataType  : "JSON",
            data:{id:id},
			beforeSend: function() {$('body').append('<div class="first-loader"><img src="'+img+'spin.svg"></div>')},
			complete  : function() {$('.first-loader').remove()},
			success   : function(data) {
				$("#modal_reader").modal("show");
				$("#result_reader").html(data.result);
				$("#modal_title_pinjam").html(data.title);
			}
		});
    }

	function add() {
		$("#modal_title").text("Tambah Pengurus");
		$("#param").val("add");
		$("#modal_form").modal("show");
		setTimeout(function () {
			$("#nama_pengurus").focus();
			$('#result_image').attr('src', '<?= base_url() ?>' + ('assets/no_image.png'));
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
				$('#list_project').html(data.result_project);
				$('#pagination_link').html(data.pagination_link);
				$("#page").val(data.hal);
				console.log(data);
			}
		});
	}
	function load_dropdown(){
		$.ajax({
			url       : url+"get_dropdown",
			method    : "POST",
			dataType  : "JSON",
			beforeSend: function() {$('body').append('<div class="first-loader"><img src="'+img+'spin.svg"></div>')},
			complete  : function() {$('.first-loader').remove()},
			success   : function(data) {
				$('#id_category_buku').html(data.kategori);
				$('#id_lokasi').html(data.lokasi);
				$("#id_jurusan").html(data.jurusan);
				console.log(data);
			}
		});
    }
	//************* PENCARIAN ***********************//

	function cari() {
		var any = $("#any").val();
		var any_jurusan = $("#any_jurusan").val();
		load_data(1, {search: true, any: any,any_jurusan:any_jurusan});
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
					$("#keterangan").val(res.res_data['keterangan']);
					$("#id_category_buku").val(res.res_data['id_category_buku']);
					$("#id_lokasi").val(res.res_data['id_lokasi']);
					$("#id_jurusan").val(res.res_data['id_jurusan']);
					$("#title").text('( '+res.res_data['files']+' )');
					$('#file_upload').val('');
					$('#file_reader').val('');
					$("#file_readered").val(res.res_data['files']);
					$('#file_uploaded').val((res.res_data['gambar']!=''?res.res_data['gambar']:''));
					$('#result_image').attr('src', '<?= base_url() ?>' + (res.res_data['gambar']!=''?res.res_data['gambar']:'assets/no_image.png'));
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
			},
			keterangan:{
				required: true
			},
			id_category_buku:{
				required: true
			},
			id_lokasi:{
				required: true
			},
			id_jurusan:{
				required: true
			}
		},
		//For custom messages
		messages: {
			nama:{
				required: "Judul Buku Tidak Boleh Kosong!",
				remote  : "Judul Buku Sudah Tersedia"
			},
			keterangan:{
				required: "Keterangan Tidak Boleh Kosong!"
			},
			id_category_buku:{
				required: "Kategori Buku Tidak Boleh Kosong!"
			},
			id_lokasi:{
				required: "Lokasi Buku Tidak Boleh Kosong!"
			},
			id_jurusan:{
				required: "Jurusan Tidak Boleh Kosong!"
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
                    console.log(res);

                    if (res.error===false) {
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
		$('#result_image').attr('src', '<?= base_url() ?>' + 'assets/no_image.png');
	});


	function ValidateFileUpload() {
		var fuData = document.getElementById('file_upload');
		var FileUploadPath = fuData.value;
		var valid = 1;
		$("#alr_file_upload").text("");
		if (FileUploadPath == '') {
		} else {
			var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
			if (Extension == "gif" || Extension == "png" || Extension == "bmp" || Extension == "jpeg" || Extension == "jpg") {
				if (fuData.files && fuData.files[0]) {
					var reader = new FileReader();
					reader.onload = function(e) {
						$('#result_image').attr('src', e.target.result);
					};
					reader.readAsDataURL(fuData.files[0]);
				}
			} else {
			}
		}
		return valid;
	}


</script>