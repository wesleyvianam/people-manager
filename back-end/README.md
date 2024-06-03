# Api - People Manager
O People Manager é uma API RESTful PHP desenvolvida sem framework
* A aplicação esta disponível na posta http://localhost:8080/api/

## Tecnologias
+ PHP 8.2
+ Composer 2.7.6
+ Mysql 8.4
+ Nginx 1.27

## Endpoints

### Resumo
--- 

#### Pessoas
| Protocol | Path             | Description                            |
|----------|------------------|----------------------------------------|
| POST     | /api/person      | Cria uma nova pessoa                   |
| GET      | /api/person      | Retorna uma lista de pessoas           |
| GET      | /api/person/{id} | Retorna os dados de uma pessoa pelo id |
| PUT      | /api/person/{id} | Edita os dados da pessoa pelo id       |
| DELETE   | /api/person/{id} | Deleta os dados da pessoa pelo id      |

#### Contatos
| Protocol  | Path              | Description                                                  |
|-----------|-------------------|--------------------------------------------------------------|
| GET       | /api/contact      | Retorna uma lista de contatos contendo a pessoa proprietária |
| POST      | /api/contact      | Cria um novo contato                                         |
| GET       | /api/contact/{id} | Retorna os dados do contato pelo id                          |
| PUT       | /api/contact/{id} | Edita os dados do contato pelo id                            |
| DELETE    | /api/contact/{id} | Deleta os dados do contato pelo id                           | 

### Exemplos
---

#### Pessoas

##### [POST]: Criar uma Pessoa
```sh
http://localhost:8080/api/person
```      

Body
```json
{
  "name": "Wesley Viana Martins",
  "cpf": "111.222.333-45",
  "type": 2,
  "contact": "(31) 9 9911-9090"
}
```

##### [PUT]: Atualizar uma Pessoa
```sh
http://localhost:8080/api/person/1
```

Body
```json
{
  "name": "Wesley Viana Martins",
  "cpf": "333.222.111-99",
  "type": 2,
  "contact": "(31) 9 9911-0000"
}
```

##### [GET]: Lista de Pessoas
filtros aceitos "search", e pode ser usado para filtrar nome e CPF.
```sh
http://localhost:8080/api/person
```
```sh
http://localhost:8080/api/person?search="wes"
```

##### [GET]: Retorna uma Pessoa
```sh
http://localhost:8080/api/person/1
```

##### [DELETE]: Deleta os dados de uma Pessoa
```sh
http://localhost:8080/api/person/1
```

#### Contatos

##### [POST]: Criar um contato
```sh
http://localhost:8080/api/contact
```      

Body
```json
{
  "person_id": 1,
  "type": 1,
  "contact": "(31) 9 9911-9090"
}
```

##### [PUT]: Atualiza o contato
```sh
http://localhost:8080/api/contact
```      

Body
```json
{
  "person_id": 1,
  "type": 1,
  "contact": "(31) 9 9911-9090"
}
```

##### [GET]: Lista de Contatos
filtros aceitos "search (Contato), type (1: Email, 2: Telefone), person_id (Dono do contato)".
```sh
http://localhost:8080/api/contact
```
```sh
http://localhost:8080/api/contact?search=&type=&person_id=
```

##### [GET]: Retorna um Contato
```sh
http://localhost:8080/api/contact/1
```

##### [DELETE]: Deleta os dados de um Contato
```sh
http://localhost:8080/api/contact/1
```
