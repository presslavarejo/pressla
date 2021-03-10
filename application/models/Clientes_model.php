<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class Clientes_model extends CI_model

{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /**

     * CREATE

     */
    public function addCliente($cliente) {
        if ($this->db->insert('clientes', $cliente)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    /**

     * READ

     */
    public function getClientes($id = null) {
        if ($id == null) {
            return $this->db->get('clientes c')->result();
        } else {
            $this->db->where('c.id', $id);
            return $this->db->get('clientes c')->row();
        }
    }
    /**
     * UPDATE
     */
    public function updateCliente($id, $cliente) {
        $this->db->where('id', $id);
        return $this->db->update('clientes', $cliente);
    }
    /**
     * DELETE
     */
    public function deleteCliente($id) {
        $this->db->where('id', $id);
        return $this->db->delete('clientes');
    }

    /**

     * Functions

     */
    public function checkFechamento($id){
        $this->db->where('id', $id);
        $cliente = $this->db->get('clientes')->row();

        $ultima = ($cliente->ultima == NULL || $cliente->ultima == "0000-00-00" ? $cliente->data_inserido : $cliente->ultima);
        $ultima = explode('-',$ultima);
        $dia = intval($cliente->fechamento) < 10 ? "0".$cliente->fechamento : $cliente->fechamento;

        $especifica = $ultima[0].'-'.$ultima[1].'-'.$dia;
        $timestamp1 = strtotime($especifica);
        $timestamp2 = strtotime('+1 month', $timestamp1);

        if(date("Y-m-d") >= date('Y-m-d', $timestamp2)){
            $this->db->set('ultima', date('Y-m-d'));
            if($cliente->usadas >= 10){
                $this->db->set('impressoes', 'impressoes+10', FALSE);
            } else {
                $this->db->set('impressoes', 'impressoes+'.$cliente->usadas, FALSE);
            }
            $this->db->set('usadas', 0);
            $this->db->where('id', $id);
            return $this->db->update('clientes');
        }
    }

    public function checkImpressoesUsadas($id){
        $this->db->where('id', $id);
        $cliente = $this->db->get('clientes')->row();
        
        return $cliente->impressoes > 0;
    }

    public function contarImpressaoUsada($id){
        $this->db->set('usadas', 'usadas+1', FALSE);
        $this->db->set('impressoes', 'impressoes-1', FALSE);
        $this->db->where('id', $id);
        return $this->db->update('clientes');
    }
}