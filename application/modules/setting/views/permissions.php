<!DOCTYPE html>
<html>
<head>

	<meta charset="UTF-8">
	<title>Users Permissions</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/easyui.css'); ?>">
        <link href="<?php echo base_url('assets/css/redmond/jquery-ui-1.9.2.custom.css'); ?>" rel="stylesheet" media="screen">
        <link href="<?php echo base_url('assets/css/redmond/ui.layout.css'); ?>" rel="stylesheet" media="screen">
		<!--<link href="assets/css/ui.jqgrid.css" rel="stylesheet" media="screen">-->
		<link href="<?php echo base_url('assets/css/jquery.treeview.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" media="screen">
		<link href="<?php echo base_url('assets/css/icon.css'); ?>" rel="stylesheet" media="screen">	
	
	<script type="text/javascript" src="<?php echo base_url('assets/jss/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jss/jquery.easyui.min.js'); ?>"></script>
	<!--<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.edatagrid.js'); ?>"></script>-->
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
		<div data-options="region:'west',split:true" title="Look up &amp; Tools" style="width:200px;">
                <form id="form" method="post" novalidate >
				<table width="180" border="0" cellspacing="1" cellpadding="2" align="center">
	                <tr>
                        <td colspan="2"  height="10" valign="middle" align="left"></td>
                    </tr>
					
                    <tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">From</td>
                        <td width="100" height="20" valign="middle" align="left">
							<select class="easyui-combogrid" name="group_from" id="group_from" style="width:115px" data-options="
									panelWidth: 300,
									idField: 'group_id',
									textField: 'group_name',
									editable: false,
									url: '<?php echo base_url('setting/combogrid_group/'); ?>',
									method: 'get',
									columns: [[
										{field:'group_id',title:'ID',width:50},
										{field:'group_name',title:'Group name',width:80,align:'right'}
									]],
									fitColumns: true
								">
							</select>
						</td>
                    </tr>
					
					<tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">To</td>
                        <td width="100" height="20" valign="middle" align="left">
							<select class="easyui-combogrid" name="group_to" id="group_to" style="width:115px" data-options="
									panelWidth: 300,
									idField: 'group_id',
									textField: 'group_name',
									editable: false,
									url: '<?php echo base_url('setting/combogrid_group/'); ?>',
									method: 'get',
									columns: [[
										{field:'group_id',title:'ID',width:50},
										{field:'group_name',title:'Group name',width:80,align:'right'}
									]],
									fitColumns: true
								">
							</select>
						</td>
                    </tr>
					
					
	                <tr>
                        <td colspan="2" height="25" valign="middle" align="center">
                            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-reload',plain:false" onclick="ToCopy()">Copy</a>
                            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-back',plain:false" onclick="DoBack()">Back</a>
                        </td>
                    </tr>
                  

                  </table>
				  </form>
                   <!-- JAVASCRIPT DAN FUNCTION -->
	                <script type="text/javascript">
	                    function myformatter(date) {
	                        var y = date.getFullYear();
	                        var m = date.getMonth() + 1;
	                        var d = date.getDate();
	                        return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
	                    }
	                    function myparser(s) {
	                        if (!s) return new Date();
	                        var ss = (s.split('/'));
	                        var y = parseInt(ss[0], 10);
	                        var m = parseInt(ss[1], 10);
	                        var d = parseInt(ss[2], 10);
	                        if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
	                            //return new Date(y, m - 1, d);
	                            return new Date(d, m - 1, y);
	                        } else {
	                            return new Date();
	                        }
	                    }
						function DoBack() {
							document.location.href = "<?php echo base_url() ?>";
						}


						function ToCopy(){
							$.messager.confirm('Confirm','Are you sure to Copy Permissions ?',function(r){
								if (r){
									save_copy();
								}
							});
						}


	                </script>
        </div>
		
        
        <!-- #Body -->
        <div data-options="region:'center',title:'Permissions'" style="background-color:#D7E4F2;">
                <!-- TABLE UTAMA -->
		<div style="height:98%" bgcolor="#3E6DB9">
          
                    <!-- ## CONTENT ##-->
<script>
function OnSelectGrid(index, record){
	$('#datagrid-permission').datagrid({
				url: '<?php echo base_url('setting/grid/'); ?>/' + index
	});
}

function check_click(menu_id, name, group_id) {

	if (group_id == '000000' || group_id == '') {
		$.messager.show({
			title:'INFO',
			msg:"Select one of the Group",
			timeout:5000,
			showType:'slide'
		});
	} else {
	
		var value = document.getElementById(name + menu_id);
		if ( value.checked ) { val = 1; } else { val = 0; }

		$.ajax({
			type:'POST',
			url:'<?php echo base_url(); ?>setting/update_id/' + menu_id + "-" + name + "-" + val + "-" + group_id, // this external php file isn't connecting to mysql db
		});
	
	}

}

