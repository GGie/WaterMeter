<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Management Information System :. - <?php echo COMPANY ?></title>
	<link href="<?php echo base_url('assets/mobile') ?>/vendor/bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/easyuilogin.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/icon.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/demo.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/jss/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/jss/jquery.easyui.min.js"></script>

<style>
  #outPopUp {
      position: absolute;
      width: 400px;
      height: 387px;
      z-index: 15;
      top: 20%;
      left: 46%;
      margin: -100px 0 0 -150px;
      padding: 20px 20px 20px 20px;
    }   
</style>
<script>
$(document).ready(function(){
	$('#txtuser').next().find('input').focus()
});	
</script>

</head>
<body style="height:100%;width:100%;background-image:url(assets/images/bg_default.gif);background-repeat:no-repeat; background-size:cover;">
    <div style="background:#3e6db9;pdding:0px 0px 0px 0px; width=90%;">
        <img src="assets/images/logo2.png" border="0"  height="30" style="vertical-align: middle;padding:8px;"/><font color="#FFFFFF">
        <?php echo COMPANY ?>, <?php echo ADDRESS ?></font>
    </div>
    <div style="background:#ffffff;pdding:0px 0px 0px 0px; width=90%;height:1px;">
    </div>
    <div id="outPopUp">
        
       <div style="height:40px;"></div>
       <p>
       <img src="assets/images/logo.png" border="0"   style="vertical-align: middle;padding:0px;"/>
       </p>


	        <div class="easyui-panel" style="width:400px;padding:15px 15px">

                <form method="post" action="" name="login">
                    <div style="margin-bottom:10px">
                    Please Sign In ... 
                    </div>
					
					<?php if ( $this->session->flashdata('message') ) { ?>
					<div style="padding: 7px 0px 5px 5px;margin: 4px;-moz-border-radius: 6px 6px 6px 6px;background:#FDE4E1;color: #B10009;border:solid 1px #FBD3C6;">
						<?php echo $this->session->flashdata('message') ?>
					</div>
					<?php } ?>
					
		            <div style="margin-bottom:10px">
			            <input type="text" name="txtuser" id="txtuser" size="10"  class="easyui-textbox" prompt="Username" iconWidth="28" style="width:100%;height:34px;padding:10px;">
		            </div>
		            <div style="margin-bottom:10px">
			            <input type="password" name="txtpassword" id="txtpassword" size="6" class="easyui-textbox" prompt="Password" iconWidth="28" style="width:100%;height:34px;padding:10px">
		            </div>
		            <div style="margin-bottom:5px">
			            <input name="login" type="submit" value=" Login " class="easyui-linkbutton" style="padding:5px 20px 5px 20px;">
		            </div>
                </form>
	        </div>
			<div class="easyui-panel" style="width:400px;padding:5px 15px;margin-top:15px;">
				<p>IP Anda : <?php echo $this->input->ip_address() ?></p>
	        </div>
			<?php if ( $id_browser != 'Google Chrome' ) { ?>
			<div class="easyui-panel" style="background-color: #FEEFB3;width:400px;padding:5px 15px;margin-top:15px;">
				<p>Disarankan untuk memakai Google Chrome <a href="https://www.google.com/chrome/browser/desktop/index.html"> Download</a></p>
	        </div>
			<?php } ?>

        <p style="text-align:center;">Copyrights &copy;  <?php echo COMPANY ?> - <?php echo version ?></p>
        
            <p style="text-align:center;">
            All data and programs is owned by <?php echo COMPANY ?> <br />
            and are not allowed misuse or copied <br />
            without permission of the company.
            </p>
    </div>
</body>
</html>





