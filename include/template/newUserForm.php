<div class="container">
  <form class="form-horizontal" role="form" id="newUserForm" action="" method="post">
    <h4>Equipment Information: <small>(Items with * are optional)</small></h4>

    <div class="form-group">
      <label class="col-xs-4 col-md-2 control-label text-right">Tag Number</label>
      <div class="col-xs-2 col-sm-2 col-lg-1">
        <input type="text" class="form-control" id="tag_num" maxlength="5"> 
      </div>   
    </div>

    <div class="form-group">
      <label class="col-xs-4 col-md-2 control-label text-right">Serial Number</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <input type="text" class="form-control" id="serial"> 
      </div>
    </div>

    <div class="form-group">
      <label class="col-xs-4 col-md-2 control-label text-right">Make</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <input type="text" class="form-control" id="make"> 
      </div>
    </div>
   
    <div class="form-group">
      <label class="col-xs-4 col-md-2 control-label text-right">Model</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <input type="text" class="form-control" id="model">
      </div>
    </div>

    <div class="form-group">
      <label class="col-xs-4 col-md-2 control-label text-right">Type of Equipment</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <select class="form-control" id="eq_type" value="Select Equipment Type">
          <option disabled selected>Select Equipment Type...
          </option>
          <option>Computer or Mobile Device
          </option>
          <option>Network Printer
          </option>
          <option>Other Equipment
          </option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-xs-4 col-md-2 control-label text-right">Department</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <select class="form-control" id="department" placeholder="Select Department">
          <option disabled selected>Select Department...
          </option>
          <option>College of Arts & Letters
          </option>
          <option>Art
          </option>
          <option>Communication
          </option>
          <option>English
          </option>
          <option>Liberal Studies
          </option>
          <option>Music
          </option>
          <option>Philosophy
          </option>
          <option>Theatre Arts
          </option>
          <option>World Languages & Literature
          </option>
          <option>RAFFMA
          </option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-xs-4 col-md-2 control-label text-right">Location</label>
      <div class="col-xs-3">
        <div class="radio">
          <label>
            <input type="radio" name="location" id="oncampus" value="on" checked>On campus
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="location" id="offcampus" value="off">Off campus
          </label>
        </div>           
      </div>
    </div>

  </form>
</div>
