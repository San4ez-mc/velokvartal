<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-ukrcredits" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><?php echo $oc15?$button_save:''; ?><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><?php echo $oc15?$button_cancel:''; ?><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-ukrcredits_license" class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-ukrcredits_license"><?php echo $text_ukrcredits_license; ?></label>
				<div class="col-sm-10">
					<div class="input-group">
					<input type="text" name="ukrcredits_license" value="" id="ukrcredits_license" data-loading-text="<?php echo $text_loading; ?>" class="form-control">
						<span class="input-group-btn">
							<button type="submit" id="ukrcredits_license" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_save; ?></button>
						</span>
					</div>
					<?php if ($error_license) { ?>
						<div class="text-danger"><?php echo $error_license; ?></div>
					<?php } ?>  					
                </div>
            </div>
			<?php echo $text_ukrcredits_license_help; ?>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>