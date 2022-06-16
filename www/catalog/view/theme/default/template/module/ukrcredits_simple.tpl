<link href="catalog/view/theme/default/stylesheet/calculator.css" rel="stylesheet" type="text/css">
	<div id="prop<?php echo $credit['type']; ?>" class="" style="margin-left: 20px;">
		<div class="prop_calc">
			<div class="prop_paymentsCount">
				<?php echo $credit['partsCount']; ?>
			</div>
			<div class="prop_select">
				<select id="termInput<?php echo $credit['type']; ?>" name="select<?php echo $credit['type']; ?>" class="form-control">
					 <?php for($credit['type']=='MB'?$i=2:$i=1;$i<=$credit['partsCount'];$i++){ ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?> <?php echo $text_mounth; ?></option>
					 <?php } ?>
				</select>
			</div>
			<div class="prop_permounth">
				<?php echo $text_per; ?> <?php echo $currency_left; ?><span><?php echo round($credit['price']); ?></span><?php echo $currency_right; ?>
			</div>
			<div class="prop_price">
				<?php echo $text_total; ?> <?php echo $currency_left; ?><span><?php echo round($credit['price']); ?></span><?php echo $currency_right; ?>
			</div>	
		</div>
		<div id="termSlider<?php echo $credit['type']; ?>" style="display:none">
			<div class="progress">
				<div id="termProgress<?php echo $credit['type']; ?>" class="progress-bar progress-bar-success" role="progressbar" style="width: 0;"></div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div> 
