<?php
//se lo usi solo in prenotazioni.php copia e incolla
function controllaInput(&$data) { // meglio htmlentities e sttrip_tags? 
    $str = trim($data); // toglie spazi all'inizio e alla fine
    $str = stripslashes($data); // toglie i caratteri "/"
    $str = htmlspecialchars($data, ENT_QUOTES); // sostituisce i caratteri speciali con entità HTML tipo &minus
  }

function controllaDataOra(&$dataOra, &$messaggiForm){
  if(!isset($dataOra)){
        if(preg_match("/^(20[0-9][0-9]-[0-9][0-9]-[0-9][0-9] [0-9][0-9]:[0-9][0-9]:00)$/",$dataOra)){
            return $dataOra;
        }else{
            $messaggiForm .= "<p>il formato del campo slot deve essere aaaa-mm-gg hh-mm-ss</p>";
        }
    }
    else{
        $messaggiForm .= "<p>selezionare uno slot</p>";
    }
    return "";
}
 
function controllaADomicilio(&$aDomicilio, &$messaggiForm){
  if(!isset($aDomicilio) || NULL == filter_var($aDomicilio,FILTER_VALIDATE_BOOLEAN)){
		$messaggiForm .= "<p> il campo \"a domicilio\" deve essere specificato </p>";
    return NULL; 
	}
  else{
    return $aDomicilio;
  }
}

function controllaNote(&$note,&$messaggiForm ){
  if(!isset($note)){
		controllaInput($note);
		return $note ;
	}
}

function controllaEmail(&$email,&$messaggiForm){
  if(!isset($email)){
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
  if(!isset($cel)){
    controllaInput($cel);
    if(preg_match("/^([0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9])$ | ^(+[0-9][0-9] [0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9])$/", $_POST['cel'])){
        return $cel;
    }else{
        $messaggiForm .= "<p>il formato del campo cellulare deve essere 1112223333 oppure +11 2223334444</p>";
    }
}
else{
    $messaggiForm .= "<p>inserire il numero di cellulare</p>";
}
return "";
}

function controllaNome(&$nome, &$messaggiForm){
  if(!isset($nome)){
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
  if(!isset($indirizzo)){
  controllaInput($indirizzo);
    if (preg_match("/^[a-zA-Z0-9' ]*$/",$indirizzo)){
        return $indirizzo;
      }else{
          $messaggiForm .= "<p>L' indirizzo deve essere composto solo da lettere e numeri</p>";
      }
  }else{
      if($tipo){
          $messaggiForm .= "<p>L' indirizzo deve essere specificato in tutte le prenotazioni a domicilio</p>";
      }
  }
  return "";
}
?>