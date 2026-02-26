<?php 
   /// definindo variaveis para conexão   
      $hostname_conn = "localhost";
      $database_conn = "vpstreet_ti19";
      $username_conn = "iwanez_83adminVP";
      $password_conn = "senacvp_ti19";
      $charset_conn = "utf8";
      
      $conn_produtos =   new mysqli($hostname_conn,$username_conn,$password_conn,$database_conn);
    // Definir conjunto de caracteres da conexao
      mysqli_set_charset($conn_produtos,$charset_conn);            
    // verificando possiveis erros na conexao
    if($conn_produtos->connect_error){
        echo "Erro: ".$conn_produtos->connect_error;
    };     
?>       