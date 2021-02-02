# Validador de mensagens
### Consiste em uma página web onde é possível relizar upload de um arquivo .txt ou .csv para realizar uma validação dos dados seguindo algumas regras.

<!--ts-->
   * [Estrutura](#estrutura)
   * [Regras](#regras)
   * [Validação de telefones](#validacao_telefones)
   * [Consultar BlackList](#blacklist)
   * [Como executar o projeto](#como_executar)
   * [Como realizar testes unitários](#como_testar)
   * [Tecnologias utilizadas](#tecnologias)
<!--te-->

<h2 id="estrutura">Estrutura</h2>

    .
    ├── src
    │   ├── classes             # Classes utilizadas para criação e validação de dados
    │   ├── public              # Arquivos utilizados no front-end
    │   │   ├── images          
    │   │   ├── js              # Aqui fica o controlador da página que realiza a requisição ajax
    │   │   ├── library         # Bibliotecas utilizadas no front-end
    │   │   └── exemple_file    # Arquivos de exemplo para utilizar no projeto
    │   └──  tests              # Classes utilizadas para realizar os testes
    ├── vendor
    ├── composer.json
    ├── composer.lock
    ├── composer.phar
    ├── index.php               # Página inicial do sistema
    └── README.md               # Readme


<h2 id="regras">Regras</h2>
<ul>
    <li>As mensagens que contenham um <a href="#validacao_telefones">telefone inválido</a> serão bloqueadas;</li>
    <li>Mensagens destinadas a telefones que estão na <a href="#blacklist">BlackList</a> serão bloqueadas;</li>
    <li>Mensagens destinadas a telefones do estado de São Paulo serão bloqueadas;</li>
    <li>Mensagens com horário de agendamento após as 19:59:59 serão bloqueadas;</li>
    <li>Mensagens com mais de 140 caracteres serão bloqueadas</li>
    <li>Caso haja mais de uma mensagem para o mesmo telefone de destino, apenas a mensagem válida com o menor horário de agendamento será considerada;</li>
</ul>

<h2 id="validacao_telefones">Validação de telefones</h2>
<p>A validação dos telefones é realizada de acordo com os critérios abaixo:</p>
<ul>
    <li>O DDD deve ser composto por 2 dígitos;</li>
    <li>O DDD deve ser válido (DDDs do Brasil);</li>
    <li>O número do celular deve ser composto por 9 dígitos;</li>
    <li>O número do celular decve começar sempre com o número 9;</li>
    <li>O segundo dígito do número do celular deve ser maior que 6;</li>
</ul>

<h2 id="blacklist">Consultar BlackList</h2>
<p>A verificação de números em blacklist deve ser realizada atraves de uma api: https://front-test-pg.herokuapp.com/blacklist/:phone</p>
<p>A validação deve ser feita pelo status de retorno, caso seja 200 o número esta em blacklist, do contrário o status será 404</p>

<h2 id="como_executar">Como executar o projeto</h2>
<p>Para executar o projeto é necessário ter Apache ou outro servidor instalado em sua máquina, a maioria dos ambientes Linux já vem com ele instalado, para ambientes Windows você pode utilizar algum programa como WampServer ou XAMPP. É necessário também ter o php8.0 e o php8.0-curl instalados em seu computador, em ambientes Windows programas como WampServer instalam automaticamente o PHP na sua máquina, e para os ambientes Linux:</p>

```bash
# apt-get install php8.0 php8.0-curl
```

<p>Após realizar a instalação, será necessário habilitar o mod PHP no Apache (Somente Linux):</p>

```bash
# a2enmod php8.0
```

<p>E então reiniciar o serviço do apache (Somente Linux):</p>

```bash
# service apache2 restart
```

<p>Após realizar a instação das dependencias, você pode realizar o download deste repositório e mover a pasta para o local correto:</p>
<p><b>Windows</b>: A pasta padrão vai depender do programa utilizado, no caso do WampServer fica em c:\wamp\www ou htdocs</p>
<p><b>Linux</b>: Existem duas formas rápidas de configurar o projeto, você pode mover os arquivos de DENTRO da pasta validador_mensagens para a pasta /var/www/html ou então mover a pasta inteira (validador_mensagens) para /var/www/ e editar as configurações do apache:</p>

```bash
# nano /etc/apache2/sites-enabled/000-default.conf
```
E então trocar o valor de DocumentRoot que deve ser <b>/var/www/html</b> para <b>/var/www/validador_mensagens</b> e então reiniciar o apache novamente

```bash
# service apache2 restart
```

<p>Após realizar estes procedimentos, basta abrir um navegador e acessar http://localhost/</p>


<h2 id="como_testar">Como realizar testes unitários</h2>
<p>Após realizar as configurações necessárias e instalação do projeto, para realizar os testes basta abrir o terminal do linux e navegar até a pasta onde o projeto se encontra:</p>

```bash
# cd /var/www/validador_mensagens
```

E executar o seguinte comando:

```bash
# ./vendor/bin/phpunit ./src/tests
```

<h2 id="tecnologias">Tecnologias utilizadas</h2>
<p>As seguintes tecnologias foram utilizadas na construção do projeto:</p>

  * Linguagens:
    * CSS;
    * HTML 5;
    * Javascript;
    * PHP 8;
  * Tenologias:
    * Ajax;
    * Apache 2;
    * Bootstrap 4;
    * Composer 2.0;
    * CURL;
    * JQuery 3.5.1;
    * PHPUnit 9;
  * SO Linux;
  * Visual Studio Code (editor de texto);
