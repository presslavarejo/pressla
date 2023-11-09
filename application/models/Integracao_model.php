<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Integracao_model extends CI_model

{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /**

     * CREATE

     */
    public function addIntegracao($dados) {
        if ($this->db->insert('integracao_wpp', $dados)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    /**

     * READ

     */
    public function get($id = null) {
        if ($id == null) {
            $this->db->select('c.nome as nome_cliente, integracao_wpp.*');
            $this->db->join('clientes as c', 'integracao_wpp.cliente = c.id', "inner");

            return $this->db->get('integracao_wpp')->result();
        } else {
            $this->db->where('cliente', $id);
            return $this->db->get('integracao_wpp')->row();
        }
    }

    public function getConfig() {
        $this->db->where('id = 1');
        return $this->db->get('integracao_wpp_config')->row();
    }
    /**
     * UPDATE
     */
    public function updateIntegracao($id, $cliente) {
        $this->db->where('id', $id);
        return $this->db->update('integracao_wpp', $cliente);
    }

    public function updateIntegracaoConf($conf) {
        $this->db->where('id = 1');
        return $this->db->update('integracao_wpp_config', $conf);
    }
    /**
     * DELETE
     */
    public function deleteIntegracao($id) {
        $this->db->where('id', $id);
        return $this->db->delete('integracao_wpp');
    }
}