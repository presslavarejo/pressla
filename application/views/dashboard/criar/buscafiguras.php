<script>
    //Guarda o endereço das figuras pertencentes ao BD
    var objFiguras = {
    <?php
        foreach($figuras as $figura){
            echo '"'.$figura->nome.'" : "'.base_url("assets/images/figuras/".$figura->src).'",';
            echo '"'.$figura->ean.'" : ["'.$figura->nome.'", "'.base_url("assets/images/figuras/".$figura->src).'"],';
        }
    ?>
    }
    
    //OBTEM AS IMAGENS DO CAMPO DE PESQUISA
    function buscaImagens(value){
        if(!$("#figura").val()){
            return
        }
        $("#figura").blur();
        $("#loader").show();
        
        figuras = [];
        //Filtra as figuras do BD para retornar apenas as figuras da pesquisa
        var array_objfiguras = Object.keys(objFiguras);
        var array_filtrado = array_objfiguras.filter(function(v){
            return v.toUpperCase().indexOf(value.toUpperCase()) != -1;
        });
        array_filtrado.forEach((item)=>{
            figuras.push({"url" : (Array.isArray(objFiguras[item]) ? objFiguras[item][1] : objFiguras[item]), "title": (Array.isArray(objFiguras[item]) ? objFiguras[item][0] : $("#figura").val())});
        });
		
        //Procura 10 resultados no google
        //"https://www.googleapis.com/customsearch/v1?key=AIzaSyDn8VqTxIoktrCJsdyXzHghc6HlXG4BANA&cx=e0fab0362a537c756&q="+value+"&callback=hndlr&imgColorType=trans&searchType=image&hl=lang_pt&imgSize=large&lr=lang_pt&safe=off&filter=1"
        
		//if(array_filtrado.length == 0){
			$.get("https://www.googleapis.com/customsearch/v1?key=AIzaSyDn8VqTxIoktrCJsdyXzHghc6HlXG4BANA&cx=e0fab0362a537c756&q="+value+"&callback=hndlr&searchType=image&imgSize=large", function(retorno1){
				retorno1 = retorno1.slice(22);
				retorno1 = retorno1.slice(0, -2);
				retorno1 = JSON.parse(retorno1);

				//Procura MAIS 10 resultados no google
				$.get("https://www.googleapis.com/customsearch/v1?key=AIzaSyDn8VqTxIoktrCJsdyXzHghc6HlXG4BANA&cx=e0fab0362a537c756&q="+value+"&callback=hndlr&searchType=image&start=11&imgSize=large", function(retorno2){
					retorno2 = retorno2.slice(22);
					retorno2 = retorno2.slice(0, -2);
					retorno2 = JSON.parse(retorno2);

					var response = retorno1;
					if(response.items){
						response.items = response.items.concat(retorno2.items);
					} else {
						response.items = retorno2.items;
					}
					
					if(response.items){
						for (var i = 0; i < response.items.length; i++) {
							var item = response.items[i];
							
							// testCORS(item.link, $("#cont")) ? figuras.push(item.link) : false;
							//CHAMA O MÉTODO QUE VERIFICA SE A IMAGEM NÃO TEM ERRO DE CORS
							i == (response.items.length - 1) && item.link ? testCORS(item.link, item.title, true) : testCORS(item.link, item.title, false);
						}
					} else {
						$("#loader").hide();
                        
                        if(figuras.length > 0) {
                            mostraFiguras();                
                        } else {
                            alert("Não foi possível entrontrar imagens disponíveis com o parâmetro informado");
                        }
					}
				});
			});
		/*
		} else {
			$("#loader").hide();
			mostraFiguras();
		}
		*/
	}
	

    var figuras;

    function passaImagem(tipo){
        if($("#imagematual").attr('src') == ""){
            return;
        } else {
            var index = 0;
            for(var i=0; i<figuras.length; i++) {
                if(figuras[i].url == $("#imagematual").attr('src')) {
                    index = i;
                    break;
                }
            }
            if(tipo == 'next' && index < figuras.length - 1){
                $("#imagematual").attr('src',figuras[index+1].url);
				// $("#produtol1").val(figuras[index+1].title);
                isAviso();
            } else if(tipo == 'next' && index == figuras.length - 1){
                $("#imagematual").attr('src',figuras[0].url);
				// $("#produtol1").val(figuras[0].title);
                isAviso();
            } else if(tipo == 'back' && index > 0){
                $("#imagematual").attr('src',figuras[index-1].url);
				// $("#produtol1").val(figuras[index-1].title);
                isAviso();
            } else {
                $("#imagematual").attr('src',figuras[figuras.length - 1].url);
				// $("#produtol1").val(figuras[figuras.length - 1].title);
                isAviso();
            }
        }
    }

    //MÉTODO QUE VERIFICA SE A IMAGEM NÃO TEM ERRO DE CORS
    function testCORS(url, title, $elem) {
        $.ajax({
        url: url
        })
        .fail(function(jqXHR, textStatus) {
            if(jqXHR.status === 0) {
                // Determine if this was a CORS violation or not
                $.ajax({
                    context: url,
                    url: "<?= base_url("cors.php") ?>?url=" + escape(this.url),
                })
                .done(function(msg) {
                    if(msg.indexOf("HTTP") < 0) {
                        // $elem.append(url + " - doesn't exist or timed out<br>");
                    } else if(msg.indexOf("Access-Control-Allow-Origin") >= 0) {
                        // $elem.append(url + " - CORS violation because '" + msg + "'<br>");
                    } else {
                        // $elem.append(url + " - no Access-Control-Allow-Origin header set<br>");
                    }
                    $elem ? mostraFiguras() : false;
                })
                .fail(function(i){
                    $elem ? mostraFiguras() : false;
                });
            } else {
                // Some other failure (e.g. 404), but not CORS-related
                // $elem.append(url + " - failed because '" + responseText + "'<br>");
                $elem ? mostraFiguras() : false;
            }
        })
        .done(function(msg) {
            // Successful ajax request
            // $elem.append(this.url + " - OK<br>");
            figuras.push({"url" : url, "title" : title})
            $elem ? mostraFiguras() : false;
        })
        // .fail(function( jqXHR, settings, exception ) {
        //     console.log("Não foi possível carregar o arquivo :(");
        // });
    }

    function mostraFiguras(){
        console.clear();
        $("#imagematual").attr('src',figuras[0].url);
        // $("#produtol1").val(figuras[0].title);
        isAviso();
        $("#controles").show('fast');
        $("#loader").hide();
    }
</script>