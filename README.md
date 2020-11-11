# Projeto Final de BD 2020/1

Ferramenta para auxiliar o professor no modelo de aulas à distância.

## Banco
Foi usado o MySQL que está rodando em um servidor web.

*hostname:* `opessoa.com.br:3306`

## Aplicação
Foi usada a linguagem php para o desenvolvimento de uma API que servirá como o CRUD de nosso projeto.

*host:* `api2.opessoa.com.br`

## Uso
### API Web
Acessar no browser:
`https://api2.opessoa.com.br/ProjetoBD/<Classe>/<funcao>/<parm1>/<parm2>/<parm3>...`

exemplo: https://api2.opessoa.com.br/ProjetoBD/AlunosController/get

### Ambiente de Teste Local (Docker)
Acessar no browser (container rodando):
`localhost:8080/?url=ProjetoBD/<Classe>/<funcao>/<param1>/<param2>/<param3>...`

exemplo: http://localhost:8080/?url=ProjetoBD/AlunosController/get

**Obs: Seria necessária a conexão com o banco, que não foi disponibilizado o arquivo no git. Caso não tenha acesso ao servidor ftp para obter o arquivo da conexão, convém criar o banco com o script SQL disponível na pasta [sql](sql/) e adicionar o seguinte arquivo na pasta [controllers](controllers/):**

**Config.php**:
```php
<?php
define('HOST', 'localhost:3306'); // ou o host e porta alternativos usados 
define('USUARIO', 'root'); // ou o usuário alternativo usado
define('SENHA', ''); // ou a senha definida
define('DB', 'opesso08_ProjetoDB'); // ou o nome alternativo dado ao banco
```

#### Dica:
Para rodar o container, foi disponibilizado um arquivo execute.sh para já criar a imagem e rodar. Deve mudar o valor da variável LOCAL_PATH e opcionalmente de APP_PORT se for mudar a porta.

Obs: é necessário ter o [docker](https://docs.docker.com/get-docker/) instalado para fazer esse teste local! 
