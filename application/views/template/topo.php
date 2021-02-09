<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?php echo $title; ?></title>

    <link rel="icon" href="<?php echo $this->cadastromodel->baseUrl(); ?>/assets/images/logo.png" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="<?php echo $this->cadastromodel->baseUrl(); ?>/assets/css/bootstrap.min.css">
    
    <?php
    foreach (glob("assets/css/cssgeral/*.css") as $filename) {
        echo "<link rel=\"stylesheet\" href=\"".$this->cadastromodel->baseUrl().'/'.$filename."?v=".time()."\">";
    }
    foreach (glob("assets/css/".$css."/*.css") as $filename) {
        echo "<link rel=\"stylesheet\" href=\"".$this->cadastromodel->baseUrl().'/'.$filename."?v=".time()."\">";
    }
    ?>

    <script src="<?php echo $this->cadastromodel->baseUrl(); ?>/assets/js/fixos/jquery.js"></script>
    <script src="<?php echo $this->cadastromodel->baseUrl(); ?>/assets/js/fixos/jquery.mask.min.js"></script>
    <script src="<?php echo $this->cadastromodel->baseUrl(); ?>/assets/js/fixos/jquery.form.js"></script>
    <script src="<?php echo $this->cadastromodel->baseUrl(); ?>/assets/js/fixos/bootstrap.min.js"></script>
    <script src="<?php echo $this->cadastromodel->baseUrl(); ?>/assets/js/fixos/icones.js"></script>
    <script src="<?php echo $this->cadastromodel->baseUrl(); ?>/assets/js/fixos/html2canvas.min.js"></script>
  
</head>

<body>
    <div class="container-fluid" id="main">
        <div id='container-invisible'>
