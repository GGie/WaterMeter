
		
	<script type="text/javascript" src="<?php echo base_url('assets/jss/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jss/jquery.easyui.min.js'); ?>"></script>
	

<!-- Toolbar -->

<!-- Dialog Form -->
<div class="easyui-panel" style="width:50%;margin:autopx;">
	<form id="form_pass" method="post" name="form_pass">
			<div style="padding:4px;">	
				<input type="password" name="pass" class="easyui-textbox" style="width:250px;" data-options="validType:'length[2,350]'">
			</div>

			<div style="padding:4px;">	
				<input type="password" name="pass" class="easyui-textbox" style="width:250px;" data-options="validType:'length[2,350]'">
			</div>			
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="save_pass()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>

	</form>
</div>
	
<script>

function save_pass(){

	jQuery('#form_pass').form('submit',{
		url: '<?php echo base_url('setting/update_pass'); ?>',
		onSubmit: function(){
			return jQuery(this).form('validate');
		},
		success: function(result){
			if (result) {
				data = $.parseJSON(result);
				if(data.success){
					alert('test');
					jQuery('#dialog-form-change').dialog('close');
					jQuery('#datagrid-crud-user').datagrid('reload');
				} else {
					jQuery.messager.show({
						title: 'Error',
						msg: data.msg
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