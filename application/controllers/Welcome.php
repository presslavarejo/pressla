<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('contatos_model');
        $this->load->model('clientes_model');
    }

	public function index($id = null) {
        $data = array(
            'title' => 'Pressla | Landing Page',
            'localPath' => 'welcome/welcome',
            'contatos' => $this->contatos_model->getContatos(),
            'id' => $id
        );

		$this->load->view($data['localPath'], $data);
    }
    
    public function add() {
		if ($this->input->post('nome')) {
			$configuracao = array(
				'file_name'     =>  null
			);
            if($_FILES != null){
                $imagem    = $_FILES['src'];
                $ext = pathinfo($imagem['name'], PATHINFO_EXTENSION);
                
                $configuracao['upload_path'] = './assets/images/logomarcas';
				$configuracao['allowed_types'] = 'gif|jpg|png|jpeg';
				$configuracao['file_name'] = date('YmdHis').md5($imagem['name']).'.'.$ext;
				$configuracao['max_size'] = '50000';
                
                $this->load->library('upload');
                $this->upload->initialize($configuracao);
                
                if(!$this->upload->do_upload('src')){
					$configuracao['file_name'] = null;
                }
            }
        
			$cliente = array(
				'nome' => $this->input->post('nome'),
				'cnpj' => $this->input->post('cnpj'),
				'rua' => $this->input->post('rua'),
				'bairro' => $this->input->post('bairro'),
				'cidade' => $this->input->post('cidade'),
                'uf' => $this->input->post('estado'),
                'contato' => json_encode(array(
                    "nome" => [$this->input->post('nome')],
                    "telefone" => [$this->input->post('telefone')],
                    "email" => [$this->input->post('login')],
                    "cargo" => [" "]
                )),
				'data_inserido' => date('Y-m-d'),
				'cep' => $this->input->post('cep'),
				'impressoes' => 10,
				'usadas' => 0,
				'login' => $this->input->post('login'),
				'senha' => $this->encryption->encrypt($this->input->post('senha')),
				'tipo' => 2,
				'ativo' => 1,
				'assinatura' => 1,
				'fechamento' => 1,
				'logomarca' => $configuracao['file_name']
			);
			$resposta = $this->clientes_model->addCliente($cliente);
			if ($resposta) {
				header('Location: '.base_url('index.php/welcome/index/1'));
			} else {
				header('Location: '.base_url('index.php/welcome/index/0'));
			}
		}
	}
}