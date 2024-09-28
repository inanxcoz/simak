	<?php js_validate(); ?>
	<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links; ?>/save" class="form-horizontal" method="post">
	  <input type="hidden" name="acc_id" id="acc_id" value="<?php echo isset($val->acc_id) ? $val->acc_id : ''; ?>" />
	  <div class="row">
	    <div class="col-md-6">
	      <div class="row form-group">
	        <div class="col-md-4 control-label">Access Group</div>
	        <div class="col-md-8">
	          <input type="text" id="acc_group" name="acc_group" class="validate[required] form-control" value="<?php echo isset($val->acc_group) ? $val->acc_group : ''; ?>" maxlength="90" autocomplete="off" />
	        </div>
	      </div>
	      <div class="row form-group">
	        <div class="col-md-4 control-label">Access Menu</div>
	        <div class="col-md-8">
	          <input type="text" id="acc_menu" name="acc_menu" class="validate[required] form-control" value="<?php echo isset($val->acc_menu) ? $val->acc_menu : ''; ?>" maxlength="90" autocomplete="off" />
	        </div>
	      </div>
	      <div class="row form-group">
	        <div class="col-md-4 control-label">Access Controller Group</div>
	        <div class="col-md-8">
	          <input type="text" id="acc_group_controller" name="acc_group_controller" class="validate[required] form-control" value="<?php echo isset($val->acc_group_controller) ? $val->acc_group_controller : ''; ?>" maxlength="8" autocomplete="off" />
	        </div>
	      </div>
	      <div class="row form-group">
	        <div class="col-md-4 control-label">Access Controller Name</div>
	        <div class="col-md-8">
	          <input type="text" id="acc_controller_name" name="acc_controller_name" class="validate[required] form-control" value="<?php echo isset($val->acc_controller_name) ? $val->acc_controller_name : ''; ?>" maxlength="90" autocomplete="off" />
	        </div>
	      </div>
        <div class="row form-group">
          <div class="col-md-4 control-label">Access Name</div>
          <div class="col-md-8">
            <input type="text" id="acc_access_name" name="acc_access_name" class="validate[required] form-control" value="<?php echo isset($val->acc_access_name) ? $val->acc_access_name : ''; ?>" maxlength="90" autocomplete="off" />
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row form-group">
          <div class="col-md-4 control-label">Access Description</div>
          <div class="col-md-8">
            <input type="text" id="acc_description" name="acc_description" class="validate[required] form-control" value="<?php echo isset($val->acc_description) ? $val->acc_description : ''; ?>" maxlength="90" autocomplete="off" />
          </div>
        </div>
        <div class="row form-group">
          <div class="col-md-4 control-label">Access By Order</div>
          <div class="col-md-8">
            <input type="text" id="acc_by_order" name="acc_by_order" class="validate[required] form-control" value="<?php echo isset($val->acc_by_order) ? $val->acc_by_order : ''; ?>" maxlength="90" autocomplete="off" />
          </div>
        </div>
        <div class="row form-group">
          <div class="col-md-4 control-label">App Id</div>
          <div class="col-md-8">
            <input type="text" id="app_id" name="app_id" class="validate[required] form-control" value="<?php echo isset($val->app_id) ? $val->app_id : ''; ?>" maxlength="90" autocomplete="off" />
          </div>
        </div>
        <div class="row form-group">
          <div class="col-md-4 control-label">Access CSS Class</div>
          <div class="col-md-8">
            <input type="text" id="acc_css_class" name="acc_css_class" class="validate[required] form-control" value="<?php echo isset($val->acc_css_class) ? $val->acc_css_class : ''; ?>" maxlength="90" autocomplete="off" />
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