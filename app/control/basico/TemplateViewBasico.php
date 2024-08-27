<?php
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;

class TemplateViewBasico extends TPage {
    public function __construct() {
        parent::__construct();

        try {
            $html = new THtmlRenderer('app/resources/template-card.html');

            $cardData = new stdClass;
            $cardData->titulo = 'Titulo Card Main';
            $cardData->descricao = 'Descrição de Card';
            $cardData->cor = '#FFA07A';

            $replaces = [];
            $replaces2 = [];

            $replaces['card$cardData'] = $cardData;
            $replaces2['cor'] = $cardData->cor;  


            $html->enableSection('main', $replaces);

            $html->enableSection('outros', $replaces2);

            parent::add($html);
        }
        catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}