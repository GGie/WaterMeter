<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>History Login</title>
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
		url  : "<?php echo base_url('home/check_refresh/ip'); ?>",
		success : function(data){
			if( Number(data.data) > Number(count)){
				count = data.data;
				if( user_id !== data.user_id){
					$('#datagrid-crud-ip').datagrid('reload');
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
                        <td height="20" valign="middle" align="right" style="font-size:12px;">Nama User</td>
                        <td width="100" height="20" valign="middle" align="left"><input  Name="nmuser" id="nmuser" size="8" value="" type="text" class="easyui-textbox"/></td>
                    </tr>
					
					<tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">IP Address</td>
                        <td width="100" height="20" valign="middle" align="left"><input  Name="ip_address" id="ip_address" size="8" value="" type="text" class="easyui-textbox"/></td>
                    </tr>
					
					<tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">Date From</td>
                        <td width="80" height="20" valign="middle" align="right">
							<input name="txtTglAwal" id="txtTglAwal" class="easyui-datebox" size="9" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>">
						</td>
                    </tr>
					
					
                    <tr>
                        <td height="20" valign="middle" align="right" style="font-size:12px;">Date To</td>
                        <td width="80" height="20" valign="middle" align="right">
							<input name="txtTglAkhir" id="txtTglAkhir" class="easyui-datebox" size="9" data-options="validType:'length[10,10]',formatter:myformatter,parser:myparser" value="<?php echo date('Y-m-d H:i:s') ?>"> 
						</td>
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
						var nmuser 		= $('#nmuser').textbox('getValue');
						var ip_address	= $('#ip_address').textbox('getValue');
						var tglawal		= $("#txtTglAwal").datebox('getValue');
						var tglakhir	= $("#txtTglAkhir").datebox('getValue');
						if ( tglawal == "" ) {
										jQuery.messager.show({
												title: 'Peringatan',
												msg: "Isi tanggal dengan lengkap !!"
											});
							} else if ( tglakhir == "" ) {
										jQuery.messager.show({
												title: 'Peringatan',
												msg: "Isi tanggal dengan lengkap !!"
											});
							} else {
								$('#datagrid-crud-ip').datagrid('load',{
									nmuser		: nmuser,
									ip_address	: ip_address,
									tglawal		: tglawal,
									tglakhir	: tglakhir,
								});
							}
						}

	                </script>
        </div>
		
        
        <!-- #Body -->
        <div data-options="region:'center',title:'History Login User'" style="background-color:#D7E4F2;">
		<!-- TABLE UTAMA -->
		<div style="height:60%" bgcolor="#3E6DB9">
		<table id="datagrid-crud-ip" class="easyui-datagrid" url="<?php echo base_url('tool/getJsonIp'); ?>?grid=true" fit="true" toolbar="#toolbar-representative" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true">
			<thead>
				<tr>
					<th field="id_login" width="60" sortable="true">ID</th>
					<th field="ip_address" width="150" sortable="true">IP Address</th>
					<th field="computer" width="200" sortable="true">Computer Name</th>
					<th field="user_id" width="200" sortable="true">User</th>
					<th field="nmuser" width="200" sortable="true">Nama User</th>
					<th field="last_login" width="200" sortable="true">Last Login</th>
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
		<div style="height:38%" style="border-style: solid;padding:10px">

		</div>
		<!-- TABLE DETAIL EOF -->
		</div>
	</div>

	</div>

</body>
</html>