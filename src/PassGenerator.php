<?php

/**
 * Class PassGenerator
 */
class PassGenerator
{
    protected $symbols;
    protected $password;
   
    private $length; // required password lenght
    private $numlower; // desired number of lowercase letters
    private $numupper; // desired number of uppercase letters
    private $numint; // desired number of numbers 
    private $numspecial; // desired number of special charaters 

    /**
     * PassGenerator constructor.
     * @param int $length
     * @param int $numlower
     * @param int $numupper
     * @param int $numint
     * @param int $numspecial
     */
    public function __construct($length = 8, $numlower = 2, $numupper = 2, $numint = 2, $numspecial = 2)
    {
        // character pools to ease selection of the desired number of characters
        $this->symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
        $this->symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $this->symbols["numbers"] = '1234567890';
        $this->symbols["special_symbols"] = '!?~@#-_+<>[]{}';

        $maxnum = 50; // maximum number of charaters in all fields
    
        $this->length = ($length < $maxnum ? $length : $maxnum);
        $this->numlower = ($numlower < $maxnum ? $numlower : $maxnum);
        $this->numupper = ($numupper < $maxnum ? $numupper : $maxnum); 
        $this->numint = ($numint < $maxnum ? $numint : $maxnum); 
        $this->numspecial = ($numspecial < $maxnum ? $numspecial : $maxnum);
    }

    /**
     * @return string the generated password
     * @internal param $length the length of the generated password
     * @internal param $numlower (optional) number of lowercase letters to be used in the password
     * @internal param $numupper (optional) number of uppercase letters to be used in the password
     * @internal param $numint (optional) number of digits to be used in the password
     * @internal param $numspecial (optional) number of special symbols to be used in the password
     */
    public function generate()
    {
        
        $pass = '';
        
        // Generate lowercase letters
        $pass .= $this->getSection($this->numlower,$this->symbols["lower_case"]);
        // Generate uppercase letters
        $pass .= $this->getSection($this->numupper,$this->symbols["upper_case"]);
        // Generate numbers 
        $pass .= $this->getSection($this->numint,$this->symbols["numbers"]);
        // Generate special symbols
        $pass .= $this->getSection($this->numspecial,$this->symbols["special_symbols"]);
        
        //Check if the sum of desired characters is to low compared to the desired password lenght, if not - random characters from all character pools are added 
        if(mb_strlen($pass) < $this->length){
            $diff = abs(mb_strlen($pass) - $this->length);
            $pass .= $this->getRandomSection($diff);
        }
        
        $pass = str_shuffle($pass);
        $pass = substr($pass, 0, $this->length);
        
        $this->password = $pass;

        return $this->getPassword();
    }

    /**
     * @return string generated password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param int the number of characters to be generated.
     * 
     * @return string random character section
     */
    public function getRandomSection(int $num)
    {
        $section = '';
        for ($i = 0; $i < $num; $i++) {
            $item = array_rand($this->symbols); // get a random character string from the string array
            $n = random_int(0, mb_strlen($this->symbols[$item]) - 1); // get a random character from string of characters
            $section .= $this->symbols[$item][$n]; // add the character to the section string
        }
        return $section;
    }

    /**
     * @param int the number of characters to be generated.
     * 
     * @param string the string we are using to select from
     * 
     * @return string selected character section
     */
    public function getSection(int $num, string $symbols)
    {
        $section = '';
        for ($i = 0; $i < $num; $i++) {
            $n = random_int(0, mb_strlen($symbols) - 1); // get a random character from the string of characters
            $section .= $symbols[$n]; // add the character to the section string
        }
        return $section;
    }

}

