<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_model extends CI_model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /**

     * CREATE

     */
    public function addProduto($produto) {
        $this->db->insert('produtos', $produto);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }
    /**

     * READ

     */
    public function getProdutos($where = null, $order = null) {
        if($where){
            foreach($where as $w){
                $this->db->where($w);        
            }
        }
        if($order){
            $this->db->order_by($order);        
        }
        $this->db->select("produtos.*, template_tipo.tipo as nome_categoria");
        $this->db->join("template_tipo", "produtos.categoria = template_tipo.id", "left");
        return $this->db->get('produtos')->result();
    }

    public function getProduto($id, $where = null) {
        $this->db->where('id', $id);
        if($where){
            foreach($where as $w){
                $this->db->where($w);        
            }
        }
        return $this->db->get('produtos')->row();
    }

    public function getProdutoPorNome($nome) {
        $this->db->where('nome', $nome);
        return $this->db->get('produtos')->row();
    }
    /**

     * UPDATE

     */
    public function updateProduto($id, $produto) {
        $this->db->where('id', $id);
        return $this->db->update('produtos', $produto);
    }

    public function updateCampoProdutosMassa($array_alt, $ids) {
        $this->db->where('id IN ('.$ids.')');
        return $this->db->update('produtos', $array_alt);
    }
    /**

     * DELETE

     */
    public function deleteProduto($id) {
        $this->db->where('id', $id);
        return $this->db->delete('produtos');
    }

    public function deleteProdutosMassa($ids) {
        $this->db->where('id IN ('.$ids.')');
        return $this->db->delete('produtos');
    }
}