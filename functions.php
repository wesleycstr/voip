<?php
//Conexao com o BD
$host = "192.168.102.100";
$db_user = "container65";
$db_pass = "1F(513050)";
$db_name = "ASA65";

$connect = mysqli_connect( $host, $db_user, $db_pass, $db_name );

//Função para efetuar login no BD e entrar na página
function login($connect){
	if (isset($_POST['acessar']) AND !empty($_POST['matricula']) AND !empty($_POST['senha'])) {
		$senha = $_POST['senha'];
		$matricula = $_POST['matricula'];
		$query = "SELECT matricula, senha FROM users WHERE matricula='$matricula' AND senha='$senha'";
		$executar = mysqli_query ($connect, $query);
		$return = mysqli_fetch_assoc($executar);

		if (!empty($return['matricula']) AND !empty($return['senha'])) {
			session_start();			
			$_SESSION['matricula'] = $return['matricula'];
			$_SESSION['ativa'] = TRUE;
			header("location: ./autentica.php");
			}else {
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				<!--
				window.alert('Matrícula ou senha incorretas')
				// -->
				</SCRIPT>";
				echo "<meta http-equiv='refresh' content='0'>";
			}
	}
}


function logout(){

	session_start();
	session_unset();
	session_destroy();
	header("location: ./index.php");
}



  function gera_senha($tamanho, $maiusculas, $numeros, $simbolos)
{
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';
	$retorno = '';
	$caracteres = '';

	$caracteres .= $lmin;
	$caracteres .= $num;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;

	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++) {
	$rand = mt_rand(1, $len);
	$retorno .= $caracteres[$rand-1];
}
return $retorno;
}

function autentica($connect, $numeroAleatorio){
  $matricula = "12345";
  $query = "UPDATE autenticacao SET senha_informada = '$numeroAleatorio' WHERE matricula = '$matricula'";
  $executar = mysqli_query($connect, $query);
  while (true) {
  $query = "SELECT senha_digitada FROM autenticacao WHERE matricula = '$matricula'";
  $resultado = mysqli_query($connect, $query);
  $row_registro = mysqli_fetch_assoc($resultado);
  $senha_digitada = $row_registro['senha_digitada'];
    if($senha_digitada == $numeroAleatorio) {
      header('location: ./user_panel.php');
  }
}

}

?>