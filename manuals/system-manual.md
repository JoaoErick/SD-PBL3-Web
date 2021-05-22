# Manual de Sistema

- [Placa](#placa)
- [IoT Core](#iot-core)
- [Arduino IDE](#arduino-ide)
- [Laravel](#laravel)
- [Elastic Beanstalk e AWS RDS](#elastic-beanstalk-e-aws-rds)
- [AWS Lambda](#aws-lambda)
- [Alexa Voice Service](#alexa-voice-service)
- [Aplicação Web](#aplicação-web)


## Placa
```Módulo NodeMcu ESP-12E```

Especificações: 
- 4MB de Memória FLASH;
- Módulo NodeMcu Lua ESP-12E;
- Wireless padrão 802.11 b/g/n;
- Antena embutida;
- Conector micro-usb.

## IoT Core

### Criando uma coisa (IoT)
1. Entre no [AWS Console](https://console.aws.amazon.com/console/home?region=us-east-1#);
2. Acesse o serviço IoT Core;
3. No menu lateral, selecione a opção **Gerenciar** e depois selecione a opção **Coisas**;
4. Clique no botão **Criar** e depois clique em **Criar uma única coisa**;
5. Digite um nome para a Coisa e clique em **Próximo**;
6. Clique em **Criar Certificado**;
7. Faça o download do **Um certificado para essa coisa** e **Uma chave privada**;
8. Clique em download ao lado de **Uma CA raiz para o AWS IoT**;
9. Faça o download da **RSA 2048 bit key**, e retorne para a página anterior;
10. Clique no botão **Ativar** e clique em **Concluído**.

---

### Anexando uma política aos certificados
1. No menu lateral, selecione a opção **Proteger** e depois selecione a opção **Políticas**;
2. Clique no botão **Criar**;
3. Defina um nome para a política;
4. Nos campos **Ação** e **Recursos ARN** digite ```*```, em **Efeitos** selecione a opção **Permitir**;
5. Clique no botão **Criar**;
6. Novamente, no menu lateral, selecione a opção **Proteger** e depois selecione a opção **Certificados**;
7. Clique em ```•••```, selecione a opção **Anexar Política**;
8. Selecione a política criada e clique em **Anexar**.

---

## Arduino IDE

### Instalação
1. Entre no site do [Arduino](https://www.arduino.cc/en/software) e faça o download da IDE;

### Adicionando pacote para reconhecer a placa utilizada
1. Abra a IDE instalada anteriormente;
2. Conecte a placa ao seu computador utilizando um cabo USB;
3. No menu superior, clique em **Ferramentas** ➞ **Porta**, verifique se apareceu uma nova **Porta Serial** e selecione-a;
4. No menu superior, clique em **Arquivo** ➞ **Preferências**;
5. No campo **URLs Adicionais para Gerenciadores de Placas** cole ```http://arduino.esp8266.com/stable/package_esp8266com_index.json``` e clique em **OK**;
6. No menu superior, clique em **Ferramentas** ➞ **Placa** ➞ **Gerenciador de Placas**;
7. Procure por **esp8266** e clique em **Instalar**;
8. No menu superior, clique em **Ferramentas** ➞ **Placa** ➞ **ESP8266 Boards** e selecione o modelo **NodeMCU 1.0 (ESP-12E Module)**;
9. Instale o arquivo de ferramentas disponível nesse [link](https://github.com/esp8266/arduino-esp8266fs-plugin/releases/tag/0.5.0) selecionando ``ESP8266FS-0.5.0.zip``;
10. Encontre o diretório do Arduino (geralmente fica no diretório Documentos), crie um diretório chamado ``tools`` e nela extraia o arquivo de ferramentas;
11. Reinicie a Arduino IDE;
12. No menu superior, clique em **Ferramentas** e verifique se apareceu a opção **ESP8266 Sketch Data Upload**.

---

### Convertendo os certificados (.pem ➞ .der)
1. Caso esteja no Sistema Operacional Windows, recomenda-se fazer o download da ferramente [GitBash](https://gitforwindows.org/), para poder utilizar o **OpenSSL**;
2. Caso esteja no Sistema Operacional Linux, verifique se a ferramenta **OpenSSL** já está instalada, caso contrário, realize a instalação de acordo com a sua distribuição;
3. Com o terminal aberto no diretório onde estão os certificados, digite os seguintes comandos para realizar as conversões, substituindo os 'xxxxxxxxxx' pelos nomes dos arquivos correspondentes:
```powershell
openssl x509 -in xxxxxxxxxx-certificate.pem.crt -out cert.der -outform DER 
openssl rsa -in xxxxxxxxxx-private.pem.key -out private.der -outform DER
openssl x509 -in AmazonRootCA1.pem -out ca.der -outform DER
```

---

### Preparando o ambiente para carregar o código na placa
1. Clone o repositório [SD-PBL3-ESP8266](https://github.com/AllanCapistrano/SD-PBL3-ESP8266)
2. No diretório do repositório clonado, crie um novo diretório chamado ``data`` e mova os certificados convertidos para o mesmo;
3. Abra o projeto na IDE do Arduino, e preencha as credenciais necessárias: 
```cpp
const char* ssid = "nomeDaRede"; /*Nome da Rede WiFi*/
const char* password = "senhaDaRede"; /*Senha da Rede WiFi*/
```
4. No menu lateral da página do IoT Core na AWS, clique em **Configurações** e copie o Endpoint;
5. No código do Arduino, preencha com o seu endpoint (copiado anteriormente) como na linha abaixo:
```cpp
const char* AWS_endpoint = "seuEndpoint"; //Endpoint do dispositivo na AWS.
```
6. No menu superior da Arduino IDE, clique em **Ferramentas** ➞ **Gerenciar Bibliotecas**;
7. Faça o download das seguintes bibliotecas: ``PubSubClient``, ```NTPClient``` e ``LinkedList``.

### Carregando o código na placa
1. No menu superior, clique em **Ferramentas** ➞ **Flash Size** e clique em **4MB (2MB)**;
2. No menu superior, clique em **Ferramentas** ➞ **ESP8266 Sketch Data Upload** e aguarde a mensagem **Image Uploaded**;
3. Abaixo do menu superior clique na seta para a direita ``⮊`` para carregar o código na placa e aguarde a mensagem **Done Uploading**;
4. Abra o monitor serial 🔎, localizado no canto superior direito, selecione o valor ``115200 baud``, e aguarde a mensagem **Conectado**;

---

## Laravel

### Instalando o PHP
1. No Sistema Operacional Windows, recomenda-se a instalação da ferramenta [XAMPP](https://www.apachefriends.org/pt_br/index.html);
2. No Sistema Operacional Linux, instale o PHP de acordo com a sua distribuição. Também será necessário a instalação do Apache e do MySQL;

---

### Instalando o Composer
1. No Sistema Operacional Windows, instale a ferramenta [Composer](https://getcomposer.org/);
2. No Sistema Operacional Linux, instale a ferramenta Composer de acordo com a sua distribuição;

---

### Configurando o projeto Laravel
1. Abra um terminal no diretório em que deseja criar o projeto, e digite os seguintes comandos:
```powershell
git clone https://github.com/JoaoErick/SD-PBL3-Web.git
composer install 
cp .env.example .env
php artisan key:generate
```
2. No diretório do projeto Laravel, criei um novo diretório chamado ``data``;
3. Neste diretório criado, coloque os arquivos dos certificados que possuem a extensão ``.pem``;
4. Entre no diretório ``config`` do projeto Laravel, e abra o arquivo ``mqtt-client.php``;
5. Nesse arquivo, substitua ``xxxxxxxxxx`` pelos nomes dos certificados correspondentes e também substitua o ``seuEndpoint`` pelo seu endpoint.
6. Abra o terminal, e execute o seguinte comando:
```powershell
php artisan config:clear
```
---

## Elastic Beanstalk e AWS RDS

### Hospedando a Aplicação Web
1. No diretório da aplicação Laravel, compacte todos arquivos e diretórios, menos o diretório oculto ``.git``;
2. Entre no [AWS Console](https://console.aws.amazon.com/console/home?region=us-east-1#);
3. Acesse o serviço Elastic Beanstalk;
4. Clique em **Create Application**
5. Insira o nome da aplicação;
6. Selecione a plataforma **PHP**, e selecione **PHP 7.4** em **Ramificação da plataforma**;
7. Em **Código do aplicativo** selecione **Fazer upload do código** e escolha o arquivo compactado anteriormente;
8. Clique em **Criar aplicativo**;
9. No menu lateral, clique em **Configuração**. Na categoria **Software** clique em **Editar**, em **Raiz do documento** digite ``/public`` e clique em **Aplicar**;
10. No menu lateral, clique em **Configuração**. Na categoria **Banco de dados** clique em **Editar**, digite o **Nome de usuário** e **Senha** (serão utilizados no arquivo ``.env``), e clique em **Aplicar**;
11. No menu lateral, clique em **Configuração**. Na categoria **Banco de dados** clique em **Endpoint**;
12. Na página do RDS, clique no Banco de Dados que foi gerado, copie o **Endpoint** e **Port**
13. Abra o arquivo ``.env`` no aplicação Laravel e altere os seguintes campos: 
```php
DB_HOST=endpointCopiado
DB_PORT=portCopiada
DB_USERNAME=nomeDeUsuarioDoBD
DB_PASSWORD=senhaDoBD
```
14. Ainda na página do Banco de Dados criado, clique em **Configuration** e copie o **DB name**
15. No arquivo ``.env``, altere o campo:
```php
DB_DATABASE=dbName
```
16. Clique em **Connectivity & security**, na aba **Security group rules**, selecione o **Security group** que possua o **Type** **EC2 Security Group - Inbound**;
17. Na página do EC2, clique em **Ações**, e selecione a opção **Editar regras de entrada**;
18. Clique em **Adicionar regra**, selecione o tipo **MYSQL/Aurora**, selecione a origem **Qualquer lugar**, e clique em **Salvar regras**;
19. Abra um terminal no diretório do projeto, e digite os seguintes comandos:
```powershell
php artisan config:clear
php artisan migrate --seed
```
19. Novamente compacte todos arquivos e diretórios menos o diretório oculto ``.git``;
20. Na parte do ambiente da aplicação no Elastic Beanstalk, clique em **Fazer upload e implantar**;
21. Selecione o arquivo compactado, e clique em **Implantar**.

---

## AWS Lambda

### Adicionando função Lambda ao projeto
1. Entre no [AWS Console](https://console.aws.amazon.com/console/home?region=us-east-1#);
2. Acesse o serviço Lambda;
3. Clique em **Criar função**
4. Insira o nome da função
5. Selecione ``Python 3.8`` para a linguagem da função e clique em **Criar função**;
6. Apague o arquivo ``lambda_function.py``;
7. Faça o download do arquivo [connection_lambda_function.zip](https://github.com/JoaoErick/SD-PBL3-Web/releases/tag/1.0);
8. Na página do Lambda, clique em **Fazer upload de** ➞ **arquivo .zip**, e selecione o ``connection_lambda_function.zip`` baixado;
9. Repita este mesmo procedimento para as seguintes funções lambdas: [historic_lambda_function.zip](https://github.com/JoaoErick/SD-PBL3-Web/releases/tag/1.1) e [alarm_mode_lambda_function.zip](https://github.com/JoaoErick/SD-PBL3-Web/releases/tag/1.2).

### Vinculando funções Lambda ao AWS IoT Core
1. Entre no [AWS Console](https://console.aws.amazon.com/console/home?region=us-east-1#);
2. Acesse o serviço IoT Core;
3. No menu lateral esquerdo clique em **Agir** ➞ **Regras**;
4. Clique em **Criar** e digite o nome para sua regra;
5. Em **Instrução da consulta da regra**, substitua ``'iot/topic'`` por ``'connectionInTopic'``;
6. Em **Definir uma ou mais ações** clique em **Adicionar ação**, selecione a opção **Chamar uma função Lambda transmitindo a mensagem de dados**, depois clique em **Configurar ação**;
7. Nessa nova página, selecione a função Lambda correspondente à ``connection_lambda_function.zip``;
8. Repita este mesmo procedimento para as seguintes funções lambdas, substituindo o ``'iot/topic'`` pelos tópicos entre parênteses: ``historic_lambda_function.zip`` (``dailyHistoricInTopic``) e ``alarm_mode_lambda_function.zip`` (``alarmModeInTopic``).

---

## Alexa Voice Service

### Criando uma Skill
1. Entre no [Amazon Alexa](https://www.amazon.com/ap/signin?openid.pape.preferred_auth_policies=Singlefactor&clientContext=132-6380408-1801301&openid.pape.max_auth_age=7200000&openid.return_to=https%3A%2F%2Fdeveloper.amazon.com%2Fen-US%2Falexa&openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.assoc_handle=amzn_dante_us&openid.mode=checkid_setup&marketPlaceId=ATVPDKIKX0DER&openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0&);
2. Caso não possua uma conta, crie-a;
3. Após efetuado o login, clique em **Create Alexa Skills** ➞ **Console** ➞ **Create Skill**;
4. Digite um nome para a mesma, em **Choose a model to add to your skill** selecione **Custom**, em **Choose a method to host your skill's backend resources** selecione **Provision your own**;
5. Clique em **Create skill**. Em **Choose a template to add to your skill** selecione **Start from Scratch**, e clique em **Choose**;
6. Faça o download do [alexa_lambda_function.zip](https://github.com/JoaoErick/SD-PBL3-Web/releases/tag/1.3), descompacte os arquivos, 
no diretório ``certificates``, coloque os certificados que possuem a extensão ``.pem`` (os mesmos utilizados em [Configurando o projeto Laravel](#configurando-o-projeto-laravel));
7. Abra o arquivo ``lambda_function.py`` no editor de sua preferência, substituindo os campos ``xxxxxxxxxx`` pelos nomes dos certificados correspondentes, substitua 
o ``ENDPOINT`` pelo seu endpoint e também ``CLIENT_ID`` pelo nome da sua coisa do AWS IoT Core;
8. Ainda nesse arquivo, preencha com as suas **Credenciais do RDS** nos campos correspondentes:
```python
#--------------- Credenciais do RDS ----------------------
rds_host  = "endpoint_do_RDS"
name = "nome_do_usuario_do_banco_de_dados"
password = "senha_do_banco_de_dados"
db_name = "nome_do_banco_de_dados"
```
9. Compacte ``lambda_function.py``, ``diretório certificates`` e ``package``, e repita os passos da seção [Adicionando função Lambda ao projeto](#adicionando-função-lambda-ao-projeto);
10. Ainda na página do Lambda, clique em **Adicionar gatilho**, selecione **Kit Alexa Skills**, e marque a opção **Habilitar** em **Verificação do ID da habilidade**;
11. Volte para a página do **alexa developer console**, na seção **Build**, clique na opção do menu lateral **Endpoint** e copie o **Your Skill ID**;
12. Com o ID da sua skill copiado, volte para a página do Lambda, e em **ID da habilidade**, cole-o e clique em **Adicionar**;
13. Recarregue a página, copie o **ARN da função** que está na seção **Visão geral da função**;
14. Após isso, volte para a página **Endpoint** do **alexa developer console**, cole o **ARN da função** em **Default Region**, e clique em **Save Endpoints** no topo da página.

### Adicionando comandos à essa Skill
1. Na página do **alexa developer console**, na seção **Build**, clique na opção do menu lateral **invocation** e escreva a frase para iniciar a sua Skill;
2. Clique em **Save Model**;
3. Faça o download do [alexa-developer.zip](https://github.com/JoaoErick/SD-PBL3-Web/releases/tag/1.4), e descompate-o;
4. No menu lateral esquerdo, clique em **Interaction Model** ➞ **Intents** ➞ **+ Add Intent**;
5. Em **Create custom intent** digite **connection** e clique em **Create custom intent**;
6. Clique em **Bulk Edit** e selecione o arquivo ``connection.csv``, clique em **Submit** e depois clique em **Save Model**;
7. Repita os passos 5 e 6 para as intentes: **interval** (``interval.csv``), **alarmMode** (``alarmMode.csv``), **getAlarmMode** (``getAlarmMode.csv``);
8. Ainda na página de **Intents**, selecione a intent **AMAZON.StopIntent**, e repita o passo 6 utilizando o arquivo ``AMAZON.StopIntent.csv``;
9. No menu lateral esquerdo, clique em **Assets** ➞ **Slots Types** ➞ **+ Add Slot Type**;
10. Em **Create a custom slot type with values** digite **modeAlarm** e clique em **Next**;
11. Clique em **Bulk Edit** e selecione o arquivo ``slots-modeAlarm-values.csv``, clique em **Submit** e depois clique em **Save Model**;
12. Volte para a página de **Intents**, clique em **alarmMode**, em **Intent Slots**, clique em **Select a slot type** e selecione **modeAlarm**;
13. Clique em **Save Model** e depois em **Build Model**.

### Testando a Skill criada
1. Faça o download do aplicativo Amazon Alexa ([Android](https://play.google.com/store/apps/details?id=com.amazon.dee.app&hl=pt_BR&gl=US) | [IOS](https://apps.apple.com/br/app/amazon-alexa/id944011620))
2. Abra o aplicativo e entre com a mesma conta utilizada no **alexa developer console**;
3. Clique na opção **Mais** ➞ **Skills e Jogos** ➞ **Suas Skills** ➞ **Desenvolvimento**;
4. Selecione a Skill criada, e ative-a;
5. A partir disso, é possível se comunicar com os serviços da Alexa através do comando abaixo;
```md
"Alexa, iniciar ~sua frase de invocação~"
```
6. Após o serviço ser incializado, é possível utilizar qualquer um dos comandos importados na página de **Intents**, consulte os comandos de cada Intent para utilizar os 
recursos, por exemplo:
```md
"Me diga o estado da conexão"
```

---

## Aplicação Web

1. Clique no link gerado pelo ambiente do Elastic Beanstalk para acessar a aplicação Web.
