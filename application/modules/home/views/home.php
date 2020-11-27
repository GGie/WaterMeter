<!DOCTYPE html>
<html>
    <head>
        <title><?php COMPANY ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link href="<?php echo base_url('assets/css/template/css/stylesheet.css') ?>" rel="stylesheet" type="text/css">
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/easyui.css'); ?>">
		<link href="<?php echo base_url('assets/css/icon.css'); ?>" rel="stylesheet">
	
	<script type="text/javascript" src="<?php echo base_url('assets/css/template/js/jquery.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/css/template/js/jquery.easyui.min.js') ?>"></script>

<script type="text/javascript">
//Fungsi untuk logout otomatis Jika 5 menit tidak ada aktifitas
function ceksession(){

	$.ajax({
	type : 'POST',
	url  : "<?php echo base_url('login/check_session'); ?>",
	success : function(data){
		if(data == 1){
			
		}else{
		  document.location.href = "<?php echo base_url('login/logout'); ?>"
		} 
	}
	});
	
}


setInterval("ceksession()", 300000);
</script>
    <script type="text/javascript">
        function CekAktif() {
            
           
 
            $('#tt').tabs({
                border: false,
                onSelect: function (title) {
                    sessionStorage.usedData = title;
                   
                 //   document.getElementById("btn1").value == title;
                   // document.getElementById("btn1").click();
                    
                }
            });
            var ttts = sessionStorage.getItem("usedData");
            if (ttts == "") {
                //alert(' kosog is selected');
            } else {
                //alert(ttts + ' ada is selected');
                $('#tt').tabs('select',ttts);
            }
        }
		
// function save_change(){
	// jQuery('#form-change').form('submit',{
		// url: '<?php echo base_url('setting/change_password') ?>',
		// onSubmit: function(){
			// return jQuery(this).form('validate');
		// },
		// success: function(result){
			// var result = eval('('+result+')');
			// if(result.success){
				// jQuery('#dialog-change').dialog('close');
			// } else {
				// jQuery.messager.show({
					// title: 'Error',
					// msg: result.msg
				// });
			// }
		// }
	// });
// }

function change_password(){
	// $('#form').form('resetValidation');
	$('#form-change').form('disableValidation');

	$('#dialog-change').dialog('open').dialog('setTitle', 'Change Password');
}
		
function save_change(){
	$('#form-change').form('submit',{
		url: '<?php echo base_url('setting/change_password') ?>',
		onSubmit: function(){
			
			$('#form-change').form('enableValidation');
			if ($(this).form('validate')) {
				$.messager.progress({
					title:'Please waiting',
					msg:'Loading data...'
				});
				return true;
			} else {
				return false;
			}
			
		},
		success: function(result){
			if (result) {
				data = $.parseJSON(result);
				$.messager.progress('close');
				
				if( data.status == "success" ){
					jQuery('#dialog-change').dialog('close');
					$.messager.show({
							title:'INFO',
							msg:"Data Save Success",
							timeout:5000,
							showType:'slide'
						});
						
				} else {
					jQuery.messager.show({
						title: 'Error',
						msg: data.message
					});
				}
			} else {
				$.messager.progress('close');
				alert('Save Failed');
			}
		}
	});
}
   </script>


<style>
.tag-box {
  width: 20%;
  padding: 5px;
  background-color: #eaf2ff;
  border: 1px solid #eaf2ff;
  float: left;
  margin-right: 1%;
  margin-bottom: 5px;
  border-radius: 6px;
}

@media only screen and (max-width: 600px) {
.tag-box {
	width: 41%;
	height: 180px;
    }
}

@media only screen and (max-width: 850px) {
.tag-box {
	width: 41%;
	height: 140px;
    }
}
@media only screen and (max-width: 1450px) {
  width: 10px;
  padding: 5px;
  background-color: #f0f0f0;
  border: 1px solid #ccc;
  float: left;
  margin-right: 2%;
  margin-bottom: 10px;	
}
</style>
</head>
<script type="text/javascript">
	$.parser.onComplete = function(){
		$('body').css('visibility','visible');
	};
	//Fungsi untuk logout otomatis Jika 5 menit tidak ada aktifitas
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
	setInterval("ceksession()", 300000);
