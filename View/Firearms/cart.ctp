<div class="row">
<?if (isset($cart_items)):
echo $this->Form->create('Firearm',array('url'=>array('action'=>'cart')));
$disabled=false;
?>
<div class="col-xs-12">
<h1>Shopping Cart <small>The arsenal awaits</small></h1>
</div>
<div class="col-xs-12">
<h2>Lane Reservation</h2>
<?

if (isset($cart_items['Services'])){?>

<?//temporary error for multiple packages, this should be fixed now
/*$svc_cnt=count($cart_items['Services'])-1;
$temp_err='';
 if( count($cart_items['Services'])>1){
	$temp_err= '<h3 style="color:red;">Only one package can be booked online at a time right now, we\'re working on fixing it. Either remove '.$svc_cnt.' item(s) or give us a ring at (307) 586-4287 for help.</h3>';
	$disabled=true;
	echo $temp_err;
 }
 */
?>
<table class="table table-hover"> 
<thead> <tr> <th>Package</th> <th>Date</th> <th>Time</th> <th>Price</th><th></th> </tr> </thead><tbody> 
<?

foreach ($cart_items['Services'] as $mbdate=>$id):
//debug($mbdate);
$date_time=explode('T',$mbdate);
//debug($id);
?>
<tr> <th scope="row"><?=$id['Name']?></th> <td><?=date('D M d, Y',strtotime($date_time[0]))?></td> <td><?=date('h:i a',strtotime($date_time[1]))?></td> <td><?=money_format('$%i',$id['OnlinePrice'])?></strike></span></td>
<td><?
$xicon='<span class="glyphicon glyphicon-remove"></span>';
echo $this->Html->link($xicon,array('action'=>'cart_remove_package',urlencode($mbdate)),array('escape'=>false));
?>
</td> </tr>
<?if (isset($id['DoubleInfo'])):?>
<tr><th class="row"><em>&nbsp;&nbsp;Double Ammo</em></th><td>Get 2x ammo and double your fun!</td>
<td></td>
<td><?=money_format('$%i',$id['DoubleInfo']['OnlinePrice'])?></td>
<td>
<? //using default naming makes this checkbox behave much nicer!!?>
<?=$this->Form->input($mbdate,array('type'=>'checkbox','label'=>false,'div'=>false,'onclick'=>'$("#update_button").click()'));?>

</td></tr>
<?
endif;
endforeach?>
</tbody>
</table>
<!-- THIS IS DISABLED FOR NOW until I get some answers from MINDBODY API team, however it can still be done by use of Back button (and then fails at checkout) Also change Lane Reservation to plural when fixed -->
<h4><?=$this->Html->link('<< Book another!',array('action'=>'pickpkg'))?></h4>
<?} 
//no valid packages
else{
$disabled=true;
?>
<div class="alert alert-dismissible fade in alert-danger session-flash">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
You must have at least one package to complete checkout<br />

</div>
<?=$this->Html->link('Browse Packages',array('action'=>'pickpkg'),array('class'=>'btn btn-lg btn-success date-btns'))?>
<?}?>
</div><!-- /package column -->

