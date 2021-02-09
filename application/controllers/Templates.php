<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Templates extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('templates_model');
		$this->load->model('login_model');
		$this->login_model->verificarLogin();
		$this->login_model->checkAdmin();
    }

	public function index() {
		$data = array(
            'title' => 'Pressla | Templates',
            'localPath' => 'templates/listar/',
            'templates' => $this->templates_model->getTemplates()
        );
		
		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath'].'style');
		$this->load->view($data['localPath'].'html');
		$this->load->view($data['localPath'].'script');
		$this->load->view('template/footer');
    }

    public function tipos() {
		$data = array(
            'title' => 'Pressla | Categorias',
            'localPath' => 'templates/listartipo/',
            'templates_tipo' => $this->templates_model->getTiposTemplates()
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
            'title' => 'Pressla | Templates',
            'localPath' => 'templates/adicionar/',
            'tipos' => $this->templates_model->getTiposTemplates(),
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
    
    public function adicionartipo($id = null) {
		$data = array(
            'title' => 'Pressla | Categorias',
            'localPath' => 'templates/adicionartipo/',
            'tipos' => $this->templates_model->getTiposTemplates(),
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
            'title' => 'Pressla | Templates',
			'localPath' => 'templates/gerenciar/',
            'template' => $this->templates_model->getTemplate($id),
            'tipos' => $this->templates_model->getTiposTemplates(),
            'clientes' => $this->clientes_model->getClientes(),
            'res' => $res
		);
		
		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath'].'html');
		$this->load->view($data['localPath'].'script');
		$this->load->view('template/footer');
    }
    
    public function gerenciartipo($id, $res = null) {
		$data = array(
            'title' => 'Pressla | Categorias',
			'localPath' => 'templates/gerenciartipo/',
            'template_tipo' => $this->templates_model->getTiposTemplate($id),
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
                    'upload_path'   => './assets/images/templates',
                    'allowed_types' => 'gif|jpg|png|jpeg',
                    'file_name'     =>  mb_strtolower(preg_replace('/\s+/', '', $imagem['name']),"UTF-8"),
                    'max_size'      => '50000'
                );
    
                $this->load->library('upload');
                $this->upload->initialize($configuracao);
                
                if($this->upload->do_upload('src')){
                    $template = array(
                        'ids_tipos' => $this->input->post('ids_tipos'),
                        'nome' => $this->input->post('nome'),
                        'src' => $configuracao['file_name'],
                        'id_exclusivo' => $this->input->post('id_exclusivo'),
                        'layout' => $this->input->post('layout')
                    );
                    if($this->templates_model->addTemplate($template)){
                        $v = "1";
                    }
                }
            }
        }
        header('Location: '.base_url('index.php/templates/adicionar').'/'.$v);
    }
    
    public function addtipo() {
        $v = "0";
		if ($this->input->post('nome')) {
            $template = array(
                'tipo' => $this->input->post('nome')
            );
            if($this->templates_model->addTipoTemplate($template)){
                $v = "1";
            }
        }
        header('Location: '.base_url('index.php/templates/adicionartipo').'/'.$v);
	}

	public function update($id) {
		$v = "0";
		if ($this->input->post('nome')) {
            $temp = $this->templates_model->getTemplate($id);
            $template = array(
                'src' => $temp->src
            );
            if($_FILES != null){
                if(!empty($_FILES['src'])){
                    $imagem    = $_FILES['src'];
                    
                    $configuracao = array(
                        'upload_path'   => './assets/images/templates',
                        'allowed_types' => 'gif|jpg|png|jpeg',
                        'file_name'     =>  mb_strtolower(preg_replace('/\s+/', '', $imagem['name']),"UTF-8"),
                        'max_size'      => '50000'
                    );
        
                    $this->load->library('upload');
                    $this->upload->initialize($configuracao);
                    
                    if($this->upload->do_upload('src')){
                        $template['src'] = $configuracao['file_name'];
                    }
                }
            }
            $template['ids_tipos'] = $this->input->post('ids_tipos');
            $template['nome'] = $this->input->post('nome');
            $template['id_exclusivo'] = $this->input->post('id_exclusivo');
            $template['layout'] = $this->input->post('layout');
            

            if($this->templates_model->updateTemplate($temp->id,$template)){
                $v = "1";
            }
        }
        header('Location: '.base_url('index.php/templates/gerenciar').'/'.$temp->id.'/'.$v);
    }
    
    public function updatetipo($id) {
		$v = "0";
		if ($this->input->post('nome')) {
            $temp = $this->templates_model->getTiposTemplate($id);
            
            $template['tipo'] = $this->input->post('nome');

            if($this->templates_model->updateTipoTemplate($temp->id,$template)){
                $v = "1";
            }
        }
        header('Location: '.base_url('index.php/templates/gerenciartipo').'/'.$temp->id.'/'.$v);
	}

	public function excluir($id) {
        $template = $this->templates_model->getTemplate($id);
        if (!$this->templates_model->deleteTemplate($id)) {
            echo 'erro-500';
        } else {
            if(file_exists(base_url('/assets/images/templates/'.$template->src))){
                unlink(base_url('assets/images/templates/'.$template->src));
            }
        }
    }
    
    public function excluirtipo($id) {
        $template = $this->templates_model->getTiposTemplate($id);
        if (!$this->templates_model->deleteTipoTemplate($id)) {
            echo 'erro-500';
        }
	}
}
