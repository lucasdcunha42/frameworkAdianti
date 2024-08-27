<?php
use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TExpression;
use Adianti\Database\TFilter;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
class CollectionLimit extends TPage {
    public function __construct() {
        parent::__construct();
        
        try
        {
            TTransaction::open('psql');
            
            $criteria = new TCriteria;
            $criteria->setProperty('limit', 10);
            $criteria->setProperty('ofset', 20);
            $criteria->setProperty('order', 'id');
            
            $repository = new TRepository('Cliente');
            $objetos = $repository->load( $criteria );

            if ($objetos) {
                foreach ($objetos as $objeto) {
                    echo $objeto->id . ' - ' . $objeto->nome;
                    echo '<br>';
                }
            }
                        
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}