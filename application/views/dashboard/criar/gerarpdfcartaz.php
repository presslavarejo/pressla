<script>
    function gerarPDF() {
        $("#loader").show();
        $.get("<?php echo base_url('index.php/dashboard/checkImpressoesUsadas/' . $id); ?>", function(result) {
            $("#loader").hide();
            if (result) {
                var tam = $('#tamanho').val().split('<|>');

                var tamanho = tam[1].split(' x ');
                var w = tamanho[0];
                var h = tamanho[1];

                var id = $('#tamanho').children(":selected").attr('id');

                var canvas = document.getElementById("cartaz");

                if (id == "A5" || id == "A6") {
                    id = "A4";
                    w = 210;
                    h = 297;
                }

                if ($("#layout").val() == 5 || $("#layout").val() == 6 || $("#layout").val() == 10 || $("#layout").val() == 11 || $("#layout").val() == 14 || $("#layout").val() == 25) {
                    var temp = w;
                    w = h;
                    h = temp;
                }

                //TAMANHO DO A2
                if ($("#layout").val() == 7 || $("#layout").val() == 18) {
                    w = parseFloat(594);
                    h = parseFloat(420);
                    id = "A2_ A3x2";
                    canvas = document.getElementById("cartaz_a2");
                }

                //TAMANHO DO A1 HORIZONTAL A3x4
                if ($("#layout").val() == 14) {
                    w = parseFloat(420);
                    h = parseFloat(297);
                    id = "A1_ A3x4";
                    if ($("#tamanho2").val() == "A3") {
                        id = "A3_bolsao";
                    } else if ($("#tamanho2").val() == "A1U") {
                        id = "A1_bolsao";
                        w = parseFloat(841);
                        h = parseFloat(594);
                    }
                    canvas = document.getElementById("cartaz1");
                }

                var d = new Date();

                // ESPAÇO DEDICADO A LAYOUTS SEM TEMPLATE
                if ($("#layout").val() == 26) {
                    w = parseFloat(4*420);
                    h = parseFloat(2*297);

                    canvas = document.getElementById("cartaz");
                    const imagem = canvas.toDataURL("image/jpeg");
                    id = "horizontal_8xA3";

                    var linhas = 2;
                    var colunas = 4;
                    var wp = 420;
                    var hp = 297;
                    var orientacao_pagina = "l";

                    // O PDF COMEÇA A SER CONTRUÍDO AQUI
                    var doc = new jsPDF({
                        orientation: orientacao_pagina,
                        format: [wp, hp]
                    });

                    for(var i = 0; i < linhas; i++){
                        for(var j = 0; j < colunas; j++){
                            if(!(i == 0 && j == 0)){
                                doc.addPage();
                            }
                            doc.addImage(imagem, "JPEG", -j*wp, -i*hp, wp*colunas, hp*linhas);
                        }
                    }
                
                } else {

                    const imagem = canvas.toDataURL("image/jpeg");
                    if ($("#layout").val() == 14) {
                        var doc = new jsPDF({
                            orientation: $("#layout").val() == 5 || $("#layout").val() == 6 || $("#layout").val() == 7 || $("#layout").val() == 18 || $("#layout").val() == 10 || $("#layout").val() == 11 || $("#layout").val() == 14 || $("#layout").val() == 25 ? 'l' : 'p',
                            format: id.length == 2 ? id : [w, h]
                        });

                        if ($("#tamanho2").val() == "A1") {
                            doc.addImage(imagem, "JPEG", 0, 0, w * 2, h * 2);
                            doc.addPage({
                                orientation: 'l',
                                format: [w, h]
                            });
                            doc.addImage(imagem, "JPEG", -w, 0, w * 2, h * 2);
                            doc.addPage({
                                orientation: 'l',
                                format: [w, h]
                            });
                            doc.addImage(imagem, "JPEG", 0, -h, w * 2, h * 2);
                            doc.addPage({
                                orientation: 'l',
                                format: [w, h]
                            });
                            doc.addImage(imagem, "JPEG", -w, -h, w * 2, h * 2);
                            //doc.addImage(imagem, "JPEG", 0, h*(-1), w, h*paginas);
                        } else {
                            doc.addImage(imagem, "JPEG", 0, 0, w, h);
                        }
                    } else {
                        if(id.indexOf("x_A") != -1){
                            const paginas = id.split("x_A")[0].trim();
                            const folha   = id.split("x_")[1].trim();
                            
                            if(paginas == 2) {
                                const options = {
                                    orientation: h > w ? "l" : "p",
                                    format: folha
                                }
                                var doc = new jsPDF(options);

                                if(h > w) {
                                    doc.addImage(imagem, "JPEG", 0, 0, h, w * 2);
                                    doc.addPage(options);     
                                    doc.addImage(imagem, "JPEG", 0, -w, h, w * 2);
                                } else {
                                    doc.addImage(imagem, "JPEG", 0, 0, h * 2, w);
                                    doc.addPage(options);     
                                    doc.addImage(imagem, "JPEG", -h, 0, h * 2, w);
                                }
                            }
                        } else {
                            var doc = new jsPDF({
                                orientation: $("#layout").val() == 5 || $("#layout").val() == 6 || $("#layout").val() == 7 || $("#layout").val() == 18 || $("#layout").val() == 10 || $("#layout").val() == 11 || $("#layout").val() == 14 || $("#layout").val() == 25 ? 'l' : 'p',
                                format: id.length == 2 ? id : [w, h]
                            });

                            if (id.length >= 8) {
                                var paginas = parseInt(id.split(' ')[1].split('x')[1]);
                                doc.addImage(imagem, "JPEG", 0, 0, w, h * paginas);
                                doc.addPage({
                                    orientation: 'l',
                                    format: [w, h]
                                });
                                doc.addImage(imagem, "JPEG", 0, h * (-1), w, h * paginas);
                            } else {
                                doc.addImage(imagem, "JPEG", 0, 0, w, h);
                            }
                        }
                    }
                }

                window.open(doc.output('bloburl'));

                $.get("<?php echo base_url('index.php/dashboard/contarHistoricoImpressao/' . $id . '/1'); ?>");
                $.get("<?php echo base_url('index.php/dashboard/contarImpressaoUsada/' . $id); ?>");
            } else {
                $('#texto-aviso').html("Você usou todos os créditos disponível!!<br><br>Obtenha mais créditos para continuar utilizando nossos serviços.");
                $("#modalAviso").modal('show');
            }
        });
    }

    function gerarPDFFila() {
        $("#loader").show();
        $.get("<?php echo base_url('index.php/dashboard/checkImpressoesUsadasNum/' . $id); ?>", function(result) {
            $("#loader").hide();
            
            if (result && parseInt(result) >= dadosdafila.length) {
                var tam = $('#tamanho').val().split('<|>');
                var tamanho = tam[1].split(' x ');
                var w = tamanho[0];
                var h = tamanho[1];

                var tamanho_explicito = $('#tamanho').children(":selected").attr('id');

                if (tamanho_explicito == "A5" || tamanho_explicito == "A6") {
                    w = 210;
                    h = 297;
                }

                var inverso = false;

                var d = new Date();
                var id = "fila"+d.getTime();

                var orientation = $("#layout").val() == 5 || $("#layout").val() == 6 || $("#layout").val() == 7 || $("#layout").val() == 18 || $("#layout").val() == 10 || $("#layout").val() == 11 || $("#layout").val() == 14 || $("#layout").val() == 16 || $("#layout").val() == 17  || $("#layout").val() == 21 || $("#layout").val() == 22 || $("#layout").val() == 25 ? 'l' : 'p';

                // ********** TAMANHOS PERSONALIZADOS **********
                if($("#layout").val() == 16 || $("#layout").val() == 17){
                    w = 200;
                    h = 80;
                    inverso = true;
                }

                if($("#layout").val() == 21 || $("#layout").val() == 22){
                    w = 170;
                    h = 120;
                    inverso = true;
                }

                if($("#layout").val() == 25){
                    w = 420;
                    h = 297;
                    inverso = true;
                }
                // ********** FIM TAMANHOS PERSONALIZADOS **********

                if(tamanho_explicito == "A5"){
                    if(orientation == "p"){
                        orientation = "l";
                    } else if(orientation == "l"){
                        orientation = "p";
                    }
                }

                var doc = new jsPDF({
                    orientation: orientation,
                    format: [w, h]
                });

                dadosdafila_new = addRepeticoes(dadosdafila);

                var q_por_pagina = tamanho_explicito == "A5" ? 2 : (tamanho_explicito == "A6" ? 4 : 1);
                var q_paginas = Math.ceil(dadosdafila_new.length / q_por_pagina);
                var cont_inicio = 0;

                for(var pg = 0; pg <= q_paginas; pg++){
                    var cont_num = 0;
                    for(var car = cont_inicio; car < cont_inicio + q_por_pagina; car++){
                        if(car < dadosdafila_new.length){
                            var canvas = document.getElementById("cartaz"+dadosdafila_new[car][0]);
                            const imagem = canvas.toDataURL("image/jpeg");

                            if(tamanho_explicito == "A5"){

                                if((orientation == 'p' && !inverso) || (orientation == 'l' && inverso)){
                                    // SE FOR UM A5 PAISAGEM
                                    doc.addImage(imagem, "JPEG", 0, cont_num*148, 210, 148);
                                } else if((orientation == 'l' && !inverso) || (orientation == 'p' && inverso)) {
                                    // SE FOR UM A5 NORMAL
                                    doc.addImage(imagem, "JPEG", cont_num*148, 0, 148, 210);
                                } 
                                
                                cont_num++;
                            } else if(tamanho_explicito == "A6"){

                                if((orientation == 'p' && !inverso) || (orientation == 'l' && inverso)){
                                    // SE FOR UM A5 NORMAL
                                    doc.addImage(imagem, "JPEG", (cont_num%2 == 0 ? 0 : 1)*105, (cont_num < 2 ? 0 : 1)*148, 105, 148);
                                } else if((orientation == 'l' && !inverso) || (orientation == 'p' && inverso)) {
                                    // SE FOR UM A5 PAISAGEM
                                    doc.addImage(imagem, "JPEG", (cont_num%2 == 0 ? 0 : 1)*148, (cont_num < 2 ? 0 : 1)*105, 148, 105);
                                } 

                                cont_num++;
                            } else {
                                if((orientation == 'p' && !inverso) || (orientation == 'l' && inverso)){
                                    doc.addImage(imagem, "JPEG", 0, 0, w, h);
                                } else if((orientation == 'l' && !inverso) || (orientation == 'p' && inverso)) {
                                    doc.addImage(imagem, "JPEG", 0, 0, h, w);
                                }    
                            }
                        }
                    }    

                    cont_inicio += q_por_pagina; 

                    if(cont_inicio < dadosdafila_new.length){
                        doc.addPage({
                            orientation: orientation,
                            format: [w, h]
                        });
                    }
                }


                window.open(doc.output('bloburl'));

                $.get("<?php echo base_url('index.php/dashboard/contarHistoricoImpressao/' . $id); ?>/"+dadosdafila.length);
                $.get("<?php echo base_url('index.php/dashboard/contarImpressaoUsadaNum/' . $id); ?>/"+dadosdafila.length);
            } else if(parseInt(result) == 0) {
                $('#texto-aviso').html("Você usou todos os créditos disponível!!<br><br>Obtenha mais créditos para continuar utilizando nossos serviços.");
                $("#modalAviso").modal('show');
            } else {
                $('#texto-aviso').html("Você está tentando gerar "+dadosdafila.length+" cartazes, mas possui apenas "+(parseInt(result))+" créditos na sua conta.<br><br>Obtenha mais créditos ou remova "+(dadosdafila.length - parseInt(result))+" ou mais cartazes da lista para continuar utilizando nossos serviços.");
                $("#modalAviso").modal('show');
            }
        });
    }

    function addRepeticoes(array){
        var novo_array = []
        array.forEach((item) => {
            var quant = $("#quant"+item[0]).val() ? $("#quant"+item[0]).val() : 1;

            for(var i = 0; i < $("#quant"+item[0]).val(); i++){
                novo_array.push(item);
            }
        });

        return novo_array;
    }

    function baixarImagem() {
        $("#loader").show();
        $.get("<?php echo base_url('index.php/dashboard/checkImpressoesUsadas/' . $id); ?>", function(result) {
            $("#loader").hide();
            if (result) {
                var canvas = document.getElementById("cartaz"); // full page 
                if ($("#layout").val() == 7) {
                    canvas = document.getElementById("cartaz_a2");
                } else if ($("#layout").val() == 14) {
                    canvas = document.getElementById("cartaz1");
                }
                var link = document.createElement("a");
                document.body.appendChild(link);
                link.download = "cartaz.jpeg";
                link.href = canvas.toDataURL("image/jpeg");
                link.target = '_blank';
                link.click();

                $.get("<?php echo base_url('index.php/dashboard/contarHistoricoImpressao/' . $id . '/1'); ?>");
                $.get("<?php echo base_url('index.php/dashboard/contarImpressaoUsada/' . $id); ?>");
            } else {
                $('#texto-aviso').html("Você usou todos os créditos disponível!!<br><br>Obtenha mais créditos para continuar utilizando nossos serviços.");
                $("#modalAviso").modal('show');
            }
        });
    }
    
</script>