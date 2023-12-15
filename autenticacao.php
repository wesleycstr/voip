#!/usr/bin/php -q
<?php
  set_time_limit(30);
  require('phpagi.php');
 
  $agi = new AGI();
  $agi->answer();  
  $matricula = $argv[1];
  $agi->verbose("Executando autenticacao. Matricula: $matricula"); 
  
  // conex�o com o BD
  $host = "192.168.102.100";
  $db_user = "container65";
  $db_pass = "1F(513050)";
  $db_name = "ASA65";

  $connect = mysqli_connect( $host, $db_user, $db_pass, $db_name ); 

  // exibindo o �udio e recebendo os d�gitos do usu�rio
  $result = $agi->get_data('chamada_para_autenticacao',5000 ,4); //$agi->get_data(<file to be streamed>, <timeout>, <max digits>)
  $digitos = $result['result']; 
  $agi->verbose("Numeros digitados pelo usuario: $digitos");
  
  // puxando a senha que o sistema gerou aleat�riamente
  $query = "SELECT * FROM autenticacao WHERE matricula='$matricula'";
  $resultado = mysqli_query($connect, $query);
  $row_registro = mysqli_fetch_assoc($resultado);
  $senha_informada = $row_registro['senha_informada'];
  $agi->verbose("Senha no BD: $senha_informada");

  //fazendo tratamento com as senhas. Nos dois casos eu salvo a senha digitada no BD para an�lise da p�gina web.
  if ($digitos == $senha_informada){
    $query = "UPDATE autenticacao SET senha_digitada = '$digitos', status = 'analise' WHERE matricula = '$matricula'";
    $executar = mysqli_query($connect, $query);
    $agi->exec("playback","acesso_liberado");
  }else{
    $query = "UPDATE autenticacao SET senha_digitada = '$digitos', status = 'analise' WHERE matricula = '$matricula'";
    $executar = mysqli_query($connect, $query);
    $agi->exec("playback","erro_autenticacao");
  };
?>
