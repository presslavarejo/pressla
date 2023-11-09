<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meuscontatos extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('meuscontatos_model');
		$this->login_model->verificarLogin();
    }

	public function index() {
		// SUBIR ARQUIVOS EM MASSA
		$colunas = 4;
		if($this->input->method() === 'post'){
			// EXCLUI EM MASSA
			if($this->input->post('acao') && $this->input->post('acao') == "excluir_massa" && $this->input->post('contatos_selecionados_modal')){
				$this->meuscontatos_model->deletecontatosMassa($this->input->post('contatos_selecionados_modal'));
			}

			// ALTERA EM MASSA
			else if($this->input->post('acao') && $this->input->post('acao') == "alterar_massa" && $this->input->post('contatos_selecionados_modal')){
				$this->meuscontatos_model->updateCampocontatosMassa(array('grupo' => $this->input->post('grupo_modal')), $this->input->post('contatos_selecionados_modal'));
			}

			else {
				if($_FILES != null){
					$arquivo = $_FILES['arquivoxml']["tmp_name"];
					$ext = pathinfo($_FILES['arquivoxml']['name'], PATHINFO_EXTENSION);
					
					if($ext == "csv"){
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
								if($nt["NOME"]){
									$tel = str_replace(['(',')','+55',' ','-'], '', $nt["WHATSAPP"] ? $nt["WHATSAPP"] : "");
									$tel = strpos($tel, "55") === 0 ? substr($tel, 2) : $tel;

									$contato = array(
										'id_cliente' => $this->session->userdata('logado')['id'],
										'nome' => utf8_decode($nt["NOME"]),
										'telefone' => $tel,
										'email' => $nt["EMAIL"] ? $nt["EMAIL"] : '',
										'grupo' => $nt["LISTA"] ? $nt["LISTA"] : 'Geral'
									);
					
									$this->meuscontatos_model->addcontato($contato);
								}
							}
						}
						
						fclose($handle);
					}
	
					header("Location: ".base_url("index.php/meuscontatos"));
					exit;
				}
			}
		}

		$data = array(
            'title' => 'Pressla | Meus Contatos',
            'localPath' => 'meuscontatos/contatos',
            'contatos' => $this->meuscontatos_model->getcontatos(["id_cliente = ".$this->session->userdata('logado')['id']], "nome ASC"),
			'id' => $this->session->userdata('logado')['id']
        );

		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath']);
		$this->load->view('meuscontatos/script');
		$this->load->view('template/footer');
	}

	public function cadastro($id = null, $view = true) {
		$data = array(
			'title' => 'Pressla | Meus Contatos',
			'localPath' => 'meuscontatos/cadcontatos'
		);

		if ($this->input->method() === 'post') {
			$tel = str_replace(['(',')','+55',' ','-'], '', $this->input->post('telefone') ? $this->input->post('telefone') : "");
			$tel = strpos($tel, "55") === 0 ? substr($tel, 2) : $tel;
			
			$contato = array(
				'id_cliente' => $this->session->userdata('logado')['id'],
				'nome' => $this->input->post('nome'),
				'email' => $this->input->post('email') ? $this->input->post('email') : "",
				'grupo' => $this->input->post('grupo'),
				'telefone' => $tel
			);

			if($id){
				unset($contato['id_cliente']);
				
				if($this->meuscontatos_model->updatecontato($id, $contato)){
					$data["mensagem"] = "alerta-sucesso-atualizacao";
				} else {
					$data["mensagem"] = "alerta-erro";
				}
			} else {
				if($resposta = $this->meuscontatos_model->addcontato($contato)){
					$data["mensagem"] = "alerta-sucesso";
				} else {
					$data["mensagem"] = "alerta-erro";
				}
			}
		}

		$data['dados'] = $this->meuscontatos_model->getcontato($id, ["id_cliente = ".$this->session->userdata('logado')['id']]);
		$data['grupos'] = $this->meuscontatos_model->getQuery("SELECT DISTINCT grupo FROM meus_contatos WHERE id_cliente = ".$this->session->userdata('logado')['id']." ORDER BY grupo ASC");

		$this->load->view('template/header', $data);
		$this->load->view('template/menu');
		$this->load->view($data['localPath']);
		$this->load->view('template/footer');
	}

	public function excluir() {
		if ($this->input->post('id')) {
			$id = $this->input->post('id');
			if (!$this->meuscontatos_model->deletecontato($id)) {
				echo 'erro-500';
			}
		} else {
			echo 'erro-500';
		}
	}

	public function buscaContatos(){
		echo json_encode($this->meuscontatos_model->getcontatos(["id_cliente = ".$this->session->userdata('logado')['id']], "nome ASC"));
	}

	public function buscaGruposContatos(){
		echo json_encode($this->meuscontatos_model->getQuery("SELECT DISTINCT grupo FROM meus_contatos WHERE id_cliente = ".$this->session->userdata('logado')['id']." ORDER BY grupo ASC"));
	}
}
