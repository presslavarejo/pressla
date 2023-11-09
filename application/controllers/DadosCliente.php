<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DadosCliente extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('integracao_model');
		$this->login_model->verificarLogin();
    }

    public function index() {
        header('Location: '.base_url('index.php/dadoscliente/gerenciar/'));
	}
	
	public function gerenciar($res = null) {
		$data = array(
            'title' => 'Pressla | Meus Dados',
			'localPath' => 'dadoscliente/',
			'cliente' => $this->clientes_model->getClientes($this->session->userdata('logado')['id']),
			'res' => $res
		);
		
		$data['cliente']->data_inserido = date('Y-m-d', strtotime($data['cliente']->data_inserido));
		
		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		
		$this->load->view($data['localPath'].'html');
		$this->load->view($data['localPath'].'script');
		$this->load->view('template/footer');
	}

	/**
	 * Ações
	 */
	public function update() {
		$v = "0";
		if ($this->input->post('id')) {
			$id = $this->input->post('id');
			$cli = $this->clientes_model->getClientes($id);
			$logocliente = $cli->logomarca;
			$configuracao = array(
				'file_name'     =>  $logocliente
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
					$configuracao['file_name'] = $logocliente;
                }
			}
			
			$cliente = array(
				'nome' => $this->input->post('nome'),
				'cnpj' => $this->input->post('cnpj'),
				'rua' => $this->input->post('rua'),
				'bairro' => $this->input->post('bairro'),
				'cidade' => $this->input->post('cidade'),
				'uf' => $this->input->post('uf'),
				'contato' => json_encode($this->input->post('contato')),
				'cep' => $this->input->post('cep'),
				'login' => $this->input->post('login'),
				'senha' => $this->encryption->encrypt($this->input->post('senha')),
				'logomarca' => $configuracao['file_name'],
				'cad_novo' => $this->input->post('cnpj') ? 0 : 1,
				'sessao' => $this->input->post('sessao'),
				'token' => $this->input->post('token')
			);

			if($cli->cad_novo == 1 && $this->input->post('cnpj')){
				$cliente["impressoes"] = 10;
			}

			if ($this->clientes_model->updateCliente($id, $cliente)) {
				$v = "1";
			}
			header('Location: '.base_url('index.php/dadoscliente/gerenciar/').$v);
		}
	}

	function verificaClienteCnpj($id, $cnpj){
		$cnpj = str_replace("barra", "/", $cnpj);
		echo $this->clientes_model->verificaClienteCnpj($id, $cnpj);
	}
}