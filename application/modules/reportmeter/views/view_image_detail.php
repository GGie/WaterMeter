			<table width='600px' class="imgcenter" style="margin-left:auto; 
			margin-right:auto;
			border: none; 
			box-shadow: none;
			overflow: visible;">
			
				<tr width='600px'>
					<td width='50%'>
					
					<?php if ($this->uri->segment(2) != "pdf_viewimage" ) { ?>
						<a href="<?php echo base_url('reportmeter/pdf_viewimage/' . $data->id . '/' . $data->period_id) ?>" class="easyui-linkbutton" target="_blank" iconCls="icon-print" ></a>
					<?php } ?>
					
					</td>
					<td width='50%'></td>
				</tr>
				
				<tr width='600px'>
					<td width='50%'><img id="open-imgview1" height="450px" width="300px" src="<?php echo $image1 ?>" style="margin-right: 10px;"></td>
					<td width='50%'><img id="open-imgview2" height="450px" width="300px" src="<?php echo $image2 ?>" style="margin-left: 10px;"></td>
				</tr>
				<?php if ($this->uri->segment(2) != "pdf_viewimage" ) { ?>
				<tr width='600px'>
					<td width='50%'><input class="easyui-filebox" style="width:300px" data-options="
						 onChange: function(value){
								var f = $(this).next().find('input[type=file]')[0];
								size = (f.files[0].size/1024);
								if ( size <= 1024 ) {
									if (f.files && f.files[0]){
										var reader = new FileReader();
										reader.onload = function(e){
											$.ajax({
												type : 'POST',
												url  : '<?php echo base_url('reportmeter/upload_image') ?>',
												
												data: {file:e.target.result, type:'METER', reportid: '<?php echo $data->id ?>'},
												success : function(data){
													if(data.status == 'success'){
														jQuery.messager.show({
															title: 'Error',
															msg: 'Berhasil upload'
														});
													}else{
														jQuery.messager.show({
															title: 'Error',
															msg: data.message
														});
													} 
												}
											});
											viewimage();
										}
										reader.readAsDataURL(f.files[0]);
									}
								} else {
												jQuery.messager.show({
													title: 'Error',
													msg: 'Max size 1 Mb'
												});
								}
							}
					"></td>
					<td width='50%'><input class="easyui-filebox" style="width:300px" data-options="
						 onChange: function(value){
								var f = $(this).next().find('input[type=file]')[0];
								size = (f.files[0].size/1024);
								if ( size <= 1024 ) {
									if (f.files && f.files[0]){
										var reader = new FileReader();
										reader.onload = function(e){
											$.ajax({
												type : 'POST',
												url  : '<?php echo base_url('reportmeter/upload_image') ?>',
												
												data: {file:e.target.result, type:'UNIT', reportid: '<?php echo $data->id ?>'},
												success : function(data){
													if(data.status == 'success'){
														jQuery.messager.show({
															title: 'Error',
															msg: 'Berhasil upload'
														});
													}else{
														jQuery.messager.show({
															title: 'Error',
															msg: data.message
														});
													} 
												}
											});
											viewimage();
										}
										reader.readAsDataURL(f.files[0]);
									}
								} else {
												jQuery.messager.show({
													title: 'Error',
													msg: 'Max size 1 Mb'
												});
								}
							}
					"></td>
				</tr>
				<?php } ?>
			</table>
			
			<table width='600px' class="center">
			<tbody>
				<tr width='600px'>
					<td width='300px' class='title' style="padding: 10px;background-color: #eee;">Periode</td>
					<td width='300px' style="padding: 10px;background-color: #eee;"><span id="imgdetail_periode"><?php echo period($data->period_id) ?></span></td>
					
					<td width='300px' class='title' style="padding: 10px;background-color: #eee;">Status</td>
					<td width='300px' style="padding: 10px;background-color: #eee;"><span id="imgdetail_status"><?php echo $status ?></span></td>
				</tr>
				<tr>
					<td class='title' style="padding: 10px;background-color: #eee;">Unitcode</td>
					<td style="padding: 10px;background-color: #eee;"><span id="imgdetail_unitcode"><?php echo $data->reference ?></span></td>
					
					<td class='title' style="padding: 10px;background-color: #eee;">Cluster</td>
					<td style="padding: 10px;background-color: #eee;"><span id="imgdetail_cluster"><?php echo $data->area ?></span></td>
				</tr>
				
				<tr>
					<td class='title' style="padding: 10px;background-color: #eee;">Prev Read</td>
					<td style="padding: 10px;background-color: #eee;"><span id="imgdetail_prev_read"><?php echo get_meter($data->customer_id, (int)$data->period_id, 'final_meter') ?></span></td>
					
					<td class='title' style="padding: 10px;background-color: #eee;">Prev Consumption</td>
					<td style="padding: 10px;background-color: #eee;"><span id="imgdetail_prev_consumption"><?php echo get_meter($data->customer_id, (int)$data->period_id, 'final_meter') - get_meter($data->customer_id, (int)$data->period_id, 'initial_meter') ?></span></td>
				</tr>
				
				<tr>
					<td class='title' style="padding: 10px;background-color: #eee;">Current Read</td>
					<td style="padding: 10px;background-color: #eee;"><span id="imgdetail_current_read"><?php echo $data->final_meter ?></span></td>
					
					<td class='title' style="padding: 10px;background-color: #eee;">Consumption</td>
					<td style="padding: 10px;background-color: #eee;"><span id="imgdetail_consumption"><?php echo $data->consumption_meter ?></span></td>
				</tr>
			</tbody>
			</table>