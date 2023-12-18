#!/usr/bin/php -q
<?php
  set_time_limit(30);
  require('phpagi.php');
 
  $agi = new AGI();
  $agi->answer();
  $agi->verbose(1,"executando AGI CENTAL DE METAS");
  
  $host = "192.168.102.100";
  $db_user = "container65";
  $db_pass = "1F(513050)";
  $db_name = "ASA65";
  
  $connect = mysqli_connect( $host, $db_user, $db_pass, $db_name );
  
  function login($agi, $connect){
  
  // exibindo o áudio e recebendo os dígitos do usuário
  $result = $agi->get_data('bem_vindo_central_de_metas',5000 ,5); //$agi->get_data(<file to be streamed>, <timeout>, <max digits>)
  $matricula = $result['result']; 
  $agi->verbose("Numeros digitados pelo usuario: $matricula");
  //realizando consulta ao banco de dados em busca da matricula
  $query = "SELECT matricula FROM users WHERE matricula='$matricula'";
  $executar = mysqli_query($connect, $query);
  $return = mysqli_fetch_assoc($executar);
  
  //tratamento dos numeros codigo e senha digitado pelo usuario
  if(!empty($return['matricula'])){
      $result = $agi->get_data('digite_a_senha',5000 ,5); //$agi->get_data(<file to be streamed>, <timeout>, <max digits>)
      $senha = $result['result'];
      $agi->verbose("Senha digitada pelo usuario: $senha");
      $query = "SELECT senha FROM users WHERE senha='$senha'";
      $executar = mysqli_query($connect, $query);
      $return = mysqli_fetch_assoc($executar);
      if (!empty($return['senha'])){
        $agi->exec("playback","login_bem_sucedido");
        menu_principal($agi, $matricula, $connect);
      }else{
        $agi->exec("playback","erro_autenticacao");
      };
  }else{
      $agi->verbose("Numero nao consta no cadastro");
      $agi->exec("playback","voce_digitou");
      $agi->exec("saydigits","$matricula");
      $agi->exec("playback","codigo_nao_consta");
  
  };
  
  }
  
    function menu_principal($agi, $matricula, $connect){
    $agi->exec("playback","menu_principal");
    $result = $agi->get_data('digite_1_digite_2',5000 ,5); //$agi->get_data(<file to be streamed>, <timeout>, <max digits>)
    $menu = $result['result'];
      if ($menu == '1'){
        menu_metas($agi, $matricula, $connect);
      }
      if ($menu == '2'){
        menu_ponto($agi, $matricula, $connect);
      }
    
  }
  
  function menu_metas($agi, $matricula, $connect){
    $agi->exec("playback","menu_de_metas");
    $result = $agi->get_data('digite_1_relatorio_de_metas',5000 ,5); //$agi->get_data(<file to be streamed>, <timeout>, <max digits>)
    $menu = $result['result'];
      if ($menu == '1'){
        relatorio_metas($agi, $matricula, $connect);
      }
      if ($menu == '2'){
        atualizar_valor($agi, $matricula, $connect);
      }
      if ($menu == '0'){
        menu_principal($agi, $matricula, $connect);
      }
    
  }
  
  function atualizar_valor($agi, $matricula, $connect){
    $query = "SELECT valor_atual FROM indicadores WHERE matricula='$matricula'";
    $resultado = mysqli_query($connect, $query);
    $row_registro = mysqli_fetch_assoc($resultado);   
    $valor_atual = $row_registro['valor_atual'];
    $agi->exec("playback","o_valor_alcancado_eh");
    $agi->exec("saynumber","$valor_atual");
    $result = $agi->get_data('deseja_atualizar_o_valor',5000 ,5); //$agi->get_data(<file to be streamed>, <timeout>, <max digits>)
    $menu = $result['result'];
    if ($menu == '1'){
        $result = $agi->get_data('digite_o_novo_valor',5000 ,5); //$agi->get_data(<file to be streamed>, <timeout>, <max digits>)
        $novo_valor = $result['result'];
        $query = "UPDATE indicadores SET valor_atual = '$novo_valor' WHERE matricula='$matricula'";
        $resultado = mysqli_query($connect, $query);
        $agi->exec("playback","o_valor_foi_atualizado");
        $result = $agi->get_data('final_atualizar_valor',5000 ,5); //$agi->get_data(<file to be streamed>, <timeout>, <max digits>)
        $menu = $result['result'];
          if ($menu == '1'){
            menu_metas($agi, $matricula, $connect);
          }
          if ($menu == '0'){
            menu_principal($agi, $matricula, $connect);
          }
    }
  }
  
  function relatorio_metas($agi, $matricula, $connect){
    $query = "SELECT * FROM indicadores WHERE matricula='$matricula'";
    $resultado = mysqli_query($connect, $query);

          while ($row_registro = mysqli_fetch_assoc($resultado)){
            $meta_atual = $row_registro['meta_atual'];
            $valor_atual = $row_registro['valor_atual'];
            $diferenca = $meta_atual - $valor_atual;
          }
          $agi->exec("playback","a_meta_estipulada_eh_de");
          $agi->exec("saynumber","$meta_atual");
          $agi->exec("playback","ate_agora_vc_alcancou");
          $agi->exec("saynumber","$valor_atual");
          $agi->exec("playback","faltam");
          $agi->exec("saynumber","$diferenca");
          $agi->exec("playback","para_cumprir_a_meta");
          $result = $agi->get_data('final_relatorio_metas',5000 ,5); //$agi->get_data(<file to be streamed>, <timeout>, <max digits>)
          $menu = $result['result'];
          if ($menu == '1'){
            relatorio_metas($agi, $matricula, $connect);
          }
          if ($menu == '2'){
            menu_metas($agi, $matricula, $connect);
          }
          if ($menu == '0'){
            menu_principal($agi, $matricula, $connect);
          }
  }
  
