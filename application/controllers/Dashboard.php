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
		$this->load->model('produtos_model');
		$this->login_model->verificarLogin();
    }

	public function index() {
		$data = array(
            'title' => 'Pressla | Home',
			'localPath' => 'dashboard/dashboard/',
			'whatsapp' => str_replace(array("(",")","-"," "),"",$this->contatos_model->getContatoPorNome("Whatsapp")->valor),
			'usuarioadm' => $this->login_model->checkAdmin(true),
			'cliente' => $this->clientes_model->getClientes($this->session->userdata('logado')['id']),
			'historico_dia' => $this->clientes_model->getHistoricoImpressoes(date("Y-m-d"), date("Y-m-d"), $this->session->userdata('logado')['id'], true),
			'historico_mes' => $this->clientes_model->getHistoricoImpressoes(date("Y-m-01"), date("Y-m-d"), $this->session->userdata('logado')['id'], true),
		);

		if(!$data['usuarioadm']){
			$data['alertas'] = $this->transacao_model->getAlertas($this->session->userdata('logado')['id']);
		}
		
		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath'].'html');
		$this->load->view('template/footer');
	}

	public function criar($lay = null) {
		$data = array(
            'title' => 'Pressla | Criar',
			'localPath' => 'dashboard/criar/',
			'tamanhos' => $this->tamanhos_model->getTamanhos(),
			'templates' => $this->templates_model->getTiposTemplates(),
			'figuras' => $this->figuras_model->getFigurasCriar(),
			'imgtemplates' => $this->templates_model->getTemplates(),
			'produtos' => $this->produtos_model->getProdutos(["id_cliente = ".$this->session->userdata('logado')['id']], "descricao ASC"),
			'id' => $this->session->userdata('logado')['id'],
			'lay' => $lay,
			'tipos' => $this->templates_model->getTipos(),
			'cliente' => $this->clientes_model->getClientes($this->session->userdata('logado')['id'])
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
			$array_idexclusivo = explode(',', $templ->id_exclusivo);
			
			if(in_array($id, $array_compat) && (in_array(0, $array_idexclusivo) || in_array($id_usu, $array_idexclusivo) || (in_array(1, $array_idexclusivo) && $cli->assinatura == 1) || $cli->tipo == 1) && $templ->layout == $lay){
			// if(in_array($id, $array_compat) && ($templ->id_exclusivo == 0 || $templ->id_exclusivo == $id_usu || ($templ->id_exclusivo == 1 && $cli->assinatura == 1) || $cli->tipo == 1) && $templ->layout == $lay){
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

	public function contarHistoricoImpressao($id, $quantidade){
		$this->clientes_model->contarHistoricoImpressao($id, $quantidade);
	}

	public function checkImpressoesUsadas($id){
		echo $this->clientes_model->checkImpressoesUsadas($id);
	}

	public function checkImpressoesUsadasNum($id){
		echo $this->clientes_model->checkImpressoesUsadasNum($id);
	}

	public function contarImpressaoUsada($id){
		$this->clientes_model->contarImpressaoUsada($id);
	}

	public function contarImpressaoUsadaNum($id, $num){
		$this->clientes_model->contarImpressaoUsadaNum($id,$num);
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

	public function cadprod() {
		if ($this->input->method() === 'post') {
			$produto = array(
				'id_cliente' => $this->session->userdata('logado')['id'],
				'ncm' => $this->input->post('modal_ncm'),
				'sku' => strtoupper($this->input->post('modal_sku')),
				'descricao' => $this->input->post('modal_descricao'),
				'preco' => str_replace(",", ".", $this->input->post('modal_preco')),
				'preco_promocional' => str_replace(",", ".", $this->input->post('modal_preco_promocional')),
				'data_cadastro' => date("Y-m-d H:i:s")
			);

			if($resposta = $this->produtos_model->addProduto($produto)){
				echo json_encode(array("status" => "sucesso", "id" => $resposta, "descricao" => $produto["descricao"], "preco" => $produto["preco"], "preco_promocional" => $produto["preco_promocional"]));
			} else {
				echo json_encode(array("status" => "erro", "msg" => "O envio dos dados não pôde ser concluído. Por favor, tente novamente mais tarde"));
			}
		} else {
			echo json_encode(array("status" => "erro", "msg" => "Não houve envio de parâmetros para o banco de dados."));
		}
	}

	public function salvaAlteracao() {
		if ($this->input->method() === 'post') {

			$produto = array(
				'linha1' => $this->input->post('linha1'),
				'linha2' => $this->input->post('linha2'),
				'linha3' => $this->input->post('linha3'),
				'preco' => str_replace(",", ".", $this->input->post('preco')),
				'preco_promocional' => str_replace(",", ".", $this->input->post('preco_promocional'))
			);

			$produto['descricao'] = $this->input->post('linha1')." ".$this->input->post('linha2')." ".$this->input->post('linha3');

			if($this->produtos_model->updateProduto($this->input->post('id_produto'), $produto)){
				echo json_encode(array("status" => "sucesso"));
			} else {
				echo json_encode(array("status" => "erro", "msg" => "Produto não atualizado"));
			}
		} else {
			echo json_encode(array("status" => "erro", "msg" => "Não houve envio de parâmetros para o banco de dados."));
		}
	}

	// ESCREVER NO CSV
	function criarFila($id, $nome){
		if(!is_dir(APPPATH."../assets/filas/cli".$id)){
			mkdir(APPPATH."../assets/filas/cli".$id, 0777, true);
		}

		$data = date("YmdHis");
		$filename = "./assets/filas/cli".$id."/".$nome."_".$data.".csv";
		$fileHandle = fopen ($filename, 'w');
		
		// fwrite($fileHandle , "layout;template;tamanho;fonte;fonte_tamanho;linha1;linha2;linha3;codigo;rodape;preco;cor_preco;preco_anterior;cor_preco_anterior;unidade;");
		$ar = ["layout","template","tamanho","fonte","fonte_tamanho","linha1","linha2","linha3","codigo","rodape","preco","cor_preco","preco_anterior","cor_preco_anterior","unidade",""];
			
		fputcsv($fileHandle, $ar, ";");
		fclose($fileHandle);

		if(file_exists(APPPATH."../assets/filas/cli".$id."/".$nome."_".$data.".csv")){
			return $nome."_".$data.".csv";
		} else {
			return "error";
		}
	}

	function addRegistroFila($id, $nome){
		$filename = "./assets/filas/cli".$id."/".$nome.".csv";
		$fileHandle = fopen ($filename, 'r');

		$header = fgetcsv($fileHandle, 0, ";");

		while ($row = fgetcsv($fileHandle, 0, ";")) {
			$nota[] = array_combine($header, $row);
		}
		print_r($nota);

		fclose($fileHandle);

		
		return;
		
		// fputs($fileHandle , "A4;Mercadillo Black;100;PRODUTO LINHA 1;PRODUTO LINHA 2;PRODUTO LINHA 3;123456;Oferta válida enquanto durarem nossos estoques;12,32;#FF0000;15,23;#000000;KG;");

		$ar = [
			"layout" => "1",
			"template" => "177",
			"tamanho" => "A4",
			"fonte" => "Mercadillo Black",
			"fonte_tamanho" => "100",
			"linha1" => "PRODUTO LINHA 1",
			"linha2" => "PRODUTO LINHA 2",
			"linha3" => "PRODUTO LINHA 3",
			"codigo" => "123456",
			"rodape" => "Oferta válida enquanto durarem nossos estoques",
			"preco" => "12,32",
			"cor_preco" => "#FF0000",
			"preco_anterior" => "15,23",
			"cor_preco_anterior" => "#000000",
			"unidade" => "KG"	
		];
		
		// fputcsv($fileHandle , explode(";", "1;177;A4;Mercadillo Black;100;PRODUTO LINHA 1;PRODUTO LINHA 2;PRODUTO LINHA 3;123456;Oferta válida enquanto durarem nossos estoques;12,32;#FF0000;15,23;#000000;KG;"), ";");
		fputcsv($fileHandle, $ar, ";");
		fclose($fileHandle);
	}
}