<script>
var UCconstants = {
	'termStep': 1,
	'priceInitial<?php echo $credit['type']; ?>': <?php echo round($credit['price'], 2); ?>,
	'termMax<?php echo $credit['type']; ?>': <?php echo isset($credit['partsCount'])?$credit['partsCount']:24; ?>,
	'termMin<?php echo $credit['type']; ?>': <?php echo $credit['type']=='MB'?2:1; ?>,
	'termSelected<?php echo $credit['type']; ?>': <?php echo $credit['partsCountSel']?$credit['partsCountSel']:($credit['type']=='MB'?2:1); ?>,
};
UCinitElements = function () {
	UCinitTermInput<?php echo $credit['type']; ?>();
	UCinitTermSlider<?php echo $credit['type']; ?>();
},
UCinitTermSlider<?php echo $credit['type']; ?> = function () {
	$("#termSlider<?php echo $credit['type']; ?>").slider({
		value: UCconstants.termSelected<?php echo $credit['type']; ?>,
		max: UCconstants.termMax<?php echo $credit['type']; ?>,
		min: UCconstants.termMin<?php echo $credit['type']; ?>,
		step: UCconstants.termStep,
		slide: function (event, ui) {
			UCsliderMoved($(this), $("#termInput<?php echo $credit['type']; ?>"), $("#termProgress<?php echo $credit['type']; ?>"), ui.value);
		}
	});
	var initprogress<?php echo $credit['type']; ?> = (UCconstants.termSelected<?php echo $credit['type']; ?> - UCconstants.termMin<?php echo $credit['type']; ?>) * 100 / ( UCconstants.termMax<?php echo $credit['type']; ?> - UCconstants.termMin<?php echo $credit['type']; ?> );
	$("#termProgress<?php echo $credit['type']; ?>").css('width', initprogress<?php echo $credit['type']; ?> + "%");
},
UCinitTermInput<?php echo $credit['type']; ?> = function () {
	var $inp = $("#termInput<?php echo $credit['type']; ?>");
	$inp.attr("min", UCconstants.termMin<?php echo $credit['type']; ?>);
	$inp.attr("max", UCconstants.termMax<?php echo $credit['type']; ?>);
	$inp.val(UCconstants.termSelected<?php echo $credit['type']; ?>);
	$inp.on('change', function () {
		UCinputChanged($inp, $("#termSlider<?php echo $credit['type']; ?>"), $("#termProgress<?php echo $credit['type']; ?>"));
	});
},
UCsliderMoved = function (slider, inputToChange, progressToChange, newValue) {
    var sMax = slider.slider("option", "max");
    var sMin = slider.slider("option", "min");
    inputToChange.val(newValue);
    var progress = (newValue - sMin) * 100 / ( sMax - sMin );
    progressToChange.css('width', progress + "%");
	UCcalc();
	savepartscount(inputToChange.attr('id'),newValue);
},
UCinputChanged = function (input, slider, progressToChange) {
    var newVal = input.val();
    slider.slider("value", newVal);
    var sMax = slider.slider("option", "max");
    var sMin = slider.slider("option", "min");
    var progress = (newVal - sMin) * 100 / ( sMax - sMin );
    progressToChange.css('width', progress + "%");
	UCcalc();
	savepartscount(input.attr('id'),input.val());
},
savepartscount = function(selector,partscount){
	type = selector.substr(-2).toLowerCase().replace('ia','ii').replace('pb','pp');
	$.ajax({
		type: 'POST',
		url: 'index.php?route=payment/ukrcredits_' + type + '/setUkrcreditsType',
		dataType: 'json',
		data: {partsCount: partscount},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}		     
	});
	<?php if ($ukrcredits_setting[str_replace(array('ia','pb'),array('ii','pp'),mb_strtolower($credit['type'])).'_markup_type'] == 'custom') { ?>
		<?php if ($oc15) { ?>
			simplecheckout_reload('payment_changed');
		<?php } else { ?>
			reloadAll();
		<?php } ?>
	<?php } ?>
},
payments = [<?php echo $text_payments; ?>],
declOfNum = function(number, titles) {  
    cases = [2, 0, 1, 1, 1, 2];  
    return titles[ (number%100>7 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];  
},
UCcalc = function(){
	var resCalc<?php echo $credit['type']; ?> = UC_CALCULATOR.calculatePhys($('#termInput<?php echo $credit['type']; ?>').val(), UCconstants.priceInitial<?php echo $credit['type']; ?>);
	if (resCalc<?php echo $credit['type']; ?> != undefined) {
		$('#prop<?php echo $credit['type']; ?> .prop_paymentsCount').html(resCalc<?php echo $credit['type']; ?>.payCount + ' ' + declOfNum(resCalc<?php echo $credit['type']; ?>.payCount,payments));
		$('#paymentsCount<?php echo $credit['type']; ?>').html(resCalc<?php echo $credit['type']; ?>.payCount);
		$('#prop<?php echo $credit['type']; ?> .prop_permounth span').html(resCalc<?php echo $credit['type']; ?>.<?php echo mb_strtolower($credit['type']); ?>Value);
		$('#prop<?php echo $credit['type']; ?> .prop_price span').html(resCalc<?php echo $credit['type']; ?>.<?php echo mb_strtolower($credit['type']); ?>Price);
	}
},
UC_CALCULATOR = (function () {
    var uc = {};
    function privParseInt(num) {
        return parseInt(num, 10)
    }
    uc.calculatePhys = function (paymentsCount, price) {
        if (isNaN(paymentsCount) || isNaN(price)) return;
        paymentsCount = privParseInt(paymentsCount) + 1;
        price = privParseInt(price);
        var ip = price / paymentsCount + price * (2.9 / 100);
        var pp = price / paymentsCount;
        var ia = (price / paymentsCount) + (price * 0.99 / 100);
        return ({
            payCount: paymentsCount,
            ppValue: pp.toFixed(2),
			pbValue: pp.toFixed(2),
            iiValue: ip.toFixed(2),
            iaValue: ia.toFixed(2),
			mbValue: pp.toFixed(2),
			iiPrice: (price + (price * (2.9 / 100) * paymentsCount)).toFixed(2),
			iaPrice: (price + (price * (0.99 / 100) * paymentsCount)).toFixed(2),
        });
    };
    return uc;
}());
$(document).ready(function() {
    UCinitElements();
    UCcalc();
});
</script>