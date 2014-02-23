Controla Car baseado no ACK DEFAULT EM ZEND FRAMEWORK2

INSTALAÇÃO:

Requisitos:
PHP 5.3.5 ou maior
Módulos do apache: rewrite
Mysql 5.5 ou maior

Um requisito do zend framework 2, por questões de segurança, é que o DOCUMENT_ROOT da aplicação aponte para o diretório <public> e não para a pasta raíz do projeto.

Procidimentos:
Copie o projeto para o diretório de produção.
Configure o apache para apontar para o projeto/public
Habilite o mod_rewrite (caso não esteja habilitado) do apache e reinicie o serviço.
Importe o banco de dados disponível em docs/schema.sql ou docs/schemaFallback.sql
Assegure-se que as permissões no diretório estejam adequadas.

Pronto! Sua intalação foi efetuada.

DOCUMENTAÇÃO

Documentação global do código pode ser encontrado em docs/doxygen em html ou latex.
A documentação de módulos reside dentro da pasta doc do próprio módulo e não dentro da pasta docs principal. Os arquivos de documentação residentes no código chamam-se README.md.

LICENSE
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>
PHP version 5
category  WebApps2
author    Jean Carlo Machado <j34nc4rl0@gmail.com> Ricardo Moro <ricardo.moro@bento.ifrs.edu.br>
license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
link      http://github.com/zendframework/zf2 for the canonical source repository

Exemplo de virtualhost apontando para a pasta public
Listen 990
<VirtualHost *:990>
    DocumentRoot /home/user/Projects/estagios/public

    SetEnv APPLICATION_ENV "development"

    <Directory /home/user/Projects/estagios/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
