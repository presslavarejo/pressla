<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Figuras_model extends CI_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /**
     * CREATE
     */
    public function addFigura($figura) {
        return $this->db->insert('figuras', $figura);
    }
	/**
     * READ
     */
    public function getFiguras() {
        $this->db->order_by('nome');
        if($this->session->userdata('logado')['tipo'] == 2){
            $this->db->where('id_cliente', $this->session->userdata('logado')['id']);
        }
		return $this->db->get('figuras')->result();
    }
    
    public function getFigurasCriar() {
        $this->db->order_by('nome');
        if($this->session->userdata('logado')['tipo'] == 2){
            $this->db->where('id_cliente = '.$this->session->userdata('logado')['id']." OR id_cliente = 0");
        }
		return $this->db->get('figuras')->result();
    }

    public function getFigura($id) {
        $this->db->where('id', $id);
        if($this->session->userdata('logado')['tipo'] == 2){
            $this->db->where('id_cliente', $this->session->userdata('logado')['id']);
        }
		return $this->db->get('figuras')->row();
    }	
    /**

     * UPDATE

     */
    public function updateFigura($id, $figura) {
        $this->db->where('id', $id);
        if($this->session->userdata('logado')['tipo'] == 2){
            $this->db->where('id_cliente', $this->session->userdata('logado')['id']);
        }
        return $this->db->update('figuras', $figura);
    }
    /**
     * DELETE
    */
    public function deleteFigura($id) {
        $this->db->where('id', $id);
        if($this->session->userdata('logado')['tipo'] == 2){
            $this->db->where('id_cliente', $this->session->userdata('logado')['id']);
        }
        return $this->db->delete('figuras');
    }
}