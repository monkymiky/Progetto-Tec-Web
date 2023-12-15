<?php
function controlla($data) { // meglio htmlentities e sttrip_tags? 
    $str = htmlspecialchars($data, "UTF-8"); // sostituisce i caratteri speciali con entità HTML tipo &minus
    $str = trim($data); // toglie spazi all'inizio e alla fine
    $str = stripslashes($data); // toglie i caratteri "/"
    return $data;
  }
function controllaOutput($data){
  $str = htmlspecialchars($data, "UTF-8");
  return $data;
}
function validateEmail($email){ // da usare dopo controlla()
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        return NULL;
      }
    return $email;
}
function validateText($text, $nameErr){ // da usare dopo controlla()
    if (!preg_match("/^[a-zA-Z0-9' ]*$/",$text)) {
        $nameErr = "Only letters and white space allowed";
      }
}



/*
REQUIRED
if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
  }
HTML
Name: <input type="text" name="name">
<span class="error">* <?php echo $nameErr;?></span>
  */
  ?>