<button type="button" id="button-ukrcredits" data-loading-text="<?php echo $text_loading; ?>" class="<?php echo $ukrcredits_css_button; ?>">
<?php if ($ukrcredits_show_icons) { ?>
	<?php foreach ($credits_data as $credit) { ?>
		<?php if ($credit) { ?>
			<img src="catalog/view/theme/default/image/ukrcredits/<?php echo $credit['type']; ?>_logo.png" title="<?php echo $credit['mounthprice_text']; ?>" data-toggle="tooltip" style="max-width:<?php echo $ukrcredits_icons_size; ?>px;">
		<?php } ?>
	<?php } ?>
<?php } ?> 
<?php echo $ukrcredits_button_name; ?>
</button>