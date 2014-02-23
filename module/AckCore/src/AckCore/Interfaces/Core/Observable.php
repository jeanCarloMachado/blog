<?php
namespace AckCore\Interfaces\Core;
interface Observable
{
    /**
     * adiciona um objeto aos observadores
     * @param  [type] $obj [description]
     * @return [type] [description]
     */
    public function attach($objName);
    /**
     * remove um objeto pela chave
     * @param  [type] $obj [description]
     * @return [type] [description]
     */
    public function detach($objName);
    /**
     * notifica os observadores
     * @param  [type] $message [description]
     * @return [type] [description]
     */
    public function notify(\AckCore\Event $event);
}
