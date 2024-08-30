<?php
use Adianti\Base\AdiantiStandardFormTrait;
class CidadeTraitForm extends TPage
{
    private $form;

    use AdiantiStandardFormTrait;
    
    public function __construct()
    {
        parent::__construct();

        $this->setDatabase('psql');
        $this->setActiveRecord('Cidade');
        
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Cidade');
        $this->form->setClientValidation( true );
        
        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $estado = new TDBCombo('estado_id', 'psql', 'Estado', 'id', 'nome');
        $id->setEditable(FALSE);
        
        $this->form->addFields( [new TLabel('Id')], [$id] );
        $this->form->addFields( [new TLabel('Nome', 'red')], [$nome] );
        $this->form->addFields( [new TLabel('Estado', 'red')], [$estado] );
        
        $nome->addValidation('Nome', new TRequiredValidator);
        $estado->addValidation('Estado', new TRequiredValidator);
        
        $this->form->addAction('Salvar', new TAction( [$this, 'onSave'] ), 'fa:save green');
        $this->form->addActionLink('Limpar', new TAction( [$this, 'onClear'] ), 'fa:eraser red');
        
        parent::add($this->form);
    }   
}