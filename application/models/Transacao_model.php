<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transacao_model extends CI_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /**
     * CREATE
     */
    public function addTransacao($transacao) {
        return $this->db->insert('transacoes', $transacao);
    }

    public function addLog($descricao) {
        return $this->db->insert('log_transacoes', $descricao);
    }
	/**
     * READ
     */
    public function getTransacao($ref) {
        $this->db->where('ref', $ref);
		return $this->db->get('transacoes')->row();
    }	

    public function getAlertas($id_cliente) {
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('lido', 0);
		return $this->db->get('transacoes')->result();
    }	
    /**

     * UPDATE

     */
    public function updateTransacao($ref, $transacao) {
        $this->db->where('ref', $ref);
        return $this->db->update('transacoes', $transacao);
    }

    public function updateLido($id) {
        $transacao = array('lido' => 1);
        $this->db->where('id', $id);
        return $this->db->update('transacoes', $transacao);
    }

    public function liberaItens($id_cliente,$quantidade){
        $this->db->where('id', $id_cliente);
        $this->db->set('impressoes', 'impressoes+'.$quantidade, FALSE);
        $this->db->update('clientes');
    }
}