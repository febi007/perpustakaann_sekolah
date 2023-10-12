<script src="<?=base_url().'assets/assets/'?>js/jquery.min.js"></script>

<iframe id="ifr" src="<?=base_url().'assets/upload/buku/BABIdikonversi.pdf#toolbar=0'?>" width='800' height='1000' allowfullscreen></iframe>`
<style>
    #download{display: none!important;}
</style>
<script>


	$(document).ready(function(){
		$('#ifr').contents().find('#download').css("display","none");
    })
</script>