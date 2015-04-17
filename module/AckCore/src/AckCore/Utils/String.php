<?php
/**
 * funções de manipulação de strings.
 *
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
 *
 * @link       http://www.icub.com.br
 */

namespace AckCore\Utils;

class String
{
    public static function stripTags($str)
    {
        return strip_tags($str);
    }

    public static function sanitize(&$str)
    {
        $str = trim($str);
        $str = str_replace("\n", "", $str);
    }

    public static function makeInstance($str)
    {
        $instance = new $str();

        return $instance;
    }

    /**
     * pega o nome puro de um controlador deprecated.
     *
     * @param unknown $str
     *
     * @return string
     */
    public static function getCleanClassName($str)
    {
        if (strtolower(substr($str, 0, 3)) == "ack") {
            $str = substr($str, 3);
        }
        if (strtolower(substr($str, -11)) == "_controller") {
            $str = substr($str, 0, -11);
        }

        return $str;
    }
    public static function replaceSpecialCharsForAscEquiv($var, $enc = 'UTF-8')
    {
            $var = htmlentities($var);
        $acentos = array(
                   'a' => '/&Atilde;|&atilde;|&Aacute;|&aacute;|&Acirc;|&acirc;|&Agrave;|&agrave;|&Aring;|&aring;|&Auml;|&auml;|&ordf;/',
                   'c' => '/&ccedil;|&Ccedil;/',
                   'e' => '/&Eacute;|&eacute;|&Ecirc;|&ecirc;|&Egrave;|&egrave;|&Euml;|&euml;/',
                   'i' => '/&Iacute;|&iacute;|&Icirc;|&icirc;|&iexcl;|&Igrave;|&igrave;|&Iuml;|&iuml;/',
                   'n' => '/&Ntilde;|&ntilde;/',
                   'o' => '/&Oacute;|&oacute;|&Ocirc;|&ocirc;|&Ograve;|&ograve;|&Oslash;|&oslash;|&ordm;|&Otilde;|&otilde;|&Ouml;|&ouml;/',
                   'u' => '/&Uacute;|&uacute;|&Ucirc;|&ucirc;|&Ugrave;|&ugrave;|&Uuml;|&uuml;/',
                   'y' => '/&Yacute;|&yacute;|&yen;|&Yuml;|&yuml;/',
            );

        $var = preg_replace($acentos, array_keys($acentos), $var);

        return $var;
    }

    public static function replaceAcentuationForEntity($var, $enc = 'UTF-8')
    {
        $acentos = array(
                        'a' => '/&Atilde;|&atilde;|&Aacute;|&aacute;|&Acirc;|&acirc;|&Agrave;|&agrave;|&Aring;|&aring;|&Auml;|&auml;|&ordf;/',
                        'c' => '/&ccedil;|&Ccedil;/',
                        'e' => '/&Eacute;|&eacute;|&Ecirc;|&ecirc;|&Egrave;|&egrave;|&Euml;|&euml;/',
                        'i' => '/&Iacute;|&iacute;|&Icirc;|&icirc;|&iexcl;|&Igrave;|&igrave;|&Iuml;|&iuml;/',
                        'n' => '/&Ntilde;|&ntilde;/',
                        'o' => '/&Oacute;|&oacute;|&Ocirc;|&ocirc;|&Ograve;|&ograve;|&Oslash;|&oslash;|&ordm;|&Otilde;|&otilde;|&Ouml;|&ouml;/',
                        'u' => '/&Uacute;|&uacute;|&Ucirc;|&ucirc;|&Ugrave;|&ugrave;|&Uuml;|&uuml;/',
                        'y' => '/&Yacute;|&yacute;|&yen;|&Yuml;|&yuml;/', );

        $var = preg_replace($acentos, array_keys($acentos), htmlentities($var, ENT_NOQUOTES, $enc));
                //$var = strtolower($var);
                return $var;
    }

        /**
         * retorna uma string com suas palavras com o primeiro elemento em caixa alta.
         *
         * @param  string $str [description]
         *
         * @return [type]      [description]
         */
        public static function upWords(string $str)
        {
            $str = strtolower($str);
            $str = preg_replace('#\s(como?|d[aeo]s?|desde|para|por|que|sem|sob|sobre|trás)\s#ie', '" ".strtolower("\1")." "', ucwords($str));

            return $str;
        }
        /**
         * (MELHORAR ESSA FUNÇÃO)
         * procura similaridades entre calledName e name
         * removendo os sufixos de name.
         *
         * @param unknown $calledName
         * @param unknown $arrayNames
         */
        public static function matchWithoutSuffixes($calledName, $name)
        {
            $calledName = strtolower($calledName);
            $name = strtolower($name);

            if ($calledName == $name) {
                return $name;
            }

            $oldName = $name;
            $oldCalledName = $calledName;

                //testa se o name é explodível
                {
                        $name = explode("_", $name);

                        if (count($name) <= 1) {
                            return;
                        }

                        if ($calledName == $name[count($name) -1]) {
                            return $oldName;
                        }
                }

            return;
        }

        /**
         * retorna uma posicao específica de uma string explodiad em array.
         *
         * @param  string  $position     [description]
         * @param  [type]  $str          [description]
         * @param  string  $explodeKey   [description]
         * @param  boolean $triggerError [description]
         *
         * @return [type]                [description]
         */
        public static function getPositionFromExplode($position = "last", $str, $explodeKey = '-', $triggerError = false)
        {
            $arr = explode($explodeKey, $str);

            if (is_int($position)) {
                if ($triggerError && !array_key_exists($position, $arr)) {
                    throw new \Exception("posição $position não encontrada no array.");
                }

                return @$arr[$position];
            } elseif ($position == "last") {
                return end($arr);
            }

            throw new \Exception("Funcionalidade ainda não mapeada");
        }

