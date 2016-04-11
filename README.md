## Maudit

[![Total Downloads](https://poser.pugx.org/mixdinternet/maudit/d/total.svg)](https://packagist.org/packages/mixdinternet/maudit)
[![Latest Stable Version](https://poser.pugx.org/mixdinternet/maudit/v/stable.svg)](https://packagist.org/packages/mixdinternet/maudit)
[![License](https://poser.pugx.org/mixdinternet/maudit/license.svg)](https://packagist.org/packages/mixdinternet/maudit)

![Área administrativa](http://mixd.com.br/github/180fcdf77d8902957ac5e7e6091445ec.png "Área administrativa")

Tenha acesso a todas as ações que o usuário executou no administrativo.

## Instalação

Adicione no seu composer.json

```js
  "require": {
    "mixdinternet/maudit": "0.1.*"
  }
```

ou

```js
  composer require mixdinternet/maudit
```

## Service Provider

Abra o arquivo `config/app.php` e adicione

`Mixdinternet\Maudit\Providers\MauditServiceProvider::class`

## Arquivos de configurações

`php artisan vendor:publish --provider="Mixdinternet\Maudit\Providers\MauditServiceProvider" --tag="config"`

## Migração

Rode a migração com o comando
`php artisan migrate --path=vendor/venturecraft/revisionable/src/migrations`

ou copie (gosto mais desta opção)

`cp vendor/venturecraft/revisionable/src/migrations/2013_04_09_062329_create_revisions_table.php database/migrations/`