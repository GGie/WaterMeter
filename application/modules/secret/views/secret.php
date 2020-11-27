<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Master Data Secret</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/easyui.css'); ?>">
		<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" media="screen">
		<link href="<?php echo base_url('assets/css/icon.css'); ?>" rel="stylesheet" media="screen">	

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
	
	let count = '<?php echo $refresh ?>';
	let user_id = '<?php echo $this->session->userdata('user_id') ?>';
	
	function gridrefresh(){
		$.ajax({
		type : 'POST',
		url  : "<?php echo base_url('home/check_refresh/secret'); ?>",
		success : function(data){
			if( Number(data.data) > Number(count)){
				count = data.data;
				if( user_id !== data.user_id){
					$('#datagrid-crud-secret').datagrid('reload');
				}
			}
		}
		});
	}
	setInterval("gridrefresh()", 4000);
	
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
		<div data-options="region:'west',split:true" title="Look up &amp; Tools" style="width:200px;">
                <table width="180" border="0" cellspacing="1" cellpadding="2" align="center">
	                <tr>
                        <td colspan="2"  height="10" valign="middle" align="left"></td>
                    </tr>
                    <tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">Secret</td>
                        <td width="100" height="20" valign="middle" align="left"><input  Name="secret" id="secret" size="8" value="" type="text" class="easyui-textbox"/></td>
                    </tr>
					
	                <tr>
                        <td colspan="2"  height="10" valign="middle" align="left"></td>
                    </tr>
	                
					<tr>
                        <td colspan="2" height="25" valign="middle" align="center">
                            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:false" onclick="ToSearch()">Search</a>
                            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-back',plain:false" onclick="DoBack()">Back</a>
                        </td>
                    </tr>
                  

                  </table>
                   <!-- JAVASCRIPT DAN FUNCTION -->
	                <script type="text/javascript">
	                    function myformatter(date){
							var y = date.getFullYear();
							var m = date.getMonth()+1;
							var d = date.getDate();
							return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
						}
						
						function myparser(s){
							if (!s) return new Date();
							var ss = (s.split('-'));
							var y = parseInt(ss[0],10);
							var m = parseInt(ss[1],10);
							var d = parseInt(ss[2],10);
							if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
								return new Date(y,m-1,d);
							} else {
								return new Date();
							}
						}
						
						function DoBack() {
							document.location.href = "<?php echo base_url() ?>";
						}


						function ToSearch(){
							var secret 	= $('#secret').textbox('getValue');
							
								$('#datagrid-crud-secret').datagrid('load',{
									secret: secret,
								}); 
						}

	                </script>
<script type="text/javascript">
var url;

function create_secret(){
	$('#form').form('disableValidation');
	
	jQuery('#dialog-form').dialog('open').dialog('setTitle','Add Data');
	jQuery('#form').form('clear');
	$('#tglcreate').textbox('setValue', '<?php echo date("Y-m-d H:i:s"); ?>');

	url = '<?php echo base_url('secret/create_secret'); ?>';
}

function update_secret(){
	var row = jQuery('#datagrid-crud-secret').datagrid('getSelected');
	if(row){
		jQuery('#dialog-form').dialog('open').dialog('setTitle','Update Data');
		jQuery('#form').form('load',row);	
		url = '<?php echo base_url('secret/update_secret'); ?>';
	}
}

function save_secret(){

		$('#form').form('submit',{
		url: url,
		dataType: "json",
		contentType: "application/json",
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
				// var data = eval('('+result+')');
				// data = JSON.parse(result);
				data = $.parseJSON(result);
				$.messager.progress('close');
				
				if( data.status == "success" ){
					jQuery('#dialog-form').dialog('close');
					jQuery('#datagrid-crud-secret').datagrid('reload');
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

function remove_secret(){
	var row = jQuery('#datagrid-crud-secret').datagrid('getSelected');
	if (row){
		
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('secret/delete_secret') ?>",
					data: {id:row.id_secret},
					dataType: "json",
					success:
					function(data){
						if ( data.status == "success") {
							jQuery('#datagrid-crud-secret').datagrid('reload');
						} else {
							jQuery.messager.show({
								title: 'Error',
								msg: data.message
							});
						}
						
					}
				});
			}
		
		
		});
	}
}