function save_copy(){

		$('#form').form('submit',{
		url: '<?php echo base_url(); ?>setting/copy_groups',
		dataType: "json",
		contentType: "application/json",
		onSubmit: function(){
			
			$('#form').form('enableValidation');
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
				// var result = eval('('+result+')');
				data = $.parseJSON(result);
				$.messager.progress('close');
				
				if( data.status == "success" ){
					jQuery('#dialog-form').dialog('close');
					jQuery('#datagrid-crud-customer').datagrid('reload');
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
<!-- Data Grid -->
<div id="toolbar">
<div style="padding:10px;">
	Group : 
	<select class="easyui-combogrid" id="group_id" style="width:250px" data-options="
			panelWidth: 300,
			idField: 'group_id',
			textField: 'group_name',
			editable: false,
			url: '<?php echo base_url('setting/combogrid_group/'); ?>',
			method: 'get',
			columns: [[
				{field:'group_id',title:'ID',width:50},
				{field:'group_name',title:'Group name',width:80,align:'right'}
			]],
			fitColumns: true,
			onChange: OnSelectGrid
		">
	</select>
	
</div>
</div>
<table id="datagrid-permission" class="easyui-datagrid" url="<?php echo base_url('setting/grid'); ?>/000000" fit="true" toolbar="#toolbar" pagination="false" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true"
data-options="
	onSortColumn: function(){
        //var opts = $(this).datagrid('options');
            // opts.sorting = false;
			// test = $.parseJSON(opts);
			//alert(opts.sortName);
			// opts.sortable  = false;
			//$('#' + opts.sortName + '44').prop('checked', true);
    },
	onDblClickCell:function(index,field,value){
		var row = $(this).datagrid('getSelected');
		var group = $('#group_id').combobox('getValue');
		
		var checked = $('#view' + row.menu_id).is(':checked');
		
		if(row.view.length > 0) {
			if (checked)
				$('#view' + row.menu_id).prop('checked', false);
			else
				$('#view' + row.menu_id).prop('checked', true);
		
			check_click(row.menu_id, 'view', group);
		}
		
		if(row.created.length > 0) {
			if (checked)
				$('#created' + row.menu_id).prop('checked', false);
			else
				$('#created' + row.menu_id).prop('checked', true);
			
			check_click(row.menu_id, 'created', group);
		}
		
		if(row.updated.length > 0) {
			if (checked)
				$('#updated' + row.menu_id).prop('checked', false);
			else
				$('#updated' + row.menu_id).prop('checked', true);
			
			check_click(row.menu_id, 'updated', group);
		}

		if(row.cancelled.length > 0) {
			if (checked)
				$('#cancelled' + row.menu_id).prop('checked', false);
			else
				$('#cancelled' + row.menu_id).prop('checked', true);
			
			check_click(row.menu_id, 'cancelled', group);
		}
		
		if(row.deleted.length > 0) {
			if (checked)
				$('#deleted' + row.menu_id).prop('checked', false);
			else
				$('#deleted' + row.menu_id).prop('checked', true);
			
			check_click(row.menu_id, 'deleted', group);
		}
		
		if(row.print.length > 0) {
			if (checked)
				$('#print' + row.menu_id).prop('checked', false);
			else
				$('#print' + row.menu_id).prop('checked', true);
				
			check_click(row.menu_id, 'print', group);
		}
		
		if(row.downloaded.length > 0) {
			if (checked)
				$('#downloaded' + row.menu_id).prop('checked', false);
			else
				$('#downloaded' + row.menu_id).prop('checked', true);
				
			check_click(row.menu_id, 'downloaded', group);
		}
		
		if(row.uploaded.length > 0) {
			if (checked)
				$('#uploaded' + row.menu_id).prop('checked', false);
			else
				$('#uploaded' + row.menu_id).prop('checked', true);
				
			check_click(row.menu_id, 'uploaded', group);
		}
		
		if(row.closed.length > 0) {
			if (checked)
				$('#closed' + row.menu_id).prop('checked', false);
			else
				$('#closed' + row.menu_id).prop('checked', true);
			
			check_click(row.menu_id, 'closed', group);
		}
		
		if(row.verified.length > 0) {
			if (checked)
				$('#verified' + row.menu_id).prop('checked', false);
			else
				$('#verified' + row.menu_id).prop('checked', true);
			
			check_click(row.menu_id, 'verified', group);
		}
		
	},
	onSelect: function(index, row) {
		// $(this).datagrid('unselectRow', index);
	}
	">
			<thead>
		<tr>
			<?php if ( $this->permissions->superadmin() ) { ?>
				<th field="menu_id" width="20" sortable="false">ID</th>
				<th field="url" width="80" sortable="false">URL</th>
			<?php } ?>
			
			<th field="menu" width="150" sortable="false">Menu</th>
			<th field="view" width="45" sortable="false" align="center">View</th>
			<th field="created" width="45" sortable="false" align="center" onclick="verticaltest();">Create</th>
			<th field="updated" width="45" sortable="false" align="center">Update</th>
			<th field="cancelled" width="45" sortable="false" align="center">Cancel</th>
			<th field="deleted" width="45" sortable="false" align="center">Delete</th>
			<th field="print" width="45" sortable="false" align="center">Print</th>
			<th field="downloaded" width="45" sortable="false" align="center">Download</th>
			<th field="uploaded" width="45" sortable="false" align="center">Upload</th>
			<th field="closed" width="45" sortable="false" align="center">Close</th>
			<th field="verified" width="45" sortable="false" align="center">Verify</th>
		</tr>
	</thead>
</table>
<script>
function verticaltest(){
	alert('test123');
}
</script>
				</div>
	                <!-- TABLE TENGAH -->
					<div style="height:2px;background-color:#3E6DB9;margin:2px">
					</div>
					<!-- TABLE TENGAH EOF -->
				<div style="height:0%" style="border-style: solid;padding:10px">
				</div>


	</div>

	</div>

</body>
</html>