<?php
class CidadeForm extends TPage
{
    private $form;
    
    public function __construct()
    {
        parent::__construct();
        
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
    
    public function onClear()
    {
        $this->form->clear(true);
    }
    
    public function onSave($param)
    {
        try
        {
            TTransaction::open('psql');
            
            $this->form->validate();
            
            $data = $this->form->getData();
            
            $cidade = new Cidade;
            $cidade->fromArray( (array) $data);
            $cidade->store();
            
            $this->form->setData( $cidade );
            
            new TMessage('info', 'Registro salvo com sucesso');
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
    public function onEdit($param)
    {
        try
        {
            TTransaction::open('psql');
            
            if (isset($param['id']))
            {
                $key = $param['id'];
                $cidade = new Cidade($key);
                $this->form->setData($cidade);
            }
            else
            {
                $this->form->clear(true);
            }
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
}