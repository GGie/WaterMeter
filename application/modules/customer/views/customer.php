<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Master Data Customer</title>
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
		url  : "<?php echo base_url('home/check_refresh/customer'); ?>",
		success : function(data){
			if( Number(data.data) > Number(count)){
				count = data.data;
				if( user_id !== data.user_id){
					$('#datagrid-crud-customer').datagrid('reload');
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
                        <td height="20" valign="middle" align="right" style="font-size:12px;">Unitcode</td>
                        <td width="100" height="20" valign="middle" align="left"><input  Name="value_reference" id="value_reference" size="8" value="" type="text" class="easyui-textbox"/></td>
                    </tr>
					
					<tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">Customer ID</td>
                        <td width="100" height="20" valign="middle" align="left"><input  Name="value_customer_id" id="value_customer_id" size="8" value="" type="text" class="easyui-textbox"/></td>
                    </tr>
					
					<tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">Customer Name</td>
                        <td width="100" height="20" valign="middle" align="left"><input  Name="value_customer_name" id="value_customer_name" size="8" value="" type="text" class="easyui-textbox"/></td>
                    </tr>
					
					<tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">Cluster</td>
                        <td width="100" height="20" valign="middle" align="left"><input  Name="value_area" id="value_area" size="8" value="" type="text" class="easyui-textbox"/></td>
                    </tr>
					
					<tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">Klasifikasi</td>
                        <td width="100" height="20" valign="middle" align="left">
							<input name="value_klasifikasi" id="value_klasifikasi" class="easyui-combogrid" style="width:90px;" data-options="
									panelWidth: 250,
									idField: 'id_klasifikasi',
									textField: 'klasifikasi',
									editable: false,
									url: '<?php echo base_url('klasifikasi/klasifikasi_combogrid/all'); ?>',
									mode: 'remote',
									onSelect: function(){										
										
									},
									columns: [[
										//{field:'id_klasifikasi',title:'ID',width:20},
										{field:'klasifikasi',title:'Klasifikasi',width:80},
									]],
									fitColumns: true
								">
						</td>
                    </tr>
					
					<tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">Address</td>
                        <td width="100" height="20" valign="middle" align="left"><input  Name="value_address" id="value_address" size="8" value="" type="text" class="easyui-textbox"/></td>
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


						function ToSearch(){
							var value_reference 	= $('#value_reference').textbox('getValue');
							var value_customer_id 	= $('#value_customer_id').textbox('getValue');
							var value_customer_name = $('#value_customer_name').textbox('getValue');
							var value_area 			= $('#value_area').textbox('getValue');
							var value_klasifikasi	= $('#value_klasifikasi').combobox('getValue');
							var value_address		= $('#value_address').textbox('getValue');
							
								$('#datagrid-crud-customer').datagrid('load',{
									reference: value_reference,
									customer_id: value_customer_id,
									customer_name: value_customer_name,
									area: value_area,
									id_klasifikasi: value_klasifikasi,
									address: value_address,
								}); 
						}
						
						function ToSearchreportmeter(){
							var value_period_id			= $('#value_period_id').textbox('getValue');
							var value_status_id			= $('#value_status_id').textbox('getValue');
							
		
								$('#datagrid-crud-reportmeter').datagrid('load',{
									period_id: value_period_id,
									status_id: value_status_id,
								}); 
						}

	                </script>
<script type="text/javascript">
var url;

function qrcode_customer(){
	
	var row = jQuery('#datagrid-crud-customer').datagrid('getSelected');
	if(row){
		
		$.ajax("../customer/qrcode/" + row.reference).done(function (reply) {
			// alert(reply);
			$('#qrcode').html(reply);
			jQuery('#dialog-qrcode').dialog('open').dialog('setTitle','QRCODE');
		});
		
	}
	
}

function create_customer(){
	$('#form').form('disableValidation');
	
	jQuery('#dialog-form').dialog('open').dialog('setTitle','Add Data');
	jQuery('#form').form('clear');
	url = '<?php echo base_url('customer/create_customer'); ?>';
}

function update_customer(){
	var row = jQuery('#datagrid-crud-customer').datagrid('getSelected');
	if(row){
		jQuery('#dialog-form').dialog('open').dialog('setTitle','Update Data');
		//jQuery('#password').form('load',row.id);
		jQuery('#form').form('load',row);
		
		url = '<?php echo base_url('customer/update_customer'); ?>/' + row.id;
	}
}

function save_customer(){

		$('#form').form('submit',{
		url: url,
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

function remove_customer(){
	var row = jQuery('#datagrid-crud-customer').datagrid('getSelected');
	if (row){
		
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('customer/delete_customer') ?>",
					data: {id:row.id},
					dataType: "json",
					success:
					function(data){
						if ( data.status == "success") {
							jQuery('#datagrid-crud-customer').datagrid('reload');
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

function printreportmeter(){
	var value_period_id			= $('#value_period_id').textbox('getValue');
	var value_status_id			= $('#value_status_id').textbox('getValue');
	var row = jQuery('#datagrid-crud-customer').datagrid('getSelected');
	if (row){
		// alert(value_period_id);
		//if(value_period_id && value_status_id){
			jQuery('#print').attr('src','<?php echo base_url() ?>reportmeter/pdf_reportmeter?status_id=' + value_status_id + "&customer_id=" + row.customer_id + "&period_id=" + value_period_id + "&detail=true&period=all");
			jQuery('#dialog-print-reportmeter').dialog('open').dialog('setTitle','Preview');	
		//}
	}
}
</script>
        </div>
		
        
        <!-- #Body -->
        <div data-options="region:'center',title:'Master Data Customer'" style="background-color:#D7E4F2;">
		<!-- TABLE UTAMA -->
		<div style="height:80%" bgcolor="#3E6DB9">
		<table id="datagrid-crud-customer" class="easyui-datagrid" style="height:100%" url="<?php echo base_url('customer/getJsonCustomer'); ?>" fit="true" toolbar="#toolbar-customer" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true"
				data-options="
					'onDblClickRow': function(index, row, value){
						
									//$('#DateFrom').textbox('setValue', '<?php echo date('Y-m-d', strtotime("-12 month")); ?>');
									//$('#DateTo').textbox('setValue', '<?php echo date('Y-m-d'); ?>');
									jQuery('#dialog-grid-reportmeter').dialog('open').dialog('setTitle',row.customer_name);
									// $('#id_nc_jawab').val(row.id_nc.split('/').join('_'));
									// jQuery('#form-jawab-nc').form('load',row);
									
									
									$('#datagrid-crud-reportmeter').datagrid({
										url: '<?php echo base_url('reportmeter/getJsonreportmeter'); ?>/' + row.customer_id + '?period_id=all'
									});
							},
					">
			<thead>
				<tr>
					<th field="customer_id" width="60" sortable="true">ID</th>
					<th field="reference" width="120" sortable="true">Unitcode</th>
					<th field="ktp" width="80" sortable="true">Ktp</th>
					<!--<th field="business_name" width="80" sortable="true">Business Name</th>-->
					<th field="customer_name" width="100" sortable="true">Customer Name</th>
					<th field="area" width="100" sortable="true">Cluster</th>
					<th field="klasifikasi" width="100" sortable="true">Klasifikasi</th>
					<th field="address" sortable="true">Address</th>
					<th field="description" width="200" sortable="true">Description</th>
					<!--<th field="stand_awal" width="100" sortable="true">Stand Awal</th>
					<th field="stand_akhir" width="100" sortable="true">Stand Akhir</th>
					<th field="input_by" width="80" sortable="true">Input By</th>
					<th field="input_date" width="70" sortable="true">Input Date</th>
					<th field="update_by" width="80" sortable="true">Update By</th>
					<th field="update_date" width="70" sortable="true">Update Date</th>-->
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
		<div style="height:18%" style="border-style: solid;padding:10px">

		</div>
		<!-- TABLE DETAIL EOF -->
		</div>
	</div>

	</div>
<!-- TOOLBAR -->
<div id="toolbar-customer">
	<?php if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" style="width:100px" onclick="create_customer()">Add</a>
	<?php } ?>
	<?php if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" style="width:100px" onclick="update_customer()">Edit</a>
	<?php } ?>
	<?php if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" style="width:100px" onclick="remove_customer()">Delete</a>
	<?php } ?>
	
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-help" style="width:100px" onclick="qrcode_customer()">QRcode</a>
</div>
<!-- TOOLBAR EOF -->

<!-- Dialog qrcode -->
<div id="dialog-qrcode" class="easyui-dialog" style="width:300px; height:330px; padding: 10px 20px" modal="true" closed="true">
	<div id="qrcode"></div>
</div>
<!-- Dialog qrcode EOF -->

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" style="width:450px; height:400px; padding: 10px 20px" modal="true" closed="true" buttons="#dialog-buttons-user">
	<form id="form" method="post" novalidate >
	<input type="hidden" name="id" required="true"/>
		<div class="form-item">
			<div style="float:left;width:130px;align:left">
				<label>ID</label>
			</div>
			<div>
				<input type="text" name="customer_id" class="easyui-textbox" required="true" size="30" maxlength="6" />
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:left">
				<label>Unitcode</label>
			</div>
			<div>
				<input type="text" name="reference" class="easyui-textbox" required="true" size="30" maxlength="50" />
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>KTP</label>
			</div>
			<div>
				<input type="text" name="ktp" class="easyui-textbox" id="ktp" size="30" maxlength="50" />
			</div>
		</div>
		<!--
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Business Name</label>
			</div>
			<div>
				<input type="text" name="business_name" class="easyui-textbox" id="business_name" size="30" maxlength="50" />
			</div>
		</div>
		-->
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Customer Name</label>
			</div>
			<div>
				<input type="text" name="customer_name" class="easyui-textbox" id="password" required="true" size="30" maxlength="50" />
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Cluster</label>
			</div>
			<div>
				<input type="text" name="area" class="easyui-textbox" required="true" size="30" maxlength="50" />
			</div>
		</div>
		
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Klasifikasi</label>
			</div>
			<div>
				<input name="id_klasifikasi" id="id_klasifikasi" class="easyui-combogrid" style="width:220px;" required="true" data-options="
									panelWidth: 400,
									idField: 'id_klasifikasi',
									textField: 'klasifikasi',
									editable: false,
									url: '<?php echo base_url('klasifikasi/klasifikasi_combogrid/'); ?>',
									mode: 'remote',
									onSelect: function(){										
										
									},
									columns: [[
										{field:'id_klasifikasi',title:'ID',width:20},
										{field:'klasifikasi',title:'Klasifikasi',width:80},
									]],
									fitColumns: true
								">
			</div>
		</div>
		
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Address</label>
			</div>
			<div>
				<input type="text" name="address" class="easyui-textbox" data-options="multiline:true" required="true" size="30" maxlength="200" />
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Description</label>
			</div>
			<div>
				<input type="text" name="description" class="easyui-textbox" data-options="multiline:true" size="30" maxlength="50" />
			</div>
		</div>
		
		<!--
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Count Meter</label>
			</div>
			<div>
				<input type="text" name="count_meter" class="easyui-numberbox" required="true" size="30" maxlength="10" />
			</div>
		</div>
		-->
		
		</div>
	</form>
</div>
<div id="dialog-buttons-user">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="save_customer()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>
<!-- Dialog Form EOF -->

<!-- Dialog Print -->
<div id="dialog-grid-reportmeter" class="easyui-dialog" style="width:100%; height:100%; padding: 4px 6px" modal="true" closed="true">
	<table id="datagrid-crud-reportmeter" class="easyui-datagrid" style="height:100%" toolbar="#toolbar-reportmeter" fit="true" pagination="true" rownumbers="true" fitColumns="false" singleSelect="true" collapsible="true"
		data-options="
						rowStyler: function(index,row){
								if (row.doublecheck > 1){
									return 'background-color:#eaf2ff;color:#000;opacity: 10;';
								}									
							},"
							>
		<thead>
			<tr>
			<th field="period" width="90" sortable="true">Periode</th>
					<th field="status" width="80" sortable="true">Status</th>
					<th field="reference" width="90" sortable="true">Unitcode</th>
					<!--<th field="doublecheck" width="90" sortable="true">doublecheck</th>-->
					<th field="ktp" width="80" sortable="true">Ktp</th>
					<th field="business_name" width="80" sortable="true">Business Name</th>
					<th field="customer_id" width="80" sortable="true">Customer ID</th>
					<th field="customer_name" width="100" sortable="true">Customer Name</th>
					<th field="area" width="100" sortable="true">Cluster</th>
					<th field="klasifikasi" width="100" sortable="true">Klasifikasi</th>
					<th field="address" sortable="true">Address</th>
					<!--<th field="description" width="200" sortable="true">Description</th>-->
					<th field="prev_final_meter" width="90" sortable="true">Prev Read</th>
					<th field="prev_consumption_meter" width="100" sortable="true">Prev Consumption</th>
					
					<th field="final_meter" width="90" sortable="true">Current Read</th>
					<th field="consumption_meter" width="90" sortable="true">Consumption</th>
					
					<th field="description" width="150" sortable="true">Description</th>
					<th field="tglcreate" width="120" sortable="true">Date</th>
					
			</tr>
		</thead>
	</table>
</div>
<!-- TOOLBAR -->
<div id="toolbar-reportmeter">
	<!--<td width="100" height="20" valign="middle" align="right" style="font-size:12px;">From</td>
	<td width="100" height="20" valign="middle" align="left"><input id="DateFrom" name="DateFrom" size="10" maxlength="10" value="" class="easyui-datebox" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser"></input></td>

	<td width="100" height="20" valign="middle" align="right" style="font-size:12px;">To</td>
	<td width="100" height="20" valign="middle" align="left"><input id="DateTo" name="DateTo" size="10"  maxlength="10" value="" class="easyui-datebox" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser"></input></td>
	-->
	
	<td width="100" height="20" valign="middle" align="right" style="font-size:12px;">
		Period
	</td>
	<td width="100" height="20" valign="middle" align="left">
		 <input name="period_id" id="value_period_id" class="easyui-combogrid" value='' style="width:95px;" data-options="
				panelWidth: 200,
				idField: 'id',
				textField: 'description',
				editable: false,
				url: '<?php echo base_url('period/period_combogrid/all'); ?>',
				mode: 'remote',
				onSelect: function(){										
					
				},
				columns: [[
					//{field:'id',title:'ID',width:20},
					{field:'description',title:'Description',width:80},
				]],
				fitColumns: true
			">
	</td>
	
	<td width="150" height="20" valign="middle" align="right" style="font-size:12px;">
		Status
	</td>
	<td width="100" height="20" valign="middle" align="left">
		 
				<select name='status_id' id="value_status_id" class="easyui-combobox" style="width:95px;" required="true" editable='false'>
					<option value=''>All</option>
					<option value='1'>Approved</option>
					<option value='2'>Pending</option>
					<option value='3'>Open</option>
					<option value='4'>Scan</option>
				</select>
				
			
	</td>
	 <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:false" style="width:100px" onclick="ToSearchreportmeter()">Search</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" style="width:100px" onclick="printreportmeter()">Print</a>
</div>
<!-- TOOLBAR EOF -->
<!-- Dialog Print EOF -->
<!-- Dialog Print -->
<div id="dialog-print-reportmeter" class="easyui-dialog" style="width:100%; height:100%; padding: 4px 6px" modal="true" closed="true">
	<iframe id="print" width="100%" height="98%" src=""></iframe>
</div>
<!-- Dialog Print EOF -->
</body>
</html>