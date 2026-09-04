## Requisitos

Para utilizar o sistema, é necessário ter o **Docker** e o **Docker Compose** instalados.

## Configuração

Inicialmente, copie o arquivo `.env.example` para `.env` e altere as credenciais do banco de dados — `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD` — para os valores de sua escolha.

## Execução

No diretório do RETACE, execute o seguinte comando:

```bash
docker compose --env-file .env -f docker/retace-compose.yml up
```

Aguarde até o sistema informar que o RETACE está disponível em `localhost:8888`.

Em seguida, basta acessar o endereço pelo seu navegador.

