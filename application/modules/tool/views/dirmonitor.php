<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Directory Monitoring</title>
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
</script>
</head>

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
                        <td colspan="2"  height="10" valign="middle" align="left"></td>
                    </tr>

	                <tr>
                        <td colspan="2" height="25" valign="middle" align="center">
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
						var f1_rcvd_vlg = $('#f1_rcvd_vlg').textbox('getValue');
						var f2_rcvd_vlg = $('#f2_rcvd_vlg').textbox('getValue');
							$('#datagrid-crud-vlg').datagrid('load',{
								vlg1: f1_rcvd_vlg,
								vlg2: f2_rcvd_vlg,
							}); 
						}
						
	                </script>
					<script type="text/javascript">
					$('#p').progressbar({
	onChange: function(value){
		alert(value)
	}
});
</script>

        </div>
		
        
        <!-- #Body -->
        <div data-options="region:'center',title:'Directory Monitoring'" style="background-color:#fff;">
		<!-- TABLE UTAMA -->
		<div style="height:60%" bgcolor="#3E6DB9">
		
		<!-- Toolbar -->
		<div id="toolbar-vlg" style="padding:10px;">
		
		<table>
			<tr>
				<td width='100px'>Modul</td>
				<td>:</td>
				<td>Image Report Meter</td>
			</tr>
			<tr>
				<td width='100px'>Size</td>
				<td>:</td>
				<td><?php echo format_size(check_dir("upload/reportmeter")) ?></td>
			</tr>
		</table>
			<div class="easyui-progressbar" data-options="value:'<?php echo number_format((check_dir("upload/reportmeter") / 1572864000 * 100),2,".","") ?>'" style="width:400px;"></div>
		<br>
		</div>
		<!-- Toolbar EOF -->
		</div>
		<!-- TABLE UTAMA EOF -->
		<!-- TABLE TENGAH -->
		<div style="height:2px;background-color:#3E6DB9;margin:2px">
		</div>
		<!-- TABLE TENGAH EOF -->
		<!-- TABLE DETAIL -->
		<div style="height:40%" style="border-style: solid;padding:10px">
		<!--
		<table id="datagrid-crud-rep" class="easyui-datagrid" url="<?php echo base_url('qms/getJsonRep'); ?>?grid=true" fit="true" toolbar="#toolbar-tes" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true">
			<thead>
				<tr>
					<th field="id_rep" width="60" sortable="true">ID</th>
					<th field="employed" width="150" sortable="true">Employed</th>
					<th field="email" width="200" sortable="true">Email</th>
				</tr>
			</thead>
		</table>
		-->
		</div>
		<!-- TABLE DETAIL EOF -->
		</div>
	</div>

	</div>

</body>
</html>