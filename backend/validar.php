<?php 
session_start();
include('./Dados.php');

$user = Dados::validar($_POST['login'],$_POST['senha']);


if(!$user){
	echo 0;
}else{
	$_SESSION['atendente'] = $user;

	echo 1;
}

?>