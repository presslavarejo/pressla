<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Figuras extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('figuras_model');
		$this->load->model('login_model');
		$this->login_model->verificarLogin();
		$this->login_model->checkAdmin();
    }

	public function index() {
		$data = array(
            'title' => 'Pressla | Figuras',
            'localPath' => 'figuras/listar/',
            'figuras' => $this->figuras_model->getFiguras()
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
            'title' => 'Pressla | Figuras',
            'localPath' => 'figuras/adicionar/',
            'clientes' => $this->clientes_model->getClientes(),
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
            'title' => 'Pressla | Figuras',
			'localPath' => 'figuras/gerenciar/',
            'figura' => $this->figuras_model->getFigura($id),
            'clientes' => $this->clientes_model->getClientes(),
            'res' => $res
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
        $v = "0";
		if ($this->input->post('nome')) {
            if($_FILES != null){
                $imagem    = $_FILES['src'];
                
                $configuracao = array(
                    'upload_path'   => './assets/images/figuras',
                    'allowed_types' => '*',
                    'file_name'     =>  mb_strtolower(preg_replace('/\s+/', '', $imagem['name']),"UTF-8"),
                    'max_size'      => '500000'
                );

                
                $this->load->library('upload');
                $this->upload->initialize($configuracao);
                
                if($this->upload->do_upload('src')){
                    $figura = array(
                        'nome' => $this->input->post('nome'),
                        'src' => $configuracao['file_name']
                    );
                    if($this->figuras_model->addFigura($figura)){
                        $v = "1";
                    }
                }
            }
        }
        header('Location: '.base_url('index.php/figuras/adicionar').'/'.$v);
	}

	public function update($id) {
		$v = "0";
		if ($this->input->post('nome')) {
            $temp = $this->figuras_model->getFigura($id);
            $figura = array(
                'src' => $temp->src
            );
            if($_FILES != null){
                if(!empty($_FILES['src'])){
                    $imagem    = $_FILES['src'];
                    
                    $configuracao = array(
                        'upload_path'   => './assets/images/figuras',
                        'allowed_types' => '*',
                        'file_name'     =>  mb_strtolower(preg_replace('/\s+/', '', $imagem['name']),"UTF-8"),
                        'max_size'      => '500000'
                    );
        
                    $this->load->library('upload');
                    $this->upload->initialize($configuracao);
                    
                    if($this->upload->do_upload('src')){
                        $figura['src'] = $configuracao['file_name'];
                    }
                }
            }
            $figura['nome'] = $this->input->post('nome');

            if($this->figuras_model->updateFigura($temp->id,$figura)){
                $v = "1";
            }
        }
        header('Location: '.base_url('index.php/figuras/gerenciar').'/'.$temp->id.'/'.$v);
	}

	public function excluir($id) {
        $figura = $this->figuras_model->getFigura($id);
        if (!$this->figuras_model->deleteFigura($id)) {
            echo 'erro-500';
        } else {
            if(file_exists(base_url('assets/images/figuras/'.$figura->src))){
                unlink(base_url('assets/images/figuras/'.$figura->src));
            }
        }
	}
}
