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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-ukrcredits" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-pp" data-toggle="tab"><?php echo $tab_pp; ?></a></li>
			<li><a href="#tab-ii" data-toggle="tab"><?php echo $tab_ii; ?></a></li>
			<li><a href="#tab-mb" data-toggle="tab"><?php echo $tab_mb; ?></a></li>
            <li><a href="#tab-status" data-toggle="tab"><?php echo $tab_order_status; ?></a></li>
			<li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>
          </ul> 
          <div class="tab-content">
            <div class="tab-pane active" id="tab-pp">
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-id-pp"><?php echo $entry_shop_id; ?></label>
                <div class="col-sm-10">
                  <?php echo $text_paymentparts_url;?>
                  <input type="text" name="pp_shop_id" value="<?php echo $pp_shop_id; ?>" placeholder="<?php echo $entry_shop_id; ?>" id="input-shop-id-pp" class="form-control"/>
                  <?php if ($error_shop_id_pp) { ?>
                  <div class="text-danger"><?php echo $error_shop_id; ?></div>
                  <?php } ?>                  
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-password-pp"><?php echo $entry_shop_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_shop_password" value="<?php echo $pp_shop_password; ?>" placeholder="<?php echo $entry_shop_password; ?>" id="input-shop-password-pp" class="form-control"/>
                  <?php if ($error_shop_password_pp) { ?>
                  <div class="text-danger"><?php echo $error_shop_password; ?></div>
                  <?php } ?>                   
                </div>                
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="pp_status" id="input-status" class="form-control">
                    <?php if ($pp_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>			  
              <div class="form-group">                  
                <label class="col-sm-2 control-label" for="input-sort-order-pp"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_sort_order" value="<?php echo $pp_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order-pp" class="form-control"/>
                </div>
              </div>				  
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_payment_type; ?>"><?php echo $entry_payment_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pp_hold) { ?>
                    <input type="radio" name="pp_hold" value="1" checked="checked" />
                    <?php echo $entry_payment_type_hold; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_hold" value="1" />
                    <?php echo $entry_payment_type_hold; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pp_hold) { ?>
                    <input type="radio" name="pp_hold" value="0" checked="checked" />
                    <?php echo $entry_payment_type_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_hold" value="0" />
                    <?php echo $entry_payment_type_standart; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pp_discount) { ?>
                    <input type="radio" name="pp_discount" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_discount" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pp_discount) { ?>
                    <input type="radio" name="pp_discount" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_discount" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_special; ?>"><?php echo $entry_special; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pp_special) { ?>
                    <input type="radio" name="pp_special" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_special" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pp_special) { ?>
                    <input type="radio" name="pp_special" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_special" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock; ?>"><?php echo $entry_stock; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pp_stock) { ?>
                    <input type="radio" name="pp_stock" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_stock" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pp_stock) { ?>
                    <input type="radio" name="pp_stock" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_stock" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-ii-pq"><span data-toggle="tooltip" title="<?php echo $help_pq; ?>"><?php echo $entry_pq; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_pq" value="<?php echo $pp_pq; ?>" placeholder="<?php echo $entry_pq; ?>" id="input-ii-pq" class="form-control"/>
                  <?php if ($error_pq_pp) { ?>
                  <div class="text-danger"><?php echo $error_pq; ?></div>
                  <?php } ?>        
                </div>
              </div>                
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-pp_min_total"><span data-toggle="tooltip" title="<?php echo $help_min_total; ?>"><?php echo $entry_min_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_min_total" value="<?php echo $pp_min_total; ?>" placeholder="<?php echo $entry_min_total; ?>" id="input-pp_min_total" class="form-control"/>
                </div>
              </div>          
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-pp_max_total"><span data-toggle="tooltip" title="<?php echo $help_max_total; ?>"><?php echo $entry_max_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_max_total" value="<?php echo $pp_max_total; ?>" placeholder="<?php echo $entry_max_total; ?>" id="input-pp_max_total" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_merchant_type; ?>"><?php echo $entry_merchant_type; ?></span></label>
                <div class="col-sm-10">
				  <?php echo $text_merchant_type_url;?>				
                  <label class="radio-inline">
                    <?php if ($pp_merchantType == 'PP') { ?>
                    <input type="radio" name="pp_merchantType" value="PP" checked="checked" />
                    <?php echo $entry_pp_merchantType_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_merchantType" value="PP" />
                    <?php echo $entry_pp_merchantType_standart; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($pp_merchantType == 'PB') { ?>
                    <input type="radio" name="pp_merchantType" value="PB" checked="checked" />
                    <?php echo $entry_pp_merchantType_period; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_merchantType" value="PB" />
                    <?php echo $entry_pp_merchantType_period; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
				<?php if (!isset($pp_markup_type)){$pp_markup_type = 'fixed';} ?>
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_markup_type; ?>"><?php echo $entry_markup_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pp_markup_type == 'fixed') { ?>
                    <input type="radio" name="pp_markup_type" value="fixed" checked="checked" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_markup_type" value="fixed" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($pp_markup_type == 'custom') { ?>
                    <input type="radio" name="pp_markup_type" value="custom" checked="checked" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } else { ?>
                    <input type="radio" name="pp_markup_type" value="custom" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-pp_markup"><span data-toggle="tooltip" title="<?php echo $help_markup; ?>"><?php echo $entry_markup; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_markup" value="<?php echo $pp_markup; ?>" placeholder="<?php echo $entry_markup; ?>" id="input-pp_markup" class="form-control"/>
                </div>
              </div>  
              <div id="pp_markup_custom" class="form-group" style="display:none">                
                <label class="col-sm-2 control-label" for="input-pp_markup_custom"><span data-toggle="tooltip" title="<?php echo $help_markup_custom; ?>"><?php echo $entry_markup_custom; ?></span></label>
				<div class="col-sm-10">
					<?php 
					if (!isset($pp_markup_custom_PP)) {
						$pp_markup_custom_PP = array(1 => 1.5,2 => 2.5,3 => 4.5,4 => 7,5 => 9,6 => 11.5,7 => 13.5,8 => 15.5,9 => 16.5,10 => 17,11 => 17.5,12 => 19,13 => 20.5,14 => 22,15 => 23.5,16 => 24.5,17 => 26,18 => 27,19 => 28.5,20 => 29.5,21 => 31,22 => 32,23 => 33,24 => 34.5); 
					}
					?>
					<div class="row">
						<div>
						<?php foreach (array_chunk($pp_markup_custom_PP, ceil(count($pp_markup_custom_PP) / 4), true) as $pp_markup_custom_PP) { ?>
							<div class="col-sm-3">
							<?php foreach ($pp_markup_custom_PP as $key => $value) { ?>
								<div class="input-group">
									<span class="input-group-addon" style="width:70px"><?php echo $key; ?> мес</span>
									<input type="text" name="pp_markup_custom_PP[<?php echo $key; ?>]" value="<?php echo $value; ?>" placeholder="%" id="input-pp_markup_custom-<?php echo $key; ?>" class="form-control text-center">
									<span class="input-group-addon">%</span>
								</div> 
							<?php } ?>
							</div>
						<?php } ?>
						</div>
						<div class="col-sm-4"><br>
							<div class="input-group">
								<span class="input-group-addon" style="width:70px"><?php echo $entry_acquiring; ?></span>
								<input type="text" name="pp_markup_acquiring" value="<?php echo isset($pp_markup_acquiring)?$pp_markup_acquiring:'2.0'; ?>" placeholder="%" id="input-pp_markup_acquiring" class="form-control text-center">
								<span class="input-group-addon">%</span>
							</div> 
						</div>							
					</div>
				</div>
			  </div>  			  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-allowed"><span data-toggle="tooltip" title="<?php echo $help_enabled; ?>"><?php echo $entry_enabled; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($pp_enabled) { ?>
                    <input type="radio" id="enabled_all_pp" name="pp_enabled" value="1" checked="checked" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_all_pp" name="pp_enabled" value="1" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$pp_enabled) { ?>
                    <input type="radio" id="enabled_selected_pp" name="pp_enabled" value="0" checked="checked" />
                    <?php echo $entry_enabled_all; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_selected_pp" name="pp_enabled" value="0" <?php echo $pp_products_allowed?'disabled':''; ?>/>
                    <?php echo $entry_enabled_all; ?>
                    <?php } ?>
				  </label>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2"></label>
				<div class="col-sm-10">
					<input type="text" name="allowed_pp" value="" placeholder="<?php echo $entry_enabled; ?>" id="input-allowed" class="form-control" />
					<input type="text" name="category_allowed_pp" value="" placeholder="<?php echo $entry_enabled_cat; ?>" class="form-control" />
					<div id="product-allowed_pp" class="well well-sm" style="height: 300px; overflow: auto;">
					<?php foreach ($pp_products_allowed as $product_allowed) { ?>
					<div id="product-allowed_pp<?php echo $product_allowed['product_id']; ?>"><?php if ($oc15) { ?><img src="view/image/delete.png" alt="" /><?php } else { ?><i class="fa fa-minus-circle"></i><?php } ?> <?php echo $product_allowed['name']; ?>
					<input type="hidden" name="pp_product_allowed[]" value="<?php echo $product_allowed['product_id']; ?>" />
					</div> 
					<?php } ?>
				  </div>
				</div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="pp_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $pp_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>  
            </div>

            <div class="tab-pane" id="tab-ii">
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-id-ii"><?php echo $entry_shop_id; ?></label>
                <div class="col-sm-10">
                  <?php echo $text_paymentparts_url;?>
                  <input type="text" name="ii_shop_id" value="<?php echo $ii_shop_id; ?>" placeholder="<?php echo $entry_shop_id; ?>" id="input-shop-id-ii" class="form-control"/>
                  <?php if ($error_shop_id_ii) { ?>
                  <div class="text-danger"><?php echo $error_shop_id; ?></div>
                  <?php } ?>                  
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-password-ii"><?php echo $entry_shop_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="ii_shop_password" value="<?php echo $ii_shop_password; ?>" placeholder="<?php echo $entry_shop_password; ?>" id="input-shop-password-ii" class="form-control"/>
                  <?php if ($error_shop_password_ii) { ?>
                  <div class="text-danger"><?php echo $error_shop_password; ?></div>
                  <?php } ?>                   
                </div>                
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="ii_status" id="input-status" class="form-control">
                    <?php if ($ii_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>			  
              <div class="form-group">                  
                <label class="col-sm-2 control-label" for="input-sort-order-ii"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="ii_sort_order" value="<?php echo $ii_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order-ii" class="form-control"/>
                </div>
              </div>				  
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_payment_type; ?>"><?php echo $entry_payment_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ii_hold) { ?>
                    <input type="radio" name="ii_hold" value="1" checked="checked" />
                    <?php echo $entry_payment_type_hold; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_hold" value="1" />
                    <?php echo $entry_payment_type_hold; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ii_hold) { ?>
                    <input type="radio" name="ii_hold" value="0" checked="checked" />
                    <?php echo $entry_payment_type_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_hold" value="0" />
                    <?php echo $entry_payment_type_standart; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ii_discount) { ?>
                    <input type="radio" name="ii_discount" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_discount" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ii_discount) { ?>
                    <input type="radio" name="ii_discount" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_discount" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_special; ?>"><?php echo $entry_special; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ii_special) { ?>
                    <input type="radio" name="ii_special" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_special" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ii_special) { ?>
                    <input type="radio" name="ii_special" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_special" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock; ?>"><?php echo $entry_stock; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ii_stock) { ?>
                    <input type="radio" name="ii_stock" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_stock" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ii_stock) { ?>
                    <input type="radio" name="ii_stock" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_stock" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-ii-pq"><span data-toggle="tooltip" title="<?php echo $help_pq; ?>"><?php echo $entry_pq; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="ii_pq" value="<?php echo $ii_pq; ?>" placeholder="<?php echo $entry_pq; ?>" id="input-ii-pq" class="form-control"/>
                  <?php if ($error_pq_ii) { ?>
                  <div class="text-danger"><?php echo $error_pq; ?></div>
                  <?php } ?>        
                </div>
              </div>                
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-ii_min_total"><span data-toggle="tooltip" title="<?php echo $help_min_total; ?>"><?php echo $entry_min_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="ii_min_total" value="<?php echo $ii_min_total; ?>" placeholder="<?php echo $entry_min_total; ?>" id="input-ii_min_total" class="form-control"/>
                </div>
              </div>          
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-ii_max_total"><span data-toggle="tooltip" title="<?php echo $help_max_total; ?>"><?php echo $entry_max_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="ii_max_total" value="<?php echo $ii_max_total; ?>" placeholder="<?php echo $entry_max_total; ?>" id="input-ii_max_total" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_merchant_type; ?>"><?php echo $entry_merchant_type; ?></span></label>
                <div class="col-sm-10">
				  <?php echo $text_merchant_type_url;?>				
                  <label class="radio-inline">
                    <?php if ($ii_merchantType == 'II') { ?>
                    <input type="radio" name="ii_merchantType" value="II" checked="checked" />
                    <?php echo $entry_ii_merchantType_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_merchantType" value="II" />
                    <?php echo $entry_ii_merchantType_standart; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($ii_merchantType == 'IA') { ?>
                    <input type="radio" name="ii_merchantType" value="IA" checked="checked" />
                    <?php echo $entry_ii_merchantType_special; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_merchantType" value="IA" />
                    <?php echo $entry_ii_merchantType_special; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
				<?php if (!isset($ii_markup_type)){$ii_markup_type = 'fixed';} ?>
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_markup_type; ?>"><?php echo $entry_markup_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ii_markup_type == 'fixed') { ?>
                    <input type="radio" name="ii_markup_type" value="fixed" checked="checked" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_markup_type" value="fixed" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($ii_markup_type == 'custom') { ?>
                    <input type="radio" name="ii_markup_type" value="custom" checked="checked" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } else { ?>
                    <input type="radio" name="ii_markup_type" value="custom" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-ii_markup"><span data-toggle="tooltip" title="<?php echo $help_markup; ?>"><?php echo $entry_markup; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="ii_markup" value="<?php echo $ii_markup; ?>" placeholder="<?php echo $entry_markup; ?>" id="input-ii_markup" class="form-control"/>
                </div>
              </div> 
              <div id="ii_markup_custom" class="form-group" style="display:none">                
                <label class="col-sm-2 control-label" for="input-ii_markup_custom"><span data-toggle="tooltip" title="<?php echo $help_markup_custom; ?>"><?php echo $entry_markup_custom; ?></span></label>
				<div class="col-sm-10">
					<?php 
					if (!isset($ii_markup_custom_II)) {
						$ii_markup_custom_II = array(1 => 1.5,2 => 2.5,3 => 4.5,4 => 6.4,5 => 7.6,6 => 8.2,7 => 8.7,8 => 9.7,9 => 10.6,10 => 11.6,11 => 12.2,12 => 12.5,13 => 12.8,14 => 13.1,15 => 13.4,16 => 13.7,17 => 14,18 => 14.3,19 => 14.7,20 => 15.5,21 => 16.2,22 => 17,23 => 17.6,24 => 18.3); 
					}
					?>
					<div class="row">
						<div>
						<?php foreach (array_chunk($ii_markup_custom_II, ceil(count($ii_markup_custom_II) / 4), true) as $ii_markup_custom_II) { ?>
							<div class="col-sm-3">
							<?php foreach ($ii_markup_custom_II as $key => $value) { ?>
								<div class="input-group">
									<span class="input-group-addon" style="width:70px"><?php echo $key; ?> мес</span>
									<input type="text" name="ii_markup_custom_II[<?php echo $key; ?>]" value="<?php echo $value; ?>" placeholder="%" id="input-ii_markup_custom-<?php echo $key; ?>" class="form-control text-center">
									<span class="input-group-addon">%</span>
								</div> 
							<?php } ?>
							</div>
						<?php } ?>
						</div>
						<div class="col-sm-4"><br>
							<div class="input-group">
								<span class="input-group-addon" style="width:70px"><?php echo $entry_acquiring; ?></span>
								<input type="text" name="ii_markup_acquiring" value="<?php echo isset($ii_markup_acquiring)?$ii_markup_acquiring:'0'; ?>" placeholder="%" id="input-ii_markup_acquiring" class="form-control text-center">
								<span class="input-group-addon">%</span>
							</div> 
						</div>	
					</div>
				</div>
			  </div>  	
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-allowed"><span data-toggle="tooltip" title="<?php echo $help_enabled; ?>"><?php echo $entry_enabled; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($ii_enabled) { ?>
                    <input type="radio" id="enabled_all_ii" name="ii_enabled" value="1" checked="checked" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_all_ii" name="ii_enabled" value="1" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$ii_enabled) { ?>
                    <input type="radio" id="enabled_selected_ii" name="ii_enabled" value="0" checked="checked" />
                    <?php echo $entry_enabled_all; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_selected_ii" name="ii_enabled" value="0" <?php echo $ii_products_allowed?'disabled':''; ?>/>
                    <?php echo $entry_enabled_all; ?>
                    <?php } ?>
				  </label>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2"></label>
				<div class="col-sm-10">
					<input type="text" name="allowed_ii" value="" placeholder="<?php echo $entry_enabled; ?>" id="input-allowed" class="form-control" />
					<input type="text" name="category_allowed_ii" value="" placeholder="<?php echo $entry_enabled_cat; ?>" class="form-control" />
					<div id="product-allowed_ii" class="well well-sm" style="height: 300px; overflow: auto;">
					<?php foreach ($ii_products_allowed as $product_allowed) { ?>
					<div id="product-allowed_ii<?php echo $product_allowed['product_id']; ?>"><?php if ($oc15) { ?><img src="view/image/delete.png" alt="" /><?php } else { ?><i class="fa fa-minus-circle"></i><?php } ?> <?php echo $product_allowed['name']; ?>
					<input type="hidden" name="ii_product_allowed[]" value="<?php echo $product_allowed['product_id']; ?>" />
					</div> 
					<?php } ?>
				  </div>
				</div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="ii_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $ii_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>  
            </div>
            <div class="tab-pane" id="tab-mb">
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-id-mb"><?php echo $entry_shop_id; ?></label>
                <div class="col-sm-10">
                  <?php echo $text_paymentparts_url_mono;?>
                  <input type="text" name="mb_shop_id" value="<?php echo $mb_shop_id; ?>" placeholder="<?php echo $entry_shop_id; ?>" id="input-shop-id-mb" class="form-control"/>
                  <?php if ($error_shop_id_mb) { ?>
                  <div class="text-danger"><?php echo $error_shop_id; ?></div>
                  <?php } ?>                  
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-password-mb"><?php echo $entry_shop_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="mb_shop_password" value="<?php echo $mb_shop_password; ?>" placeholder="<?php echo $entry_shop_password; ?>" id="input-shop-password-mb" class="form-control"/>
                  <?php if ($error_shop_password_mb) { ?>
                  <div class="text-danger"><?php echo $error_shop_password; ?></div>
                  <?php } ?>                   
                </div>                
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="mb_status" id="input-status" class="form-control">
                    <?php if ($mb_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>			  
              <div class="form-group">                  
                <label class="col-sm-2 control-label" for="input-sort-order-mb"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="mb_sort_order" value="<?php echo $mb_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order-mb" class="form-control"/>
                </div>
              </div>				  
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_discount; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($mb_discount) { ?>
                    <input type="radio" name="mb_discount" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_discount" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$mb_discount) { ?>
                    <input type="radio" name="mb_discount" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_discount" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_special; ?>"><?php echo $entry_special; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($mb_special) { ?>
                    <input type="radio" name="mb_special" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_special" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$mb_special) { ?>
                    <input type="radio" name="mb_special" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_special" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_stock; ?>"><?php echo $entry_stock; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($mb_stock) { ?>
                    <input type="radio" name="mb_stock" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_stock" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$mb_stock) { ?>
                    <input type="radio" name="mb_stock" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_stock" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_merchant_type; ?></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($mb_merchantType == 'MB') { ?>
                    <input type="radio" name="mb_merchantType" value="MB" checked="checked" />
                    <?php echo $entry_mb_merchantType_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_merchantType" value="MB" />
                    <?php echo $entry_mb_merchantType_standart; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-mb-pq"><span data-toggle="tooltip" title="<?php echo $help_pq; ?>"><?php echo $entry_pq; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="mb_pq" value="<?php echo $mb_pq; ?>" placeholder="<?php echo $entry_pq; ?>" id="input-mb-pq" class="form-control"/>
                  <?php if ($error_pq_mb) { ?>
                  <div class="text-danger"><?php echo $error_pq; ?></div>
                  <?php } ?>        
                </div>
              </div>                
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-mb_min_total"><span data-toggle="tooltip" title="<?php echo $help_min_total; ?>"><?php echo $entry_min_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="mb_min_total" value="<?php echo $mb_min_total; ?>" placeholder="<?php echo $entry_min_total; ?>" id="input-mb_min_total" class="form-control"/>
                </div>
              </div>          
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-mb_max_total"><span data-toggle="tooltip" title="<?php echo $help_max_total; ?>"><?php echo $entry_max_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="mb_max_total" value="<?php echo $mb_max_total; ?>" placeholder="<?php echo $entry_max_total; ?>" id="input-mb_max_total" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
				<?php if (!isset($mb_markup_type)){$mb_markup_type = 'fixed';} ?>
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_markup_type; ?>"><?php echo $entry_markup_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($mb_markup_type == 'fixed') { ?>
                    <input type="radio" name="mb_markup_type" value="fixed" checked="checked" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_markup_type" value="fixed" />
                    <?php echo $entry_markup_type_fixed; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if ($mb_markup_type == 'custom') { ?>
                    <input type="radio" name="mb_markup_type" value="custom" checked="checked" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } else { ?>
                    <input type="radio" name="mb_markup_type" value="custom" />
                    <?php echo $entry_markup_type_custom; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-mb_markup"><span data-toggle="tooltip" title="<?php echo $help_markup; ?>"><?php echo $entry_markup; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="mb_markup" value="<?php echo $mb_markup; ?>" placeholder="<?php echo $entry_markup; ?>" id="input-mb_markup" class="form-control"/>
                </div>
              </div>  
              <div id="mb_markup_custom" class="form-group" style="display:none">                
                <label class="col-sm-2 control-label" for="input-mb_markup_custom"><span data-toggle="tooltip" title="<?php echo $help_markup_custom; ?>"><?php echo $entry_markup_custom; ?></span></label>
				<div class="col-sm-10">
					<?php 
					if (!isset($mb_markup_custom_MB)) {
						$mb_markup_custom_MB = array(2 => 2.9, 3 => 4.1, 4 => 5.9, 5 => 7.2, 6 => 8.3, 7 => 9.5, 8 => 10.8, 9 => 12, 10 => 13.2, 11 => 14.3, 12 => 15.5, 13 => 16.6, 14 => 17.7, 15 => 18.8, 16 => 19.8, 17 => 20.9, 18 => 21.9, 19 => 23, 20 => 24, 21 => 29.4, 22 => 25.9, 23 => 26.8, 24 => 27.8); 
					}
					?>
					<div class="row">
						<div>
						<?php foreach (array_chunk($mb_markup_custom_MB, ceil(count($mb_markup_custom_MB) / 4), true) as $mb_markup_custom_MB) { ?>
							<div class="col-sm-3">
							<?php foreach ($mb_markup_custom_MB as $key => $value) { ?>
								<div class="input-group">
									<span class="input-group-addon" style="width:70px"><?php echo $key; ?> мес</span>
									<input type="text" name="mb_markup_custom_MB[<?php echo $key; ?>]" value="<?php echo $value; ?>" placeholder="%" id="input-mb_markup_custom-<?php echo $key; ?>" class="form-control text-center">
									<span class="input-group-addon">%</span>
								</div> 
							<?php } ?>
							</div>
						<?php } ?>
						</div>
						<div class="col-sm-4"><br>
							<div class="input-group">
								<span class="input-group-addon" style="width:70px"><?php echo $entry_acquiring; ?></span>
								<input type="text" name="mb_markup_acquiring" value="<?php echo isset($mb_markup_acquiring)?$mb_markup_acquiring:'0'; ?>" placeholder="%" id="input-mb_markup_acquiring" class="form-control text-center">
								<span class="input-group-addon">%</span>
							</div> 
						</div>	
					</div>
				</div>
			  </div>  				  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-allowed"><span data-toggle="tooltip" title="<?php echo $help_enabled; ?>"><?php echo $entry_enabled; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($mb_enabled) { ?>
                    <input type="radio" id="enabled_all_mb" name="mb_enabled" value="1" checked="checked" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_all_mb" name="mb_enabled" value="1" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$mb_enabled) { ?>
                    <input type="radio" id="enabled_selected_mb" name="mb_enabled" value="0" checked="checked" />
                    <?php echo $entry_enabled_all; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_selected_mb" name="mb_enabled" value="0" <?php echo $mb_products_allowed?'disabled':''; ?>/>
                    <?php echo $entry_enabled_all; ?>
                    <?php } ?>
				  </label>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2"></label>
				<div class="col-sm-10">
					<input type="text" name="allowed_mb" value="" placeholder="<?php echo $entry_enabled; ?>" id="input-allowed" class="form-control" />
					<input type="text" name="category_allowed_mb" value="" placeholder="<?php echo $entry_enabled_cat; ?>" class="form-control" />
					<div id="product-allowed_mb" class="well well-sm" style="height: 300px; overflow: auto;">
					<?php foreach ($mb_products_allowed as $product_allowed) { ?>
					<div id="product-allowed_mb<?php echo $product_allowed['product_id']; ?>"><?php if ($oc15) { ?><img src="view/image/delete.png" alt="" /><?php } else { ?><i class="fa fa-minus-circle"></i><?php } ?> <?php echo $product_allowed['name']; ?>
					<input type="hidden" name="mb_product_allowed[]" value="<?php echo $product_allowed['product_id']; ?>" />
					</div> 
					<?php } ?>
				  </div>
				</div>
			  </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="mb_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $mb_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>  
            </div>

            <div class="tab-pane" id="tab-status">
				<div class="form-group">
				  <label class="col-sm-2 control-label"><?php echo $entry_completed_status; ?></label>
				  <div class="col-sm-10">
					<select name="completed_status_id" class="form-control">
					  <?php foreach ($order_statuses as $order_status) { ?>
					  <?php if ($order_status['order_status_id'] == $completed_status_id) { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label"><?php echo $entry_canceled_status; ?></label>
				  <div class="col-sm-10">
					<select name="canceled_status_id" class="form-control">
					  <?php foreach ($order_statuses as $order_status) { ?>
					  <?php if ($order_status['order_status_id'] == $canceled_status_id) { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
				  </div>
				</div> 
				<div class="form-group">
				  <label class="col-sm-2 control-label"><?php echo $entry_clientwait_status; ?></label>
				  <div class="col-sm-10">
					<select name="clientwait_status_id" class="form-control">
					  <?php foreach ($order_statuses as $order_status) { ?>
					  <?php if ($order_status['order_status_id'] == $clientwait_status_id) { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
				  </div>
				</div> 
				<div class="form-group">
				  <label class="col-sm-2 control-label"><?php echo $entry_created_status; ?></label>
				  <div class="col-sm-10">
					<select name="created_status_id" class="form-control">
					  <?php foreach ($order_statuses as $order_status) { ?>
					  <?php if ($order_status['order_status_id'] == $created_status_id) { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
				  </div>
				</div>                                                     
				<div class="form-group">
				  <label class="col-sm-2 control-label"><?php echo $entry_failed_status; ?></label>
				  <div class="col-sm-10">
					<select name="failed_status_id" class="form-control">
					  <?php foreach ($order_statuses as $order_status) { ?>
					  <?php if ($order_status['order_status_id'] == $failed_status_id) { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
				  </div>
				</div> 
				<div class="form-group">
				  <label class="col-sm-2 control-label"><?php echo $entry_rejected_status; ?></label>
				  <div class="col-sm-10">
					<select name="rejected_status_id" class="form-control">
					  <?php foreach ($order_statuses as $order_status) { ?>
					  <?php if ($order_status['order_status_id'] == $rejected_status_id) { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
				  </div>
				</div>                               
            </div>
			<div class="tab-pane" id="tab-design">
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-button_name"><?php echo $entry_button_name; ?></label>
                <div class="col-sm-10">
					<?php foreach ($languages as $language) { ?>
                        <div class="input-group"><span class="input-group-addon"><img src="<?php echo strlen($language['code']) > 2 ? 'language/'.$language['code'].'/'.$language['code'].'.png' : 'view/image/flags/'.$language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                          <input type="text" name="button_name[<?php echo $language['language_id']; ?>]" value="<?php echo $button_name[$language['language_id']]; ?>" placeholder="<?php echo $entry_button_name; ?>" id="input-button_name-<?php echo $language['language_id']; ?>" class="form-control" />
                        </div>
                    <?php } ?>
				</div>
              </div> 
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_show_icons; ?>"><?php echo $entry_show_icons; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($show_icons) { ?>
                    <input type="radio" name="show_icons" value="1" checked="checked" />
                    <?php echo $text_yes; ?>
                    <?php } else { ?>
                    <input type="radio" name="show_icons" value="1" />
                    <?php echo $text_yes; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$show_icons) { ?>
                    <input type="radio" name="show_icons" value="0" checked="checked" />
                    <?php echo $text_no; ?>
                    <?php } else { ?>
                    <input type="radio" name="show_icons" value="0" />
                    <?php echo $text_no; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-icons_size"><?php echo $entry_icons_size; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="icons_size" value="<?php echo $icons_size; ?>" placeholder="<?php echo $entry_icons_size; ?>" id="input-icons_size" class="form-control"/>
                </div>
              </div>			  
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-css-button"><span data-toggle="tooltip" title="<?php echo $help_css_button; ?>"><?php echo $entry_css_button; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="css_button" value="<?php echo $css_button; ?>" placeholder="<?php echo $entry_css_button; ?>" id="input-css-button" class="form-control"/>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-selector-button"><span data-toggle="tooltip" title="<?php echo $help_selector_button; ?>"><?php echo $entry_selector_button; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="selector_button" value="<?php echo $selector_button; ?>" placeholder="<?php echo $entry_selector_button; ?>. По умолчанию - $('#button-cart')" id="input-selector-button" class="form-control"/>
                </div>
              </div>
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-selector-block"><span data-toggle="tooltip" title="<?php echo $help_selector_block; ?>"><?php echo $entry_selector_block; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="selector_block" value="<?php echo $selector_block; ?>" placeholder="<?php echo $entry_selector_block; ?>" id="input-selector-block" class="form-control"/>
                </div>
              </div>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-css-custom"><span data-toggle="tooltip" title="<?php echo $help_css_custom; ?>"><?php echo $entry_css_custom; ?></span></label>
                <div class="col-sm-10">
                  <textarea name="css_custom" placeholder="<?php echo $entry_css_custom; ?>" rows="5" id="input-css-custom" class="form-control"><?php echo $css_custom; ?></textarea>
                </div>
              </div>
			</div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
if ($('input[name=\'pp_markup_type\']:checked').val() == 'fixed') {
	$('#pp_markup_custom').hide();
} else {
	$('#pp_markup_custom').show();
}
if ($('input[name=\'pp_merchantType\']:checked').val() == 'PB') {
	$('input[name=\'pp_markup_type\'][value="custom"]').prop('disabled', true);
}
$('input[name=\'pp_merchantType\']').change(function() {
	if ($('input[name=\'pp_merchantType\']:checked').val() == 'PB') {
		$('#pp_markup_custom').hide();
		$('input[name=\'pp_markup_type\'][value="fixed"]').trigger('click');
		$('input[name=\'pp_markup_type\'][value="custom"]').prop('disabled', true);
	} else {
		$('input[name=\'pp_markup_type\'][value="custom"]').prop('disabled', false);
	}
});
$('input[name=\'pp_markup_type\']').change(function() {
	if ($('input[name=\'pp_markup_type\']:checked').val() == 'fixed') {
		$('#pp_markup_custom').hide();
	} else {
		$('#pp_markup_custom').show();
	}
});



if ($('input[name=\'ii_markup_type\']:checked').val() == 'fixed') {
	$('#ii_markup_custom').hide();
} else {
	$('#ii_markup_custom').show();
}
if ($('input[name=\'ii_merchantType\']:checked').val() == 'II') {
	$('input[name=\'ii_markup_type\'][value="custom"]').prop('disabled', true);
}
$('input[name=\'ii_merchantType\']').change(function() {
	if ($('input[name=\'ii_merchantType\']:checked').val() == 'II') {
		$('#ii_markup_custom').hide();
		$('input[name=\'ii_markup_type\'][value="fixed"]').trigger('click');
		$('input[name=\'ii_markup_type\'][value="custom"]').prop('disabled', true);
	} else {
		$('input[name=\'ii_markup_type\'][value="custom"]').prop('disabled', false);
	}
});
$('input[name=\'ii_markup_type\']').change(function() {
	if ($('input[name=\'ii_markup_type\']:checked').val() == 'fixed') {
		$('#ii_markup_custom').hide();
	} else {
		$('#ii_markup_custom').show();
	}
});



if ($('input[name=\'mb_markup_type\']:checked').val() == 'fixed') {
	$('#mb_markup_custom').hide();
} else {
	$('#mb_markup_custom').show();
}
$('input[name=\'mb_markup_type\']').change(function() {
	if ($('input[name=\'mb_markup_type\']:checked').val() == 'fixed') {
		$('#mb_markup_custom').hide();
	} else {
		$('#mb_markup_custom').show();
	}
});
</script>
<style>
.nav-tabs > li > a {
    height: 48px;
    vertical-align: middle;
    display: table-cell;
}
</style>
<?php if ($oc15) { ?>
<style>
.nav-tabs {
    margin-bottom: 25px;
}
label {
    cursor: initial;
	color:#000;
}
</style>
<script>
$('input[name=\'category_allowed_pp\']').autocomplete({
	delay: 200,
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item.name,
			  value: item.category_id
            }
          }));
        }
      });
    }, 
    select: function(event, ui) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&token=<?php echo $token; ?>&filter_category_id=' +  ui.item.value,
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed_pp' + item.product_id).remove();
            $('#product-allowed_pp').append('<div id="product-allowed' + item.product_id + '"><img src="view/image/delete.png" alt="" />' + item.name + '<input type="hidden" name="pp_product_allowed[]" value="' + item.product_id + '" /></div>');
			$('#product-allowed_pp div:odd').attr('class', 'odd');
			$('#product-allowed_pp div:even').attr('class', 'even');
			$('#enabled_selected_pp').prop('disabled',true);
			$('#enabled_all_pp').attr('checked', 'checked');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed_pp\']').autocomplete({
	delay: 200,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#product-allowed_pp' + ui.item.value).remove();
		$('#product-allowed_pp').append('<div id="product-allowed' + ui.item.value + '"><img src="view/image/delete.png" alt="" />' + ui.item.label + '<input type="hidden" name="pp_product_allowed[]" value="' + ui.item.value + '" /></div>');
		$('#product-allowed_pp div:odd').attr('class', 'odd');
		$('#product-allowed_pp div:even').attr('class', 'even');
		$('#enabled_selected_pp').prop('disabled',true);
		$('#enabled_all_pp').attr('checked', 'checked');
		return false;		
	},
	focus: function(event, ui) {
      return false;
	}
});
$('#product-allowed_pp div img').live('click', function() {
	$(this).parent().remove();
	$('#product-allowed_pp div:odd').attr('class', 'odd');
	$('#product-allowed_pp div:even').attr('class', 'even');
	
	if ($('#product-allowed_pp').html().trim() === '') {
		$('#enabled_selected_pp').prop('disabled',false);
	}
});
$('input[name=\'category_allowed_ii\']').autocomplete({
	delay: 200,
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item.name,
			  value: item.category_id
            }
          }));
        }
      });
    }, 
    select: function(event, ui) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&token=<?php echo $token; ?>&filter_category_id=' +  ui.item.value,
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed_ii' + item.product_id).remove();
            $('#product-allowed_ii').append('<div id="product-allowed' + item.product_id + '"><img src="view/image/delete.png" alt="" />' + item.name + '<input type="hidden" name="pp_product_allowed[]" value="' + item.product_id + '" /></div>');
			$('#product-allowed_ii div:odd').attr('class', 'odd');
			$('#product-allowed_ii div:even').attr('class', 'even');
			$('#enabled_selected_ii').prop('disabled',true);
			$('#enabled_all_ii').attr('checked', 'checked');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed_ii\']').autocomplete({
	delay: 200,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#product-allowed_ii' + ui.item.value).remove();
		$('#product-allowed_ii').append('<div id="product-allowed' + ui.item.value + '"><img src="view/image/delete.png" alt="" />' + ui.item.label + '<input type="hidden" name="pp_product_allowed[]" value="' + ui.item.value + '" /></div>');
		$('#product-allowed_ii div:odd').attr('class', 'odd');
		$('#product-allowed_ii div:even').attr('class', 'even');
		$('#enabled_selected_ii').prop('disabled',true);
		$('#enabled_all_ii').attr('checked', 'checked');
		return false;		
	},
	focus: function(event, ui) {
      return false;
	}
});
$('#product-allowed_ii div img').live('click', function() {
	$(this).parent().remove();
	$('#product-allowed_ii div:odd').attr('class', 'odd');
	$('#product-allowed_ii div:even').attr('class', 'even');
	
	if ($('#product-allowed_ii').html().trim() === '') {
		$('#enabled_selected_ii').prop('disabled',false);
	}
});
$('input[name=\'category_allowed_mb\']').autocomplete({
	delay: 200,
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item.name,
			  value: item.category_id
            }
          }));
        }
      });
    }, 
    select: function(event, ui) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&token=<?php echo $token; ?>&filter_category_id=' +  ui.item.value,
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed_mb' + item.product_id).remove();
            $('#product-allowed_mb').append('<div id="product-allowed' + item.product_id + '"><img src="view/image/delete.png" alt="" />' + item.name + '<input type="hidden" name="pp_product_allowed[]" value="' + item.product_id + '" /></div>');
			$('#product-allowed_mb div:odd').attr('class', 'odd');
			$('#product-allowed_mb div:even').attr('class', 'even');
			$('#enabled_selected_mb').prop('disabled',true);
			$('#enabled_all_mb').attr('checked', 'checked');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed_mb\']').autocomplete({
	delay: 200,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#product-allowed_mb' + ui.item.value).remove();
		$('#product-allowed_mb').append('<div id="product-allowed' + ui.item.value + '"><img src="view/image/delete.png" alt="" />' + ui.item.label + '<input type="hidden" name="pp_product_allowed[]" value="' + ui.item.value + '" /></div>');
		$('#product-allowed_mb div:odd').attr('class', 'odd');
		$('#product-allowed_mb div:even').attr('class', 'even');
		$('#enabled_selected_mb').prop('disabled',true);
		$('#enabled_all_mb').attr('checked', 'checked');
		return false;		
	},
	focus: function(event, ui) {
      return false;
	}
});
$('#product-allowed_mb div img').live('click', function() {
	$(this).parent().remove();
	$('#product-allowed_mb div:odd').attr('class', 'odd');
	$('#product-allowed_mb div:even').attr('class', 'even');
	
	if ($('#product-allowed_mb').html().trim() === '') {
		$('#enabled_selected_mb').prop('disabled',false);
	}
});
</script>
<?php } else {?>
<script>
$('input[name=\'category_allowed_pp\']').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item['name'],
			  value: item['category_id']
            }
          }));
        }
      });
    }, 
    select: function(item) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_category_id=' +  encodeURIComponent(item['value']),
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed_pp' + item.product_id).remove();
            $('#product-allowed_pp').append('<div id="product-allowed' + item.product_id + '"><i class="fa fa-minus-circle"></i> ' + item.name + '<input type="hidden" name="pp_product_allowed[]" value="' + item.product_id + '" /></div>');
			
			$('#enabled_selected_pp').prop('disabled',true);
			$('#enabled_all_pp').attr('checked', 'checked');
			$('#enabled_all_pp').parent().trigger('click');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed_pp\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'allowed_pp\']').val('');
		$('#product-allowed_pp' + item['value']).remove();
		$('#product-allowed_pp').append('<div id="product-allowed' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="pp_product_allowed[]" value="' + item['value'] + '" /></div>');
		
		$('#enabled_selected_pp').prop('disabled',true);
		$('#enabled_all_pp').attr('checked', 'checked');
		$('#enabled_all_pp').parent().trigger('click');
	}
});
$('#product-allowed_pp').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
	
	if ($('#product-allowed_pp').html().trim() === '') {
		$('#enabled_selected_pp').prop('disabled',false);
	}
});
$('input[name=\'category_allowed_ii\']').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item['name'],
			  value: item['category_id']
            }
          }));
        }
      });
    }, 
    select: function(item) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_category_id=' +  encodeURIComponent(item['value']),
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed_ii' + item.product_id).remove();
            $('#product-allowed_ii').append('<div id="product-allowed' + item.product_id + '"><i class="fa fa-minus-circle"></i> ' + item.name + '<input type="hidden" name="ii_product_allowed[]" value="' + item.product_id + '" /></div>');
			
			$('#enabled_selected_ii').prop('disabled',true);
			$('#enabled_all_ii').attr('checked', 'checked');
			$('#enabled_all_ii').parent().trigger('click');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed_ii\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'allowed_ii\']').val('');
		$('#product-allowed_ii' + item['value']).remove();
		$('#product-allowed_ii').append('<div id="product-allowed' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="ii_product_allowed[]" value="' + item['value'] + '" /></div>');
		
		$('#enabled_selected_ii').prop('disabled',true);
		$('#enabled_all_ii').attr('checked', 'checked');
		$('#enabled_all_ii').parent().trigger('click');
	}
});
$('#product-allowed_ii').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
	
	if ($('#product-allowed_ii').html().trim() === '') {
		$('#enabled_selected_ii').prop('disabled',false);
	}
});
$('input[name=\'category_allowed_mb\']').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item['name'],
			  value: item['category_id']
            }
          }));
        }
      });
    }, 
    select: function(item) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_category_id=' +  encodeURIComponent(item['value']),
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed_mb' + item.product_id).remove();
            $('#product-allowed_mb').append('<div id="product-allowed' + item.product_id + '"><i class="fa fa-minus-circle"></i> ' + item.name + '<input type="hidden" name="mb_product_allowed[]" value="' + item.product_id + '" /></div>');
			
			$('#enabled_selected_mb').prop('disabled',true);
			$('#enabled_all_mb').attr('checked', 'checked');
			$('#enabled_all_mb').parent().trigger('click');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed_mb\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&<?php echo $text_token; ?>=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'allowed_mb\']').val('');
		$('#product-allowed_mb' + item['value']).remove();
		$('#product-allowed_mb').append('<div id="product-allowed' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="mb_product_allowed[]" value="' + item['value'] + '" /></div>');
		
		$('#enabled_selected_mb').prop('disabled',true);
		$('#enabled_all_mb').attr('checked', 'checked');
		$('#enabled_all_mb').parent().trigger('click');
	}
});
$('#product-allowed_mb').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
	
	if ($('#product-allowed_mb').html().trim() === '') {
		$('#enabled_selected_mb').prop('disabled',false);
	}
});
</script>
<?php } ?>
<?php echo $footer; ?>