<div class="col-xs-12">
<h2>Targets and Extra Guns</h2>
<?
//still need to fill in this info somehow
?>
<?if (isset($extras)){?>
<table class="table table-hover"> 
<thead> <tr> <th>Item</th> <th>Description</th> <th>Price</th><th>&nbsp;</th> </tr> </thead><tbody> 
<script>
//this doesn't work on my iPad mini - tried some workarounds and none worked, moving on (everyone else seems to work, so heck with em)
$( document ).ready(function() {
$("input[type=number]").focus(function() { $(this).select(); }); 
});
</script>
<?
//using counter for mockup
$i=0;
foreach ($extras as $id=>$extra):
$i++;
//if ($i>3) break;
$qty_val=0;
//debug($cart_items['Extras']);
if (isset($cart_items['Extras'][$extra['barcodeID']])){
	$qty_val=$cart_items['Extras'][$extra['barcodeID']];
}

?>
<tr> <th scope="row"><?=$extra['Name']?></th> <td><?=$extra['ShortDesc']?></td> <td><?=money_format('$%i',$extras[$id]['OnlinePrice'])?></td> 
<td>
<?
//old way with a number

echo $this->Form->input($extra['barcodeID'],array('onchange'=>'$("#update_button").click()','type'=>'number','class'=>'','label'=>false,'div'=>false,'style'=>'width:45px','value'=>$qty_val,'min'=>0,'name'=>'data[Cart][Extras]['.$extra['barcodeID'].']'));

//now a checkbox, can't get it to work, will do later
//echo $this->Form->input($extra['barcodeID'],array('onclick'=>'$("#update_button").click()','type'=>'checkbox','label'=>false,'div'=>false,'name'=>'data[Cart][Extras]['.$extra['barcodeID'].']'));

?>
</td> </tr>



<?

endforeach?>
</tbody>
</table>

<?} 
//no valid extras
else{?>
<div class="alert alert-dismissible fade in alert-success session-flash">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
Don't forget to add targets and other fun extras to maximize your experience.<br />

</div>

<?}?>
<h2><small>Shirts, hats, drinks/snacks and other merchandise are available at our full retail store.</small></h2>

<style>
.radio{
	margin-left:30px;
}
.radio input[type=radio]{
	//margin-left:0px;
}
</style>
<?
//still not sure best way to do this, using underscores/explode for now

$options=array();
foreach ($discounts as $dival){
	$options[$dival['Firearm']['amount'].'_'.$dival['Firearm']['setting_value']]=$dival['Firearm']['description'];
}
$options['']='None';

//we have to make an entire option array to get the value right
 $option_array=array(
	//'before' => '--before--',
    //'between' => '<div class="radio_btn"',
	//'after' => '--after--',
	'label'=>false,
	'legend'=>false,
	'class'=>'radio_dis',
    'separator' => '<br/>',
	'type'=>'radio',
	'value'=>'',
	'onchange'=>'$("#update_button").click()',
    'options' => $options
);

if (isset($this->request->data['Firearm']['Discount'])){
	unset($option_array['value']);
}
//else $opt_array['value']='';
//the discount is still not working, disabled for now

/* discounts disabled! */
//echo '<h3>Discount <small>Applied at final payment, please bring card or ID. Limit one discount per order.</small></h3>';


//echo $this->Form->input('Discount', $option_array);

?>
</div><!-- /add-ons column -->
<div class="col-xs-12 col-pad">
<h2 align="">Cart Total: <?=money_format('$%i',$cart_total)?><br /><small> Tax will be added at checkout</small></h2>
<?
//this is a temporary thing, hopefully
//echo $temp_err;
?>
</div>
<div class="col-xs-12 col-md-6 col-pad">
<?=$this->Form->submit('Update', array('div' => false,'class'=>'btn btn-lg date-btns','name'=>'data[Cart][update_button]','id'=>'update_button','onclick'=>$this->element('blockui',array('msg'=>'Updating cart...'))))?>
</div>

<div class="col-xs-12 col-md-6 col-pad">
<?echo $this->Form->submit('Checkout', array('div' => false,'class'=>'btn btn-lg date-btns','name'=>'data[Cart][checkout_button]','disabled'=>$disabled,'onclick'=>$this->element('blockui',array('msg'=>'Checking out...'))));
echo $this->Form->end();
?>
</div>

<?//cart is empty
else:?>
<div class="col-xs-12" style="padding: 10px">
<?=$this->Html->link('Packages',array('action'=>'packages'),array('class'=>'btn btn-lg date-btns'))?>
</div>
<div class="col-xs-12" style="padding: 10px">
<?=$this->Html->link('About Us',array('action'=>'entry'),array('class'=>'btn btn-lg btn-primary'))?>
</div>

<?endif?>

</div><!-- /cart row -->