        /**
         * testa se determinada string tem sufixo de
         * algum idioma no sistema, caso tenha retorna-o.
         *
         * @param unknown $string
         */
        public static function hasLangSuffix($string)
        {
            $container = \AckCore\Facade::getInstance();
            $langSuffixes = $container->getLanguageSuffixes();

            $string = explode("_", $string);
            if (count($string) <= 1) {
                return false;
            }

            $string = end($string);

            if (in_array($string, $langSuffixes)) {
                return $string;
            }

            return false;
        }

        /**
         * retorna a extençãod e uma string (o valor depois do último ponto).
         *
         * @param  [type] $str [description]
         *
         * @return [type]      [description]
         */
        public static function getExtension($str)
        {
            $str = explode(".", $str);

            return end($str);
        }

        /**
         * limpa um array ou string.
         *
         * @param  [type] $arr [description]
         *
         * @return [type]      [description]
         */
        public static function clean($arr)
        {
            if (!empty($arr)) {
                foreach ($arr as $key => $element) {
                    if (is_array($element)) {
                        $arr[$key] = self::clean($element);
                    } else {
                        $str = trim($element);
                        $invalid_characters = array("$", "%", "#", "<", ">", "|");
                        $str = str_replace($invalid_characters, "", $str);
                        $arr[$key] = $str;
                    }
                }
            }

            return $arr;
        }

        /**
         * mostra um número n de caracteres da string str
         * se passar disso contactena o sufixo.
         */
        public static function showNChars($str, $n = 100, $suffix = '...')
        {
            if (strlen($str) < $n) {
                return $str;
            }

            $str = substr($str, 0, $n);

            $restChars = strrpos($str, ' ');

            $n = $n - ($n - $restChars);

            $str = substr($str, 0, $n);
            $str .= $suffix;

            return $str;
        }

    public static function toUrl($str)
    {
        $str = strtolower(utf8_decode($str));
        $i = 1;
        $str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûýýÿ'), 'aaaaaaaceeeeiiiinoooooouuuyyy');
        $str = preg_replace("/([^a-z0-9])/", '-', utf8_encode($str));
        while ($i>0) {
            $str = str_replace('--', '-', $str, $i);
        }
        if (substr($str, -1) == '-') {
            $str = substr($str, 0, -1);
        }

        return $str;
    }

        /**
         * retorna os nomes das pastas das views no padrão zf2.
         *
         * @param  [type] $str [description]
         *
         * @return [type]      [description]
         */
        public static function getZF2ViewFormat(&$str)
        {
            $strCpy = $str;
            $upperStack = array();

            for ($i = 0; $i < strlen($strCpy); $i++) {
                if (ctype_upper($strCpy[$i]) && $i != 0) {
                    $upperStack[] = $strCpy[$i];
                }
            }

            foreach ($upperStack as $char) {
                $newChar = strtolower($char);
                $newChar = "-".$newChar;
                $str = str_replace($char, $newChar, $str);
            }
            $str = strtolower($str);
            if ($str[0] == "-") {
                $str = substr($str, 1);
            }
        }

        /**
         * da espace de uma string.
         *
         * @param  [type] $str [description]
         *
         * @return [type]      [description]
         */
        public static function escape($str)
        {
            return $str;

            $str = str_replace('\n', '', $str);

            return mysql_escape_string($str);
        }

    public static function unEscape($str)
    {
        return $str;

        $str = stripslashes($str);

        return mysql_real_escape_string($str);
    }
        /**
         * search and replace recursivo à partir de dir.
         *
         * @param  [type] $dir           [description]
         * @param  [type] $stringsearch  [description]
         * @param  [type] $stringreplace [description]
         *
         * @return [type]                [description]
         */
        public static function searchAndReplace($dir, $stringsearch, $stringreplace)
        {
            $listDir = array();
            if ($handler = opendir($dir)) {
                while (($sub = readdir($handler)) !== false) {
                    if ($sub != "." && $sub != ".." && $sub != "Thumb.db") {
                        if (is_file($dir."/".$sub)) {
                            if (substr_count($sub, '.php') || substr_count($sub, '.xml')) {
                                $getfilecontents = file_get_contents($dir."/".$sub);
                                if (substr_count($getfilecontents, $stringsearch)>0) {
                                    $replacer = str_replace($stringsearch, $stringreplace, $getfilecontents);
                                // Let's make sure the file exists and is writable first.
                                  if (is_writable($dir."/".$sub)) {
                                      if (!$handle = fopen($dir."/".$sub, 'w')) {
                                          echo "Cannot open file (".$dir."/".$sub.")";
                                          exit;
                                      }
                                      // Write $somecontent to our opened file.
                                      if (fwrite($handle, $replacer) === false) {
                                          echo "Cannot write to file (".$dir."/".$sub.")";
                                          exit;
                                      }

                                      fclose($handle);
                                  } else {
                                      echo "The file ".$dir."/".$sub." is not writable";
                                  }
                                }
                            }
                            $listDir[] = $sub;
                        } elseif (is_dir($dir."/".$sub)) {
                            $listDir[$sub] = self::searchAndReplace($dir."/".$sub, $stringsearch, $stringreplace);
                        }
                    }
                }
                closedir($handler);
            }

            return $listDir;
        }

    /**
     * pega strings contendo nomes no padrão do banco
     * e as transforma em strings líveis pelo usuário.
     *
     * @param [type] $str [description]
     *
     * @return [type] [description]
     */
    public static function humanizeDbName($str)
    {
        $str = explode("_", $str);
        $str = reset($str);
        $str = ucfirst($str);

        return $str;
    }
}
