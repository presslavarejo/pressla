<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meuscontatos_model extends CI_model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /**

     * CREATE

     */
    public function addcontato($contato) {
        $this->db->insert('meus_contatos', $contato);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }
    /**

     * READ

     */
    public function getcontatos($where = null, $order = null) {
        if($where){
            foreach($where as $w){
                $this->db->where($w);        
            }
        }
        if($order){
            $this->db->order_by($order);        
        }
        
        return $this->db->get('meus_contatos')->result();
    }

    public function getcontato($id, $where = null) {
        $this->db->where('id', $id);
        if($where){
            foreach($where as $w){
                $this->db->where($w);        
            }
        }
        return $this->db->get('meus_contatos')->row();
    }

    public function getQuery($query){
        return $this->db->query($query)->result();
    }
    /**

     * UPDATE

     */
    public function updatecontato($id, $contato) {
        $this->db->where('id', $id);
        return $this->db->update('meus_contatos', $contato);
    }

    public function updateCampocontatosMassa($array_alt, $ids) {
        $this->db->where('id IN ('.$ids.')');
        return $this->db->update('meus_contatos', $array_alt);
    }
    /**

     * DELETE

     */
    public function deletecontato($id) {
        $this->db->where('id', $id);
        return $this->db->delete('meus_contatos');
    }

    public function deletecontatosMassa($ids) {
        $this->db->where('id IN ('.$ids.')');
        return $this->db->delete('meus_contatos');
    }
}