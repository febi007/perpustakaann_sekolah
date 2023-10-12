<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 noPadding">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tanggal Peminjaman</label>
                                <input type="text" name="tgl_peminjaman" id="tgl_peminjaman" class="form-control" value="<?=date('Y-m-d')?>" readonly>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Catatan</label>
                                <input type="text" name="catatan" id="catatan" class="form-control">
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Cari</label>
                                <input type="text" name="any" class="form-control pull-right" id="any" value="<?=isset($this->session->search['any'])?$this->session->search['any']:''?>" placeholder="Cari disini ...">
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

                            <table class="table table-striped table-bordered table-responsive table-hover">
                                <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="7%">Gambar</th>
                                    <th width="10%">ISBN</th>
                                    <th width="20%">Nama</th>
                                    <th width="30%">Catatan</th>
                                    <th width="4%">Qty</th>
                                    <th width="4%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody id="result_table"></tbody>
                            </table>
                        </div>
                        <div id="cols"></div>
                        <button class="btn btn-primary" onclick="simpan()">Simpan</button>
                        <button class="btn btn-primary" onclick="batal()">Batal</button>
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


<script>
	var img = "http://localhost/perpustakaan/assets/spin.svg";//** url images **//
    $(document).ready(function(){
	    get_buku();
	    $("#col").val('4')
	    // check();
    });

    $("#any").autocomplete({
        minChars: 2,
        serviceUrl: '<?=base_url().'bo/cart_buku'?>',
        type: 'post',
        dataType: 'json',
        response: function(event, ui) {
            if (ui.content.length === 0) {
                $("#empty-message").text("No results found");
            } else {
                $("#empty-message").empty();
            }
        },
        onSelect: function (suggestion) {
            console.log(suggestion);
            if (suggestion.judul !== 'not_found') {
                console.log(suggestion.judul);
                insertTr(suggestion.id);
                $(this).val('');
            } else {
                //$("#kd_brg").val('').focus();
            }
        }
    });



    function insertTr(id){
	    $.ajax({
		    url : "<?=base_url().'bo/insert_tr'?>",
		    type: "post",
		    dataType:"JSON",
		    data: {id:id},
		    beforeSend: function() {$('body').append('<div class="first-loader"><img src="'+img+'"></div>')},
		    complete  : function() {$('.first-loader').remove()},
		    success:function(res){
			    console.log(res);
			    if(res.status == true){
				    get_buku();
			    }else{
				    alert(res.msg);
			    }
			    // if(res.qty <='2'){
			    //
			    // }


		    }
	    });

    }


    function checkQty(qty){
	    if(qty <= '2'){
	    	return true;
        }else{
	    	return false;
        }

    }


    function update(qty,id,no){
	    $.ajax({
		    url : "<?=base_url().'bo/updateTr'?>",
		    type: "POST",
		    dataType:"JSON",
		    data:{qty:qty,id:id},
		    success:function(res){
			    console.log(res.msg);
		    }
	    })

    }

    function simpan(){
    	if($("#col").val() !== '0'){
		    $.ajax({
			    url : "<?=base_url().'bo/insertDetPeminjaman'?>",
			    type: "POST",
			    dataType:"JSON",
			    data:{tgl_peminjaman:$("#tgl_peminjaman").val(),catatan:$("#catatan").val()},
			    beforeSend: function() {$('body').append('<div class="first-loader"><img src="'+img+'"></div>')},
			    complete  : function() {$('.first-loader').remove()},
			    success:function(res){
				    // location.reload();
				    swal('Kerja Bagus!', 'Pemijaman Buku Berhasil!', 'success');
				    get_buku();
			    }
		    })
        }

    }

    function batal(){
	    $.ajax({
		    url : "<?=base_url().'bo/deleteAllTr'?>",
		    type: "POST",
		    dataType:"JSON",
		    beforeSend: function() {$('body').append('<div class="first-loader"><img src="'+img+'"></div>')},
		    complete  : function() {$('.first-loader').remove()},
		    success:function(res){
			    console.log(res.msg);
			    get_buku();

		    }
	    })
    }

	function hapus(id){
		console.log("<?=$this->session->id?>");
		$.ajax({
			url : "<?=base_url().'bo/deleteOne'?>",
			type: "POST",
			dataType:"JSON",
            data:{id:id},
			beforeSend: function() {$('body').append('<div class="first-loader"><img src="'+img+'"></div>')},
			complete  : function() {$('.first-loader').remove()},
			success:function(res){
				console.log(res.msg);
				if(res.status == 'success'){
					get_buku();
				}else{
					console.log(res.msg);
				}
			}
		})
	}


    function get_buku(){
	    $.ajax({
		    url : "<?=base_url().'bo/get_buku'?>",
		    type: "post",
		    dataType:"JSON",
		    beforeSend: function() {$('body').append('<div class="first-loader"><img src="'+img+'"></div>')},
		    complete  : function() {$('.first-loader').remove()},
		    success:function(res){
			    console.log(res);
			    $("#result_table").html(res.result);
			    $("#cols").html(res.col);

		    }
	    });
    }

</script>