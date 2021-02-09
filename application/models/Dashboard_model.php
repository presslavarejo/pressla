<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * READ
     */
    public function countProcessosStatus($status = null) {
        $processos = $this->db->get('processos')->result();
        $resposta = [];
        if ($status != null) {
            foreach($processos as $processo) {
                $statusProcesso = $this->getLastStatusProcesso($processo->id);
                if (isset($statusProcesso->status_id) && $statusProcesso->status_id == $status) {
                    array_push($resposta, $processo);
                }
            }
        } else {
            $resposta = $processos;
        }
        return count($resposta);
    }

    public function countProcessosFase($fase = null) {
        if ($fase != null) {
            if ($fase == 3) {
                $this->db->where('fase_espelhamento', 1);
                $this->db->where('fase <', 5);
            } else {
                $this->db->where('fase', $fase);
            }
        }
        return $this->db->count_all_results('processos');
    }

    public function countProcessosDataChegada() {
		$this->db->where("data_chegada <= CURDATE() AND data_chegada != '0000-00-00'");
		$this->db->where('fase < 5');
        return $this->db->count_all_results('processos');
    }

    public function countEquipamentosStatus($status = null) {
        if ($status != null) {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results('equipamentos');
    }

    public function countEquipamentosLocalizacao($localizacao = null) {
        if ($localizacao != null) {
            $this->db->where('localizacao', $localizacao);
        }
        return $this->db->count_all_results('equipamentos');
    }

    /**
     * Functions
     */
    private function getLastStatusProcesso($processo) {
        $this->db->where('processo_id', $processo);
        $this->db->limit(1);
        $this->db->order_by('id', 'DESC');
        return $this->db->get('processo_status')->row();
    }

}
