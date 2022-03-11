
<html>

<?php 
include("./header.php"); 
session_destroy();

?>
	  <style>
	  		*{
	  			margin: 0;
	  			padding: 0;
	  		}
			body{
				height: 100vh;
				background-color: #003F63;
				color: #D9D9D9;
			}
			.img-medico{
				padding: 5px;
				width: 150px;
			}
			.card-login{
				margin:0 auto;
				padding: 0px;
				width:250px;
				border: none;
				background-color: transparent;
			}
		</style>
<body>
    
<div class="container">
			<div class="card card-login text-center">
				<br><br><br><br>
			  <p class="display-4">Recepção</p>
			  <div class="card-body">
			  	<input type="text" class="form-control" id="login" name="login" placeholder="Login"><br>
			  	<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha">
			  	<br>
			  	<button class="btn btn-warning form-control" onclick="login()">Entrar</button>
			  </div>
			</div>
		
</div>
</body>

<script type="text/javascript">
	
	function login(){
		var login = $("#login").val();
		var senha = $("#senha").val();
		$.ajax({
		method: "POST",
		url: "./backend/validar.php",
		data: {login: login, senha: senha},
		success: function(response){
			if(response == 1){
				location.href ="./home.php";
			}else{
				alert("Dados incorretos, tente novamente.");
			}

		}
	})



	}
</script>
