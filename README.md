# PM - People Manager

---
## Sobre o projeto:
Back-end
* PHP 8.2
* Composer 2.7.6 - [Documentação](https://getcomposer.org/doc/)
* vlucas/phpdotenv 5.5 - [Documentação](https://github.com/vlucas/phpdotenv)
* Doctrine ORM 3 - [Documentação](https://www.doctrine-project.org/)

Front-end
* React 18.2
* Tailwind 3.4

--- 
## Requisitos do Projeto:
 * Docker && Docker compose [Documentação](https://docs.docker.com/engine/install/) 

--- 
## Instalação e Inicialização:
1 - Clone o projeto em sua maquina.
```bash
    git@github.com:wesleyvianam/people-manager.git
```

2 - Configurando Variáveis de Ambiente: Clonar arquivo ".env.example" com o nome ".env" na raiz do projeto e alterar as credenciais:

      DB_USERNAME="username"
      DB_PASSWORD="password"
      DATABASE_NAME="nome_do_database"

3 - Na raiz do projeto rode o comando "docker compose up -d" para instalar e inicializar o projeto:
```bash
    docker compose up -d
```
O projeto irá inicializar a **API** na porta http://localhost:8080 e o **Front-end** na porta http://localhost:4200

4 - Para executar as migrações e criar as tabelas no banco de dados, rode o comando:
```bash
  docker exec -it api /usr/local/bin/php vendor/bin/doctrine-migrations migrations:migrate
```

