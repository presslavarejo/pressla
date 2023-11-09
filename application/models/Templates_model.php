<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Templates_model extends CI_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /**
     * CREATE
     */
    public function addTemplate($template) {
        return $this->db->insert('templates', $template);
    }

    public function addTipoTemplate($template_tipo) {
        return $this->db->insert('template_tipo', $template_tipo);
    }
	/**
     * READ
     */
    public function getTiposTemplates() {
        $this->db->order_by('tipo');
        return $this->db->get('template_tipo')->result();
    }	

    public function getTiposTemplate($id) {
        $this->db->where('id', $id);
        return $this->db->get('template_tipo')->row();
    }	
	
	public function getTipos() {
        return $this->db->query("SELECT DISTINCT layout, (SELECT GROUP_CONCAT(DISTINCT temp1.ids_tipos SEPARATOR ', ') FROM templates as temp1 WHERE temp1.layout = temp2.layout) as tipos_ids FROM templates as temp2")->result();
    }
    
    public function getTemplates($tab = null) {
        if($tab){
            $this->db->where('tabloid', $tab);    
        }
        $this->db->order_by('nome');
		return $this->db->get('templates')->result();
    }	

    public function getTemplate($id) {
        $this->db->where('id', $id);
		return $this->db->get('templates')->row();
    }	

    public function getLogo($id) {
        $this->db->where('id', $id);
		return $this->db->get('clientes')->row();
    }	
    /**

     * UPDATE

     */
    public function updateTemplate($id, $template) {
        $this->db->where('id', $id);
        return $this->db->update('templates', $template);
    }

    public function updateTipoTemplate($id, $template_tipo) {
        $this->db->where('id', $id);
        return $this->db->update('template_tipo', $template_tipo);
    }
    /**
     * DELETE
    */
    public function deleteTemplate($id) {
        $this->db->where('id', $id);
        return $this->db->delete('templates');
    }

    public function deleteTipoTemplate($id) {
        $this->db->where('id', $id);
        return $this->db->delete('template_tipo');
    }
}