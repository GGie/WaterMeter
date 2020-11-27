<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="utf-8">
	<title>Menu Edit</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/easyui.css'); ?>">
		<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" media="screen">
		<link href="<?php echo base_url('assets/css/icon.css'); ?>" rel="stylesheet" media="screen">	
		<link href="<?php echo base_url('assets/js/jquery-nestable/jquery.nestable.css'); ?>" rel="stylesheet" media="screen">	

	<script type="text/javascript" src="<?php echo base_url('assets/jss/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jss/jquery.easyui.min.js'); ?>"></script>
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
	<body class="easyui-layout" style="visibility:hidden">
	<div data-options="region:'center'">
	<div class="easyui-layout" style="width:100%;height:100%;">
		<div data-options="region:'north',border:false" style="height:35px;background:#ffffff;padding:0px">
            <div class="HeaderTopMenu">
				<div style="background: #3e6db9;padding:10px;float:left" align="left">
					<font color="#ffffff"><?php echo COMPANY ?></font>
				</div>
                <div style="background: #3e6db9;padding:10px;" align="right">
                <div align="right">
                     <font color="#ffffff">Username : <?php echo $this->session->userdata('username') ?> ( <?php echo $this->session->userdata('user_id') ?> )</font>
                </div>
				
                </div>
            </div>
            <div class="HeaderTopModule"></div>
		</div>
		<div data-options="region:'south',split:true" style="background: #3e6db9;height:30px;padding:4px;">
            <font color="#ffffff"><?php echo copyright ?> | <?php echo version ?> | User : <?php echo $this->session->userdata('username') ?></font>
        </div>

        <!-- #Left Menu -->
		
		
        
        <!-- #Body -->
        
	</div>

	</div>
<!-- TOOLBAR -->

    <script>
		function DoBack() {
			document.location.href = "<?php echo base_url('setting/menu/' . $this->uri->segment(3)) ?>";
		}
        function submitForm(){
            // $('#ff').form('submit');
			$('#ff').form('submit',{
				url: '<?php echo base_url('setting/menu_save') ?>',
				dataType: "json",
				contentType: "application/json; charset=utf-8",
				onSubmit: function(){
					
					$(this).form('enableValidation');
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
							
							DoBack();
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
        function clearForm(){
            $('#ff').form('clear');
        }
    </script>
<!-- TOOLBAR EOF -->
<!-- Dialog Form -->
    <div style="margin:10px 0;"></div>
    <div class="easyui-dialog" title="Edit Menu" style="width:100%;max-width:400px;padding:10px 60px;">
        <form id="ff" method="post" action="">
		<input type="hidden" id="id_menu_type" name="id_menu_type" value="<?php echo $menu->id_menu_type ?>">
            <div style="margin-bottom:10px">
				<input type="text" id="menu_id" name="menu_id" class="easyui-textbox" required="true" size="30" maxlength="50" value="<?php echo $menu->menu_id ?>" data-options="label:'ID:',required:true, readonly:true"/>
            </div>
			<div style="margin-bottom:10px">
				<input type="text" id="menu" name="menu" class="easyui-textbox" required="true" size="30" maxlength="50" value="<?php echo $menu->menu ?>" data-options="label:'Menu:',required:true"/>
            </div>
            <div style="margin-bottom:10px">
                <input type="text" id="title" name="title" class="easyui-textbox" id="password" required="true" size="30" maxlength="50" value="<?php echo $menu->title ?>" data-options="label:'Menu Title:',required:true"/>
            </div>
            <div style="margin-bottom:10px">
                <input type="text" id="url" name="url" class="easyui-textbox" size="25" maxlength="50" value="<?php echo $menu->url ?>" placeholder="<?php echo base_url() ?>" data-options="label:'Url:'"/>
            </div>
			
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='view' id='view' <?php echo ($menu->view) ? 'checked' : '' ?>><label> View</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='created' id='created' <?php echo ($menu->created) ? 'checked' : '' ?>><label> Created</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='updated' id='updated' <?php echo ($menu->updated) ? 'checked' : '' ?>><label> Updated</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='cancelled' id='cancelled' <?php echo ($menu->cancelled) ? 'checked' : '' ?>><label> Cancelled</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='deleted' id='deleted' <?php echo ($menu->deleted) ? 'checked' : '' ?>><label> Deleted</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='print' id='print' <?php echo ($menu->print) ? 'checked' : '' ?>><label> Print</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='downloaded' id='downloaded' <?php echo ($menu->downloaded) ? 'checked' : '' ?>><label> Downloaded</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='uploaded' id='uploaded' <?php echo ($menu->uploaded) ? 'checked' : '' ?>><label> Uploaded</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='closed' id='closed' <?php echo ($menu->closed) ? 'checked' : '' ?>><label> Closed</label>
			</div>
			<div style="margin-bottom:0px">
				<input type='checkbox' class="easyui-checkbox" name='verified' id='verified' <?php echo ($menu->verified) ? 'checked' : '' ?>><label> Verified</label>
			</div>
			
        </form>
        <div style="text-align:center;padding:15px 0">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="submitForm()" style="width:80px">Submit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="clearForm()" style="width:80px">Clear</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-back',plain:false" onclick="DoBack()">Back</a>
        </div>
    </div>

<!-- Dialog Form EOF -->
</body>
</html>