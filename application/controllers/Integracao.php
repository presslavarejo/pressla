<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Integracao extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('integracao_model');
		$this->load->model('clientes_model');
		$this->load->model('meuscontatos_model');
		$this->login_model->verificarLogin();
    }

	public function index() {
		$data = array(
            'title' => 'Pressla | Integração',
            'localPath' => 'integracao/integracao',
            'id' => $this->session->userdata('logado')['id']
        );

		$integracao = $this->integracao_model->get($data['id']);
		$cliente = $this->clientes_model->getClientes($data['id']);
		$integracao_config = $this->integracao_model->getConfig();

		if(!$integracao){
			$dados = array(
				"cliente" => $cliente->id,
				"nome" => explode("@", $cliente->login)[0],
				"token" => md5($cliente->id.date("YmdHis"))
			);

			$this->integracao_model->addIntegracao($dados);
			header("Location: ".base_url("index.php/integracao"));
			exit;
		
		} else {
			$url = $integracao_config->url_api.'/';
			$dd = ['id' => $integracao->nome, 'token' => $integracao->token];
			$get = 'status-sessao';

			$curl = curl_init();

			curl_setopt_array($curl, [
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => $url.$get,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => $dd
			]);
			
			$response = curl_exec($curl);

			curl_close($curl);

			$response = json_decode($response);

			if(!$response->status){
				$get = 'criar-sessao';

				$curl = curl_init();

				curl_setopt_array($curl, [
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => $url.$get,
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => $dd
				]);
				
				$response = curl_exec($curl);

				curl_close($curl);
			}

			$data['qrcode'] = $this->buscaQrCode(str_rot13($integracao->nome));
			$data['sessao'] = $integracao->nome;
		}

		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath']);
		$this->load->view('template/footer');
	}

	public function echoQrCode($nome, $token){
		if($nome && $token){

			$cliente = array(
				'sessao' => $nome,
				'token' => $token
			);

			$this->clientes_model->updateCliente($this->session->userdata('logado')['id'], $cliente);
			echo $this->buscaQrCode($nome);
		} else {
			echo json_encode(array("status" => false, "msg" => "Você não possui credenciais para se integrar com whatsapp. Procure um administrador!"));
		}
	}

	public function buscaQrCode($nome){
		$integracao_config = $this->integracao_model->getConfig();

		$get = '';

		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $integracao_config->url_qrcode,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => ["button2" => 1, "sessaoScan" => $nome]
		]);
		
		$response = curl_exec($curl);

		curl_close($curl);

		$response = explode("<body>", $response);
		$response = explode("<hr>", $response[1])[0];

		return json_encode(array("status" => true, "msg" => $response));
	}

	public function verDadosIntegracao(){
		$integracao_config = $this->integracao_model->getConfig();
		$integracao = $this->integracao_model->get($this->session->userdata('logado')['id']);

		if($integracao) {
			echo json_encode(array("status" => true, "nome" => $integracao->nome, "token" => $integracao->token));
		} else {
			// SE NÃO TEM INTEGRAÇÃO, A GENTE CRIA
			$cliente = $this->clientes_model->getClientes($this->session->userdata('logado')['id']);
			$dados = array(
				"cliente" => $cliente->id,
				"nome" => explode("@", $cliente->login)[0],
				"token" => md5($cliente->id.date("YmdHis"))
			);

			if($this->integracao_model->addIntegracao($dados)){
				$url = $integracao_config->url_api.'/';
				$dd = ['id' => $dados['nome'], 'token' => $dados['token']];
				$get = 'status-sessao';

				$curl = curl_init();

				curl_setopt_array($curl, [
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => $url.$get,
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => $dd
				]);
				
				$response = curl_exec($curl);

				curl_close($curl);

				$response = json_decode($response);

				if(!$response->status){
					$get = 'criar-sessao';

					$curl = curl_init();

					curl_setopt_array($curl, [
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => $url.$get,
						CURLOPT_POST => 1,
						CURLOPT_POSTFIELDS => $dd
					]);
					
					$response = curl_exec($curl);

					curl_close($curl);
				}

				if($response->status){
					echo json_encode(array("status" => true, "nome" => $dados['nome'], "token" => $dados['token']));
				} else {
					echo json_encode(array("status" => false, "msg" => "O serviço do Whatsapp não funcionou como o esperado. Tente integrar-se pelo módulo Integração no menu lateral."));
				}
			} else {
				echo json_encode(array("status" => false, "msg" => "Não foi possível criar os dados de integração no servidor"));
			}
		}
	}

	public function enviarCartaz(){
		$integracao_config = $this->integracao_model->getConfig();
		$integracao_cliente = $this->clientes_model->getClientes($this->session->userdata('logado')['id']);

		$contatos = $this->meuscontatos_model->getQuery("SELECT nome, telefone FROM meus_contatos WHERE grupo IN ('".implode("','",$this->input->post('telefones'))."') AND id_cliente = ".$this->session->userdata('logado')['id']);

		if($this->input->method() === "post"){
			// CRIA O ARQUIVO DO CARTAZ
			// obtém o conteúdo base64 da imagem
			$content = str_replace("data:image/png;base64,", "", $this->input->post('imagem'));

			// decodifica o conteúdo base64
			$decoded = base64_decode($content);

			// gera um nome de arquivo aleatório
			$url_envio = uniqid() . '.jpg';
			$filename = APPPATH . "../assets/temp/" . $url_envio;

			// salva o arquivo no servidor
			file_put_contents($filename, $decoded);

			if($integracao_cliente){
				$ok = false;
				$erros = array();
				$url = $integracao_config->url_api."/";

				// $telefones = $this->input->post('telefones');

				foreach($contatos as $contato){
					sleep(rand($this->input->post('min'), $this->input->post('max')));
					$dd = [
						'sender' => $integracao_cliente->sessao, 
						'token' => $integracao_cliente->token, 
						'user' => "55".$contato->telefone,
						'caption' => str_replace("*{nome}", $contato->nome, $this->input->post('mensagem')),
						'file' => base_url("assets/temp/".$url_envio)
					];
					
					$get = 'send-media';
		
					$curl = curl_init();
		
					curl_setopt_array($curl, [
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => $url.$get,
						CURLOPT_POST => 1,
						CURLOPT_POSTFIELDS => $dd
					]);
					
					$response = curl_exec($curl);
		
					curl_close($curl);
				}
	
				echo json_encode(array("status" => true));
			}

			if (file_exists($filename)) {
				unlink($filename);
			}
		}
	}
}
