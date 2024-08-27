<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
class CollectionsShortcuts extends TPage 
{
    public function __construct() {
        parent::__construct();

        try {
            TTransaction::open('psql');

            /* $clientes = Cliente::all();
            echo '<pre>';
                 print_r($clientes);
            echo '<pre>'; */

            /*
            $count = Cliente::where('situacao','=','Y')
                            ->where('genero', '=', 'F')
                            ->count();
            print_r($count);
            */

            

            TTransaction::close();


        } catch (\Throwable $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}