<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="utf-8">
	<title>Menu</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/easyui.css'); ?>">
		<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" media="screen">
		<link href="<?php echo base_url('assets/css/icon.css'); ?>" rel="stylesheet" media="screen">	
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">	
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
		<div data-options="region:'west',split:true" title="Look up &amp; Tools" style="width:200px;">
	                <!--<tr>
                        <td colspan="2" height="25" valign="middle" align="center">
                            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:false" onclick="ToSearch()">Search</a>
                            
                        </td>
                    </tr>-->
                  </table>
<div class="box-body" style="padding: 2px">
        <div class="list-group">
          <?php foreach ($menu_type as $value): ?>
            <?php 
              $url = urldecode(str_replace(' ', '-', strtolower($value->type)));
              $active = '';
              if ($url == $this->uri->segment(3))
                $active = ' active ';
            ?>
            <?php if ($value->id_menu_type != 1): ?>
			<li class="dd-item">
              <a href="<?php echo base_url('setting/menu_type/'.$url.'/delete/'.$value->id_menu_type) ?>" title="Delete menu type"><i class="fa fa-trash"></i> Delete</a>
            </li>
			<?php endif ?>
			<li class="dd-item">
			<a href="<?php echo base_url('setting/menu/'.$url) ?>" class="easyui-linkbutton list-group-item <?php echo $active ?>" iconCls="icon-large-picture" onclick="create_group()" style="width:150px;text-align:left"><?php echo $value->type ?></a>
            </li>
			<br><br>
          <?php endforeach ?>
        </div>
        <div class="form-group">
          <a href="<?php echo base_url('setting/menu_type/'.$this->uri->segment(3).'/add') ?>" class="btn btn-primary btn-block btn-flat"><i class="fa fa-plus-circle"></i> Add Menu Type</a>
        </div> 
</div>				  
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
							var nmuser		= $('#nmuser').textbox('getValue');
							var dept_id		= $('#dept_id').textbox('getValue');
							var jabatan_id	= $('#jabatan_id').textbox('getValue');

							$('#datagrid-crud-user').datagrid('load',{
								nmuser: nmuser,
								dept_id: dept_id,
								jabatan_id: jabatan_id,
							}); 
						}

	                </script>
        </div>
		
        
        <!-- #Body -->
        <div data-options="region:'center',title:'Master Page Menu'" style="background-color:#D7E4F2;">
		<!-- TABLE UTAMA -->
		<div style="height:99%" bgcolor="#3E6DB9">
		
		<!-- Content -->
		<!-- /.box-header -->
<div id="p" class="easyui-panel"
        style="width:500px;height:100%;padding:10px;background:#fafafa;"
        data-options="iconCls:'icon-save',closable:false,
                collapsible:false,minimizable:false,maximizable:false">
		<div class="box-body">
		<form id="form" method="post" action="<?php echo base_url('setting/update_menu') ?>">
			  <div class="form-group">
				<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-back',plain:false" onclick="DoBack()">Back</a>
				<a href="<?php echo base_url('setting/menu_add/' . $this->uri->segment(3)) ?>" class="easyui-linkbutton" iconCls="icon-add">Add Menu</a>
				<button type="submit" id="saveMenu" class="easyui-linkbutton" iconCls="icon-save">Save Menu</button>
			  </div>
			  <div id="sideMenu" class="dd">
				<?php echo $admin_menu ?>
			  </div>
			  <input type="hidden" name="type" value="<?php echo $this->uri->segment(3) ?>">
			  <textarea name="json_menu" hidden id="tampilJsonSideMenu"></textarea>
		</form>
		</div>
</div><!-- /.box-body -->		
		<!-- Content -->
		</div>
		<!-- TABLE UTAMA EOF -->
		<!-- TABLE TENGAH -->
		<div style="height:2px;background-color:#3E6DB9;margin:2px">
		</div>
		<!-- TABLE TENGAH EOF -->
		<!-- TABLE DETAIL -->
		<div style="height:1%" style="border-style: solid;padding:10px">

		</div>
		<!-- TABLE DETAIL EOF -->
		</div>
	</div>

	</div>
<!-- TOOLBAR -->

<!-- TOOLBAR EOF -->
<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" style="width:450px; height:350px; padding: 10px 20px" modal="true" closed="true" buttons="#dialog-buttons-user">
	<form id="form" method="post" novalidate >

		<input type="hidden" name="user_id" required="true" size="30" maxlength="50" />
		<div class="form-item">
			<div style="float:left;width:130px;align:left">
				<label>User Login</label>
			</div>
			<div>
				<input type="text" name="iduser" class="easyui-textbox" required="true" size="30" maxlength="50" />
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Name</label>
			</div>
			<div>
				<input type="text" name="nmuser" class="easyui-textbox" id="password" required="true" size="30" maxlength="50" />
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Fullname</label>
			</div>
			<div>
				<input type="text" name="fullname" class="easyui-textbox" required="true" size="30" maxlength="50" />
			</div>
		</div>
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Password</label>
			</div>
			<div>
				<input type="text" name="pass" class="easyui-textbox" required="true" size="30" maxlength="50" />
			</div>
		</div>
		
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Status</label>
			</div>
			<div>
				<select name='status_id'>
					<option value='1'>Aktif</option>
					<option value='0'>Disable</option>
				</select>
			</div>
		</div>
		
		<div class="form-item" style="padding-top:4px">
			<div style="float:left;width:130px;align:right">
				<label>Atasan ID</label>
			</div>
			<div>
				<input type="text" name="atasan_id" class="easyui-textbox" size="30" maxlength="50" />
			</div>
		</div>
		
	</form>
</div>
<div id="dialog-buttons-user">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="save_user()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>
<!-- Dialog Form EOF -->
</body>
</html>

<script>
  $(function(){
    $('#navMenu').addClass('active');
    $('#sideMenu').nestable();
    $('#tampilJsonSideMenu').html(window.JSON.stringify($('#sideMenu').nestable('serialize')));
    $('#sideMenu').on('change', function() {
      $('#tampilJsonSideMenu').val(window.JSON.stringify($('#sideMenu').nestable('serialize')));      
    });
  });
</script>

	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-nestable/jquery.nestable.js'); ?>"></script>