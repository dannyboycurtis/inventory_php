<div class="container">
  <form class="form-horizontal" role="form" id="newLocationForm" action="" method="post">
    <h4>Location Information: <small>(Items with * are optional)</small></h4>

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
      <div class="col-xs-5 col-sm-4 col-md-3">
        <select class="form-control" id="location" placeholder="Select Location">
          <option disabled selected>Select Location...
          </option>
          <option value="oncampus">On campus
          </option>
          <option value="offcampus">Off campus
          </option>
        </select>
      </div>
    </div>

    <div class="form-group" id="building_input">
      <label class="col-xs-4 col-md-2 control-label text-right">Building</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <select class="form-control" id="building" placeholder="Select Building">
          <option disabled selected>Select Building...
          </option>
          <option>UH
          </option>
          <option>PA
          </option>
          <option>VA
          </option>
          <option>CE
          </option>
        </select>
      </div>
    </div>

    <div class="form-group" id="room_num_input">
      <label class="col-xs-4 col-md-2 control-label text-right">Room Number</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <input type="text" class="form-control" id="room_num">
      </div>
    </div>

    <div class="form-group" id="phone_input">
      <label class="col-xs-4 col-md-2 control-label text-right">Phone Extension*</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <input type="text" class="form-control" id="phone" placeholder="#####" maxlength="5">
      </div>
    </div>

  </form>
</div>
