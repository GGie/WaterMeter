<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Master Data Report</title>
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
		url  : "<?php echo base_url('home/check_refresh/reportmeter'); ?>",
		success : function(data){
			if( Number(data.data) > Number(count)){
				count = data.data;
				if( user_id !== data.user_id){
					$('#datagrid-crud-reportmeter').datagrid('reload');
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
					
					<!--
					<tr>
                        <td width="100" height="20" valign="middle" align="right" style="font-size:12px;">From</td>
                        <td width="100" height="20" valign="middle" align="left"><input id="DateFrom" name="DateFrom" size="10" maxlength="10" value="<?php echo date('Y-m-d', strtotime("-1 month")); ?>" class="easyui-datebox" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser"></input></td>
                    </tr>
                    <tr>
                        <td width="100" height="20" valign="middle" align="right" style="font-size:12px;">To</td>
                        <td width="100" height="20" valign="middle" align="left"><input id="DateTo" name="DateTo" size="10"  maxlength="10" value="<?php echo date("Y-m-d"); ?>" class="easyui-datebox" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser"></input></td>
                    </tr>
                    -->
                    
					
		
					<tr>
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
                    </tr>
					
					<tr>
                        <td width="150" height="20" valign="middle" align="right" style="font-size:12px;">
							Period
						</td>
                        <td width="100" height="20" valign="middle" align="left">
							 <input name="period_id" id="value_period_id" class="easyui-combogrid" style="width:95px;" value='<?php echo $getPeriod ?>' data-options="
									panelWidth: 200,
									idField: 'id',
									textField: 'description',
									editable: false,
									url: '<?php echo base_url('period/period_combogrid/'); ?>',
									mode: 'remote',
									onSelect: function(){										
										
									},
									columns: [[
										{field:'id',title:'ID',width:20},
										{field:'description',title:'Description',width:80},
									]],
									fitColumns: true
								">
						</td>
                    </tr>
					
					
					<tr>
                        <td width="150" height="20" valign="middle" align="right" style="font-size:12px;">
							PIC Scan
						</td>
                        <td width="100" height="20" valign="middle" align="left">
							 <input name="user_pic" id="user_pic" class="easyui-combogrid" style="width:95px;" data-options="
									panelWidth: 200,
									idField: 'user_id',
									textField: 'user_name',
									editable: true,
									url: '<?php echo base_url('setting/combogrid_user/'); ?>',
									mode: 'remote',
									onSelect: function(){										
										// var val 	= $('#user_pic').combogrid('grid').datagrid('getSelected');
										// alert(val.user_id);
										// $('#customer_id').textbox('setValue', val.customer_id);
									},
									columns: [[
										{field:'user_id',title:'ID',width:25},
										{field:'user_name',title:'Username',width:40},
									]],
									fitColumns: true
								">
						</td>
                    </tr>
					
					<!--
					<tr>
                        <td width="150" height="20" valign="middle" align="right" style="font-size:12px;">
							Double Check
						</td>
                        <td width="100" height="20" valign="middle" align="left">
							<input type="checkbox" id="doubleCheck" class="easyui-checkbox" name="doubleCheck" >
						</td>
                    </tr>
					-->
					
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
						
						function myformattertime(date){
							var y = date.getFullYear();
							var m = date.getMonth()+1;
							var d = date.getDate();
							// var s1 = String(d<10?('0'+d):d) + '.' + String(m<10?('0'+m):m) + '.' + String(y);
							var s1 = y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
						   
							var hh = date.getHours();
							var mm = date.getMinutes();
							var ss = date.getSeconds();
							var s2 = String(hh<10?('0'+hh):hh) + ':' + String(mm<10?('0'+mm):mm) + ':' + String(ss<10?('0'+ss):ss);
							
							return s1 + ' ' + s2;
						}
						
						function myparsertime(s)
						 {
							//alert('mydtparser(s) s=['+ s +']');
							// if ( (!s) || ($.trim(s) == '') )
							  // {return new Date();}
							var dt = s.split(' ');
							var dateFormat = dt[0].split('-');
							var timeFormat = dt[1].split(':');
							var date = new Date( parseInt(dateFormat[0]),parseInt(dateFormat[1])-1,parseInt(dateFormat[2]) );
							if (dt.length>1){
							  date.setHours(timeFormat[0]);
							  date.setMinutes(timeFormat[1]);
							  date.setSeconds(timeFormat[2]);
							}
							//alert('mydtparser(s) return date=['+ date +']');
							return date;
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
							var value_user_pic		= $('#user_pic').combobox('getValue');
							var value_address		= $('#value_address').textbox('getValue');
							var value_status_id		= $('#value_status_id').textbox('getValue');
							var value_period_id		= $('#value_period_id').textbox('getValue');
							//var DateFrom			= $('#DateFrom').textbox('getValue');
							//var DateTo				= $('#DateTo').textbox('getValue');
							// alert(value_user_pic);
							// var doubleCheck = document.getElementById('doubleCheck');
							// if ( doubleCheck.checked ) { val = 1; } else { val = 0; }
		
								$('#datagrid-crud-reportmeter').datagrid('load',{
									reference: value_reference,
									customer_id: value_customer_id,
									customer_name: value_customer_name,
									area: value_area,
									id_klasifikasi: value_klasifikasi,
									address: value_address,
									status_id: value_status_id,
									period_id: value_period_id,
									user_pic: value_user_pic,
									//DateFrom: DateFrom,
									//DateTo: DateTo,
									// doubleCheck: val,
								}); 
						}

	                </script>
<script type="text/javascript">
var url;

function create_reportmeter(){
	$('#form').form('disableValidation');
	
	jQuery('#dialog-form').dialog('open').dialog('setTitle','Add Data');
	jQuery('#form').form('clear');
	$('#reference').combogrid('grid').datagrid('reload');
	$('#tglcreate').textbox('setValue', '<?php echo date("Y-m-d H:i:s"); ?>');
	$('#reference').textbox('readonly', false);
	
	url = '<?php echo base_url('reportmeter/create_reportmeter'); ?>';
}

function update_reportmeter(){
	var ids = [];
	var rows = $('#datagrid-crud-reportmeter').datagrid('getSelections');
	
	for(var i=0; i<rows.length; i++){
			ids.push(rows[i].reference);
	}
	
	if ( i == 1 ) {
		
		var row = $('#datagrid-crud-reportmeter').datagrid('getSelected');
		if(row){
			$('#dialog-form').dialog('open').dialog('setTitle','Update Data');
			//$('#password').form('load',row.id);
			$('#form').form('load',row);
			$('#reference').combogrid('grid').datagrid('reload');
			$('#reference').textbox('readonly', true);	
			url = '<?php echo base_url('reportmeter/update_reportmeter'); ?>/' + row.id;
		}
	
	} else {
		$.messager.show({
			title: 'Error',
			msg: "Pilih 1 Report Saja"
		});
	}
}

function save_reportmeter(){
	var initial_meter 			= $('#initial_meter').textbox('getValue');
	var final_meter 			= $('#final_meter').textbox('getValue');

if ( (initial_meter) <= (final_meter) ) {
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
					jQuery('#datagrid-crud-reportmeter').datagrid('reload');
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
	
} else {
	$.messager.show({
		title:'INFO',
		msg:"Current Read Harus Lebih Besar Dari Prev Read",
		timeout:7000,
		showType:'slide'
	});
}
}

function remove_reportmeter(){
	var row = jQuery('#datagrid-crud-reportmeter').datagrid('getSelected');
	if (row){
		jQuery.messager.confirm('Confirm','Are you sure you want to remove ?',function(r){
			if (r){
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('reportmeter/delete_reportmeter') ?>",
					data: {id:row.id},
					dataType: "json",
					success:
					function(data){
						if ( data.status == "success") {
							jQuery('#datagrid-crud-reportmeter').datagrid('reload');
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

function printout(){
	//var DateFrom = $('#DateFrom').textbox('getValue');
	//var DateTo = $('#DateTo').textbox('getValue');
	
	var reference = $('#value_reference').textbox('getValue');
	var customer_id = $('#value_customer_id').textbox('getValue');
	var customer_name = $('#value_customer_name').textbox('getValue');
	var area = $('#value_area').textbox('getValue');
	var address = $('#value_address').textbox('getValue');
	var status_id = $('#value_status_id').textbox('getValue');
	var period_id = $('#value_period_id').textbox('getValue');
	
	if(period_id){
		var url = '<?php echo base_url() ?>reportmeter/pdf_reportmeter?period_id=' + period_id + "&status_id=" + status_id + "&reference=" + reference + "&customer_id=" + customer_id + "&customer_name=" + customer_name + "&area=" + area + "&address=" + address + "&detail=false";
		jQuery('#print').attr('src', url);
		jQuery('#dialog-print-reportmeter').dialog('open').dialog('setTitle','Preview');
	}
}

function export_excel(){
	//var DateFrom = $('#DateFrom').textbox('getValue');
	//var DateTo = $('#DateTo').textbox('getValue');
							
	var reference = $('#value_reference').textbox('getValue');
	var customer_id = $('#value_customer_id').textbox('getValue');
	var customer_name = $('#value_customer_name').textbox('getValue');
	var area = $('#value_area').textbox('getValue');
	var klasifikasi	= $('#value_klasifikasi').combobox('getValue');
	var user_pic = $('#user_pic').combobox('getValue');
	var address = $('#value_address').textbox('getValue');
	var status_id = $('#value_status_id').textbox('getValue');
	var period_id = $('#value_period_id').textbox('getValue');
	
	if(period_id){
		
		// var url = '<?php echo base_url() ?>reportmeter/xls_reportmeter?period_id=' + period_id + "&status_id=" + status_id + "&reference=" + reference + "&customer_id=" + customer_id + "&customer_name=" + customer_name + "&area=" + area + "&address=" + address + "&detail=false";
		var url = '<?php echo base_url() ?>export/xls?period_id=' + period_id + "&status_id=" + status_id + "&reference=" + reference + "&customer_id=" + customer_id + "&customer_name=" + customer_name + "&area=" + area + "&klasifikasi=" + klasifikasi + "&user_pic=" + user_pic + "&address=" + address + "&detail=false";
		window.location = url;
	}
}

function toapproved_reportmeter() {
		var ids = [];
		var rows = $('#datagrid-crud-reportmeter').datagrid('getSelections');
		
		for(var i=0; i<rows.length; i++){
				ids.push(rows[i].id);
		}
		
		if ( i >= 1 ) {
			
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('reportmeter/to_approved') ?>/",
				data: {id:ids.join('-')},
				dataType: "json",
				beforeSend: function ( xhr ) {
			
					$.messager.progress({
						title:'Please waiting',
						msg:'Loading data...'
					});
					return true;
					
				},
				success: function(data){
					if ( data.status == "success") {
						$.messager.progress('close');
						jQuery('#datagrid-crud-reportmeter').datagrid('reload');
						
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
				
			// document.location.href = "<?php echo base_url('reportmeter/to_approved') ?>/" + ids.join('-');
			// location.reload()
			// history.go(0)
			// location.href = "<?php echo base_url('reportmeter/to_approved') ?>/" + ids.join('-');
			// location.href = location.pathname
			// location.replace(location.pathname)
			// location.reload(true) 

		} else {
			jQuery.messager.show({
				title: 'Error',
				msg: "Pilih minimal 1 Report"
			});
		}
		
}

function tounapproved_reportmeter() {
		var ids = [];
		var rows = $('#datagrid-crud-reportmeter').datagrid('getSelections');
		
		for(var i=0; i<rows.length; i++){
				ids.push(rows[i].id);
		}
		
		if ( i >= 1 ) {
			
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('reportmeter/to_unapproved') ?>/",
				data: {id:ids.join('-')},
				dataType: "json",
				beforeSend: function ( xhr ) {
			
					$.messager.progress({
						title:'Please waiting',
						msg:'Loading data...'
					});
					return true;
					
				},
				success: function(data){
					if ( data.status == "success") {
						$.messager.progress('close');
						jQuery('#datagrid-crud-reportmeter').datagrid('reload');
						
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
			
		} else {
			jQuery.messager.show({
				title: 'Error',
				msg: "Pilih minimal 1 Report"
			});
		}
		
}

function viewimage(){
		var ids = [];
		var rows = $('#datagrid-crud-reportmeter').datagrid('getSelections');
		
		for(var i=0; i<rows.length; i++){
				ids.push(rows[i].reference);
		}
		
		//harus pilih 1 saja
		if ( i == 1 ) {
			
			$.messager.progress({
				title:'Please waiting',
				msg:'Loading data...'
			});

			var row = jQuery('#datagrid-crud-reportmeter').datagrid('getSelected');
			//logic
			// if ( row.image_url1 ) {
				// $('#open-imgview1').attr('src', '.' + row.image_url1);
			// } else {
				// $('#open-imgview1').attr('src', '../upload/reportmeter/noimage.png');
			// }
			
			// if ( row.image_url2 ) {
				// $('#open-imgview2').attr('src', '.' + row.image_url2);
			// } else {
				// $('#open-imgview2').attr('src', '../upload/reportmeter/noimage.png');
			// }
			
			// $('#imgdetail_periode').text(row.period);
			// $('#imgdetail_status').html(row.status);
			// $('#imgdetail_unitcode').text(row.reference);
			// $('#imgdetail_cluster').text(row.area);
			
			// $('#imgdetail_prev_read').text(row.prev_final_meter);
			// $('#imgdetail_prev_consumption').text(row.prev_consumption_meter);
			// $('#imgdetail_current_read').text(row.final_meter);
			// $('#imgdetail_consumption').text(row.consumption_meter);
			
			// $('#dialog-open-imgdetail').dialog('open').dialog('setTitle','IMAGE DETAIL');
			$('#dialog-open-imgdetail').dialog({
				closed:false,
				// iconCls:'icon-add',
				title:' IMAGE DETAIL',
				href:'../reportmeter/viewimage/' + row.id + '/' + row.period_id,
				onLoad:function(){
					//$('#form').form('load',row);
					// $('#form').form('disableValidation');
					// jQuery('#form').form('clear');
					// url = '<?php echo base_url('dokter/create_dokter'); ?>';
				}
			});
			//$('#open-imgview1').attr('src', this.src);"
			//logic eof
			
			$.messager.progress('close');
			
		} else {
			jQuery.messager.show({
				title: 'Error',
				msg: "Pilih 1 Report Saja"
			});
		}
}	
</script>
        </div>
		
        
        <!-- #Body -->
        <div data-options="region:'center',title:'Master Data Report'" style="background-color:#D7E4F2;">
		<!-- TABLE UTAMA -->
		<div style="height:80%" bgcolor="#3E6DB9">
		<table id="datagrid-crud-reportmeter" class="easyui-datagrid" style="height:100%" url="<?php echo base_url('reportmeter/getJsonReportMeter'); ?>" fit="true" toolbar="#toolbar-user" pagination="true" rownumbers="true" fitColumns="false" singleSelect="false" collapsible="true"
						showFooter='true'
						data-options="
							rowStyler: function(index,row){
									// if (row.doublecheck > 1){
										// return 'background-color:#eaf2ff;color:#000;opacity: 10;';
									// }									
								},
							'onClickRow': function(index, field, value){
								var row = jQuery('#datagrid-crud-reportmeter').datagrid('getSelected');
								
								if ( row.status_id == 1 ) {
									 $('#id-edit').linkbutton('disable');
									 $('#id-delete').linkbutton('disable');
								} else {
									 $('#id-edit').linkbutton('enable');
									 $('#id-delete').linkbutton('enable');
								}
								
								if ( row.image_url1 ) {
									$('#image_url1').attr('src', '.' + row.image_url1);
								} else {
									$('#image_url1').attr('src', '');
								}
								
								if ( row.image_url2 ) {
									$('#image_url2').attr('src', '.' + row.image_url2);
								} else {
									$('#image_url2').attr('src', '');
								}
							},">
			<thead>
				<tr>
					<th field="ck" checkbox="true"></th>
					<th field="period" width="90" sortable="true">Periode</th>
					<th field="status" width="80" sortable="true">Status</th>
					<th field="reference" width="90" sortable="true">Unitcode</th>
					<!--<th field="doublecheck" width="90" sortable="true">doublecheck</th>-->
					<th field="customer_id" width="80" sortable="true">Customer ID</th>
					<th field="customer_name" width="100" sortable="true">Customer Name</th>
					<th field="area" width="100" sortable="true">Cluster</th>
					<th field="klasifikasi" width="100" sortable="true">Klasifikasi</th>
					<th field="address" sortable="true">Address</th>
					<th field="prev_final_meter" width="90" sortable="true">Prev Read</th>
					<th field="prev_consumption_meter" width="100" sortable="true">Prev Consumption</th>
					
					<th field="final_meter" width="90" sortable="true">Current Read</th>
					<th field="consumption_meter" width="90" sortable="true">Consumption</th>
					<th field="description" width="150" sortable="true">Description</th>
					<th field="createby" width="120" sortable="true">PIC Scan</th>
					<th field="tglcreate" width="120" sortable="true">Date Scan</th>
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
		<!--<div style="height:18%" style="border-style: solid;padding:10px">-->
		
		<div style="height:18%" width="39%" align="right" style="border-left: 1px solid #95B8E7">
			<!--
			<div style="height:100%;width: 250px;background-color:#3E6DB9;margin:2px;float:right">	
				<img id="image_url2" class='img' valign='top' ondblclick="jQuery('#dialog-open-img').dialog('open').dialog('setTitle','UNIT FOTO');
				jQuery('#open-img').attr('src', this.src);">
			</div>
			<div style="height:100%;width: 250px;background-color:#3E6DB9;margin:2px;float:right">
				<img id="image_url1" class='img' valign='top' ondblclick="jQuery('#dialog-open-img').dialog('open').dialog('setTitle','METER FOTO');
				jQuery('#open-img').attr('src', this.src);">
			</div>
			-->
		</div>
		</div>
		
		<div id="dialog-open-img" class="easyui-dialog" style="width:100%; height:100%; padding: 4px 6px" modal="true" closed="true">
			<img id="open-img" style="height:100%" height="98%" src="">
		</div>
		<style>
		table.imgcenter {
			margin-left:auto; 
			margin-right:auto;
			border: none; 
			box-shadow: none;
			overflow: visible;
		}
		table.center {
			margin-left:auto; 
			margin-right:auto;
			border: none; 
			box-shadow: none;
			overflow: visible;
		}
		table.center td {
			padding: 10px;
			background-color: #eee;
		}
		
		table.center td.title {
			font-weight:bold;
		}
		</style>
		<div id="dialog-open-imgdetail" class="easyui-dialog" style="position:relative;width:800px;height:550px;overflow:auto;" modal="true" closed="true">
			
		</div>
		
		<!--</div>-->
		
		<!-- TABLE DETAIL EOF -->
		</div>
	</div>

	</div>
<!-- TOOLBAR -->
<div id="toolbar-user">
	<div align="left" style="float:left">
	<?php if ( $this->permissions->menu($menu_id, 'created') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" id="id-add" iconCls="icon-add" style="width:100px" onclick="create_reportmeter()">Add</a>
	<?php } ?>
	<?php if ( $this->permissions->menu($menu_id, 'updated') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" id="id-edit" iconCls="icon-edit" style="width:100px" onclick="update_reportmeter()">Edit</a>
	<?php } ?>
	<?php if ( $this->permissions->menu($menu_id, 'deleted') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" id="id-delete" iconCls="icon-cancel" style="width:100px" onclick="remove_reportmeter()">Delete</a>
	<?php } ?>
	<?php if ( $this->permissions->menu($menu_id, 'print') ) { ?>
	<!--<a href="javascript:void(0)" class="easyui-linkbutton" id="id-print" iconCls="icon-print" style="width:100px" onclick="printout()">Print</a>-->
	<?php } ?>
	
	
	
	
	<?php if ( $this->permissions->menu($menu_id, 'downloaded') ) { ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" id="id-download" iconCls="icon-excel" style="width:100px" onclick="export_excel()">Download</a>
	<?php } ?>
	<a href="javascript:void(0)" class="easyui-linkbutton" id="id-viewimage" iconCls="icon-large-picture" style="width:100px" onclick="viewimage()">viewimage</a>
	</div>
	
	<div align="right">
	<?php if ( $this->permissions->menu($menu_id, 'verified') ) { ?>
		<a href="javascript:void(0)" class="easyui-linkbutton" id="id-add" iconCls="icon-ok" style="width:100px" onclick="toapproved_reportmeter()">Approved</a>
	<?php } ?>
	<?php if ( $this->permissions->menu($menu_id, 'cancelled') ) { ?>
		<a href="javascript:void(0)" class="easyui-linkbutton" id="id-add" iconCls="icon-cancel" style="width:100px" onclick="tounapproved_reportmeter()">un approved</a>
	<?php } ?>
	</div>
	
</div>
<!-- TOOLBAR EOF -->
<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" style="width:450px; height:480px; padding: 10px 20px" modal="true" closed="true" buttons="#dialog-buttons-user">
	<form id="form" method="post" novalidate >
	<input type="hidden" name="id" required="true"/>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:left">
				<label>Unitcode</label>
			</div>
			<div>
			<input name="reference" id="reference" class="easyui-combogrid" data-options="
									panelWidth: 550,
									idField: 'reference',
									textField: 'reference',
									editable: true,
									url: '<?php echo base_url('reportmeter/cust_name_combogrid/'); ?>',
									mode: 'remote',
									onSelect: function(){										
										var val 	= $('#reference').combogrid('grid').datagrid('getSelected');
										$('#customer_id').textbox('setValue', val.customer_id);
										$('#customer_name').textbox('setValue', val.customer_name);
										$('#area').textbox('setValue', val.area);
										$('#address').textbox('setValue', val.address);
										$('#initial_meter').textbox('setValue', val.count_meter);
									},
									columns: [[
										{field:'customer_id',title:'ID',width:35},
										{field:'reference',title:'Unitcode',width:90},
										{field:'customer_name',title:'Customer Name',width:90,align:'left'},
										{field:'area',title:'Cluster',width:80,align:'left'},
										{field:'address',title:'Address',width:150,align:'left'},
									]],
									fitColumns: true
								">
				<!--<input type="text" name="reference" id="reference" class="easyui-textbox" required="true" size="30" maxlength="50" />-->
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:left">
				<label>Customer ID</label>
			</div>
			<div>
				<input type="text" name="customer_id" id="customer_id" class="easyui-textbox" required="true" size="30" maxlength="6" />
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Customer Name</label>
			</div>
			<div>
				<input type="text" name="customer_name" id="customer_name" class="easyui-textbox" required="true" size="30" maxlength="50" />
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Cluster</label>
			</div>
			<div>
				<input type="text" name="area" id="area" class="easyui-textbox" required="true" size="30" maxlength="50" />
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
				<input type="text" name="address" id="address" class="easyui-textbox" data-options="multiline:true" required="true" size="30" maxlength="200" />
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Description</label>
			</div>
			<div>
				<input type="text" name="description" id="description" class="easyui-textbox" data-options="multiline:true" size="30" maxlength="50" />
			</div>
		</div>
		
		<div class="form-item" style="padding-top:20px">
			<div style="float:left;width:130px;align:right">
				<label>Date Scan</label>
			</div>
			<div>
				<input type="text" name="tglcreate" id="tglcreate" class="easyui-datetimebox" required="true" size="30" maxlength="50"  data-options="editable:false,validType:'length[19,19]',formatter:myformattertime,parser:myparsertime"/>
			</div>
		</div>
		
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Prev Read</label>
			</div>
			<div>
				<input type="text" name="initial_meter" id="initial_meter" class="easyui-numberbox" id="initial_meter" required="true" size="30" maxlength="50" />
			</div>
		</div>
		
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Current Read</label>
			</div>
			<div>
				<input type="text" name="final_meter" class="easyui-numberbox" id="final_meter" required="true" size="30" maxlength="10"/>
			</div>
		</div>
		
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Status</label>
			</div>
			<div>
				<select name='status_id' class="easyui-combobox" style="width:220px;" data-options="editable: false" required="true">
					<option value='1'>Approved</option>
					<option value='2'>Pending</option>
					<option value='3'>Open</option>
					<option value='4'>Scan</option>
				</select>
			</div>
		</div>
		
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Period</label>
			</div>
			<div>
				<input name="period_id" id="period_id" class="easyui-combogrid" style="width:220px;" required="true" data-options="
									panelWidth: 400,
									idField: 'id',
									textField: 'description',
									editable: false,
									url: '<?php echo base_url('period/period_combogrid/'); ?>',
									mode: 'remote',
									onSelect: function(){										
										
									},
									columns: [[
										{field:'id',title:'ID',width:20},
										{field:'description',title:'Description',width:80},
									]],
									fitColumns: true
								">
			</div>
		</div>
		
		</div>
	</form>
</div>
<div id="dialog-buttons-user">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="save_reportmeter()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>
<!-- Dialog Form EOF -->
<!-- Dialog Print -->
<div id="dialog-print-reportmeter" class="easyui-dialog" style="width:100%; height:100%; padding: 4px 6px" modal="true" closed="true">
	<iframe id="print" width="100%" height="98%" src=""></iframe>
</div>
<!-- Dialog Print EOF -->
</body>
</html>

<script>
$.base64ImageToBlob = function(str) {
        // extract content type and base64 payload from original string
        var pos = str.indexOf(';base64,');
        var type = str.substring(5, pos);
        var b64 = str.substr(pos + 8);
      
        // decode base64
        var imageContent = atob(b64);
      
        // create an ArrayBuffer and a view (as unsigned 8-bit)
        var buffer = new ArrayBuffer(imageContent.length);
        var view = new Uint8Array(buffer);
      
        // fill the view, using the decoded base64
        for (var n = 0; n < imageContent.length; n++) {
          view[n] = imageContent.charCodeAt(n);
        }
      
        // convert ArrayBuffer to Blob
        var blob = new Blob([buffer], { type: type });
      
        return blob;
    }
</script>