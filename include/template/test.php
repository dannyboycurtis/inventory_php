<html>
<head>
  <title>TestAddRecord.php</title>

  <script src="../../js/jquery-2.1.0.min.js"></script>

  <link rel="stylesheet" href="../../css/bootstrap.min.css">
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/bootstrap-typeahead.js"></script>

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
          <li class="active"><a href="#equipmentInfo" data-toggle="tab">Equipment </a></li>
		  <li><a href="#purchaseInfo" data-toggle="tab">Purchase </a></li>
		  <li><a href="#locationInfo" data-toggle="tab">Location </a></li>
          <li><a href="#userInfo" data-toggle="tab">Users </a></li>
          <li><a href="#netInfo" data-toggle="tab">Network </a></li>
          <li><a href="#otherInfo" data-toggle="tab">Other </a></li>
        </ul>
		<br>
          <div class="tab-content">
            <div class="tab-pane active" id="equipmentInfo">
              <?php include "newEquipmentForm.php"; ?>
            </div>
			<div class="tab-pane" id="purchaseInfo">
              <?php include "newPurchaseForm.php"; ?>
            </div>
			<div class="tab-pane" id="locationInfo">
              <?php include "newLocationForm.php"; ?>
            </div>
            <div class="tab-pane" id="userInfo">
              <?php include "newUserForm.php"; ?>
            </div>
            <div class="tab-pane" id="netInfo">
              <?php include "newNetworkForm.php"; ?>
            </div>
            <div class="tab-pane" id="otherInfo">
              <?php include "newOtherForm.php"; ?>
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
    <input type="text" class="span3" id="typeahead" data-provide="typeahead" autocomplete="off">
</div>
<script>
$(document).ready(function() {
    $('#typeahead').typeahead({
	    source: function(typeahead, query) {
			$.ajax({
				url: 'source.php',
				type: 'POST',
				data: 'query=' + query,
				datatype: 'JSON',
				async: false,
				success: function(data) {
					typeahead.process(JSON.parse(data));
					console.log(data);
				}
			});
		}
    });
});

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
       $('#hostname_input, #os_input, #printer_input').hide();

     } 
     else if ($('#eq_type').val() == "computer")
     {
       $('#hostname_input, #os_input, #printer_input').show();
       $('#description_input').hide();
     }
     else if ($('#eq_type').val() == "printer")
     {
       $('#hostname_input').show();
       $('#os_input, #description_input, #printer_input').hide();
     }
     else
       $('#hostname_input, #os_input, #description_input, #printer_input').hide();
   });

  // this brings up text boxes based on purchased_by
  $('#location').change(function(){
     if ($('#location').val() == "oncampus")
        $('#building_input, #room_num_input').show();

     else
        $('#building_input, #room_num_input').hide();

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
    $('#description_input, #hostname_input, #os_input, #printer_input').hide();
    $('#building_input, #room_num_input').hide();
    $('#purchased_by_input').hide();
	$( '#newMake, #newModel' ).hide();
	$( '#maketype' ).text( "Choose Make " );
	$( '#modeltype' ).text( "Choose Model " );
  });
</script>
</body>
</html>


