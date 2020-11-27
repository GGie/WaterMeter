<?php foreach($data->result() as $reportdata) {} ?>

<table border="0" width="100%" style="font-size:9px;font-family:'Arial Narrow';border-collapse: collapse;">
	<tr>

		<td style="padding:4px;" align="center">
			
			<h1><?php echo COMPANY ?></h1>
			<?php echo ADDRESS; ?><br>
		</td>	
	</tr>
</table>
<div style="width:100%;border:solid 1px #000;height:1px"></div>

<table border="0" width="100%" style="font-size:9px;font-family:'Arial Narrow';border-collapse: collapse;">
	<tr>
		<td style="padding:12px;" align="center">
			<h1><u>REPORT METER </u></h1>
		</td>	
	</tr>
</table>

<table border="0" width="400px" style="font-family:'Arial Narrow';border-collapse: collapse;">
	<tr>
		<td align="left">
			Unit Code
		</td>
		<td>
			:
		</td>
		<td align="left">
			<?php echo $reportdata->reference; ?>
		</td>		
	</tr>
	<tr>
		<td align="left">
			Customer Name
		</td>
		<td>
			:
		</td>
		<td align="left">
			<?php echo $reportdata->customer_name; ?>
		</td>		
	</tr>
	
	<tr>
		<td align="left">
			Address
		</td>
		<td>
			:
		</td>
		<td align="left">
			<?php echo $reportdata->address; ?>
		</td>		
	</tr>
	
	<tr>
		<td align="left">
			Cluster
		</td>
		<td>
			:
		</td>
		<td align="left">
			<?php echo $reportdata->area; ?>
		</td>		
	</tr>
	
	<tr>
		<td align="left">
			Klasifikasi
		</td>
		<td>
			:
		</td>
		<td align="left">
			<?php echo $reportdata->klasifikasi; ?>
		</td>		
	</tr>
</table>

<div style="margin-top:15px"></div>

<table border="0" width="80%" style="font-family:'Arial Narrow';border-collapse: collapse;">
	<thead>
		  <tr>
			<td width="50px" style="font-weight:bold" height="40px" align="center"><span>ID</span></td>
			<td width="90px" style="font-weight:bold" align="center"><span>Periode</span></td>
			<td width="90px" style="font-weight:bold" align="center"><span>Prev Read</span></td>
			<td width="90px" style="font-weight:bold" align="center"><span>Prev Consumption</span></td>
			<td width="90px" style="font-weight:bold" align="center"><span>Current Read</span></td>
			<td width="90px" style="font-weight:bold" align="center"><span>Consumption</span></td>
		  </tr>
	</thead>
	<tbody>
	  <?php foreach($data->result() as $key => $report) { ?>
		<tr>
			<?php $prev_final_meter = @get_meter($report->customer_id, (int)$report->period_id, 'final_meter'); ?>
			<?php $prev_initial_meter = @get_meter($report->customer_id, (int)$report->period_id, 'initial_meter'); ?>
			<td height="40px" style="padding:4px" align="center"> <?php echo ($key+1); ?>
			<td style="padding:4px" align="center"> <?php echo period($report->period_id); //date("Y-m-d", strtotime($report->tglcreate)); ?>
			<td style="padding:4px" align="center"> <?php echo $prev_final_meter; ?>
			<td style="padding:4px" align="center"> <?php echo (int)$prev_final_meter - (int)$prev_initial_meter ?>
			<td style="padding:4px" align="center"> <?php echo $report->final_meter; ?>
			<td style="padding:4px" align="center"> <?php echo $report->consumption_meter; ?>
		</tr>
	  <?php }?>
	</tbody>
</table>


</table>

<!-- Signature sj -->
<div style="margin-top:15px">
<table height='100%' border='1' style='border-collapse:collapse'>
	<tr>
		<td width='150px' align='center'>Signature
		</td>
		<td>
		</td>
		<td width='150px' align='center'>Signature
		</td>
	</tr>
	<tr>
		<td height='50px'>
		</td>
		
		<td>
		</td>
		
		<td>
		</td>
	</tr>
	<tr>
		<td height='25px'>
		</td>
		
		<td>
		</td>
		
		<td>
		</td>
	</tr>
</table>