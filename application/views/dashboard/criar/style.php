<?php
    $path = 'assets/fonts/';
    $diretorio = dir($path);

    while($arquivo = $diretorio -> read()){
        if(strpos($arquivo, '.ttf')){
            echo "<link rel=\"preload\" as=\"font\" href=\"".base_url().$path.$arquivo."\" type=\"font/ttf\" crossorigin=\"important\" id=\"".explode('.',$arquivo)[0]."\">";
        }
    }
    $diretorio -> close();
?>
<style>
<?php
    $path = 'assets/fonts/';
    $diretorio = dir($path);

    while($arquivo = $diretorio -> read()){
        if(strpos($arquivo, '.ttf')){
            echo " @font-face {font-family: \"".explode('.',$arquivo)[0]."\";src: local('".explode('.',$arquivo)[0]."'), url(\"".base_url().$path.$arquivo."\") format('truetype');}";
        }
    }
    $diretorio -> close();
?>
</style>