<?php
//se lo usi solo in prenotazioni.php copia e incolla
function controllaInput(&$data) { // meglio htmlentities e sttrip_tags? 
    $str = trim($data); // toglie spazi all'inizio e alla fine
    $str = stripslashes($data); // toglie i caratteri "/"
    $str = htmlspecialchars($data, ENT_QUOTES); // sostituisce i caratteri speciali con entità HTML tipo &minus
  }

function controllaDataOra(&$dataOra, &$messaggiForm){
  if(isset($dataOra)){
        if(preg_match("/^(20[0-9][0-9]-[0-9][0-9]-[0-9][0-9] [0-9][0-9]:[0-9][0-9])$/",$dataOra)){
            return $dataOra;
        }else{
            $messaggiForm .= "<p>il formato del campo slot deve essere aaaa-mm-gg hh:mm</p>";
        }
    }
    else{
        $messaggiForm .= "<p>selezionare uno slot</p>";
    }
    return "";
}
 
function controllaADomicilio($aDomicilio, &$messaggiForm){

  if(!isset($aDomicilio) || !( $aDomicilio == "1" || $aDomicilio== "0") ){
		$messaggiForm .= "<p> il campo \"a domicilio\\in studio \" deve essere specificato </p>";
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
			$messaggiForm .= "<p>L'email inserito non è in un formato valido </p>";
		}else{
			return $email;
		}
	}else{
		$messaggiForm .= "<p> il campo \"email\" deve essere specificato </p>";
	}
  return "";
}

function controllaCel(&$cel, &$messaggiForm){
  if(isset($cel)){
    controllaInput($cel);
    if(preg_match("/^([+]d{2})?\s*\d{3}\s*\d{3}\s*\d{4}$/", $cel)){
        return $cel;
    }else{
        $messaggiForm .= "<p>il formato del campo cellulare deve essere 111 222 3333 oppure +11 222 333 4444</p>";
    }
}
else{
    $messaggiForm .= "<p>inserire il numero di cellulare</p>";
}
return "";
}

function controllaNome(&$nome, &$messaggiForm){
  if(isset($nome)){
    controllaInput($nome);
    if (preg_match("/^[a-zA-Z' ]*$/",$nome)){
        return $nome;
    }else{
        $messaggiForm .= "<p>Il nome deve essere composto solo da lettere</p>";
    }
}else{
    $messaggiForm .= "<p>Il nome deve essere specificato </p>";
}
return "";
}

function controllaIndirizzo(&$indirizzo , &$messaggiForm){
  if(isset($indirizzo)){
  controllaInput($indirizzo);
    if (preg_match("/^[a-zA-Z0-9' ]*$/",$indirizzo)){
        return $indirizzo;
      }else{
          $messaggiForm .= "<p>L' indirizzo deve essere composto solo da lettere e numeri</p>";
      }
  }else{
    $messaggiForm .= "<p>L' indirizzo deve essere specificato in tutte le prenotazioni a domicilio</p>";
  }
  return "";
}
?>