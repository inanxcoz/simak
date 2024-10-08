 <form action="" method="post">
 	<div class="well">
 		<div class="row">
 			<?php if ($this->jCfg['user']['is_all'] == 1 ||  $this->jCfg['user']['is_all'] == 0) { ?>
 				<?php if (count($this->cat_search) > 0) { ?>
 					<div class="col-md-2">
 						<select name="colum" class="form-control select" id="colum">
 							<?php cat_search($this->cat_search); ?>
 						</select>
 					</div>
 				<?php } else { ?>
 					<input type="hidden" name="colum" value="" />
 				<?php } ?>
 				<div class="col-md-2">
 					<input type="text" class="form-control" id="keyword" name="keyword" value="<?php echo $this->jCfg['search']['keyword']; ?>" placeholder="Keyword" />
 				</div>
 			<?php } else { ?>
 				<input type="hidden" name="keyword" value="" />
 				<input type="hidden" name="colum" value="" />
 			<?php } ?>

 			<?php if ($this->is_search_date == true) { ?>
 				<div class="col-md-2" style="margin-top:0px;">
 					<div class="input-group">
 						<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
 						<input type="text" id="date_start" name="date_start" class="form-control datepicker" placeholder="Tanggal Awal" value="<?php echo $this->jCfg['search']['date_start']; ?>" />
 					</div>
 				</div>
 				<div class="col-md-2" style="margin-top:0px;">
 					<div class="input-group">
 						<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
 						<input type="text" id="date_end" name="date_end" class="form-control datepicker" placeholder="Tanggal Akhir" value="<?php echo $this->jCfg['search']['date_end']; ?>" />
 					</div>
 				</div>
 			<?php } ?>
 			<div class="col-md-2" style="margin-top:0px;">
 				<input type="submit" value="Search!" style="margin-right:5px;" name="btn_search" id="btn_search" class="btn btn-primary col-md-5" />
 				<input type="submit" value="Reset!" name="btn_reset" id="btn_reset" class="btn btn-warning col-md-5" />
 			</div>
 			<?php if ($this->enable_option_limit == TRUE) { ?>
 				<div class="col-md-1 pull-right">
 					<select name="limit_page" class="form-control select" id="limit_page">
 						<?php foreach ((array)$this->arr_perpage as $page1) { ?>
 							<option value="<?php echo $page1; ?>" <?php echo $this->per_page == $page1 ? 'selected="selected"' : ''; ?>><?php echo $page1; ?></option>
 						<?php } ?>
 					</select>
 				</div>
 			<?php } ?>
 			<?php if ($this->enable_download == FALSE) { ?>
 				<div class="col-md-1 pull-right">
 					<div class="btn-group pull-right"> <a href="#" data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-demo-space"> <span class="fa fa-download"></span>Download <span class="caret"></span> </a>
 						<ul class="dropdown-menu">
 							<li><a href="<?php echo $this->own_link; ?>/export_data?type=html" target="_blank"><span class="fa fa-html5"></span> Html</a></li>
 							<li><a href="<?php echo $this->own_link; ?>/export_data?type=excel"><span class="fa fa-table"></span> Excel</a></li>
 						</ul>
 					</div>
 				</div>
 			<?php } ?>
 		</div>
 	</div>
 </form>