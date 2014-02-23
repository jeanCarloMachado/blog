<?php
namespace AckCore\Interfaces\Core;
interface Observer
{
    public function listen(\AckCore\Event $event);
}
