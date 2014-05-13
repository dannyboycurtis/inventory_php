<div class="container">
  <form class="form-horizontal" role="form" id="newPurchaseForm" action="" method="post">
    <h4>Purchase Information: <small>(Items with * are optional)</small></h4>

    <div class="form-group">
      <label class="col-xs-4 col-md-2 control-label text-right">Purchase Order*</label>
      <div class="col-xs-4 col-sm-3 col-md-2">
        <input type="text" class="form-control" id="purchase_order"> 
      </div>   
    </div>

    <div class="form-group">
      <label class="col-xs-4 col-md-2 control-label text-right">Purchase Date</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <input type="text" class="form-control" id="purchase_date" placeholder="YYYY-MM-DD">
      </div>
    </div>

    <div class="form-group">
      <label class="col-xs-4 col-md-2 control-label text-right">Purchased By</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <select class="form-control" id="purchased_by" value="Select Purchased By">
          <option disabled selected>Select Purchased By...
          </option>
          <option value="college">College
          </option>
          <option value="department">Department
          </option>
          <option value="other">Other
          </option>
        </select>
      </div>
    </div>

    <div class="form-group" id="purchased_by_input">
      <label class="col-xs-4 col-md-2 control-label text-right">Name of Purchaser</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <input type="text" class="form-control" id="purchased_by_other"> 
      </div>   
    </div>

  </form>
</div>
