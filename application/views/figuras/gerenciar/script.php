<script>
    <?php 
    if(isset($res)){
        if($res==1){
    ?>
        $(window).scrollTop(0);
        $('#alerta-sucesso').show('fast');
        $('#frm-template')[0].reset();
        setTimeout(() => {
            $('#alerta-sucesso').hide('fast')
        }, 2500);
    <?php 
        } else {
    ?>
        $('#alerta-erro').show('fast');
        setTimeout(() => {
            $('#alerta-erro').hide('fast')
        }, 2500);
    }
    <?php 
        }
    }
    ?>
</script>
