<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('produtos_model');
		
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
		$cliente = $this->clientes_model->getClientes($this->session->userdata('logado')['id']);

		if($cliente && $cliente->planilha && ($cliente->planilha != null || $cliente->planilha != '')) {
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
			}

			$planilha = $cliente->planilha;

			$data = array(
				'title' => 'Pressla | Meus Produtos do Google Sheets',
				'localPath' => 'produtos/produtossheets',
				'produtos' => $this->buscaProdutos($categoria, $quantidade, $pagina, $planilha),
				'planilha' => $planilha,
				'categoria_atual' => $categoria,
				'pagina_atual' => $pagina,
				'quantidade_atual' => $quantidade,
				'templates' => $this->templates_model->getTiposTemplates(),
				'id' => $this->session->userdata('logado')['id']
			);
		
		} else {
			// SUBIR ARQUIVOS EM MASSA
			$colunas = 8;
			$categoria = 0;
			if($this->input->method() === 'post'){
				if($this->input->post('filtro_categoria')){
					$categoria = $this->input->post('filtro_categoria');
				}
				
				else if($this->input->post('acao') && $this->input->post('acao') == "excluir_massa" && $this->input->post('produtos_selecionados_modal')){
					$this->produtos_model->deleteProdutosMassa($this->input->post('produtos_selecionados_modal'));
				}

				else if($this->input->post('acao') && $this->input->post('acao') == "alterar_categorias_massa" && $this->input->post('produtos_selecionados_modal') && $this->input->post('categoria_modal')){
					$this->produtos_model->updateCampoProdutosMassa(array('categoria' => $this->input->post('categoria_modal')), $this->input->post('produtos_selecionados_modal'));
				}
				
				else {
					if($_FILES != null){
						$arquivo = $_FILES['arquivoxml']["tmp_name"];
						$ext = pathinfo($_FILES['arquivoxml']['name'], PATHINFO_EXTENSION);
						
						if($ext == 'xml'){
						
							$link = $arquivo;
							//link do arquivo xml
							$xml = simplexml_load_file($link) -> Produto;
		
							foreach($xml as $item){
								$produto = array(
									'id_cliente' => $this->session->userdata('logado')['id'],
									'ncm' => $item -> NCM,
									'sku' => strtoupper($item -> SKU),
									'categoria' => isset($item -> SKU) ? $item -> SKU : 1,
									'descricao' => $item -> DESCRICAO,
									'preco' => str_replace(",",".",$item -> PRECO),
									'preco_promocional' => str_replace(",",".",$item -> PRECOPROMOCIONAL),
									'unidade' => isset($item -> UNIDADE) ? $item -> UNIDADE : "Un.",
									'quantidade' => isset($item -> QUANTIDADE) ? $item -> QUANTIDADE : 1,
									'data_cadastro' => date("Y-m-d H:i:s")
								);
				
								$this->produtos_model->addProduto($produto);
							}
						
						} else if($ext == "csv"){
							$handle = fopen($arquivo, "r");
		
							$header = fgetcsv($handle, 1000, ",");
							
							// if(count($header) > 1){
							// 	$virgula = true;
							// 	$handle = fopen($arquivo, "r");
							// 	$header = fgetcsv($handle, 1000, ";");
							// 	$header = explode(",",utf8_encode($header[0]));
							// } else {
							// 	$header = explode(";",utf8_encode($header[0]));
							// 	$virgula = false;
							// }
							if(count($header) > 1){
								$separador = ",";
								$handle = fopen($arquivo, "r");
								$header = fgetcsv($handle, 1000, ";");
								$header = explode(",",utf8_encode($header[0]));
							} else if(mb_strpos(implode("-",$header), ";")) {
								$header = explode(";",utf8_encode($header[0]));
								$separador = ";";
							} else if(mb_strpos(implode("-",$header), "\t")) {
								$header = explode("\t",utf8_encode($header[0]));
								$separador = "\t";
							}
		
							// while(count($header) > $colunas){
							// 	array_pop($header);
							// }
		
							// while ($row = fgetcsv($handle, 1000, $virgula ? ";" : "\n")) {
							// 	// echo var_dump(substr_count($row[0], ","));
							// 	$linha = explode($virgula ? "," : ";",utf8_encode($row[0]));
							// 	while(count($linha) > $colunas){
							// 		array_pop($linha);
							// 	}
							// 	$nota[] = array_combine($header, $linha);
							// }
							while(count($header) > $colunas){
								array_pop($header);
							}
		
							while ($row = fgetcsv($handle, 1000, $separador == "," ? ";" : "\n")) {
								$linha = explode($separador, utf8_encode($row[0]));
								while(count($linha) > $colunas){
									array_pop($linha);
								}
								$nota[] = array_combine($header, $linha);
							}
		
							if(isset($nota)){
								foreach($nota as $nt){
									if($nt["DESCRICAO"]){
										$produto = array(
											'id_cliente' => $this->session->userdata('logado')['id'],
											'ncm' => $nt["NCM"],
											'sku' => strtoupper($nt["SKU"]),
											'categoria' => isset($nt["CATEGORIA"]) ? $nt["CATEGORIA"] : 1,
											'descricao' => utf8_decode($nt["DESCRICAO"]),
											'preco' => str_replace(",",".",$nt["PRECO"]),
											'preco_promocional' => str_replace(",",".",$nt["PRECO PROMOCIONAL"]),
											'unidade' => isset($nt["UNIDADE"]) ? utf8_decode($nt["UNIDADE"]) : "Un.",
											'data_cadastro' => date("Y-m-d H:i:s")
										);
						
										$this->produtos_model->addProduto($produto);
									}
								}
							}
							
							fclose($handle);
						}
		
						header("Location: ".base_url("index.php/produtos"));
						exit;
					}
				}
			}

			$data = array(
				'title' => 'Pressla | Meus Produtos',
				'produtos' => $this->produtos_model->getProdutos(["produtos.id_cliente = ".$this->session->userdata('logado')['id'], $categoria != 0 && $categoria != -1 ? "produtos.categoria = ".$categoria : ($categoria == "0" ? "produtos.id IS NOT NULL" : "produtos.categoria = 0")], "produtos.descricao ASC"),
				'categoria_atual' => $categoria,
				'localPath' => 'produtos/produtos',
				'tamanhos' => $this->tamanhos_model->getTamanhos(),
				'templates' => $this->templates_model->getTiposTemplates(),
				'figuras' => [],
				'imgtemplates' => $this->templates_model->getTemplates(),
				'id' => $this->session->userdata('logado')['id'],
				'tipos' => $this->templates_model->getTipos()
			);
		}
		
		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath']);
		$this->load->view('produtos/script');
		$this->load->view('template/footer');
	}

	public function g(){
		// SUBIR ARQUIVOS EM MASSA
		$colunas = 8;
		if($this->input->method() === 'post'){
			if($_FILES != null){
				$arquivo = $_FILES['arquivoxml']["tmp_name"];
				$ext = pathinfo($_FILES['arquivoxml']['name'], PATHINFO_EXTENSION);

				$a = [];
				$contador = 0;
				
				if($ext == 'xml'){
                
					$link = $arquivo;
					//link do arquivo xml
					$xml = simplexml_load_file($link) -> Produto;

					foreach($xml as $item){
						array_push($a, [
							"".$contador++, 
							$item->DESCRICAO, 
							$item->NCM, 
							strtoupper($item->SKU), 
							str_replace(",",".",$item->PRECO), 
							str_replace(",",".",$item->PRECOPROMOCIONAL), 
							isset($item->UNIDADE) ? $item->UNIDADE : "Un", 
							isset($item->QUANTIDADE) ? $item->QUANTIDADE : 1]);
					}
				
				} else if($ext == "csv"){

					$handle = fopen($arquivo, "r");

					$header = fgetcsv($handle, 1000, ",");

					if(count($header) > 1){
						$separador = ",";
						$handle = fopen($arquivo, "r");
						$header = fgetcsv($handle, 1000, ";");
						$header = explode(",",utf8_encode($header[0]));
					} else if(mb_strpos(implode("-",$header), ";")) {
						$header = explode(";",utf8_encode($header[0]));
						$separador = ";";
					} else if(mb_strpos(implode("-",$header), "\t")) {
						$header = explode("\t",utf8_encode($header[0]));
						$separador = "\t";
					}

					while(count($header) > $colunas){
						array_pop($header);
					}

					while ($row = fgetcsv($handle, 1000, $separador == "," ? ";" : "\n")) {
						$linha = explode($separador, utf8_encode($row[0]));
						while(count($linha) > $colunas){
							array_pop($linha);
						}
						$nota[] = array_combine($header, $linha);
					}

					if(isset($nota)){
						foreach($nota as $nt){
							if(isset($nt["DESCRICAO"])){
								array_push($a, [
									"".$contador++, 
									utf8_decode($nt["DESCRICAO"]), 
									$nt["NCM"], 
									strtoupper($nt["SKU"]), 
									number_format(floatval(str_replace(",",".",$nt["PRECO"])), 2, ".", ""), 
									number_format(floatval(str_replace(",",".",$nt["PRECO PROMOCIONAL"])), 2, ".", ""), 
									isset($nt["UNIDADE"]) ? utf8_decode($nt["UNIDADE"]) : "Un", 
									isset($nt["QUANTIDADE"]) ? $nt["QUANTIDADE"] : 1
								]);
							}
						}
					}
					
					fclose($handle);
				}

				echo json_encode(array("status" => "ok", "msg" => "Sucesso", "dados" => $a));
            } else {
				echo json_encode(array("status" => "error", "msg" => "Nenhum arquivo enviado"));
			}
		} else {
			echo json_encode(array("status" => "error", "msg" => "Nenhum dado enviado"));
		}
	}
	
	public function cartazesmassa() {
		$data = array(
			'title' => 'Pressla | Meus Produtos',
			'localPath' => 'produtos/produtos_p',
			'produtos' => $this->produtos_model->getProdutos(["id_cliente = ".$this->session->userdata('logado')['id']], "descricao ASC"),
			'tamanhos' => $this->tamanhos_model->getTamanhos(),
			'templates' => $this->templates_model->getTiposTemplates(),
			'figuras' => $this->figuras_model->getFiguras(),
			'imgtemplates' => $this->templates_model->getTemplates(),
			'id' => $this->session->userdata('logado')['id'],
			'tipos' => $this->templates_model->getTipos()
		);

		$ar = explode(",-,", $this->input->post('produtosselecionados'));
		$a = [];

		foreach($ar as $r){
			$ar_temp = explode("<|>", $r);
			array_push($ar_temp, "Oferta válida enquanto durarem nossos estoques");
			array_push($ar_temp, 1);
			array_push($a, $ar_temp);
		}

		$data['produtosselecionados'] = json_encode($a);

		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath']);
		$this->load->view('produtos/script');
		$this->load->view('template/footer');
	}

	public function cadastro($id = null, $view = true) {
		if($view){
			$data = array(
				'title' => 'Pressla | Meus Produtos',
				'localPath' => 'produtos/cadprodutos',
				'categorias' => $this->templates_model->getTiposTemplates(),
			);
		}

		if ($this->input->method() === 'post') {
			$produto = array(
				'id_cliente' => $this->session->userdata('logado')['id'],
				'ncm' => $this->input->post('ncm'),
				'sku' => strtoupper($this->input->post('sku')),
				'categoria' => $this->input->post('categoria') ? $this->input->post('categoria') : 1,
				'descricao' => $this->input->post('descricao'),
				'preco' => str_replace(",", ".", $this->input->post('preco')),
				'preco_promocional' => str_replace(",", ".", $this->input->post('preco_promocional')),
				'unidade' => $this->input->post('unidade') ? $this->input->post('unidade') : "Un.",
				'data_cadastro' => date("Y-m-d H:i:s")
			);

			if($id){
				unset($produto['id_cliente']);
				unset($produto['data_cadastro']);
				$produto['linha1'] = null;
				$produto['linha2'] = null;
				$produto['linha3'] = null;
				
				if($this->produtos_model->updateProduto($id, $produto)){
					$data["mensagem"] = "alerta-sucesso-atualizacao";
				} else {
					$data["mensagem"] = "alerta-erro";
				}
			} else {
				$produto['data_ultima_atualizacao'] = date("Y-m-d H:i:s");
				if($resposta = $this->produtos_model->addProduto($produto)){
					// $id = $resposta;
					$data["mensagem"] = "alerta-sucesso";
				} else {
					$data["mensagem"] = "alerta-erro";
				}
			}
		}

		if($view){

			if($prod = $this->produtos_model->getProduto($id, ["id_cliente = ".$this->session->userdata('logado')['id']])){
			
				$data['dados'] = $prod;
			
			} else if($id){

				$data["localPath"] = 'produtos/produto_dined';

			}
			
			$this->load->view('template/header', $data);
			$this->load->view('template/menu');
			$this->load->view($data['localPath']);
			$this->load->view('template/footer');
		} else {
			echo isset($data["mensagem"]) ? $data["mensagem"] : "erro";
		}
	}

	public function excluir() {
		if ($this->input->post('id')) {
			$id = $this->input->post('id');
			if (!$this->produtos_model->deleteProduto($id)) {
				echo 'erro-500';
			}
		} else {
			echo 'erro-500';
		}
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
