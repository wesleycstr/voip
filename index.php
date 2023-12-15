<?php
  require_once "functions.php" ; 
  if (isset($_POST['acessar'])){
    login($connect);
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MetaAdmin - Login</title>
   <!-- Favicon -->
   <link href="./img/meta.png" rel="icon">
	
  <style>
    body {
      background-color: #f2f2f2;
      font-family: Arial, sans-serif;
    }

    form {
      margin: 0 auto;
      width: 78%;
      max-width: 600px;
      background-color: #fff;
      padding: 20px;
      margin-top: 50px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      background-image: url('./img/logo.jpg');
      background-repeat: no-repeat;
      background-size: 270px auto;
      background-position: right center;
      opacity: 1.0;
    }


    fieldset {
      border: none;
      margin: 0;
      padding: 0;
    }

    legend {
      font-size: 36px;
      font-weight: bold;
      color: #333;
      margin-bottom: 5px;
    }

    legend2 {
      font-size: 16px;
      font-weight: bold;
      color: #333;
      margin-bottom: 10px;
    }

    input[type="password"] {
      width: 53%;
      padding: 10px;
      margin-bottom: 20px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      background-color: #f2f2f2;
    }

    input[type="text"] {
      width: 53%;
      padding: 10px;
      margin-bottom: 20px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      background-color: #f2f2f2;
    }

    select {
      background-color: #f2f2f2;
      width: 56%;
      padding: 10px;
      margin-bottom: 20px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
    }

    input[type="submit"] {
      background-color: #0077cc;
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #0066b2;
    }


  </style>
</head>
<body>
  <!-- Inicio Campo selecionar OM -->  
	<form action="" method="post"> 
		<fieldset>
			<legend>MetaAdmin</legend>
      <legend2>Gerenciamento de Metas ON-LINE</legend2>
      <br>
      <br>
      <!--<select name="om" id="om" size="1" required>
        <option value="" SELECTED>Selecione a OM</option>
        <?php// select_om($connect)?>
      </select>-->
  
      <!-- Fim Campo selecionar OM -->

      <!-- Inicio Campo inserir nip -->
      
        <input type="text" name="matricula" placeholder="Matrícula" maxlength="10" required><br>
     
      <!-- Fim Campo inserir nip -->

      <!-- Inicio campo senha  -->
      <input type="password" name="senha" placeholder="Senha" required><br>
			<input type="submit" name="acessar" value="Acessar"><br><br>
      <!-- Fim campo senha  -->

      <!-- Inicio link capa solicitar cadastro
      <a href="./solicitar_senha.php">Solicitar acesso</a>
      Fim link capa solicitar cadastro  -->
		</fieldset>
	</form>
  <br>
  <br>
</body>
</html>