function active_secret(){
	var row = jQuery('#datagrid-crud-secret').datagrid('getSelected');
	if (row){
		
		$.messager.progress({
			title:'Please waiting',
			msg:'Loading data...',
		});
		
		setTimeout(function(){
			$.messager.progress('close');
		}, 90000);

		
		jQuery.messager.confirm('Confirm','Are you sure you want to Active Secret ?',function(r){
			if (r){
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('secret/active_secret') ?>",
					data: {id:row.option_id},
					dataType: "json",
					success:
					function(data){
						$.messager.progress('close');
						
						if ( data.status == "success") {
							jQuery('#datagrid-crud-secret').datagrid('reload');
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
						
					}
				});
			}
		
		
		});
	}
}
</script>
        </div>
		
        
        <!-- #Body -->
        <div data-options="region:'center',title:'Master Data Secret'" style="background-color:#D7E4F2;">
		<!-- TABLE UTAMA -->
		<div style="height:80%" bgcolor="#3E6DB9">
		<table id="datagrid-crud-secret" class="easyui-datagrid" style="height:100%" url="<?php echo base_url('secret/getJsonsecret'); ?>" fit="true" toolbar="#toolbar-user" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true">
			<thead>
				<tr>
					<th field="active" width="80" sortable="true">Active</th>
					<th field="reportmeter_folder_id" width="250" sortable="true">Folder id</th>
					<th field="client_email" width="350" sortable="true">Client Email</th>
					<th field="private_key" width="250" sortable="true">Private Key</th>
					<!--<th field="input_by" width="100" sortable="true">Input By</th>
					<th field="input_date" width="100" sortable="true">Input Date</th>
					<th field="update_by" width="100" sortable="true">Update By</th>
					<th field="update_date" width="100" sortable="true">Update Date</th>-->
				</tr>
			</thead>
		</table>
		</div>
		<!-- TABLE UTAMA EOF -->
		<!-- TABLE TENGAH -->
		<div style="height:2px;background-color:#3E6DB9;margin:2px">
		</div>
		<!-- TABLE TENGAH EOF -->
		<!-- TABLE DETAIL -->
		<!--<div style="height:18%" style="border-style: solid;padding:10px">-->
		<!--</div>-->
		
		<!-- TABLE DETAIL EOF -->
		</div>
	</div>

	</div>
<!-- TOOLBAR -->
<div id="toolbar-user">
	<?php if ( $this->permissions->menu($menu_id, 'verified') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="width:100px" onclick="active_secret()">Active</a>
	<?php } ?>
	<?php if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" style="width:100px" onclick="create_secret()">Add</a>
	<?php } ?>
	<?php if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" style="width:100px" onclick="update_secret()">Edit</a>
	<?php } ?>
	<?php if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" style="width:100px" onclick="remove_secret()">Delete</a>
	<?php } ?>
</div>
<!-- TOOLBAR EOF -->
<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" style="width:550px; height:250px; padding: 10px 20px" modal="true" closed="true" buttons="#dialog-buttons-user">
	<form id="form" method="post" enctype="multipart/form-data" novalidate >
	<input type="hidden" name="id_secret" required="true"/>
		<div class="form-item" style="padding-top:4px">
			
			<input type="hidden" name="option_id"/>
			
			<div style="float:left;width:130px;align:left">
				<label>Folder ID</label>
			</div>
			<div>
				<input type="text" name="reportmeter_folder_id" class="easyui-textbox" required="true" size="30" maxlength="100" />
			</div>
		</div>

		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:left">
				<label>Clien Email</label>
			</div>
			<div>
				<input type="text" name="client_email" class="easyui-textbox" required="true" size="30" maxlength="100" />
			</div>
		</div>
		
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:left">
				<label>Private Key</label>
			</div>
			<div>
				<!--<input type="text" name="private_key" class="easyui-textbox" required="true" size="30" maxlength="100" />-->
				<input class="easyui-filebox" name="private_key" style="width:235px">
			</div>
		</div>
		
	</form>
</div>
<div id="dialog-buttons-user">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="save_secret()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>
<!-- Dialog Form EOF -->
</body>
</html>