</script>
<body leftmargin="0" topmargin="0" class="easyui-layout" onload="CekAktif();" style="visibility:hidden">

<div id="dialog-change" class="easyui-dialog" style="width:450px; height:200px; padding: 4px 6px" modal="true" closed="true" buttons="#dialog-change-btn">
<form id="form-change" method="post" action="<?php echo base_url('nc/jawab_nc'); ?>">
		<div class="form-item">
			<div style="float:left;width:130px;align:left">
				<label>User ID</label>
			</div>
			<div>
				<input type="text" name="user_id" class="easyui-textbox" required="true" size="30" maxlength="50" value="<?php echo $this->session->userdata('user_id') ?>" readonly>
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Name</label>
			</div>
			<div>
				<input type="text" name="nmuser" class="easyui-textbox" id="password" required="true" size="30" maxlength="50" value="<?php echo $this->session->userdata('username') ?>" readonly>
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Fullname</label>
			</div>
			<div>
				<input type="text" name="fullname" class="easyui-textbox" required="true" size="30" maxlength="50" value="<?php echo $this->session->userdata('user_fullname') ?>">
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Password</label>
			</div>
			<div>
				<input type="text" name="pwd" class="easyui-textbox" required="true" size="30" maxlength="50" />
			</div>
		</div>
</form>
</div>
<div id="dialog-change-btn">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="save_change()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-change').dialog('close')">Batal</a>
</div>
	<div data-options="region:'north',border:false" style="height:35px;background:#ffffff;padding:0px">
            <div class="HeaderTopMenu">
				<div style="background: #3e6db9;padding:10px;float:left" align="left">
					<font color="#ffffff"><?php echo tgl_to_day(date('Y-m-d')) ?>, <?php echo format_indo_return(date('Y-m-d')) ?></font>
				</div>
                <div style="background: #3e6db9;padding:10px;" align="right">
                <div align="right">
                     <font color="#ffffff">User ID : <?php echo $this->session->userdata('user_id') ?> | 
                     <a href="#" onclick="change_password()" style="color:#ffffff;">Change Password</a>  |
                     <a href="<?php echo base_url('login/logout') ?>" style="color:#ffffff;">Logout</a></font>
                </div>
                </div>
            </div>
            <div class="HeaderTopModule">
			
			</div>
            
    </div>


	<div data-options="region:'south',border:false" style="height:55px;background:#ffffff;padding:5px;"><?php echo copyright ?>
		<marquee><?php echo online(); ?>
		</marquee>
	</div>

	<div data-options="region:'center',title:'<?php COMPANY ?>'">

	<div id="tt" class="easyui-tabs" style="width:100%;height:100%;" data-options="tabPosition:'left'">
        <?php foreach ($menu_tab->result() as $tab) { ?>
        <?php if ( $this->permissions->menu($tab->menu_id, 'view') ) { ?>
              <div title="<?php echo $tab->title ?>" style="padding:10px">
				<?php $menu_child = $this->db->query("SELECT * FROM menu WHERE menu_pid='" . $tab->menu_id . "' AND status_id=1 ORDER BY menu_order"); ?>
				
				
				
				
				
				<?php foreach ($menu_child->result() as $child) { ?>
					
					<?php if ( $this->permissions->menu($child->menu_id, 'view') ) { ?>
						<div class="tag-box">
						<a href="<?php echo $child->url ?>">
							<div><?php echo ucwords(strtolower($child->menu)) ?></div>
							<img src="<?php echo base_url('assets/images/icons/' . $child->icon) ?>" height="64px">
							<div><?php echo ucwords(strtolower($child->title)) ?></div>
						</a>
						</div>
					<?php } ?>
					
				 <?php } ?>
				 
				 
				 
				 
				 
			  </div>
		<?php } ?>
		<?php } ?>
           
	</div>
    </div>
    <form method="post" name="frm" target="_parent" id="frm" >  
    <input name="btn1" type="submit" id="btn1" value="F Submit " hidden=hidden />
    </form>
</body>
</html>
