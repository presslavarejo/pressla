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
		return $this->db->get('figuras')->result();
    }	

    public function getFigura($id) {
        $this->db->where('id', $id);
		return $this->db->get('figuras')->row();
    }	
    /**

     * UPDATE

     */
    public function updateFigura($id, $figura) {
        $this->db->where('id', $id);
        return $this->db->update('figuras', $figura);
    }
    /**
     * DELETE
    */
    public function deleteFigura($id) {
        $this->db->where('id', $id);
        return $this->db->delete('figuras');
    }
}