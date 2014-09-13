<?php
/**
 * classe que realiza diversos trabalhos relativos à idiomas no framework (depreciada utilizar api de tradução do zend)
 * PHP version 5
 *
 * LICENSE:  This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @link       http://www.icub.com.br
 */
namespace AckCore\Language;
class Language
{
    /**
     * nome da sessao
     */
    const SESSION_NAME = "lang";
    const DEFAULT_LANG = "pt";
    private static $translations = null;

    protected static $_languages = array('pt','en','es');
    protected static $langs = array(
                        "pt" => array("name"=>"Português"),
                        "en" => array("name"=>"Inglês"),
                        "es" => array("name"=>"Espanhol"),
                        );

    /**
     * retorna a linguagem atual
     * @return [type] [description]
     */
    public static function current()
    {
        if(!isset($_SESSION[self::SESSION_NAME]))
            $_SESSION[self::SESSION_NAME] = self::DEFAULT_LANG;

        return $_SESSION[self::SESSION_NAME];
    }

    /**
     * seta a linguagem atual
     */
    public static function setCurrent($lang = null)
    {
        $lang = strtolower($lang);

        if (in_array($lang, self::$_languages)) {
            $_SESSION[self::SESSION_NAME] = $lang;
            setcookie("lang",$lang);
        } else {
            throw new \Exception("Lingua selecionada indisponível ou inexistente");
        }
    }

    /**
     * traduz uma string para o idioma setado em setCurrent
     * @param  string $str [description]
     * @return [type] [description]
     */
    public static function translate($str,$lang="pt")
    {
        return $str;

        // if (!self::$translations) {
        // 	require \AckCore\Facade::getInstance()->getTranslateFilePath();

        // 	self::$translations = $trl;
        // }
        // $trl = self::$translations;
        // /**
        //  * testa se existe uma entrada na tabela languages
        //  * se nao existir retorna o valor normal
        //  * @var [type]
        //  */

        // if(!is_array($trl))
        // 	throw new \Exception("array de traduções não setado, ou não linkado corretamente");

        // if (!empty($trl[\AckCore\Language\Language::current()][$str])) {
        // 	return $trl[\AckCore\Language\Language::current()][$str];
        // }

        // foreach ($trl[$lang] as $columnId => $column) {

        // 	if ($column == $str) {

        // 		if(!isset($trl[\AckCore\Language\Language::current()][$columnId]))
        // 			break;

        // 		return $trl[\AckCore\Language\Language::current()][$columnId];
        // 	}
        // }
        // 	return $str;
    }

    /**
     * retorna a configuração da classe
     * @param  [type] $config [description]
     * @return [type] [description]
     */
    public function getConfig()
    {
        $config = System_Config::get();

        return $config->system->controller;
    }

    /**
     * retorna as configurações globais
     * @param  [type] $config [description]
     * @return [type] [description]
     */
    public function getConfigGlobal()
    {
        $config = System_Config::get();

        return $config->global;
    }

    public static function getDefault()
    {
        return "pt";
    }

    /**
     * testa se a linguagem está habilitada
     * @return boolean
     */
    public static function hasEnglish()
    {
        $model = new \AckCore\Model\Languages();
        $resultLang = $model->toObject()->onlyAvailable()->get(array("abreviatura"=>"en"));

        $resultLang = reset($resultLang);

        if(empty($resultLang))

            return false;

        $result=  $resultLang->getVisivel()->getVal();

        return $result;
    }

    /**
     * testa se a linguagem está habilitada
     * @return boolean
     */
    public static function hasPortuguese()
    {
            $model = new \AckCore\Model\Languages();
        $resultLang = $model->toObject()->onlyAvailable()->get(array("abreviatura"=>"pt"));

        $resultLang = reset($resultLang);

        if(empty($resultLang))

            return false;

        $result=  $resultLang->getVisivel()->getVal();

        return $result;
    }

    public static function getCorrespondentLanguageNameByAcronym($acronym  = "pt")
    {
        return self::$langs[$acronym]["name"];
    }
}
