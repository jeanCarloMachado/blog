<?php
return array(
    'elementsSettings' => array(
        'FilterHTMLTypePreffix' => '\AckCore\HtmlElements\Filters\\',
        'HTMLElementPreffix' => '\AckCore\HtmlElements\\',
        'HTMLElementDefaultPermission' => 2,
        'overrideConfig' => false,
        /**
         * prioridade das definições do maior para a menor, as maiores sobreescrevem as menores no interpretador
         */
        'priority' => array (
            'names',
            'types',
        ),
        /**
         * denifições das configurações
         */
        'definitions' => array(
            'types' => array(
                '/^int.*/' => array('FilterHTMLType' => 'Input', 'SearchPattern' =>'Equals','HTMLElementType'=>'Input'),
                '/^decimal.*/' => array('SearchPattern' =>'Equals','HTMLElementType'=>'Float'),

                '/^varchar\([2-9][5-9][0-9]\)$/' => array('FilterHTMLType' => 'Input', 'SearchPattern' =>'DoubleLike', 'HTMLElementType'=>'TextArea'),
                '/^varchar\(.*\)$/' => array('FilterHTMLType' => 'Input', 'SearchPattern' =>'DoubleLike', 'HTMLElementType'=>'Input'),
                '/^text$/' => array('FilterHTMLType' => 'Input','SearchPattern' =>'DoubleLike','HTMLElementType'=>'TextEditor'),
                '/^date.*$/' => array('FilterHTMLType' => 'Date','SearchPattern' =>'Equals','renderFilter' =>true,'HTMLElementType'=>'Date'),
                '/^boolean$/' => array('FilterHTMLType' => 'BooleanCheck','SearchPattern' =>'Equals','HTMLElementType'=>'BooleanSelector'),
                '/^set\(\'?\'.*\'?\'\)$/' => array('FilterHTMLType' => 'BooleanCheck','SearchPattern' =>'Equals', 'HTMLElementType'=>'BooleanSelector'),
                '/^tinyint.*/' => array('FilterHTMLType' => 'BooleanCheck','SearchPattern' =>'Equals', 'HTMLElementType'=>'BooleanSelector'),
            ),
            'names' => array(
                '/^id$/' => array('FilterHTMLType' => 'Input','SearchPattern' =>'Equals', 'renderForm'=>false, 'HTMLElementType'=>'Input', 'HTMLElementPermission'=>1),
                '/^.*_id$/' => array('FilterHTMLType' => 'Input','SearchPattern' =>'Equals', 'renderForm'=>false),
                '/^titulo.*$/' => array('FilterHTMLType' => 'Input','SearchPattern' =>'DoubleLike', 'HTMLElementType'=>'Input'),
                '/^bairro.*$/' => array('HTMLElementType'=>'Input'),
                '/^endereco.*$/' => array( 'HTMLElementType'=>'TextArea','title'=>'Endereço'),
                '/^empresa.*$/' => array( 'HTMLElementType'=>'Input'),
                '/^fone.*$/' => array( 'HTMLElementType'=>'Fone'),
                '/^remetente.*$/' => array( 'HTMLElementType'=>'Input'),
                '/^email.*$/' => array( 'HTMLElementType'=>'Input','SearchPattern' =>'DoubleLike','title'=>'E-mail'),
                '/^mensagem.*$/' =>  array('FilterHTMLType' => 'Input','SearchPattern' =>'DoubleLike','HTMLElementType'=>'TextArea'),
                '/^visivel.*$/' => array('FilterHTMLType' => 'BooleanCheck','SearchPattern' =>'Equals','renderForm'=>false,'title'=>'Visível'),
                '/^status.*$/' => array('FilterHTMLType' => 'BooleanCheck', 'renderFilter' =>false, 'renderForm'=>false),
                '/^ordem.*$/' => array('renderFilter'=>false,'renderForm'=>false),
                '/^destaque.*$/' => array('renderForm'=>false),
                '/^.*data.*$/' => array('FilterHTMLType' => 'Date','SearchPattern' =>'Equals','renderFilter' =>true,'HTMLElementType'=>'Date'),
                '/^.*codigo.*$/' => array('SearchPattern' =>'DoubleLike'),
                '/^.*ano.*$/' => array('HTMLElementType' => 'Year'),
                '/^.*cor.*$/' => array('HTMLElementType' => 'Color'),
                '/^portas$/' => array('HTMLElementType' => 'Ports'),
                '/^placa$/' => array('HTMLElementType' => 'Placa'),
                '/^.*cnpj.*$/' => array('HTMLElementType' => 'CNPJ'),
                '/^.*cpf.*$/' => array('HTMLElementType' => 'cpf'),
                '/^.*classificacao.*$/' => array('HTMLElementType' => 'Rating'),
                '/^.*senha.*$/' => array('HTMLElementType' => 'PasswordManagementBlock'),
            ),
            'fallback' => array(
                array('FilterHTMLType' => 'Input', 'SearchPattern' =>'Equals','renderFilter' =>true,'HTMLElementType'=>'Input')
            ),
        )
    )
);
