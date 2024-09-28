	<?php js_validate(); ?>
	<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
	  <input type="hidden" name="aca_id" id="aca_id" value="<?php echo isset($val->aca_id) ? $val->aca_id : ''; ?>" />
	  <div class="row">
	    <div class="col-md-6">
	      <div class="row form-group">
	        <div class="col-md-4 control-label">Access Id</div>
	        <div class="col-md-8">
	          <input type="text" id="aca_access_id" name="aca_access_id" class="validate[required] form-control" value="<?php echo isset($val->aca_access_id) ? $val->aca_access_id : ''; ?>" maxlength="90" autocomplete="off" />
	        </div>
	      </div>
	      <div class="row form-group">
	        <div class="col-md-4 control-label">Action Id</div>
	        <div class="col-md-8">
	        	<select name="aca_action_id" id="aca_action_id" class="validate[required] form-control select">
	            <option value=""> - Pilih - </option>
	            <?php
	            foreach ((array)cfg('action') as $k1 => $v1) {
	              $slc = isset($val) && trim($val->aca_action_id) == $k1 ? 'selected="selected"' : '';
	              echo "<option value='" . $k1 . "' $slc >" . $v1 . "</option>";
	            }
	            ?>
	          </select>
	          <!-- <input type="text" id="aca_action_id" name="aca_action_id" class="validate[required] form-control" value="<?php echo isset($val->aca_action_id) ? $val->aca_action_id : ''; ?>" maxlength="90" autocomplete="off" /> -->
	        </div>
	      </div>
	      <div class="row form-group">
	        <div class="col-md-4 control-label">App Id</div>
	        <div class="col-md-8">
	          <input type="text" id="app_id" name="app_id" class="validate[required] form-control" value="<?php echo isset($val->app_id) ? $val->app_id : ''; ?>" maxlength="8" autocomplete="off" />
	        </div>
	      </div>
	    </div>
	  </div>
	  <br />
	  <div class="panel-footer">
	    <div class="pull-left">
	      <button type="button" onclick="document.location='<?php echo $own_links; ?>'" class="btn btn-warning btn-cons">Cancel</button>
	    </div>
	    <div class="pull-right">
	      <button type="submit" name="simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Save</button>
	    </div>
	  </div>
	</form>