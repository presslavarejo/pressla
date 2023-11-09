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

	public function index_iframe($id = null) {
        $data = array(
            'title' => 'Pressla | Cadastro',
            'localPath' => 'welcome/welcome_iframe',
            'id' => $id
        );

		$this->load->view($data['localPath'], $data);
    }
    
    public function add() {
		if ($this->input->post('nome')) {
			if ($this->clientes_model->verificaCnpj($this->input->post('cnpj'))) {
				header('Location: '.base_url('index.php/welcome/index/2'));
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

	public function add_iframe() {
		if ($this->input->post('nome')) {
			if ($this->clientes_model->verificaCnpj($this->input->post('cnpj'))) {
				header('Location: '.base_url('index.php/welcome/index_iframe/2'));
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
				'logomarca' => $configuracao['file_name'],
				'cad_novo' => $this->input->post('cnpj') ? 0 : 1
			);
			$resposta = $this->clientes_model->addCliente($cliente);
			if ($resposta) {
				header('Location: '.base_url('index.php/welcome/index_iframe/1'));	
			} else {
				header('Location: '.base_url('index.php/welcome/index_iframe/0'));	
			}
		}
	}

	public function addpub() {
		// $saida = array(
		// 	"nome" => $_POST["form_fields"]
		// );
		// $this->clientes_model->addLog(array("descricao" => print_r($_POST["fields"], true)));
		
		if($_POST["fields"]){
			$cliente = array(
				'nome' => $_POST["fields"]["field_5f759bd"]["value"],
				'contato' => '{"nome":["'.$_POST["fields"]["field_5f759bd"]["value"].'"],"telefone":["'.$_POST["fields"]["field_6e0e0a7"]["value"].'"],"email":["'.$_POST["fields"]["email"]["value"].'"],"cargo":[""]}',
				'impressoes' => 1,
				'usadas' => 0,
				'login' => $_POST["fields"]["email"]["value"],
				'senha' => $this->encryption->encrypt($_POST["fields"]["field_e5b5f4c"]["value"]),
				'tipo' => 2,
				'ativo' => 1,
				'assinatura' => 1,
				'fechamento' => 1,
				'data_inserido' => date("Y-m-d"),
				'cad_novo' => 1
			);
			$resposta = $this->clientes_model->addCliente($cliente);
		}
	}
}