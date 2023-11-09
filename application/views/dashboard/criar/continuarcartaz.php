<script>
    //Depois de adicionar figura
    function continuarCartaz(ctx,w,h,fundo=false,cartaz,figura = null){
        if(fundo){
            if(fundo.height < fundo.width){
                if($("#layout").val() == 21 || $("#layout").val() == 22 || $("#layout").val() == 23){
                    ctx.drawImage(fundo, 0, 0, w, h);
                } else {
                    ctx.drawImage(fundo, 0, 0, w, w * fundo.height / fundo.width);
                }
                
            } else {
                ctx.drawImage(fundo, 0, 0, w, h);
            }
        }
        var logo = new Image();
        logo.src = "<?php echo base_url().'assets/images/logomarcas/'.($this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca ? $this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca : "logopadrao.png"); ?>";
        
        logo.onload = function(){
            if($("#layout").val() == 1 || $("#layout").val() == 13){
                layout1(ctx,w,h,fundo,cartaz,logo);
            } else if($("#layout").val() == 2) {
                layout2(ctx,w,h,fundo,cartaz,logo);
            } else if($("#layout").val() == 3 || $("#layout").val() == 4 || $("#layout").val() == 15) {
                layout3(ctx,w,h,fundo,cartaz,logo);
            } else if($("#layout").val() == 5) {
                layout4(ctx,w,h,fundo,cartaz,logo);
            } else if($("#layout").val() == 6 || $("#layout").val() == "6b") {
                layout5(ctx,w,h,fundo,cartaz,logo,figura);
            } else if($("#layout").val() == 7) {
                layout6(ctx,w,h,fundo,cartaz,logo);
            } else if($("#layout").val() == 18) {
                layout18(ctx,w,h,fundo,cartaz,logo,0,figura);
            } else if($("#layout").val() == 8 || $("#layout").val() == 9) {
                layout7(ctx,w,h,fundo,cartaz,logo);//8 ou 9
            } else if($("#layout").val() == 10 || $("#layout").val() == 11) {
                layout8(ctx,w,h,fundo,cartaz,logo);//10 ou 11
            } else if($("#layout").val() == 12) {
                layout9(ctx,w,h,fundo,cartaz,logo);
            } else if($("#layout").val() == 14) {
                layout10(ctx,w,h,fundo,cartaz,logo);
            } else if($("#layout").val() == 16 || $("#layout").val() == 17) {
                layout11(ctx,w,h,fundo,cartaz,logo);
            } else if($("#layout").val() == 19 || $("#layout").val() == 20) {
                layout12(ctx,w,h,fundo,cartaz,logo,figura);
            } else if($("#layout").val() == 21  || $("#layout").val() == 22) {
                layout13(ctx,w,h,fundo,cartaz,logo,figura);
            } else if($("#layout").val() == 23) {
                layout14(ctx,w,h,fundo,cartaz,logo,figura);
            } else if($("#layout").val() == 25) {
                layout25(ctx,w,h,fundo,cartaz,logo,figura);
            } else if($("#layout").val() == 26) {
                layout26(ctx,w,h,cartaz,logo);
            } else if($("#layout").val() == 27) {
                layout28(ctx,w,h,fundo,cartaz,logo,0,figura);
            } else if($("#layout").val() == 28) {
                layout28(ctx,w,h,fundo,cartaz,logo,0,figura);
            }
        }
    }
    
    function continuarCartazFila(ctx,w,h,fundo,cartaz,figura=null,i=0){
        var context = ctx;
        ctx = context[i];

        if(dadosdafila.length > 1){
            setTimeout(() => {
                if((i+1) == dadosdafila.length){
                    $("#carregando").html("");
                } else {
                    $("#carregando").html("<h1 class='text-center m-5'>Criando cartaz "+(i+1)+" de "+(dadosdafila.length)+"</h1>");
                }
            }, 1);
        }

        //INCLUE O FUNDO BRANCO
        ctx.beginPath();
        ctx.rect(0, 0, w, h);
        ctx.fillStyle = "#FFFFFF";
        ctx.fill();

        if(fundo){
            if(fundo.height < fundo.width){
                if($("#layout").val() == 21 || $("#layout").val() == 22 || $("#layout").val() == 23){
                    ctx.drawImage(fundo, 0, 0, w, h);
                } else {
                    ctx.drawImage(fundo, 0, 0, w, w * fundo.height / fundo.width);
                }
                
            } else {
                ctx.drawImage(fundo, 0, 0, w, h);
            }
        }
        var logo = new Image();
        logo.src = "<?php echo base_url().'assets/images/logomarcas/'.($this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca ? $this->templates_model->getLogo($this->session->userdata('logado')['id'])->logomarca : "logopadrao.png"); ?>";
        
        logo.onload = function(){
            if($("#layout").val() == 1 || $("#layout").val() == 13){
                // OK
                layout1([ctx, context],w,h,fundo,cartaz,logo,i);
            } else if($("#layout").val() == 2) {
                layout2([ctx, context],w,h,fundo,cartaz,logo,i);
            } else if($("#layout").val() == 3 || $("#layout").val() == 4 || $("#layout").val() == 15) {
                // OK
                layout3([ctx, context],w,h,fundo,cartaz,logo,i);
            } else if($("#layout").val() == 5) {
                // OK
                layout4([ctx, context],w,h,fundo,cartaz,logo,i);
            } else if($("#layout").val() == 6) {
                layout5([ctx, context],w,h,fundo,cartaz,logo,figura,i);
            } else if($("#layout").val() == 7) {
                layout6([ctx, context],w,h,fundo,cartaz,logo,i);
            } else if($("#layout").val() == 18) {
                layout18([ctx, context],w,h,fundo,cartaz,logo,i);
            } else if($("#layout").val() == 8 || $("#layout").val() == 9) {
                layout7([ctx, context],w,h,fundo,cartaz,logo);//8 ou 9
            } else if($("#layout").val() == 10 || $("#layout").val() == 11) {
                // OK
                layout8([ctx, context],w,h,fundo,cartaz,logo,i);//10 ou 11
            } else if($("#layout").val() == 12) {
                // OK
                layout9([ctx, context],w,h,fundo,cartaz,logo,i);
            } else if($("#layout").val() == 14) {
                layout10([ctx, context],w,h,fundo,cartaz,logo);
            } else if($("#layout").val() == 16 || $("#layout").val() == 17) {
                // OK
                layout11([ctx, context],w,h,fundo,cartaz,logo,i);
            } else if($("#layout").val() == 19 || $("#layout").val() == 20) {
                layout12([ctx, context],w,h,fundo,cartaz,logo,figura);
            } else if($("#layout").val() == 21  || $("#layout").val() == 22) {
                // OK PARA 21 E PARCIAL PARA 22
                layout13([ctx, context],w,h,fundo,cartaz,logo,figura,i);
            } else if($("#layout").val() == 23) {
                layout14([ctx, context],w,h,fundo,cartaz,logo,figura);
            } else if($("#layout").val() == 25) {
                // OK
                layout25([ctx, context],w,h,fundo,cartaz,logo,i);
            } else if($("#layout").val() == 26) {
                layout26([ctx, context],w,h,cartaz,logo,i);
            }
        }
    }
</script>