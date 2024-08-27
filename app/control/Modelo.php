<?php
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
class Template extends TPage {
    public function __construct() {
        parent::__construct();
        
        try {
            //code...
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}