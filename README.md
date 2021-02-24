# Pressla
## Sistema de Cartazes

* O que fazer antes de usar:

	* Mudar o conteúdo de MercadoPago\SDK::setAccessToken('TOKEN_DE_PRODUCAO'); para o seu TOKEN do Mercado Pago (o de teste ou o de produção) nos arquivos application/controllers/Notificacao.php e application/views/dashboard/dashboard/html.php


* Adicionar Figuras em Massa:

	* Inclua todas as imagens desejadas na pasta C:\Inetpub\vhosts\pressla.com.br\app.pressla.com.br\assets\images\figuras
	* Acesse o link: app.pressla.com.br/assets/images/figuras/banco.php
	* Copie todo o conteúdo retornado na tela (você pode selecionar tudo com o atalho CTRL + A e copiar com CTRL + C)
	* Abra o phpMyAdmin acessando o link http://162.214.159.35/phpmyadmin/
	* Acesse o banco fparedes_cartaz -> tabela "figuras" -> SQL
	* Apague o conteúdo da tela e cole o script que você copiou anteriormente
	* Clique em executar e veja que todas as figuras foras adicionadas



* O que mudar caso precise instalar em outro servidor

	* Mudar a base_url no arquivo application/config/config.php
	* Mudar os dados do banco de dados em application/config/database.php
