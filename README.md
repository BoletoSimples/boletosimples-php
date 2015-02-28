# Boleto Simples PHP

Essa biblioteca é um conjunto de classes em PHP para acessar informações da sua conta no [Boleto Simples](http://boletosimples.com.br) através da [API](http://api.boletosimples.com.br).

Todas as classes são herdadas do PHP ActiveResouce. Veja a documentação do [PHP ActiveResouce](https://github.com/jbroadway/phpactiveresource) para mais informações.

## Instalação

### Usando [Composer](https://getcomposer.org/)

Crie um arquivo chamado `composer.json` com o seguinte conteúdo:

```json
{
	"require": {
		"boletosimples/boletosimples": "0.0.1"
	}
}
```

Execute:

    $ composer install

## Configuração

```php
<?php

require_once 'vendor/autoload.php';
use BoletoSimples\BoletoSimples;

BoletoSimples::configure(array(
  "environment" => 'production', // default: 'sandbox'
  "access_token" => 'access-token'
));

?>
```

### Variáveis de ambiente

Você também pode configurar as variáveis de ambiente a seguir e não será necessário chamar `BoletoSimples::configure`

```bash
ENV['BOLETOSIMPLES_ENV']
ENV['BOLETOSIMPLES_APP_ID']
ENV['BOLETOSIMPLES_APP_SECRET']
ENV['BOLETOSIMPLES_ACCESS_TOKEN']
```

## Exemplos

(a desenvolver)

## Desenvolvendo

Instale as dependências

    $ composer install

Rode os testes

    $ ./vendor/bin/phpunit tests

## Licença

Esse código é livre para ser usado dentro dos termos da licença [MIT license](http://www.opensource.org/licenses/mit-license.php).

## Bugs, Issues, Agradecimentos, etc

Comentários são bem-vindos. Envie seu feedback através do [issue tracker do GitHub](http://github.com/BoletoSimples/boletosimples-php/issues)

## Autor

[**Rafael Lima**](http://github.com/rafaelp) trabalhando no [Boleto Simples](http://boletosimples.com.br)

Blog: [http://rafael.adm.br](http://rafael.adm.br)

Twitter: [http://twitter.com/rafaelp](http://twitter.com/rafaelp)