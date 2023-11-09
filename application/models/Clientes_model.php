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

    public function addLog($texto) {
        return $this->db->insert('log_testes', $texto);
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

    public function getJoin($where = null, $order = null, $select = null, $join = null, $limit = null, $group_by = null, $mult = true) {
        if($where){
            foreach($where as $w){
                $this->db->where($w);
            }
        }
        if($order){
            foreach($order as $o){
                $this->db->order_by($o[0], $o[1]);
            }
        }
        if($select){
            $this->db->select($select);
        }
        if($join){
            foreach($join as $j){
                $this->db->join($j[0], $j[1], $j[2]);
            }
        }
        if($limit){
            $this->db->limit($limit);
        }
        if($group_by){
            $this->db->group_by($group_by);
        }

        if($mult){
            return $this->db->get("clientes as c")->result();
        } else {
            return $this->db->get("clientes as c")->row();
        }
    }

    public function verificaCnpj($cnpj){
        $clientes = $this->getClientes();
        $temCliente = false;
        foreach($clientes as $cliente){
            if(str_replace(array(".", "/", "-", ",", " "), "", $cliente->cnpj) == str_replace(array(".", "/", "-", ",", " "), "", $cnpj)){
                $temCliente = true;
                break;
            }
        }
        return $temCliente;
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

        if(date("Y-m-d") >= date('Y-m-d', $timestamp2) && $cliente->cad_novo == 0){
            $dados_historico = array(
                'id_usuario' => $id,
                'quantidade' => $cliente->usadas,
                'data_de' => $cliente->ultima,
                'data_ate' => date('Y-m-d'),
            );

            $this->db->insert('historico_impressoes', $dados_historico);

            $this->db->set('ultima', date('Y-m-d'));
            // if($cliente->usadas >= 10){
            //     $this->db->set('impressoes', 'impressoes+10', FALSE);
            // } else {
            //     $this->db->set('impressoes', 'impressoes+'.$cliente->usadas, FALSE);
            // }
            
            // EXPIRANDO TUDO E ENTRANDO OS 10 GRATUITOS
            $this->db->set('impressoes', '10', FALSE);
            
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

    public function checkImpressoesUsadasNum($id){
        $this->db->select('impressoes,assinatura');
        $this->db->where('id', $id);
        $cliente = $this->db->get('clientes')->row();

        if($cliente->assinatura == 2){
            return "1000000000";
        } else {
            return $cliente->impressoes;
        }
    }

    public function contarHistoricoImpressao($id, $quantidade){
        return $this->db->insert('new_historico_impressoes', array(
            "id_usuario" => $id,
            "quantidade" => $quantidade,
            "data_hora_impressao" => date("Y-m-d H:i:s")
        ));
    }

    public function contarImpressaoUsada($id){
        $this->db->where('id', $id);
        $cliente = $this->db->get('clientes')->row();

        $this->db->set('usadas', 'usadas+1', FALSE);
        if($cliente->assinatura != 2){
            $this->db->set('impressoes', 'impressoes-1', FALSE);
        } else {
            $this->db->set('impressoes', '10', FALSE);
        }
        $this->db->where('id', $id);
        return $this->db->update('clientes');
    }

    public function contarImpressaoUsadaNum($id,$num){
        $this->db->where('id', $id);
        $cliente = $this->db->get('clientes')->row();

        $this->db->set('usadas', 'usadas+'.$num, FALSE);
        if($cliente->assinatura != 2){
            $this->db->set('impressoes', 'impressoes-'.$num, FALSE);
        } else {
            $this->db->set('impressoes', '10', FALSE);
        }
        $this->db->where('id', $id);
        return $this->db->update('clientes');
    }

    public function verificaClienteCnpj($id, $cnpj){
        $this->db->where('cnpj', $cnpj);
        $this->db->where('id != '.$id);
        $cliente = $this->db->get('clientes')->row();

        if($cliente){
            return "error";
        } else {
            return "200";
        }
    }

    public function getHistorico($filtro){
        $this->db->select('h.*, c.nome');
        $this->db->where('h.data_de > (NOW() - INTERVAL '.$filtro.' MONTH)');
        $this->db->join('clientes as c', 'h.id_usuario = c.id', 'LEFT');
        return $this->db->get('historico_impressoes as h')->result();
    }

    public function getHistoricoImpressoes($de, $ate, $cliente, $resumido){
        $this->db->where('h.data_hora_impressao >= "'.$de.' 00:00:00" AND h.data_hora_impressao <= "'.$ate.' 23:59:59"');
        if($cliente != 0){
            $this->db->where('h.id_usuario = '.$cliente);
        }
        $this->db->join('clientes as c', 'h.id_usuario = c.id', 'LEFT');
        if($resumido){
            $this->db->select('h.id_usuario, SUM(h.quantidade) as quantidade, c.nome');
            $this->db->group_by('h.id_usuario');
        } else {
            $this->db->select('h.id_usuario, h.quantidade, h.data_hora_impressao, c.nome');
        }
        return $this->db->get('new_historico_impressoes as h')->result();
    }
}