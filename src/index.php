<?php

require_once(__DIR__.'/PassGenerator.php');
require_once(__DIR__.'/PassValidator.php');

$PassGenerator = new PassGenerator(4,2,5,3,1);
$PassGenerator->generate();
$PassValidator = new PassValidator(10);

  echo 'generated pasword ' . htmlspecialchars($PassGenerator->getPassword());
  echo '<br>';
  echo '<br>';
  if(!$PassValidator->validatePassword($PassGenerator->getPassword())){
    foreach($PassValidator->getErrors() as $value) {
        print $value . '<br>';
      }
  }else{
    echo 'password is valid';
  }
  echo '<br>';
  if($PassValidator->scorePassword($PassGenerator->getPassword()) == 0){
    echo 'password is good';
  }elseif($PassValidator->scorePassword($PassGenerator->getPassword()) < 5){
    echo 'password could be better';
  }elseif($PassValidator->scorePassword($PassGenerator->getPassword()) > 5){
    echo 'password is bad';
  }
  
  
