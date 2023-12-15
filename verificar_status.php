<?php
session_start();
$matricula = $_SESSION[matricula];

//Conexao com o BD
$host = "192.168.102.100";
$db_user = "container65";
$db_pass = "1F(513050)";
$db_name = "ASA65";

$conn = new mysqli( $host, $db_user, $db_pass, $db_name );

// Verifique a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulte os dados no banco de dados (substitua a consulta conforme necessário)
$query = "SELECT * FROM autenticacao WHERE matricula = '$matricula'";
$result = $conn->query($query);

// Prepare os dados para enviar como JSON
$data = array(
    "matricula" => array(),
    "senha_informada" => array(),
    "senha_digitada" => array(),
    "status" => array()
);

while ($row = $result->fetch_assoc()) {
    $data["matricula"] = $row["matricula"];
    $data["senha_informada"] = $row["senha_informada"];
    $data["senha_digitada"] = $row["senha_digitada"];

    $senha_digitada = $row["senha_digitada"];
    $senha_informada = $row["senha_informada"];
    $status = $row['status'];

    if ($status == 'processando'){
        $data["status"] = $status;
        break;

    }

    if($status ='analise'){
        if ($senha_digitada == $senha_informada) {
            $data["status"] = 'aprovado';
        }else{
            $data["status"] = 'reprovado';
        }
    }else{
        $data["status"] = $row['$status'];
    }
}
//echo $senha_digitada;
// Feche a conexão com o banco de dados
$conn->close();

// Envie os dados como JSON
header("Content-type: application/json");
echo json_encode($data);
?>