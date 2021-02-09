<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historico_model extends CI_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
	}
	/**
     * READ
     */
    public function getLinha($id_cliente, $linha) {
        $this->db->select('produto');
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('linha', $linha);
        $this->db->order_by('produto');
		return $this->db->get('historico_produtos')->result();
    }	
    
    public function setLinha($produto) {
        return $this->db->insert('historico_produtos', $produto);
    }	
    
    public function produtoExiste($produto, $linha, $id_cliente) {
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('linha', $linha);
        $this->db->where('produto', $produto);
		if($this->db->get('historico_produtos')->row()){
            return true;
        } else {
            return false;
        }
	}	
}