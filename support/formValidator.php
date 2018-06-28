<?php

class FormValidate {
    
    private $error_messages = array(); 
    
    public function validate($name, $value, $type) {

        switch ($type) {
        	
            case "NOT_EMPTY":
                if(!$this->not_empty($value)) {
                    $this->error_messages[] = "$name cannot be empty";
                }
                break;

            case "DIGITS":
                $exp = '/^[0-9]+$/';
                if (!$this->not_empty($value) && !preg_match($exp, $value)) {
                    $this->error_messages[] = "$name is not numeric";
                } 
                break;

            case "EMAIL":
                $exp = '/^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i';
                if (!$this->not_empty($value) && !preg_match($exp, $value)) {
                    $this->error_messages[] = "$name is not a valid email address";
                } 
                break;

            default:
                if(!$this->not_empty($value)) {
                    $this->error_messages[] = "$name cannot be empty";
                }
        } 
    } 
    
    public function anyErrors() {
        if(count($this->error_messages) > 0) {
            return true;
        }
        return false;
    }
    
    public function getErrorString() {
        $return_value = "";
        foreach($this->error_messages as $message) {
            $return_value .= "<li>$message</li>";
        }
        return $return_value;
    }
    
    private function not_empty($value) {
        if (trim($value) == "") {
            return false;
        } else {
            return true;
        } 
    } 
    
}