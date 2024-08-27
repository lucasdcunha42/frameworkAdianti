<?php
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;
class TemplateViewRepeat extends TPage {
    public function __construct() {
        parent::__construct();
        
        try {
            $html = new THtmlRenderer('app/resources/template-repeat.html');

            $replace = [];
            $replace[] = ['nome' => 'peter', 'endereco' => 'Rua um', 'numero' => 123 ];
            $replace[] = ['nome' => 'mary', 'endereco' => 'Rua dois', 'numero' => 231 ];
            $replace[] = ['nome' => 'john', 'endereco' => 'Rua b', 'numero' => 321 ];

            $html->enableSection('main', []);
            $html->enableSection('details', $replace, true);

            parent::add($html);

        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}