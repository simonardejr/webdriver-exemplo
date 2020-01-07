# webdriver-exemplo

## Download do chromedriver
Faça o download do chromedriver e coloque no diretório `./bin`

https://chromedriver.chromium.org/downloads
> IMPORTANTE: utilize a versão que suporte o chrome que será usado. A versão desse repo é a 78.0.3904.105 que suporta a versão 78 do Chrome

## Instale as dependências
Só rodar o composer install
```shell
composer install
```

## Execute o código de exemplo
```shell
php crawler.php
```
O Chrome deverá abrir e executar o código de teste.

## Headless
Você pode executar o Chrome em modo "headless", para isso, basta descomentar a [linha 72 do arquivo webdriver.php](https://github.com/simonardejr/webdriver-exemplo/blob/adcb160c1e92cc19ae24e7744b0312cf6038efb4/webdriver.php#L72)

## Cheatsheet
https://gist.github.com/aczietlow/7c4834f79a7afd920d8f