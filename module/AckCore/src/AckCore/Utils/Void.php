<?php
namespace AckCore\Utils;
class Void
{
    public function &__call($method, array $args)
    {
        return $this;
    }
}
