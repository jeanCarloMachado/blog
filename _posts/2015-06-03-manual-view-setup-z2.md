---
layout: post
title: Setup manual de views no ZF2
---

Algum tempo atrás tive que setar from scratch uma camada de view
Zend 2 para meu ambiente de testes. Segue aí a solução caso alguém
precise de algo similar.

A camada de view do Zend Framework 2 é composta por vários
componentes - estruturados independentemente para permitir extensão e
múltiplos usos. A documentação do Zend Framework aponta os seguintes
componentes:

- Contedores de variáveis: guardam variáveis e callbacks para
serem representados na view
- Modelos de visão (view-models): armazenam Contedores de variáveis, especificam qual template
será utilizado, e implementam o padrão de software (Composite)[https://en.wikipedia.org/wiki/Composite_pattern\]

- Renderizadores: dado um Modelo de Visão, provêm uma representação
do mesmo para ser retornado. O Zend Framework disponibiliza três
renderizadores padrão: 1. PhpRenderer 2. JsonRenderer 3. FeedRenderer

- Resolvedores: Utilizam de Strategies para mapear um template para
um recurso que o Renderizador poderá consumir. - Estratégias de
renderização - Estratégias de resposta

Um processo de renderização Zend 2 se dá da
seguinte forma: O Zend recebe uma requisição do usuário, ele faz
todo o processamento prévio a view e A view do Zend 2 consiste em
estratégias que mapeaiam as requisições para um renderizador e
estratégias para injetar o resultado de uma renderização na resposta.


```
$renderer = new \Zend\View\Renderer\PhpRenderer();

$translate = new \Zend\I18n\View\Helper\Translate();
$translate->setTranslator( (new
\Zend\I18n\Translator\TranslatorServiceFactory())->createService
($serviceLocator) );

$helperPluginManager = new \Zend\View\HelperPluginManager();
$helperPluginManager->setService('translate', $translate);

$renderer->setHelperPluginManager($helperPluginManager);

$resolver = new \Zend\View\Resolver\AggregateResolver();

$renderer->setResolver($resolver);

$stack = new \Zend\View\Resolver\TemplatePathStack(array(
'script_paths' => array( getenv('PROJECT_ROOT').  '/module/Application/view', ) ));

$map = new \Zend\View\Resolver\TemplateMapResolver([
'email-layout' => getenv('PROJECT_ROOT').
'/module/Core/view/layout/layout-email.phtml' ]);

$resolver->attach($stack);

return $renderer;
```
