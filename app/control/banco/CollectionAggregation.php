<?php
use Adianti\Database\TTransaction;

class CollectionAggregation extends TPage 
{
    public function __construct() 
    {
        parent::__construct();

        try {
            TTransaction::open('psql');
            TTransaction::dump();

            //$total = Venda::sumBy('total');
            //$count = Venda::countDistinctBy('total');

            $rows = Venda::groupBy('dt_venda, cliente_id')->sumBy('total');
            echo '<pre>';
            var_dump($rows);
            echo '</pre>';

            TTransaction::close();

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}