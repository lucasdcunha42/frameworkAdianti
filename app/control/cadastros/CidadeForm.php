<?php
use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Validator\TRequiredListValidator;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Wrapper\BootstrapFormBuilder;

class CidadeForm extends TPage {

    private $form;

    public function __construct() {
        parent::__construct();

        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle("Formulario Cidade");

        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $estado = new TDBCombo('estado_id', 'psql', 'Estado', 'id', 'nome');
        $id->setEditable(FALSE);

        $this->form->addFields([new TLabel('Id')], [$id]);
        $this->form->addFields([new TLabel('Nome')], [$nome]);
        $this->form->addFields([new TLabel('Estado')], [$estado]);

        $nome->addValidation('Nome', new TRequiredValidator);
        $estado->addValidation('Estado', new TRequiredValidator);

        $this->form->addAction('Salvar', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink('Limpar', new TAction([$this, 'onClear']), 'fa:eraser red');

        parent::add($this->form);
    }

    public function onSave($param) {
        try {

            TTransaction::open('psql');

            $this->form->validate();
            $data = $this->form->getData();

            $cidade = new Cidade;
            $cidade->fromArray( (array) $data);
            $cidade->store();

            $this->form->setData( $cidade );

            new TMessage('info', 'Registro Salvo com Sucesso');

            TTransaction::close();

        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }

    public function onClear($param) {

    }

    public function onEdit($param) {
        try 
        {
            TTransaction::open('psql');

            if ($param['id']) {
                $key = $param['id'];
                $cidade = new Cidade($key);
                $this->form->setData( $cidade ); 
            }

            TTransaction::close();

        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
}