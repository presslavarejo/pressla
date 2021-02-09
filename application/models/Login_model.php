<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('clientes_model');
	}	
	/**
     * READ
     */
    public function getLogin($usuario, $senha) {
		$this->db->where('login', $usuario);
		$this->db->where('ativo', 1);
        $usuario = $this->db->get('clientes')->row();
        if($usuario){
            if ($senha === $this->encryption->decrypt($usuario->senha)) {
                return $usuario;
            } else {
                return false;
            }
        } else {
            return false;
        }
	}
	
	public function getTipos($id = null) {
        if ($id == null) {
            return $this->db->get('usuario_tipo u')->result();
        } else {
            $this->db->where('u.id', $id);
            return $this->db->get('usuario_tipo u')->row();
        }
    }

    /**
     * Functions
     */
    public function verificarLogin() {
        $login = $this->session->userdata('logado');
        if (isset($login['id'])) {
            $this->db->where('login', $login['login']);
			$this->db->where('ativo', 1);
            if (!$this->db->get('clientes')->row()) {
                $this->deslogar();
            }
        } else {
            $this->deslogar();
        }
    }
    
    public function checkAdmin($bool = null) {
		$usuario_id = $this->session->userdata('logado')['id'];
		$usuarioDb = $this->clientes_model->getClientes($usuario_id);
		if ($usuarioDb) {
			if ($usuarioDb->tipo == 1) {
				return true;
			}
        }
        if($bool){
            return false;
        } else {
            header('Location: '.base_url('index.php/dashboard'));
            exit;
        }
	}
	
	public function deslogar() {
        $this->session->unset_userdata('logado');
        header('Location: '.base_url('index.php/login'));
        exit;
    }
}
