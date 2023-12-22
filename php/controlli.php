<?php
//se lo usi solo in prenotazioni.php copia e incolla
function controllaInput($data) { // meglio htmlentities e sttrip_tags? 
    $str = htmlspecialchars($data, "UTF-8"); // sostituisce i caratteri speciali con entità HTML tipo &minus
    $str = trim($data); // toglie spazi all'inizio e alla fine
    $str = stripslashes($data); // toglie i caratteri "/"
    return $data;
  }

?>