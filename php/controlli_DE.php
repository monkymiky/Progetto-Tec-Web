<?php
//se lo usi solo in prenotazioni.php copia e incolla
function controllaInput(&$data) { // meglio htmlentities e ststrip_tags? 
    $str = trim($data); // toglie spazi all'inizio e alla fine
    $str = stripslashes($data); // toglie i caratteri "/"
    $str = htmlspecialchars($data, ENT_QUOTES); // sostituisce i caratteri speciali con entità HTML tipo &minus
  }

function controllaDataOra(&$dataOra, &$messaggiForm){
  if(isset($dataOra)){
        if(preg_match("/^(20[0-9][0-9]-[0-9][0-9]-[0-9][0-9] [0-9][0-9]:[0-9][0-9]:00)$/",$dataOra)){
            return $dataOra;
        }else{
            $messaggiForm .= "<p class='phpError'>Das Datumsformat muss aaaa-mm-tt hh:mm lauten</p>";
        }
    }
    else{
        $messaggiForm .= "<p class='phpError'>Bitte wählen Sie einen Slot aus</p>";
    }
    return "";
}
 
function controllaADomicilio($aDomicilio, &$messaggiForm){

  if(!isset($aDomicilio) || !( $aDomicilio == "1" || $aDomicilio== "0") ){
		$messaggiForm .= "<p class='phpError'>Das Feld \"zu Hause/in der Praxis\" muss angegeben werden</p>";
    return NULL; 
	}
  else{
    return $aDomicilio;
  }
}

function controllaNote(&$note,&$messaggiForm ){
  if(isset($note)){
		controllaInput($note);
		return $note ;
	}
}

function controllaEmail(&$email,&$messaggiForm){
  if(isset($email)){
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$messaggiForm .= "<p class='phpError'>Die eingegebene E-Mail-Adresse ist nicht gültig</p>";
		}else{
			return $email;
		}
	}else{
		$messaggiForm .= "<p class='phpError'>Das Feld \"E-Mail\" muss angegeben werden</p>";
	}
  return "";
}

function controllaCel(&$cel, &$messaggiForm){
  if(isset($cel)){
    controllaInput($cel);
    if(preg_match("/^([+]d{2})?\s*\d{3}\s*\d{3}\s*\d{4}$/", $cel)){
        return $cel;
    }else{
        $messaggiForm .= "<p class='phpError'>Das Format der Telefonnummer muss 111 222 3333 oder +11 222 333 4444 lauten</p>";
    }
}
else{
    $messaggiForm .= "<p class='phpError'>Bitte geben Sie die Telefonnummer ein</p>";
}
return "";
}

function controllaNome(&$nome, &$messaggiForm){
  if(isset($nome)){
    controllaInput($nome);
    if (preg_match("/^[a-zA-Z' ]*$/",$nome)){
        return $nome;
    }else{
        $messaggiForm .= "<p class='phpError'>Der Name darf nur Buchstaben enthalten</p>";
    }
}else{
    $messaggiForm .= "<p class='phpError'>Der Name muss angegeben werden</p>";
}
return "";
}

function controllaIndirizzo(&$indirizzo , &$messaggiForm){
  if(isset($indirizzo)){
  controllaInput($indirizzo);
    if (preg_match("/^[a-zA-Z0-9' ]*$/",$indirizzo)){
        return $indirizzo;
      }else{
          $messaggiForm .= "<p class='phpError'>Die Adresse darf nur Buchstaben und Zahlen enthalten</p>";
      }
  }else{
    $messaggiForm .= "<p class='phpError'>Die Adresse muss für alle Buchungen zu Hause angegeben werden</p>";
  }
  return "";
}
?>
