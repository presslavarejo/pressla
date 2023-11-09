<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historico extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('login_model');
        $this->load->model('clientes_model');
		$this->login_model->verificarLogin();
		$this->login_model->checkAdmin();
    }

	public function index($filtro = 2) {
		$data = array(
            'title' => 'Pressla | Histórico',
            'localPath' => 'historico/listar/',
            'filtro' => $filtro,
            'historico' => $this->clientes_model->getHistorico($filtro)
        );
		
		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath'].'style');
		$this->load->view($data['localPath'].'html');
		$this->load->view($data['localPath'].'script');
		$this->load->view('template/footer');
    }
    
    public function impressoes() {

        $de = date("Y-m-d");
        $ate = date("Y-m-d");
        $cliente = 0;
        $resumido = true;

        if($this->input->method() === "post"){
            $de = $this->input->post("de");
            $ate = $this->input->post("ate");
            $cliente = $this->input->post("cliente");
            $resumido = $this->input->post("resumido") ? true : false;
        }

		$data = array(
            'title' => 'Pressla | Histórico de Impressões',
            'localPath' => 'historico/listar/',
            'de' => $de,
            'ate' => $ate,
            'cli' => $cliente,
            'resumido' => $resumido,
            'historico' => $this->clientes_model->getHistoricoImpressoes($de, $ate, $cliente, $resumido),
            'clientes' => $this->clientes_model->getClientes()
        );
		
		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
        $this->load->view($data['localPath'].'style');
		$this->load->view($data['localPath'].'listar_impressoes');
        $this->load->view($data['localPath'].'script');
		$this->load->view('template/footer');
    }
}
