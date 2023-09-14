<?php

require_once(__DIR__.'/PassGenerator.php');
require_once(__DIR__.'/PassValidator.php');

$PassGenerator = new PassGenerator(16,1,0,0,0);
$PassValidator = new PassValidator();

  echo 'test';
  echo '<br>';
  echo 'generated pasword ' . htmlspecialchars($PassGenerator->generate());
  echo '<br>';
  echo '<br>';
  if(!$PassValidator->validatePassword($PassGenerator->getPassword())){
    foreach($PassValidator->getErrors() as $value) {
        print $value;
      }
  }else{
    echo 'password is valid';
  }
  echo '<br>';
  if($PassValidator->scorePassword($PassGenerator->getPassword()) == 0){
    echo 'password is good';
  }else{
    echo 'password is could be better';
  }
  
  
