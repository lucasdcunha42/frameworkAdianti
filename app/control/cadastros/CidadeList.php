<?php
use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Datagrid\TPageNavigation;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Wrapper\BootstrapFormBuilder;

class CidadeList extends TPage {
    private $datagrid;
    private $pageNavigation;
    private $loaded;

    public function __construct() {
        parent::__construct();

        $this->datagrid = new BootstrapDatagridWrapper( new TDataGrid);
        $this->datagrid->width = '100%';

        $col_id = new TDataGridColumn('id', 'Cód', 'right', '10%');
        $col_nome = new TDataGridColumn('nome', 'Nome', 'left', '70%');
        $col_estado = new TDataGridColumn('estado->nome','Estado', 'center', '30%' );

        $col_id->setAction( new TAction( [ $this, 'onReload' ]), ['order' => 'id']);
        $col_nome->setAction( new TAction( [ $this, 'onReload' ]), ['order' => 'id']);

        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);
        $this->datagrid->addColumn($col_estado);

        $action1 = new TDataGridAction(['CidadeForm', 'onEdit'], ['key' => '{id}']);
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{id}']);

        $this->datagrid->addAction($action1, 'Editar', 'fa:edit blue');
        $this->datagrid->addAction($action2, 'Excluir', 'fa:trash-alt red');

        $this->datagrid->createModel();

        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction( new TAction([$this, 'onReload'] ));

        $panel = new TPanelGroup;
        $panel->add($this->datagrid);
        $panel->add($this->pageNavigation);

        parent::add($panel);

    }

    public function onReload($param) {

        try {
            TTransaction::open('psql');

            $repository = new TRepository('Cidade');

            $limit = 3;

            $criteria = new TCriteria();
            $criteria->setProperty('limit', $limit);
            $criteria->setProperties($param);

            $cidades = $repository->load($criteria);

            $this->datagrid->clear();

            if ($cidades) {
                foreach($cidades as $cidade){
                    $this->datagrid->addItem($cidade);
                }
            }

            $criteria->resetProperties();
            $count = $repository->count($criteria);

            $this->pageNavigation->setCount($count);
            $this->pageNavigation->setProperties($param);
            $this->pageNavigation->setLimit($limit);

            TTransaction::close();
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }

    }

    public static function onDelete ($param) {

    }

    function show()
    {
        if (!$this->loaded)
        {
            $this->onReload(func_get_args());
        }
        parent::show();
    }
}