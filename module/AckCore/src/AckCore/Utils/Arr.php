<?php
/**
 * classe que trata funcionalidades relativas
 * a arrays a palava array não foi utilizada pois esta
 * é uma palavra chave do php
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
 * @link       http://www.icub.com.br
 */
namespace AckCore\Utils;
class Arr
{
        /**
         * retorna uma coluna de um conjunto de objetos \AckDb\ZF1\RowAbstract
         * @param  [type] $col     [description]
         * @param  [type] $objects [description]
         * @return [type]          [description]
         */
        public static function getColFromObjects($col, $objects,$bruteVal = true)
        {
            $result = array();

            if(empty($objects)) return $result;

            foreach ($objects as $obj) {

                if($bruteVal)
                $result[]= $obj->vars[$col]->getBruteVal();
                else
                $result[]= $obj->vars[$col]->getVal();

            }

            return $result;
        }

         /**
         * retorna uma coluna de um conjunto de objetos \AckDb\ZF1\RowAbstract
         * @param  [type] $col     [description]
         * @param  [type] $objects [description]
         * @return [type]          [description]
         */
        public static function getColFromArrays($col, $arrays,$bruteVal = true)
        {
            $result = array();

            if(empty($arrays)) return $result;

            foreach ($arrays as $obj) {

                $result[]= $obj[$col];
            }

            return $result;
        }

        /**
         ** $getPhoto =  function ($object, &$result) {
          *          $photo =  \AckMultimidia\Model\Photos::getFirst();
          *          if(!empty($photo))
          *          $result[$object->getId()->getBruteVal()]['foto'] = \AckCore\HtmlElements\Image::setupPath($path,"&w=310&h=170&zc=1");
          *  };
         * À PARTIR DE UM ARRAY de objeto e um array com
         * os nomes das colunas dos objetos forma-se uma array
         * @param  [type] $cols    [description]
         * @param  [type] $objects [description]
         * @return [type]          [description]
         */
        public static function getColsFromObjects($cols,&$objects,$func = null,$useIdsAsKeys = false,$extraParams = array(),$returnUniqWithoutKeys = false)
        {
            $result = array();

            if (!is_array($objects)) {
                $result = self::getColsFromObject($cols,$objects,$func);
            } else {
                  foreach ($objects as $keyObj => $object) {
                    if($useIdsAsKeys)
                        $result[$object->getId()->getBruteVal()] = self::getColsFromObject($cols,$object,$func);
                    else
                        $result[] = self::getColsFromObject($cols,$object,$func,$extraParams,$returnUniqWithoutKeys);
                }
            }

            return $result;
        }

        /**
         * retorna um array com as colunas passadas de um objeto
         * @param  [type] $cols        [description]
         * @param  [type] $object      [description]
         * @param  [type] $func        [description]
         * @param  array  $extraParams [description]
         * @return [type]              [description]
         */
        public static function getColsFromObject($cols,$object,$func = null,$extraParams = array(),$returnUniqWithoutKeys = false)
        {
            $result = array();
            $uniqKey = (count($cols) == 1) ? true : false;
            foreach ($object->vars as $key => $value) {
                        foreach ($cols as $colKey => $col) {
                            if (is_int($colKey)) {
                                if ($col == $key) {
                                    if($uniqKey && $returnUniqWithoutKeys)
                                        $result = $value->getVal();
                                    else
                                        $result[$col] = $value->getVal();

                                    break;
                                }
                            } else {
                                 if ($colKey == $key) {
                                    if($uniqKey && $returnUniqWithoutKeys)
                                        $result = $value->getVal();
                                    else
                                        $result[$col] = $value->getVal();

                                    break;
                                }
                            }
                        }
                    }
                if(!empty($func))
                    $func($object,$result,$extraParams);

            return $result;
        }

