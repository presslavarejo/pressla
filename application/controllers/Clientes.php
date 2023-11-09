<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('login_model');
		$this->login_model->verificarLogin();
		$this->login_model->checkAdmin();
    }
	
	public function listar() {
		$data = array(
            'title' => 'Pressla | Clientes',
			'localPath' => 'clientes/listar/',
			'clientes' => $this->clientes_model->getClientes()
        );
		
		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath'].'style');
		$this->load->view($data['localPath'].'html');
		$this->load->view($data['localPath'].'script');
		$this->load->view('template/footer');
	}

	public function adicionar($id = null) {
		$data = array(
            'title' => 'Pressla | Clientes',
			'localPath' => 'clientes/adicionar/',
			'id' => $id
        );
		
		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath'].'style');
		$this->load->view($data['localPath'].'html');
		$this->load->view($data['localPath'].'script');
		$this->load->view('template/footer');
	}

	public function gerenciar($id, $res = null) {
		$data = array(
            'title' => 'Pressla | Clientes',
			'localPath' => 'clientes/gerenciar/',
			'cliente' => $this->clientes_model->getClientes($id),
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
	public function add() {
		$v = "0";
		if ($this->input->post('nome')) {
			if ($this->clientes_model->verificaCnpj($this->input->post('cnpj'))) {
				header('Location: '.base_url('index.php/clientes/adicionar/0'));
				exit();
			}
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
				'uf' => $this->input->post('uf'),
				'contato' => json_encode($this->input->post('contato')),
				'obs' => $this->input->post('obs'),
				'data_inserido' => date('Y-m-d'),
				'cep' => $this->input->post('cep'),
				'impressoes' => $this->input->post('impressoes'),
				'usadas' => $this->input->post('usadas'),
				'login' => $this->input->post('login'),
				'senha' => $this->encryption->encrypt($this->input->post('senha')),
				'tipo' => $this->input->post('tipo'),
				'ativo' => $this->input->post('ativo'),
				'assinatura' => $this->input->post('assinatura'),
				'tabloid' => $this->input->post('tabloid') ? 1 : 0,
				'fechamento' => $this->input->post('fechamento'),
				'logomarca' => $configuracao['file_name'],
				'cad_novo' => $this->input->post('cnpj') ? 0 : 1,
				'sessao' => $this->input->post('sessao'),
				'token' => $this->input->post('token')
			);
			$resposta = $this->clientes_model->addCliente($cliente);
			if ($resposta) {
				$v = "1";
			}
			header('Location: '.base_url('index.php/clientes/adicionar').'/'.$v);
		}
	}

	public function update() {
		$v = "0";
		if ($this->input->post('id')) {
			$id = $this->input->post('id');
			$logocliente = $this->clientes_model->getClientes($id)->logomarca;
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
				'obs' => $this->input->post('obs'),
				'data_inserido' => ($this->input->post('data_cadastro') ? $this->input->post('data_cadastro') : date('Y-m-d')),
				'cep' => $this->input->post('cep'),
				'impressoes' => $this->input->post('impressoes'),
				'usadas' => $this->input->post('usadas'),
				'login' => $this->input->post('login'),
				'senha' => $this->encryption->encrypt($this->input->post('senha')),
				'tipo' => $this->input->post('tipo'),
				'ativo' => $this->input->post('ativo'),
				'assinatura' => $this->input->post('assinatura'),
				'tabloid' => $this->input->post('tabloid') ? 1 : 0,
				'fechamento' => $this->input->post('fechamento'),
				'logomarca' => $configuracao['file_name'],
				'sessao' => $this->input->post('sessao'),
				'token' => $this->input->post('token')
			);

			if ($this->clientes_model->updateCliente($id, $cliente)) {
				$v = "1";
			}
			header('Location: '.base_url('index.php/clientes/gerenciar').'/'.$id.'/'.$v);
		}
	}

	public function excluir() {
		if ($this->input->post('id')) {
			$id = $this->input->post('id');
			if (!$this->clientes_model->deleteCliente($id)) {
				echo 'erro-500';
			}
		} else {
			echo 'erro-500';
		}
	}
}