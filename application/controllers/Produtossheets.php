<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtossheets extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('templates_model');
		$this->load->model('login_model');
		$this->login_model->verificarLogin();
    }

	public function index() {
		$categoria = 0;
		$quantidade = 10;
		$pagina = 1;

		if($this->input->method() === 'post'){
			if($this->input->post('filtro_categoria')){
				$categoria = $this->input->post('filtro_categoria');
			}

			if($this->input->post('filtro_quantidade') || $this->input->post('filtro_quantidade') === "0"){
				$quantidade = $this->input->post('filtro_quantidade');
			}

			if($this->input->post('filtro_pagina')){
				$pagina = $this->input->post('filtro_pagina');
			}

			if($this->input->post('codigoplanilha')){
				$planilha = $this->input->post('codigoplanilha');
				$this->clientes_model->setplanilhas(array("id_cliente" => $this->session->userdata('logado')['id'], "id_planilha" => $planilha, "time" => time()));
				header("Location:".base_url("index.php/produtossheets"));
				exit;
			}
		}

		$planilha = array_values($this->clientes_model->getplanilhas($this->session->userdata('logado')['id']));

		$data = array(
            'title' => 'Pressla | Meus Produtos do Google Sheets',
            'localPath' => 'produtos/produtossheets',
            'produtos' => $planilha && count($planilha) > 0 ? $this->buscaProdutos($categoria, $quantidade, $pagina, $planilha[0]->id_planilha) : json_encode(array()),
			'planilha' => $planilha && count($planilha) > 0 ? $planilha[0]->id_planilha : "",
			'categoria_atual' => $categoria,
			'pagina_atual' => $pagina,
			'quantidade_atual' => $quantidade,
			'templates' => $this->templates_model->getTiposTemplates(),
			'id' => $this->session->userdata('logado')['id']
        );

		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath']);
		$this->load->view('produtos/script');
		$this->load->view('template/footer');
	}

	public function buscaProdutos($categoria, $quantidade, $pagina, $planilha){
		// ID da planilha (extraído da URL da planilha)
		$spreadsheetId = $planilha;

		// Intervalo da planilha que você deseja obter (por exemplo, 'Sheet1'!A1:B10)
		$de  = $pagina == 1 ? 2 : (1 + ($quantidade*($pagina-1)));
		$ate = $pagina == 1 ? ($quantidade + 1) : (1 + ($quantidade*($pagina)));
		
		// Sua chave de API do Google
		$apiKey = 'AIzaSyA089Pws7JhNwDs7KTZLxOstx5UCNE4clw';

		if($quantidade == 0){
			$range = "Produtos!A2:H?majorDimension=ROWS";
		} else {
			$range = "Produtos!A$de:H$ate?majorDimension=ROWS";	
		}
		
		// URL da API do Google Sheets
		$url = "https://sheets.googleapis.com/v4/spreadsheets/$spreadsheetId/values/$range&key=$apiKey";

		// Inicializar cURL
		$ch = curl_init($url);

		// Configurar opções do cURL
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Fazer a solicitação HTTP GET
		$response = curl_exec($ch);

		// Verificar se houve algum erro na solicitação
		if (curl_errno($ch)) {
			echo 'Erro ao obter dados da planilha: ' . curl_error($ch);
		}

		// Fechar a sessão cURL
		curl_close($ch);

		$response = json_decode($response);

		if (!isset($response->code) && $categoria != 0) {
			$values = $response->values;
			$values = array_filter($values, function($value) use ($categoria){return $value[5] == $categoria;});	

			$response->values = $values;
		}

		return json_encode($response);
	}
}
