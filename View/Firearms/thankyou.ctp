<div class ="col-xs-12">
<div class ="jumbotron">
<h1>Thank you. <small>A confirmation has been sent to your email. </small></h1>
<h2>Booked Lane Time(s):</h2>
<ul>
<?
foreach ($cart['Services'] as $mbdate=>$val):?>
<li><h3>
<?
$date=explode('T',$mbdate);
echo '<strong>'.date('l M d, Y',strtotime($date[0])).' at '.date('h:i a',strtotime($date[1])).':</strong> '.$val['Name'];
//debug($date);
?>
</h3>
</li>
<?
endforeach;
?>
</ul>
<h2 style="color:red">Please arrive on time, if you're more than 10 minutes late we may have to cancel your reservation.</h2>
<p>
<?=$this->Html->link('Return Home','/',array('class'=>'btn btn-success btn-lg','role'=>'button'))?></p>
</div>

</div>