        /**
         * da replace somente das paginas finais
         * @param  [type] $arr1 [description]
         * @param  [type] $arr2 [description]
         * @return [type]       [description]
         */
        public static function mergeReplacingOnlyFinalKeys($arr1 , $arr2)
        {
                foreach ($arr2 as $key2 => $element2) {

                        if(isset($arr2[$key2]) && is_array($arr2[$key2]) && isset($arr1[$key2]) && is_array($arr1[$key2]))
                                $arr1[$key2] = self::mergeReplacingOnlyFinalKeys($arr1[$key2],$arr2[$key2]);
                        else
                                $arr1[$key2] = $element2;
                }

                return $arr1;
        }

        public static function putOnlyIntexistentKeysRecursively(&$arr1,$arr2)
        {
                if (empty($arr1)) {
                    $arr1 = $arr2;

                    return true;
                }

                foreach ($arr2 as $key2 => $element2) {

                        if(is_array($arr2[$key2]) && is_array($arr1[$key2]))
                                $arr1[$key2] = self::putOnlyIntexistentKeysRecursively($arr1[$key2],$arr2[$key2]);
                        else
                                if(!isset($arr1[$key2]))
                                 $arr1[$key2] = $element2;
                }

            return true;
        }

        /**
         * cria um novo array com os valores dos dois anteriores
         * quando o valor das chaves forem iguais
         * do tipo: valorArray1 => $valorArray2
         *
         * @param  array $arr1 [description]
         * @param  array $arr2 [description]
         * @return array       [description]
         */
        public function mergeArraysByKeys($arr1,$arr2)
        {
                $newArray = array();

                foreach ($arr1 as $arr1Key => $arr1Value) {
                        foreach ($arr2 as $arr2Key => $arr2Value) {
                                if ($arr1Key ==  $arr2Key) {
                                        $newArray[$arr1Value] = $arr2Value;
                                        break;
                                }
                        }
                }

                return $newArray;
        }

        /**
         * à partir de um array de objetos cria-se um stringify
         * @param  [type] $objects       [description]
         * @param  [type] $functionName  [description]
         * @param  string $separator     [description]
         * @param  string $elementEnvole [description]
         * @return [type]                [description]
         */
        public static function stringifyFromObjects($objects,$functionName,$separator = ",", $elementEnvole = "")
        {
            if(empty($objects))

                return false;

            $arr = array();
            foreach ($objects as $object) {
                $arr[] = $object->$functionName();
            }

            return self::stringfy($arr,$separator,$elementEnvole);
        }

        /**
         * transforma um array em um texto com suas entradas e separado por $separator
         * @param  [type] $array       [description]
         * @param  [type] $string=null [description]
         * @return [type]              [description]
         */
        public static function stringfy(array $arr, $separator = ",", $elementEnvole="")
        {
            $str = "";
            $counter = 0;
            foreach ($arr as $element) {

                if(is_array($element))
                    throw new \Exception("Tentanto converter para string um array com outro aninhado.");

                if ($counter) {
                    $str.= $separator.$elementEnvole.$element.$elementEnvole;
                } else {
                    $str = $elementEnvole.$element.$elementEnvole;
                }
                $counter++;
            }

            return $str;
        }

        /**
         * concatena arrays por uma coluna em comum retornando o novo array
         * @param  [type] $arrays [description]
         * @param  [type] $column [description]
         * @return [type]         [description]
         */
        public function mergeArraysByColumn(&$arrays,$column)
        {
                $result = array();
                foreach ($arrays as $arrayId => $array) {
                        $columnName = $array[$column];
                        unset($array[$column]);
                        $result[$columnName][] = $array;
                }

                return $result;
        }

        /**
         * dá implode de um array e de todos seus arrays filhos
         * @param  [type] $array       [description]
         * @param  [type] $string=null [description]
         * @return [type]              [description]
         */
        public static function implodeRecursively($array,$string=null,$separator="|",$disableKeys = false)
        {

                if (is_array($array)) {
                        foreach ($array as $columnName => $element) {
                                if (is_array($element)) {
                                        if(!$disableKeys)
                                                $string.= $columnName."=>";
                                        $string.= $this->implodeRecursively($element,$string);
                                } else {
                                        if(!$disableKeys)
                                                $string.= $columnName."=>";

                                        $string.= $element.$separator;
                                }
                        }
                }

                return $string;
        }

