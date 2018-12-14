<?php

function start_job($file,$user,$input1=null,$input2=null,$input3=null,$input4=null,$input5=null,$input6=null,$input7=null,$input8=null) {

	include('jobs/'.$file);

}


function register_job($name,$type,$user,$input1=null,$input2=null,$input3=null,$input4=null,$input5=null,$input6=null,$input7=null,$input8=null) {
	include('database.php');
	
	mysqli_query($database, "INSERT INTO jobs (name,type,user,start,status,input1,input2,input3,input4,input5,input6,input7,input8) VALUES ('".$name."','".$type."','".$user."',".time().",'Started','".$input1."','".$input2."','".$input3."','".$input4."','".$input5."','".$input6."','".$input7."','".$input8."')");
	
	return mysqli_insert_id($database);
}

function update_job($id,$status) {
	include('database.php');

	mysqli_query($database, "UPDATE jobs SET status='".$status."' WHERE id=".$id);

}

function finish_job($id,$status,$output1=null,$output2=null,$output3=null,$output4=null,$output5=null,$output6=null,$output7=null,$output8=null) {
	include('database.php');

	mysqli_query($database, "UPDATE jobs SET status='".$status."', output1='".$output1."', output2='".$output2."', output3='".$output3."', output4='".$output4."', output5='".$output5."', output6='".$output6."', output7='".$output7."', output8='".$output8."', finish=".time()." WHERE id=".$id);

}

?>