function menu_ponto ($agi, $matricula, $connect){
    $agi->exec("playback","menu_marcacao_ponto");
    $data = date("d-m-Y");
    $query = "SELECT * FROM ponto WHERE data='$data' and matricula = '$matricula'";
    $executar = mysqli_query($connect, $query);
    $return = mysqli_fetch_assoc($executar);
    
    //tratamento dos numeros codigo e senha digitado pelo usuario
    if(empty($return['data'])){
        $result = $agi->get_data('digite_1_registrar_inicio_trabalho',5000 ,5); //$agi->get_data(<file to be streamed>, <timeout>, <max digits>)
        $menu = $result['result'];
        if ($menu == '1'){
          date_default_timezone_set('America/Sao_Paulo');
          $hora = date("H:i:s");
          $query = "INSERT INTO ponto (matricula, data, entrada, status) VALUES ('$matricula', '$data', '$hora','trabalhando')";
          $executar = mysqli_query($connect, $query);
          $agi->exec("playback","marcacao_de_inicio_bem_sucedida");
          menu_principal($agi, $matricula, $connect);
        }
        if ($menu == '0'){
          menu_principal($agi, $matricula, $connect);
		}
	}
	if(!empty($return['data']) AND ($return['status'] == 'trabalhando')){
        $result = $agi->get_data('digite_1_registrar_termino_trabalho',5000 ,5); //$agi->get_data(<file to be streamed>, <timeout>, <max digits>)
        $menu = $result['result'];
        if ($menu == '1'){
          date_default_timezone_set('America/Sao_Paulo');
          $hora = date("H:i:s");
          $query = "UPDATE ponto SET saida = '$hora', status = 'pausado' WHERE matricula = '$matricula' AND status = 'trabalhando'";
          $executar = mysqli_query($connect, $query);
          $agi->exec("playback","marcacao_de_termino_bem_sucedida");
          menu_principal($agi, $matricula, $connect);
        }

    }
    if(!empty($return['data']) AND ($return['status'] == 'pausado')){
        $result = $agi->get_data('digite_1_registrar_inicio_trabalho',5000 ,5); //$agi->get_data(<file to be streamed>, <timeout>, <max digits>)
        $menu = $result['result'];
        if ($menu == '1'){
          date_default_timezone_set('America/Sao_Paulo');
          $hora = date("H:i:s");
          $query = "INSERT INTO ponto (matricula, data, entrada, status) VALUES ('$matricula', '$data', '$hora','trabalhando')";
          $executar = mysqli_query($connect, $query);
          $agi->exec("playback","marcacao_de_inicio_bem_sucedida");
          menu_principal($agi, $matricula, $connect);
        }
        if ($menu == '0'){
          menu_principal($agi, $matricula, $connect);
        }
    }
}  
login($agi, $connect);
  
?>