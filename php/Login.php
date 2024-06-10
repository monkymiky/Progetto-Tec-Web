<?php // selezione di dati da una tabella con MySQLi
// inclusione del file di connessione
session_start();
require_once ("connessione.php");
require_once ("controlli.php");
USE DB\DBAccess;

ini_set('display_errors',1);
ini_set("display_startup_errors",1);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("../html/loginTemplate.html");

$messaggiForm = " messaggi debug : \n";
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'admin.php';

if(isset($_SESSION["session_id"])){ // login gia avvenuto?
  $messaggiForm .= "\n debug : sessione aperta ";
  header("Location: http://$host$uri/$extra");// redirect ad admin.php
  exit;
}else{ // login da fare
  if (isset($_POST['loginSubmit'])) {
    $messaggiForm .= " \n debug : if 1  ";
    if(!isset($_POST["user"]) && !isset($_POST["password"])){
      $messaggiForm .= "\n  if 2  ";
      controllaInput($_POST["user"]) ; 
      controllaInput($_POST["password"]);
      $connessione = new DBAccess();
      $connessione->openDBConnection();
      if ($connessione->login($_POST['user'],$_POST['password'])){
        $messaggiForm .= "\n  if 3  ";
        $connessione->closeConnection();
        $_SESSION["session_id"] = session_id();
        header("Location: http://$host$uri/$extra");// redirect ad admin.php
        exit;
      }else {
        $messaggiForm .= " \nelse 1  ";
        $connessione->closeConnection(); 
      }
    }else{
      $messaggiForm .= "\n user o password non inserito";
    }
    $messaggiForm .= " \n out 1  ";
  }
  $messaggiForm .= " \n out 2  ";
}

$paginaHTML = str_replace("{messaggiForm}", $messaggiForm, $paginaHTML);
echo $paginaHTML;
?>