        /**
         * aplica um método de escape a todas as entradas de um array
         * @param  [type] $array [description]
         * @return [type]        [description]
         */
        public static function escapeArray($array)
        {
                if (is_array($array)) {
                        foreach ($array as $key => $element) {

                                if(is_array($element))
                                        $array[$key] = self::escapeArray($element);
                                else
                                        $array[$key] = \AckCore\Utils\String::escape($element);
                        }
                }

                return $array;
        }

        /**
         * esta se todas as entradas de um array estão vazias
         * @param  array  $array [description]
         * @return [type]        [description]
         */
        public static function allElementsEmpty(array &$array)
        {
                if(!is_array($array))

                        return true;

                foreach ($array as $element) {
                        if(!empty($element))

                                return false;
                }

                return true;
        }
        /**
         * chama uma função recursivamente
         * @param  [type] $arr        [description]
         * @param  [type] $funcName   [description]
         * @param  [type] $funcParams [description]
         * @return [type]             [description]
         */
        public function funcRecursively($arr,$funcName,$funcParams=null)
        {
                $result = array();

                if (is_array($arr)) {
                        foreach ($arr as $elementId => $element) {

                                if (is_array($element)) {

                                        $tmpResult = $funcRecursively($element,$funcName,$funcParams);

                                        foreach ($tmpResult as $tmpElementId => $tmpElement) {
                                                $result[] = $tmpElement;
                                        }

                                } else {
                                        $result[] = $funcName($element,$funcParams);
                                }
                        }
                }

                return $result;
        }

        /**
         * faz ordenação buble de um array pela coluna passada
         * @param  [type] &$array [description]
         * @param  [type] $key    [description]
         * @return [type]         [description]
         */
        public function sortByInternalKey(&$array,$key,$order = 'asc')
        {

                $order = strtolower($order);
                $size = sizeof($array);

                if ($order == 'asc') {

                        for ($i=0; $i<$size; $i++) {

                                for ($j=0; $j<$size-1-$i; $j++) {

                                        if ($array[$j+1][$key] < $array[$j][$key]) {

                                                $this->swap($array, $j, $j+1);
                                        }
                                }
                        }

                } else {

                        for ($i=0; $i<$size; $i++) {
                                for ($j=0; $j<$size-1-$i; $j++) {

                                        if ($array[$j+1][$key] > $array[$j][$key]) {

                                                $this->swap($array, $j, $j+1);
                                        }
                                }
                        }
                }

                return $array;
        }

        /**
         * troca 2 valores em um array
         * @param  [type] $arr [description]
         * @param  [type] $a   [description]
         * @param  [type] $b   [description]
         * @return [type]      [description]
         */
        private function swap(&$arr, $a, $b)
        {
                $tmp = $arr[$a];
                $arr[$a] = $arr[$b];
                $arr[$b] = $tmp;
        }
        /**
         * converte um objeto para array
         * @param  [type] $object [description]
         * @return [type]         [description]
         */
        public function objectToArray($object)
        {
                if (is_object($object)) {
                        $object = get_object_vars($object);
                }

                if (is_array($object)) {
                        return array_map(__FUNCTION__, $object);
                } else {
                        return $object;
                }
        }

        /**
         * arquivo com funções que ainda nao receberam uma classe
         */
        function idIsInArrayOfObjects($id,&$objects,$objectMethod="getId")
        {

                foreach ($objects as $element) {
                        if($id == $element->$objectMethod()->getBruteVal())

                                return true;
                }

                return false;
        }

