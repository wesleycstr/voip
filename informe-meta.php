#!/usr/bin/php -q
<?php
  set_time_limit(30);
  require('phpagi.php');
 
  $agi = new AGI();
  $agi->answer();
  $agi->verbose(1,"executando META ADMIN");
  
  $matricula = $argv[1];
  $agi->verbose(1,"Parametro: $parametro");  

  //$agi->exec("saynumber","$parametro");  

  $host = "192.168.102.100";
  $db_user = "container65";
  $db_pass = "1F(513050)";
  $db_name = "ASA65";

  $connect = mysqli_connect( $host, $db_user, $db_pass, $db_name );

  $query = "SELECT * FROM indicadores WHERE matricula='$matricula'";
  $resultado = mysqli_query($connect, $query);

while ($row_registro = mysqli_fetch_assoc($resultado)){
    $matricula = $row_registro['matricula'];
    $nome = $row_registro['nome'];
    $meta_atual = $row_registro['meta_atual'];
    $meta_anterior = $row_registro['meta_anterior'];
    $valor_atual = $row_registro['valor_atual'];
}

  $agi->exec("playback","a_sua_meta_foi_alterada");
  $agi->exec("saynumber","$meta_anterior");
  $agi->exec("playback","para");
  $agi->exec("saynumber","$meta_atual");
  $agi->exec("playback","boa_sorte");

?>
