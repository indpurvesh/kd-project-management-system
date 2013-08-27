<?php

class Kdecom_Debug extends Zend_Debug{
    public static function dump($var, $label = null, $echo = true) {
        parent::dump($var, $label, $echo );
        die;
        
    }

}
