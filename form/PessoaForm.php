<?php

require_once '../classes/Pessoa.php';
require_once '../classes/Cidade.php';

class PessoaForm {
    private $html;
    private $data;

    public function __construct() {
        
        $this->html = file_get_contents('../html/form.html');
        $this->data = [
            'id'        => '',
            'nome'      => '',
            'endereco'  => '',
            'bairro'    => '',
            'telefone'  => '',
            'email'     => '',
            'id_cidade' => '' 
        ];

        $cidades = '';

        foreach (Cidade::all() as $cidade) {
            $cidades .= "<option value='{$cidade['id']}'> '{$cidade['nome']}'</option>";
        }
        $this->html = str_replace('{cidades}', $cidades, $this->html);
    }

    public function edit($param) {
        
        $id = (int) $param['id'];
        $pessoa = Pessoa::find($param);
        $this->data = $pessoa;
    }

    public function save($param) {
        
        Pessoa::save($param);
        $this->data = $param;
        print "Pessoa Salva Com sucesso";
    }

    public function show() {
        $this->html = str_replace('{id}', $this->data['id'], $this->html);
        $this->html = str_replace('{nome}', $this->data['nome'], $this->html);
        $this->html = str_replace('{endereco}', $this->data['endereco'], $this->html);
        $this->html = str_replace('{bairro}', $this->data['bairro'], $this->html);
        $this->html = str_replace('{telefone}', $this->data['telefone'], $this->html);
        $this->html = str_replace('{email}', $this->data['email'], $this->html);
        $this->html = str_replace('{id_cidade}', $this->data['id_cidade'], $this->html);

        $this->html = str_replace("option value='{$this->data['id_cidade']}'",
        "<option selected=1 value='{$this->data['id_cidade']}'", $this->html);
        
        print $this->html;
    }
}