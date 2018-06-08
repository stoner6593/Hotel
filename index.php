<?php
session_start();

$_SESSION['xyzidusuario'] = "";
$_SESSION['xyzusuario'] = "";
$_SESSION['xyzcodigo'] = "";
$_SESSION['userlog'] = "";
$_SESSION['estadomenu'] = 0;
$_SESSION['idturno'] = 0;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<title>Administrador</title>
<style>
	@import url(https://fonts.googleapis.com/css?family=Montserrat:400,700);
	body {
		background: url('') no-repeat fixed center center; /* http://i.imgur.com/Eor57Ae.jpg*/
		background-size: cover;
		font-family: Montserrat;
	}
	
	.logo {
		width: 250px;
		height: 65px;
		background: url('imagenesv/logohotelcentralinn2.png') no-repeat;
		margin: 30px auto;
	}
	
	.login-block {
		width: 320px;
		padding: 20px;
		background:#ECECEC;
		border-radius: 5px;
		border-top: 5px solid #FF1820;
		margin: 0 auto;
	}
	
	.login-block h1 {
		text-align: center;
		color: #FF1820;
		font-size: 16px;
		text-transform: uppercase;
		margin-top: 0;
		margin-bottom: 20px;
	}
	
	.login-block input {
		width: 100%;
		height: 42px;
		box-sizing: border-box;
		border-radius: 5px;
		border: 1px solid #ccc;
		margin-bottom: 20px;
		font-size: 14px;
		font-family: Montserrat;
		padding: 0 20px 0 50px;
		outline: none;
	}
	
	.login-block input#username {
		background: #fff url('imagenesv/u0XmBmv.png') 20px top no-repeat;
		background-size: 16px 80px;
	}
	
	.login-block input#username:focus {
		background: #fff url('imagenesv/u0XmBmv.png') 20px bottom no-repeat;
		background-size: 16px 80px;
	}
	
	.login-block input#password {
		background: #fff url('imagenesv/Qf83FTt.png') 20px top no-repeat;
		background-size: 16px 80px;
	}
	
	.login-block input#password:focus {
		background: #fff url('imagenesv/Qf83FTt.png') 20px bottom no-repeat;
		background-size: 16px 80px;
	}
	
	.login-block input:active, .login-block input:focus {
		border: 1px solid #ff656c;
	}
	
	.login-block button {
		width: 100%;
		height: 40px;
		background: #FF1820;
		box-sizing: border-box;
		border-radius: 5px;
		border: 1px solid #FF1820;
		color: #fff;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 14px;
		font-family: Montserrat;
		outline: none;
		cursor: pointer;
	}
	
	.login-block button:hover {
		background: #FF1820;
	}
	
	.txterror{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 11px;
		color:#FF1820;
		text-align:center;
		padding:10px;
	}

</style>
</head>

<body>

<div class="logo"></div>

<div class="login-block">
    <h1>Acceso Administrador</h1>
    <form action="prg_login.php" method="post" autocomplete="off">
        <input type="text" value="" placeholder="Usuario" id="username" name="username"  />
        <input type="password" value="" placeholder="Password" id="password" name="password" />
        <button>Enviar</button>
    </form>
</div>
<div class="txterror">
	<?php echo $_SESSION['msgerror']; $_SESSION['msgerror']="";?>
</div>

</body>

</html>