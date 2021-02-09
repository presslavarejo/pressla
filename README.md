# pressla
## Sistema de Cartazes

O que fazer antes de usar:
* Mudar o conteúdo de MercadoPago\SDK::setAccessToken('TOKEN_DE_PRODUCAO'); para o seu TOKEN do Mercado Pago (o de teste ou o de produção) nos arquivos application/controllers/Notificacao.php e application/views/dashboard/dashboard/html.php

O que mudar caso precise instalar em outro servidor
* Mudar a base_url no arquivo application/config/config.php
* Mudar os dados do banco de dados em application/config/database.php
