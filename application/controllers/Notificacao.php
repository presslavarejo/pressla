<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacao extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('transacao_model');
    }

	public function index() {
        // $dataUpdate = array(
        //     'situacao' => "APROVADO",
        //     'ultima_atualizacao' => date("Y-m-d H:i:s")
        // );
        // $this->transacao_model->updateTransacao($_GET["id"], $dataUpdate);
        // if($transa = $this->transacao_model->getTransacao($_GET["id"])){
        //     $this->transacao_model->liberaItens($transa->id_cliente,$transa->quantidade);
        // }
        MercadoPago\SDK::setAccessToken("TEST-5999412981018379-020306-27863709b5a3277790c87de708a52342-150651446");
        //MercadoPago\SDK::setAccessToken('TOKEN_DE_PRODUCAO');
        
        $payment = MercadoPago\Payment::find_by_id($_GET["data_id"]);

        $retorno = "Recebeu retorno em ".date("Y-m-d H:i:s")." sobre o ID = ".$_GET["data_id"]." e Referência Externa = ".$payment->{'external_reference'}." informando que o status é ".$payment->{'status'}." Detalhe = ".$payment->{'status_detail'};
        
        $this->transacao_model->addLog(array('descricao' => $retorno));

        if($payment->{'status'} == 'approved'){
            $dataUpdate = array(
                'code' => $_GET["data_id"],
                'situacao' => "approved",
                'detalhe' => $payment->{'status_detail'},
                'lido' => 0,
                'ultima_atualizacao' => date("Y-m-d H:i:s")
            );
            $this->transacao_model->updateTransacao($payment->{'external_reference'}, $dataUpdate);
            if($transa = $this->transacao_model->getTransacao($payment->{'external_reference'})){
                $this->transacao_model->liberaItens($transa->id_cliente,$transa->quantidade);
            }
        } else {
            $dataUpdate = array(
                'code' => $_GET["data_id"],
                'situacao' => $payment->{'status'},
                'detalhe' => $payment->{'status_detail'},
                'lido' => 0,
                'ultima_atualizacao' => date("Y-m-d H:i:s")
            );
            $this->transacao_model->updateTransacao($payment->{'external_reference'}, $dataUpdate);
        }

        // $merchant_order = null;

        // switch($_GET["topic"]) {
        //     case "payment":
        //         $payment = MercadoPago\Payment::find_by_id($_GET["id"]);
        //         // Get the payment and the corresponding merchant_order reported by the IPN.
        //         $merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order->id);
        //         break;
        //     case "merchant_order":
        //         $merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
        //         break;
        // }

        // $paid_amount = 0;
        // foreach ($merchant_order->payments as $payment) {	
        //     if ($payment['status'] == 'approved'){
        //         $paid_amount += $payment['transaction_amount'];
        //     }
        // }
        
        // // If the payment's transaction amount is equal (or bigger) than the merchant_order's amount you can release your items
        // if($paid_amount >= $merchant_order->total_amount){
        //     if (count($merchant_order->shipments)>0) { // The merchant_order has shipments
        //         if($merchant_order->shipments[0]->status == "ready_to_ship") {
        //             //print_r("Totally paid. Print the label and release your item.");
        //             $dataUpdate = array(
        //                 'situacao' => "APROVADO",
        //                 'ultima_atualizacao' => date("Y-m-d H:i:s")
        //             );
        //             $this->transacao_model->updateTransacao($_GET["id"], $dataUpdate);
        //             if($transa = $this->transacao_model->getTransacao($_GET["id"])){
        //                 $this->transacao_model->liberaItens($transa->id_cliente,$transa->quantidade);
        //             }
        //         }
        //     } else { // The merchant_order don't has any shipments
        //         $dataUpdate = array(
        //             'situacao' => "APROVADO",
        //             'ultima_atualizacao' => date("Y-m-d H:i:s")
        //         );
        //         $this->transacao_model->updateTransacao($_GET["id"], $dataUpdate);
        //         if($transa = $this->transacao_model->getTransacao($_GET["id"])){
        //             $this->transacao_model->liberaItens($transa->id_cliente,$transa->quantidade);
        //         }
        //     }
        // } else {
        //     $dataUpdate = array(
        //         'situacao' => $payment['status'],
        //         'ultima_atualizacao' => date("Y-m-d H:i:s")
        //     );
        //     $this->transacao_model->updateTransacao($_GET["id"], $dataUpdate);
        // }
	}	
}