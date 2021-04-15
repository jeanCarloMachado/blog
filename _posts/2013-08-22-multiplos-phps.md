---
layout: post
title: Múltiplas instalações do PHP
---

Recentemente urgiu a necessidade de ter a última versão do PHP no
servidor da empresa onde trabalho. Contudo, o sistema utiliza o Plesk,
com as diversas customizações que este serviço faz ao apache e suas
respectivas instalações do PHP fica difícil fazer qualquer customização,
outrossim, a probabilidade que quebrar o servidor é alta. Sendo assim,
pesquisei a possibilidade de instalar outro servidor web, preservando as
seguintes condições/requisitos: não alterar as configurações do apache e
suportar várias versões do PHP em paralelo. Resumindo, conheci o NGINX, 
e com as customizações que aqui apresentarei, foi possível alcançar os
requisitos além disso, experienciar um servidor web muito mais agradável
de se administrar.

O NGINX pareceu-me muito mais organizado em relação ao Apache,
principalmente quando relativo aos arquivos de configuração: mais limpos
e melhor organizados, utilizando um padrão quase json. A inexistência de
**.htaccess** também me deixou contente pois estes sempre são de difícil
compreensão bem como necessitam estar juntamente à aplicação; a
estratégia do NGINX é manter todas estas configurações na própria
virtualhost. O NGINX é também conhecido por sua escalabilidade e maior
performance em aplicações tipo *plain text*.

**Observações**:

Testei este processo em duas máquinas, uma com CentoOS 5.8 e outra com
Centos 6.5, as diferenças para ambos estão descritas ao longo do texto.
Para utilizar em outras distribuições, pode-se variar o processo de
instalação do NGINX e o local de residência dos arquivos de
configuração.

Utilizei a seguintes convenção de nomenclatura: todo o código fonte e
estrangeirismos estão em *itálico*.


 **PASSO 1 - COMPILANDO O PHP**

Primeiramente devemos fazer o download de  uma versão do PHP no site
[php.net](/posts/editar/php.net/downloads.php).

Baixei a mais nova versão estável no tempo de publicação deste post  à
dizer: 5.5.12.

``mkdir -p ~/builds/php && cd \~/builds/php``

``wget <http://us1.php.net/get/php-5.5.12.tar.gz/from/a/mirror>``

 

Extraia e entre na pasta

Para tar.gz

``tar -zxvf php-5.5.12.tar.gz``

Para tar.bz2

``tar -jxf php-5.5.12.tar.gz``

``cd php-5.5.12``

 

Configure as opções e extensões que deseja nesta instalação - minhas
opções padrões são da forma que segue:

```
./configure --prefix=/opt/php-5.5.12 --with-pdo-pgsql --with-zlib-dir
--with-freetype-dir --enable-mbstring --with-libxml-dir=/usr
--enable-soap --enable-calendar --with-curl --with-mcrypt --with-zlib
--with-gd --with-pgsql --disable-rpath --enable-inline-optimization
--with-bz2 --with-zlib --enable-sockets --enable-sysvsem
--enable-sysvshm --enable-pcntl --enable-mbregex --with-mhash
--enable-zip --with-pcre-regex --with-mysql --with-pdo-mysql
--with-mysqli --with-jpeg-dir=/usr --with-png-dir=/usr
--enable-gd-native-ttf --with-openssl --with-fpm-user=nginx
--with-fpm-group=nginx --with-libdir=lib64 --enable-ftp --with-imap
--with-imap-ssl --with-kerberos --with-gettext --enable-cgi
```

 Algumas coisas devem ser levadas em consideração neste ponto:

-   Deve-se habilitar o fast-cgi como mostrado no último parâmetro:
    *--enable-cgi*
-   Deve-se setar o local de instalação através do parâmetro
    *--prefix=/opt/php-5.5.12*
-   Se desejas utilizar a mesma instalação do php com o apache via FPM
    deves utilizar os parâmetros: *fpm-user=apache
    --with-fpm-group=apache*.

Se você não compila com frequência em seu computador, provavelmente
necessitará resolver depencências antes de compilar. O escopo este post
não leva em consideração o provisionamento de bibliotecas; entretanto, a
maioria dos erros são facilmente remediáveis quando jogados no Google
:).