        /**
         * remove as entradas vazias de um array
         * @param  [type] $arr [description]
         * @return [type]      [description]
         */
        public static function removeEmptyEntrys(&$arr)
        {
                foreach ($arr as $key => $val) {
                        if(empty($val))
                                unset($arr[$key]);
                }
        }
        /**
         * imita o array_key_exists só que compara à partir de uma expressão regular
         * @param  [type] $key   [description]
         * @param  [type] $array [description]
         * @param  [type] $regex [description]
         * @return [type]        [description]
         */
        public static function array_key_exists_from_match($pattern,$array,$returnPattern = false)
        {
                if(!is_array($array))
                    throw new \Exception("o segundo parametro precisa ser um array cujas chaves sejam expressões regulares", 1);

                if(is_array($pattern) || empty($pattern))
                    throw new \Exception("o primeiro parâmetro atual:<$pattern> precisa ser um valor para ser testado com as chaves do array ", 1);

                foreach ($array as $key_regex => $value) {
                    if (preg_match($key_regex, $pattern)) {
                            if($returnPattern)

                                return $pattern;
                            return $key_regex;
                    }
                }

                return null;
        }

        /**
         * testa se o padrao passado se encontra no arrray
         * @param  [type] $pattern [description]
         * @param  [type] $array   [description]
         * @return [type]          [description]
         */
        public static function in_array_from_match(&$pattern,&$array)
        {
                foreach ($array as $value) {
                    if (preg_match($value, $pattern)) {
                                return $value;
                    }
                }

                return null;
        }

        public static function getOneLevelArray(array $arr)
        {
            foreach ($arr as $key => $element) {
                if (is_array($element)) {
                    foreach ($element as $subKey => $subElement) {
                        if(is_array($subElement))
                        $arr = array_merge($arr,self::getOneLevelArray($subElement));
                        else
                        $arr[$subKey] = $subElement;
                    }
                    unset($arr[$key]);
                }
            }

            return $arr;
        }

        /**
         * recebe um array no estilo valorAntigo => novoValor e renomeia
         * as entradas que corresponderem à vaor antigo para o novo valor da chave
         * @param  array  $renameRelation [description]
         * @param  array  $cols           [description]
         * @return [type]                 [description]
         */
        public static function renameEntrys(array $renameRelation, array &$entrys,$overridePreExistedValues = true)
        {
            if(empty($renameRelation)) throw new \Exception("A relação está vazia!", 1);
            if(empty($entrys)) throw new \Exception("Nenhum dado foi passado para ser renomeado!", 1);

            foreach ($entrys as $oldEntry => $newEntry) {
                if (array_key_exists($oldEntry, $renameRelation)) {
                    if (!empty($entrys[$oldEntry])) {
                        if(!empty($entrys[$newEntry]) && $overridePreExistedValues)
                            $entrys[$renameRelation[$oldEntry]] = $entrys[$oldEntry];
                        else if(empty($entrys[$newEntry]))
                             $entrys[$renameRelation[$oldEntry]] = $entrys[$oldEntry];

                        unset($entrys[$oldEntry]);
                    }
                }
            }

            return true;
        }

    public static function transformProcessTimeArrayIntoRespectivePhpInlineArray($array, $innerKey = -1, $tabsCounter = 0)
    {
        if (-1 == $innerKey || is_int($innerKey)) {
            $result = '';
            for ($i=0; $i < $tabsCounter; $i++) {
                $result="\t";
            }

            $result.=  'array(';
        } else {
            $result =  '';

            for ($i=0; $i < $tabsCounter; $i++) {
                $result.="\t";
            }

            $result.='"'.$innerKey.'" => array(';
        }

        if (!empty($array)) {

            foreach ($array as $key => $value) {

                if (is_array($value)) {

                    $result.= self::transformProcessTimeArrayIntoRespectivePhpInlineArray($value, $key, ++$tabsCounter);
                } else {

                    $result.= '"'.$key.'" => "'.$value.'", ';
                }

            }

            $result = substr($result, 0, -2);
        }

        if ($innerKey != -1) {
            $result.= '),'.PHP_EOL;
        } else {
            $result.= ')';
        }

        return $result;
    }
}
