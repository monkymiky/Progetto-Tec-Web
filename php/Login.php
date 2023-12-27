<?php // selezione di dati da una tabella con MySQLi
// inclusione del file di connessione
require_once ("connessione.php");
require_once ("controlli.php");
USE DB\DBAccess;

ini_set('display_errors',1);
ini_set("display_startup_errors",1);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("../html/loginTemplate.html");

$messaggiForm = "";
 
if (isset($_POST['submit'])) {
  if(!empty($_POST["user"]) && !empty($_POST["password"])){
    controllaInput($_POST["user"]) ; 
    controllaInput($_POST["password"]);
    $connessione = new DBAccess();
    $connessione->openDBConnection();
    if ($connessione->login($_POST['user'],$_POST['password'])){
      $connessione->closeConnection();
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'admin.php';
      header("Location: http://$host$uri/$extra");// redirect ad admin.php
    }else {
      $connessione->closeConnection();
    }
  }else{
    $messaggiForm .= "user o password non inserito";
  }
}
$paginaHTML = str_replace("{messaggiForm}", $messaggiForm, $paginaHTML);
echo $paginaHTML;
?>


