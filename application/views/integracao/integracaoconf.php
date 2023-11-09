<div class="col-2" id="comptela"></div>
<div class='col' id="tela">
    <h1 class="header" style='padding:10px;'>Configurações Gerias de Integração</h1>
    <hr>

    <div class="card p-4 mb-4">
        <form method="post">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <label>URL da API</label>
                    <input type="text" class="form-control pt-2" name="url_api" required value="<?= isset($configuracoes) ? $configuracoes->url_api : "" ?>">
                </div>
                <div class="col-md-6">
                    <label>URL do QrCode</label>
                    <input type="text" class="form-control pt-2" name="url_qrcode" required value="<?= isset($configuracoes) ? $configuracoes->url_qrcode : "" ?>">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col text-right">
                    <input type="submit" value="SALVAR" class="btn btn-success">
                </div>
            </div>
        </form>
    </div>
</div>