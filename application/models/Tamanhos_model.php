<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tamanhos_model extends CI_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
	}
	/**
     * READ
     */
    public function getTamanhos() {
		return $this->db->get('tamanhos')->result();
	}	
}