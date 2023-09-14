<?php

/**
 * class PassValidator
 */
class PassValidator {

  protected $errors = array();
  protected $minLength;
  protected $minNumbers;
  protected $minLowerCase;
  protected $minUpperCase ;
  protected $minSymbols;
  protected $hitcount;

  /**
   * PassValidator constructor.
    * @param int $minLength // minimun password lenght
    * @param int $minNumbers // minimun number of numbers
    * @param int $minLowerCase // minimun number of  lowercase letters
    * @param int $minUpperCase // minimun number of uppercase letters
    * @param int $minSymbols // minimun number of special characters
    * @param int $hitcount // counter for bad password pratice
   */
  public function __construct($minLength = 10, $minNumbers = 2, $minLowerCase = 1, $minUpperCase = 1, $minSymbols = 1, $hitcount = 0)
   {
    $this->minLength = $minLength;
    $this->minNumbers = $minNumbers;
    $this->minLetters = $minLowerCase + $minUpperCase; 
    $this->minLowerCase = $minLowerCase; 
    $this->minUpperCase = $minUpperCase;
    $this->minSymbols = $minSymbols;
    $this->hitcount = $hitcount;
  }

  /**
   * Validate the password 
   *
   * @param string the string we are validating.
   *
   * @return boolean True if string valid.
   */
  public function validatePassword($password) {
   
    $this->errors = array();

    // Check password minimum length.
    if (strlen($password) < $this->minLength) {
      $this->errors[] = 'Password must be ' . $this->minLength . ' characters long, current password is too short at ' . strlen($password) . ' characters.';
    }
    // Check the number of numbers in the password.
    if (strlen(preg_replace('/([^0-9]*)/', '', $password)) < $this->minNumbers) {
      $this->errors[] = 'Not enough numbers in password, a minimum of ' . $this->minNumbers . ' required.';
    }
    // Check the number of letters in the password
    if (strlen(preg_replace('/([^a-zA-Z]*)/', '', $password)) < $this->minLetters) {
      $this->errors[] = 'Not enough letters in password, a minimum of ' . $this->minLetters . ' required.';
    }
    // Check the number of lower case letters in the password
    if (strlen(preg_replace('/([^a-z]*)/', '', $password)) < $this->minLowerCase && $this->minLowerCase != 0) {
      $this->errors[] = 'Not enough lower case letters in password, a minimum of ' . $this->minLowerCase . ' required.';
    }
    // Check the number of upper case letters in the password
    if (strlen(preg_replace('/([^A-Z]*)/', '', $password)) < $this->minUpperCase && $this->minUpperCase != 0) {
      $this->errors[] = 'Not enough upper case letters in password, a minimum of ' . $this->minUpperCase . ' required.';
    }
    // Check the minimum number of symbols in the password.
    if (strlen(preg_replace('/([a-zA-Z0-9]*)/', '', $password)) < $this->minSymbols && $this->minSymbols != 0) {
      $this->errors[] = 'Not enough symbols in password, a minimum of ' . $this->minSymbols . ' required.';
    }

    // If any errors have been encountered then return false.
    if (count($this->errors) > 0) {
      return false;
    }
    return true;
  }

  /**
   * @param string $password .
   *
   * @return mixed Returns an integer hitcount of the password errors.
   */
  public function scorePassword($password) {
    // Check if we have validation first
    if (!$this->validatePassword($password)) {
      return 10;
    }

    // Reset initial score.
    $this->hitcount = 0;

    $passwordLetters = preg_replace('/([^a-zA-Z]*)/', '', $password);
    $letters = array();
    for ($i = 0; $i < strlen($passwordLetters); ++$i) {
      // Add to hitcount for duplicate letters.
      if (in_array($passwordLetters[$i], $letters)) {
        $this->hitcount++;
      }
      // Add to hitcount for duplicate letters next to each other.
      if (isset($passwordLetters[$i - 1]) && $passwordLetters[$i] == $passwordLetters[$i - 1]) {
        $this->hitcount++;
      }
      $letters[] = $passwordLetters[$i];
    }

    // Add to hitcount for duplicate numbers.
    $passwordNumbers = preg_replace('/([^0-9]*)/', '', $password);
    $numbers = array();
    for ($i = 0; $i < strlen($passwordNumbers); ++$i) {
      if (in_array($passwordNumbers[$i], $numbers)) {
        $this->hitcount++;
      }
      $numbers[] = $passwordNumbers[$i];
    }

    // Add to hitcount for no symbols.
    if (strlen(preg_replace('/([a-zA-Z0-9]*)/', '', $password)) == 0) {
      $this->hitcount++;
    }

    // Return the hitcount.
    return $this->hitcount;
  }

  /**
   * @return array errors 
   */
  public function getErrors() {
    return $this->errors;
  }

}