<?php
/**
 * entidade representando a tabela: Ajudas
 *
 * AckDefault - Cub
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * PHP version 5
 *
 * @category  WebApps
 * @package   AckDefault
 * @author    Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @copyright 2013 Copyright (C) CUB
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @version   GIT: <6.4>
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace AckContent\Model;

use AckDb\ZF1\TableAbstract as Table;
/**
 * entidade representando a tabela: Ajudas
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class Ajudas extends Table
{
    /**
     * nome da tabela no banco
     * @var string
     */
    protected $_name = 'ackcontent_ajuda';
    /**
     * nome da entidade relacionada representando uma linha
     * @var string
     */
    protected $_row = '\AckContent\Model\Ajuda';

    /**
     * apelidos para os nomes das colunas da tabela
     * (estes nomes serão exibidos para o usuário)
     *
     * @var array
     */
    protected $colsNicks = array(
        'fakeid'=>'Id',
        'titulo' => 'Título',
        'descricao' => 'Descrição'
    );

    protected $meta = array(
        "humanizedIdentifier" => "titulo",
    );

    protected $relations = array(
        '1:n' => array(
                    array('model'=>'\AckContent\Model\AjudaCategorias','reference'=>'categoria_id','elementTitle'=>'Categoria','relatedRowUrlTemplate'=>'/categoriasdetextosdeajuda/editar/{id}'),
                ),
    );
}
