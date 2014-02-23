<?php
/**
 * recebe mensagens e as mostra em um bloco de conteúdo
 * no padrão twb
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 */
namespace AckContent\View\Helper;
use Zend\View\Helper\AbstractHelper;
/**
 * recebe mensagens e as mostra em um bloco de conteúdo
 * no padrão twb
 *
 * @category Business
 * @package  AckDefault
 * @author   Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 3 2013
 * @link     http://github.com/zendframework/zf2 for the canonical source repository
 */
class NotificationBlock extends AbstractHelper
{
    protected static $instance;
    protected $messages = array();

    public static function getInstance()
    {
        if(!self::$instance)
            self::$instance = new self;

        return self::$instance;
    }

    public function hasMessages()
    {
        if(!empty($this->messages)) return true;

        return false;
    }

    protected function __construct()
    {
    }

    public function error($message)
    {
        $this->append($message,E_USER_ERROR);

        return $this;
    }

    public function notice($message)
    {
        $this->append($message,E_NOTICE);

        return $this;
    }

    public function info($message)
    {
        $this->append($message,E_NOTICE);

        return $this;
    }

    public function success($message)
    {
        $this->append($message);

        return $this;
    }

    public function __invoke(array $messages = null)
    {

        if(empty($messages)) $messages = $this->getMessages();

        return $this;
    }

    public function render()
    {
       if(!empty($this->messages)) :
           foreach($this->messages as $message) :

            if (isset($message['type']) && $message['type'] == E_USER_ERROR):
            ?>
                <div class="alert alert-danger notificationArea">
                <button class="close" data-dismiss="alert" type="button">×</button>
                <?php echo $message["message"]; ?>
                </div>
            <?php elseif (!isset($message['type'])): ?>
                <div class="alert alert-success notificationArea">
                <button class="close" data-dismiss="alert" type="button">×</button>
                 <?php echo $message["message"]; ?>
                </div>
            <?php elseif(isset($message['type']) && $message['type'] == E_NOTICE): ?>
                <div class="alert alert-info notificationArea">
                <button class="close" data-dismiss="alert" type="button">×</button>
                 <?php echo $message["message"]; ?>
                </div>
            <?php
            endif;
        endforeach;
        endif;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function setMessages($messages)
    {
        $this->messages = $messages;

        return $this;
    }

    public function append($message,$type = null)
    {
        $this->messages[] = array("message" => $message,"type"=>$type);

        return $this;
    }
}
