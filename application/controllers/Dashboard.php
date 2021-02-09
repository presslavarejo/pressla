<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('dashboard_model');
		$this->load->model('tamanhos_model');
		$this->load->model('templates_model');
		$this->load->model('figuras_model');
		$this->load->model('login_model');
		$this->load->model('contatos_model');
		$this->load->model('historico_model');
		$this->load->model('transacao_model');
		$this->login_model->verificarLogin();
    }

	public function index() {
		$data = array(
            'title' => 'Pressla | Home',
			'localPath' => 'dashboard/dashboard/',
			'whatsapp' => str_replace(array("(",")","-"," "),"",$this->contatos_model->getContatoPorNome("Whatsapp")->valor),
			'usuarioadm' => $this->login_model->checkAdmin(true)
		);

		if($data['usuarioadm']){
			$data['metricas'] = $this->clientes_model->getClientes();
		} else {
			$data['metricas'] = $this->clientes_model->getClientes($this->session->userdata('logado')['id']);
			$data['alertas'] = $this->transacao_model->getAlertas($this->session->userdata('logado')['id']);
		}
		
		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath'].'html');
		$this->load->view('template/footer');
	}

	public function criar() {
		$data = array(
            'title' => 'Pressla | Criar',
			'localPath' => 'dashboard/criar/',
			'tamanhos' => $this->tamanhos_model->getTamanhos(),
			'templates' => $this->templates_model->getTiposTemplates(),
			'figuras' => $this->figuras_model->getFiguras(),
			'imgtemplates' => $this->templates_model->getTemplates(),
			'id' => $this->session->userdata('logado')['id'],
			'linha1' => $this->historico_model->getLinha($this->session->userdata('logado')['id'],1),
			'linha2' => $this->historico_model->getLinha($this->session->userdata('logado')['id'],2),
			'linha3' => $this->historico_model->getLinha($this->session->userdata('logado')['id'],3)
		);
		
		
		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath'].'style');
		$this->load->view($data['localPath'].'html');
		$this->load->view($data['localPath'].'script');
		$this->load->view('template/footer');
	}

	/*
	AÇÕES
	*/
	public function buscaTemplatesPorTipo($id, $id_usu, $lay) {
		$templs = $this->templates_model->getTemplates();
		$cli = $this->clientes_model->getClientes($id_usu);

		$array_id = array();
		foreach($templs as $templ){
			$array_compat = explode(', ', $templ->ids_tipos);
			if(in_array($id, $array_compat) && ($templ->id_exclusivo == 0 || $templ->id_exclusivo == $id_usu || ($templ->id_exclusivo == 1 && $cli->assinatura == 1) || $cli->tipo == 1) && $templ->layout == $lay){
				array_push($array_id, $templ->id."<|>".$templ->nome);
			}
		}
		echo implode(',',$array_id);
	}

	public function buscaTemplate($id) {
		if($templ = $this->templates_model->getTemplate($id)){
			echo $templ->src;
		} else {
			echo "";
		}
	}

	public function checkImpressoesUsadas($id){
		echo $this->clientes_model->checkImpressoesUsadas($id);
	}

	public function contarImpressaoUsada($id){
		$this->clientes_model->contarImpressaoUsada($id);
	}

	public function cadastraHistoricoProduto($produto, $linha, $id_cliente){
		if(!$this->historico_model->produtoExiste(urldecode($produto), $linha, $id_cliente)){
			$array_produto = array(
				'linha' => $linha,
				'id_cliente' => $id_cliente,
				'produto' => urldecode($produto)
			);
			$this->historico_model->setLinha($array_produto);
		}
	}

	public function atualizaAutoComplete($id_cliente,$linha){
		$linha = $this->historico_model->getLinha($id_cliente, $linha);
		foreach($linha as $l)
        {
            $arrayl[] = $l->produto;
        }
        echo implode(',',$arrayl);
	}

	public function updateLido($id_cliente){
		$this->transacao_model->updateLido($id_cliente);
		header("Location: ".base_url('index.php/dashboard'));
		exit;
	}
}
