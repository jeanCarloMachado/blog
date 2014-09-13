<?php
namespace AckCore\View\Helper;
use Zend\View\Helper\AbstractHelper;
class Pluralizer extends AbstractHelper
{
    protected static $cache;

    /**
     * regras de pluralização
     * @var array
     */
    public static $rules = array(
    //singular     plural
        'ão'    => 'ões',
        'ês'    => 'eses',
        'm'     => 'ns',
        'l'     => 'is',
        'r'     => 'res',
        'x'     => 'xes',
        'z'     => 'zes',
    );

    /**
     * exceções
     * @var array
     */
    public static $exceptions = array(
        'cidadão' => 'cidadões',
        'mão'     => 'mãos',
        'qualquer'=> 'quaisquer',
        'campus'  => 'campi',
        'lápis'   => 'lápis',
        'ônibus'  => 'ônibus',
        "seção do site" => "seções do site",
        "página inicial" => "página inicial",
        "ajuda" => "ajuda",
        "trabalhe conosco" => "trabalhe conosco",
        "Parte do corpo" => "Partes do corpo",
        "Rede Social" => "Redes Sociais",
        'Setor ou vaga' => "Setores ou Vagas",
    );

    public function __invoke($string)
    {
        $strCpy = $string;
        if(isset(self::$cache[__FUNCTION__.$string])) return self::$cache[__FUNCTION__.$string];

        $result = null;

        //Pertence a alguma exceÃ§Ã£o?
        if(array_key_exists($string, self::$exceptions)):
            $result =  self::$exceptions[$string];
        //NÃ£o pertence a nenhuma exceÃ§Ã£o. Mas tem alguma regra?
        else:
            foreach(self::$rules as $singular=>$plural):
                if(preg_match("({$singular}$)", $string)) $result = preg_replace("({$singular}$)", $plural, $string);
            endforeach;
        endif;
        //NÃ£o pertence Ã s exceÃ§Ãµes, nem Ã s regras.
        //Se nÃ£o terminar com "s", adiciono um.
        if(substr($string, -1) !== 's') $result  = $string . 's';

        if($strCpy == $string) {
            $string.="s";
        }

        $result = $string;

        self::$cache[__FUNCTION__.$string] = $result;
        return $result;
    }
}
