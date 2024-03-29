<div class="container">
	<form class="form-horizontal" role="form" id="networkForm" action="" method="post">

		<div id="mac_input" class="form-group">
			<label class="col-xs-2 control-label text-right">MAC Address*</label>
			<div class="col-xs-3">
				<input type="text" class="form-control" id="mac" maxlength="17"> 
			</div>
		</div>

		<div id="mac_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="ip_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Static IP Address*</label>
			<div class="col-xs-3">
				<input type="text" class="form-control" id="ip" maxlength="15">
			</div>
		</div>

		<div id="ip_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>
   
		<div id="wmac_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Wireless MAC*</label>
			<div class="col-xs-3">
				<input type="text" class="form-control" id="wmac" maxlength="17"> 
			</div>
		</div>

		<div id="wmac_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

	</form>
</div>

<script>
$( '#mac, #wmac' ).mask( "**:**:**:**:**:**", {placeholder:" "} );
$( '#ip' ).mask( "999.999.999.999", {placeholder:" "} );

$( '.input_error' ).hide();
</script>
