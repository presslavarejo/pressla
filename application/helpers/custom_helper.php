<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function object_to_array($obj, $index = null) {
    $resposta = array();
    foreach($obj as $elemento) {
        foreach($elemento as $key => $value) {
            if ($index != null) {
                if ($key === $index) {
                    $resposta[] = $value;
                }
            } else {
                $resposta[] = $value;
            }
        }
    }
    return $resposta;
}

function check_status($status) {
    $check = false;
    foreach($status as $status) {
        if ($status->status_id == 6) {
            $check = true;
        }
    }
    return $check;
}