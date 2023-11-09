<?php
    $diretorio = dir("./");
    echo "DELETE FROM figuras; <br>";
    echo "INSERT INTO figuras VALUES ";
    $saida = "";
    while($arquivo = $diretorio -> read()){
        if($arquivo != "." && $arquivo != ".." && pathinfo($arquivo, PATHINFO_EXTENSION) != "php"){
            $saida .= '(NULL,"'.str_replace(".".pathinfo($arquivo, PATHINFO_EXTENSION),"",$arquivo).'","'.$arquivo.'"),<br>';
        }
    }
    echo substr($saida, 0, -5).";";
    $diretorio -> close();
?>