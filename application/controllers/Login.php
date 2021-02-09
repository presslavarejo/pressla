<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('login_model');
    }

	public function index() {
		$data = array(
            'title' => 'Pressla | Login',
            'localPath' => 'login/login'
        );

		$data['msg'] = $this->session->flashdata('mensagem');
		
		$this->load->view($data['localPath'], $data);
		//echo $this->encryption->decrypt('4e9d57bfb94910794d0504237d98f9aa66bdfaba326f393bc0845223ad6320b7f17351b3d5085bacc414ef29eafe527f857654bc234a12ea8413892e689e5211RziSNn1nGGazhFzj3tHTnOqU0yCgyyy3GC7yKv4kAKY=');
	}
	/**
	 * Ações
	 */
	public function logar() {
		if ($this->input->post('usuario') && $this->input->post('senha')) {
			$usuario = $this->input->post('usuario');
			$senha = $this->input->post('senha');

			$login = $this->login_model->getLogin($usuario, $senha);
			if ($login) {
				$usuarioSessao = array(
					'id' => $login->id,
					'nome' => $login->nome,
					'login' => $login->login,
					'tipo' => $login->tipo
				);
				$this->session->set_userdata('logado', $usuarioSessao);
				if($login->tipo == 1){
					header('Location: '.base_url('index.php/dashboard/'));
				} else {
					header('Location: '.base_url('index.php/dashboard/'));
				}
			} else {
				$this->session->set_flashdata('mensagem', 'Usuário e/ou Senha inválidos!');
				$this->login_model->deslogar();
			}
		} else {
			$this->session->set_flashdata('mensagem', 'Usuário e Senha obrigatórios!');
			$this->login_model->deslogar();
		}
	}

	public function deslogar() {
		$this->login_model->deslogar();
	}
}