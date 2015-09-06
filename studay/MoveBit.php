<?php
include 'str.php';

$bnumb=$bbite=$bresult=$numb=$bite=$result="";

if(isset($_POST['submit'])){
	$numb=$_POST['thenumber'];
	$bnumb=decbin($numb);
	
	$bite=$_POST['thebite'];
	$bbite=decbin($bite);
	
	$result= (int)$numb << (int)$bite;
	$bresult=decbin($result);
	
	$outinfo="Covering <b>{$numb}</b>("
	.add_separate_fromlast($bnumb,4,' ').") << <b>{$bite}</b>("
	.add_separate_fromlast($bbite,4,' ').") to <b>{$result}</b>("
	.add_separate_fromlast($bresult,4,' ').")";
}


?>
<form method="POST" action="">
	<p/>
	Move the Number:
	<input type="text" style="text-align:center" name="thenumber" size="2"  />
	 to
	<input type="text" style="text-align:center" name="thebite" size="2" />
	 bite is
	<input type="submit" name="submit" value="Move"/>
</form>
<?php 
if(isset($outinfo))echo $outinfo;
?>