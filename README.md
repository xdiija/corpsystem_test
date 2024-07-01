### Passo a passo

```sh
cd corp_system_teste
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Acesse o container app
```sh
docker-compose exec app bash
```

Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Acesse o projeto
[http://localhost:8989]
