<html>
<head>
  <title>TestAddRecord.php</title>

  <script src="js/jquery-2.1.0.min.js"></script>

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap-typeahead.js"></script>

</head>
<body>
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
Launch demo modal
</button>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">


      <div class="modal-body">
        <ul class="nav nav-tabs" id="addRecordTab">
          <li class="active"><a href="#equipmentInfo" data-toggle="tab">Equipment <span style="color:green;" class="glyphicon glyphicon-ok"></span></a></li>
		  <li><a href="#purchaseInfo" data-toggle="tab">Purchase <span style="color:green;" class="glyphicon glyphicon-ok"></span></a></li>
		  <li><a href="#locationInfo" data-toggle="tab">Location </a></li>
          <li><a href="#userInfo" data-toggle="tab">Users </a></li>
          <li><a href="#netInfo" data-toggle="tab">Network </a></li>
          <li><a href="#otherInfo" data-toggle="tab">Other </a></li>
        </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="equipmentInfo">
              <? include "newEquipmentForm.php"; ?>
            </div>
			<div class="tab-pane" id="purchaseInfo">
              <? include "newPurchaseForm.php"; ?>
            </div>
			<div class="tab-pane" id="locationInfo">
              <? include "newLocationForm.php"; ?>
            </div>
            <div class="tab-pane" id="userInfo">
              <? include "newUserForm.php"; ?>
            </div>
            <div class="tab-pane" id="netInfo">
              <? include "newNetworkForm.php"; ?>
            </div>
            <div class="tab-pane" id="otherInfo">
              <? include "newOtherForm.php"; ?>
            </div>
          </div>
      </div>

      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
        <button type="button" class="btn btn-primary disabled">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="well">
    <input type="text" class="span3" id="typeahead" data-provide="typeahead">
</div>
<button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#demo">
  simple collapsible
</button>

<div id="demo" class="collapse">This content was collapsed!</div>
<script>
$(function() {
    $('#typeahead').typeahead({
	    source: function(typeahead, query) {
			$.ajax({
				url: 'source.php',
				type: 'POST',
				data: 'query=' + query,
				dataType: 'JSON',
				async: false,
				success: function(data) {
				
				}
			)}
		}


    });
});
</script>

<script>
  // initially hides certain input boxes
  $('#description_input').hide();
  $('#hostname_input').hide();
  $('#os_input').hide();
  $('#building_input').hide();
  $('#room_num_input').hide();
  $('#phone_input').hide();
  $('#purchased_by_input').hide();
  $('#printer_input').hide();

  // this brings up text boxes based on equipment type
  $('#eq_type').change(function(){
     if ($('#eq_type').val() == "other")
     {
       $('#description_input').show();
       $('#hostname_input').hide();
       $('#os_input').hide();
       $('#printer_input').hide();
     } 
     else if ($('#eq_type').val() == "computer")
     {
       $('#hostname_input').show();
       $('#os_input').show();
       $('#printer_input').show();
       $('#description_input').hide();
     }
     else if ($('#eq_type').val() == "printer")
     {
       $('#hostname_input').show();
       $('#os_input').hide();
       $('#description_input').hide();
       $('#printer_input').hide();
     }
     else
     {
       $('#hostname_input').hide();
       $('#os_input').hide();
       $('#description_input').hide();
       $('#printer_input').hide();
     }
   });

  // this brings up text boxes based on purchased_by
  $('#location').change(function(){
     if ($('#location').val() == "oncampus")
     {
        $('#building_input').show();
        $('#room_num_input').show();
        $('#phone_input').show();
     } 
     else
     {
        $('#building_input').hide();
        $('#room_num_input').hide();
        $('#phone_input').hide();
     }
   });

  // this brings up text boxes based on location
  $('#purchased_by').change(function(){
     if ($('#purchased_by').val() == "other")
     {
       $('#purchased_by_input').show();
     } 
     else
     {
       $('#purchased_by_input').hide();
     }
   });
  // this resets form data in the modal on closing
  $('.modal').on('hidden.bs.modal', function(){
    $(this).find('#newEquipmentForm')[0].reset();
    $(this).find('#newPurchaseForm')[0].reset();
	$(this).find('#newLocationForm')[0].reset();
    $(this).find('#newUserForm')[0].reset();
    $(this).find('#newNetworkForm')[0].reset();
    $(this).find('#newOtherForm')[0].reset();
    $('#addRecordTab a:first').tab('show');
    $('#description_input').hide();
    $('#hostname_input').hide();
    $('#os_input').hide(); 
    $('#building_input').hide();
    $('#room_num_input').hide();
    $('#phone_input').hide();
    $('#purchased_by_input').hide();
    $('#printer_input').hide();
  });
</script>
</body>
</html>


