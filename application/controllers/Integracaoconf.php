<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Integracaoconf extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('integracao_model');
		$this->load->model('clientes_model');
		$this->login_model->verificarLogin();
    }

	public function index() {
		if(!$this->login_model->checkAdmin(true)){
			header("Location: ".base_url("index.php/dashboard"));
		}
		$data = array(
            'title' => 'Pressla | Integração',
            'localPath' => 'integracao/integracaoconf',
            'id' => $this->session->userdata('logado')['id']
        );

		if($this->input->method() === "post"){
			
			$conf = array(
				'url_api' => $this->input->post('url_api'),
				'url_qrcode' => $this->input->post('url_qrcode')
			);
			
			$this->integracao_model->updateIntegracaoConf($conf);
			
			header('Location: '.base_url('index.php/integracaoconf'));
		}

		$data['configuracoes'] = $this->integracao_model->getConfig();
		// $data['clientes'] = $this->integracao_model->get();

		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath']);
		$this->load->view('template/footer');
	}

	
}
