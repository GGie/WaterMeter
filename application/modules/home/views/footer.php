<script type="text/javascript">
function ceksession(){

	$.ajax({
	type : 'POST',
	url  : "<?php echo base_url('home/check_session'); ?>",
	success : function(data){
		if(data == 1){
			
		}else{
		  document.location.href = "<?php echo base_url('login/logout'); ?>"
		} 
	}
	});
	
}

setInterval("ceksession()", 600000);
</script>