<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == "save_survey"){
	$save = $crud->save_survey();
	if($save)
		echo $save;
}
if($action == "delete_survey"){
	$delete = $crud->delete_survey();
	if($delete)
		echo $delete;
}
if($action == "save_question"){
	$save = $crud->save_question();
	echo $save;
}
if($action == "delete_question"){
	$delsete = $crud->delete_question();
	if($delsete)
		echo $delsete;
}
if($action == "save_option"){
	$save = $crud->save_option();
	echo $save;
}
if($action == "delete_option"){
	$delete = $crud->delete_option();
	if($delete)
		echo $delete;
}
if($action == "update_survey_status"){
	$save = $crud->update_survey_status();
	if($save)
		echo $save;
}
if($action == "get_survey_details"){
	$save = $crud->get_survey_details();
	if($save)
		echo $save;
}

ob_end_flush();
?>