Os executáveis necessários para a compilação podem ser instalados
através do comando:

``yum groupinstall "Development Tools" "Development Libraries"``

Compile o php e instale-o:
 ``make && make install``


 Copie o php.ini de sua compilação para o local necessário na
instalação:
 ``cp -rf ~/builds/php/php-5.5.12/php.ini-production
/opt/php-5.5.12/lib/php.ini``

 Se fores utilizar o php.ini que o PHP gera, ao menos adicione o
*timezone* isso pode poupar-lhe grandes problemas.
 ``echo "date.timezone = \"America/Sao\_Paulo\\"" &gt;&gt;
/opt/php-5.5.12/lib/php.ini``

 Para um php.ini já configurado para o desenvolvimento testado em php
5.5.9 à 5.5.12 confira
[aqui](https://gist.github.com/jeanCarloMachado/3e9b0bde19db16176623).


 **PASSO 2 - INSTALANDO O  NGINX**

 Instale os repositórios requisitos:


 Para CentOS 6
 ``rpm -Uvh
http://download.fedoraproject.org/pub/epel/6/i386/epel-release-6-7.noarch.rpm``
 ``rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm``


Para CentOS 5
 ``rpm -Uvh
http://dl.fedoraproject.org/pub/epel/5/i386/epel-release-5-4.noarch.rpm``
 ``rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-5.rpm``


 Adicione o repositório de nginx em
 ``/etc/yum.repos.d/nginx.repo``

```
 *[nginx\]*\
 *name=nginx repo*
 *baseurl=http://nginx.org/packages/centos/$releasever/\$basearch/*\
 *gpgcheck=0*
 *enabled=1*
```

 Para verificar as versões disponíveis do NGINX digite:
 ``yum --enablerepo=remi list nginx``

 Instale com o seguinte comando:
 ``yum --enablerepo=remi install nginx``

 

**PASSO 3 - CONFIGURANDO O NGINX**

 Depois da instalação devemos fazer modificações no arquivo de
configuração do nginx */etc/nginx/nginx.conf* para que cumpra com nossos
requisitos.


 É recomendável trocar o valor de *worker_processes* para o número de
processadores de seu servidor. Pode-se conseguir esta informação através
do comando:

``cat /proc/cpuinfo | grep processor | wc -l``

Adicione a cláusula se desejares reescrever as configurações de log em
suas virtualhosts:

```
 http {
 # Debug rewrite rules\
 rewrite_log on;\
 }
```
 Elimine a configuração default de servidor do nginx:

``rm /etc/nginx/conf.d/default.conf``



 Adicione a virtualhost de seu php (e mais qualquer uma que deseje
criar) no arquivo ``/etc/nginx/conf.d/virtual.conf``

```
 *server {*
*     server_name 127.0.0.1;*\
 *     listen 5512;*
 *     root ~/tests/php/5.5.12;*\
 *     index index.php;*
 *     fastcgi_index index.php;*\
 *     error_log /var/log/nginx/error.log debug;*\

 *     location ~ \\.htaccess {*\
 *          deny all;*
 *     }*

 *     location / {*
 *          index index.php;*
 *     }*

 *     #rewrite engine equivalente ao .htaccess*\
 *     #funciona out of the box com os principais frameworks*\
 *     # disponíveis*\
 *     error_page 404 = /index.php;*\
 *     if (!-e $request\_filename) {*\
 *          rewrite ^.\*\$ /index.php last;*\
 *     }*

 *     location ~ \\.php {*\
 *          try_files \$uri =404;*\
 *          include /etc/nginx/fastcgi_params;*\
 *          keepalive_timeout 0;*\
 *          fastcgi_param SCRIPT\_FILENAME
$document\_root\$fastcgi\_script\_name;*\
 *          # essa parte é importante, a porta aqui selecionada deve
ser a mesma do script de inicialização do nginx*
 *          # para a versão coreta do php*\
 *          fastcgi_pass 127.0.0.1:9000;*\
 *     }*
 *}*
```


A fim de que consigamos trabalhar com múltiplas versões do php
necessitamos alterar o script de inicialização do daemon e forçá-lo a
ouvir portas específicas para cada versão do PHP que desejarmos. No
arquivo */etc/init.d/nginx* procure pela função *start() {}*  e altere
seu conteúdo para que fique equivalente a este:

```
 *start() {*
*     USER=nobody*
 *     PHP_55\_BIND=127.0.0.1:9000*\
 *     PHP_55\_CGI=/opt/php-5.5.11/bin/php-cgi*\
 *     PHP_FCGI\_CHILDREN=15*\
 *     PHP_FCGI\_MAX\_REQUESTS=1000*\
 *     PHP_CGI\_ARGS="- USER=\$USER PATH=/usr/bin*

*     PHP_FCGI\_CHILDREN=\$PHP\_FCGI\_CHILDREN*

*     PHP_FCGI\_MAX\_REQUESTS=\$PHP\_FCGI\_MAX\_REQUESTS"*\
 *     PHP_55\_CGI\_ARGS="\${PHP\_CGI\_ARGS} \${PHP\_55\_CGI} -b
${PHP\_55\_BIND}"*\

 *     killall -q -w -u ${USER} nginx*\

 *     killall -q -w -u ${USER} \${PHP\_55\_CGI}*\

 *     /usr/bin/env -- $PHP\_55\_CGI\_ARGS &*\
 *     /usr/sbin/nginx*

 *     retval=$?*\
 *     echo*
 *     [ \$retval -eq 0 \] && touch \$lockfile*\
 *     return $retval*\
 *}*
```

Neste caso forcei o NGINX a direcionar para o PHP 5.5.12 todas as
chamadas na porta 9000, sendo assim, duplicando-se as configurações de
todas as entradas *PHP_55*\* para outra, por exemplo: *PHP\_53\*,*
possibilita-se utilizar mais de uma versão do PHP. Necessário lembrar
que a respectiva porta configruada aqui, também deve estar na
virtualhost para que consigamos unir a versão específica do PHP para com
sua respectiva aplicação, como no caso da sessão da virtualhost acima:
*fastcgi_pass 127.0.0.1:9000;*.

Marque o serviço para inicar junto ao boot do servidor

*chkconfig nginx on*

 

**PASSO 4 - FIREWALL**


 Caso você utilize firewall será necessário liberar as portas utilizadas
- neste tutorial: 9000 (porta do serviço nginx), 5512 (porta da
virtualhost para PHP 5.5.12).
 Para isso adicione as seguintes regras no seu /etc/sysconfig/iptables

```
 -A VZ_INPUT -p tcp -m tcp --dport 5512 -j ACCEPT\
 -A VZ_INPUT -p tcp -m tcp --dport 9000 -j ACCEPT\
 -A VZ_OUTPUT -p tcp -m tcp --sport 9000 -j ACCEPT\
 -A VZ_OUTPUT -p tcp -m tcp --sport 5512 -j ACCEPT\
```

 Reinicie o serviço:
 ``/etc/init.d/iptables restart``

 

## PASSO 5 - TESTANDO A CONFIGURAÇÃO


 Vamos adicionar um php.info para testarmos a configuração

```
mkdir ~/tests/php/5.5.12
touch ~/tests/php/5.5.12/index.php
echo "<?php phpinfo(); " &gt; ~/tests/php/5.5.12/index.php
```

### Inicie o NGINX:

``/etc/init.d/nginx start``



 Agora teste através de seu navegador o endereço: 
``{Meu IP}:5512``
 

Como já mencionado, o nginx não utiliza .htaccess  - a configuração
equivalente fica na virtualhost. O exemplo de configuração de
virtualhost aqui exposto já implementa as instruções necessárias para
funcionar out-of-the-box nos principais frameworks PHP do mercado;
entretanto, se necessitares de configurações .htacess diferentes do aqui
exposto recomendo [este](http://www.anilcetin.com/) conversor
.htaccess/nginx. Este foi o único a traduzir com sucesso umas instruções
obscuras que alguns dos sites que dou suporte utilizam.*

 

Não construi a funcionalidade de comentários no meu blog ainda, mas se
você tiver alguma dúvida pode me contatar através da sessão de contato
do mesmo.

 
