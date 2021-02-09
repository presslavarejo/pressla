<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contatos extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('contatos_model');
		$this->load->model('login_model');
		$this->login_model->verificarLogin();
		$this->login_model->checkAdmin();
    }

	public function index() {
		$data = array(
            'title' => 'Pressla | Contatos',
            'localPath' => 'contatos/listar/',
            'contatos' => $this->contatos_model->getContatos()
        );

		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath'].'style');
		$this->load->view($data['localPath'].'html');
		$this->load->view($data['localPath'].'script');
		$this->load->view('template/footer');
	}
	
	public function adicionar() {
		$data = array(
            'title' => 'Pressla | Contatos',
			'localPath' => 'contatos/adicionar/'
        );
		
		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath'].'style');
		$this->load->view($data['localPath'].'html');
		$this->load->view($data['localPath'].'script');
		$this->load->view('template/footer');
	}

	public function gerenciar($id) {
		$data = array(
            'title' => 'Pressla | Contatos',
			'localPath' => 'contatos/gerenciar/',
			'contato' => $this->contatos_model->getContato($id)
			
		);
		
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
		if ($this->input->post('contato')) {
			$contato = json_decode($this->input->post('contato'));
			$contato = array(
				'nome' => $contato->nome,
				'valor' => $contato->valor
			);
			$resposta = $this->contatos_model->addContato($contato);
			if (!$resposta) {
				echo 'erro-500';
			} else {
				echo $resposta;
			}
		}
	}

	public function update() {
		if ($this->input->post('contato')) {
			$contato = json_decode($this->input->post('contato'));
			$id = $contato->id;
			$contato = array(
				'nome' => $contato->nome,
				'valor' => $contato->valor
			);
			if ($this->contatos_model->updateContato($id, $contato)) {
				echo '200';
			}
		}
	}

	public function excluir() {
		if ($this->input->post('id')) {
			$id = $this->input->post('id');
			if (!$this->contatos_model->deleteContato($id)) {
				echo 'erro-500';
			}
		} else {
			echo 'erro-500';
		}
	}
}
