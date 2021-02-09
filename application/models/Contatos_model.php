<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contatos_model extends CI_model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /**

     * CREATE

     */
    public function addContato($contato) {
        return $this->db->insert('contatos', $contato);
    }
    /**

     * READ

     */
    public function getContatos() {
        return $this->db->get('contatos')->result();
    }

    public function getContato($id) {
        $this->db->where('id', $id);
        return $this->db->get('contatos')->row();
    }

    public function getContatoPorNome($nome) {
        $this->db->where('nome', $nome);
        return $this->db->get('contatos')->row();
    }
    /**

     * UPDATE

     */
    public function updateContato($id, $contato) {
        $this->db->where('id', $id);
        return $this->db->update('contatos', $contato);
    }
    /**

     * DELETE

     */
    public function deleteContato($id) {
        $this->db->where('id', $id);
        return $this->db->delete('contatos');
    }
}