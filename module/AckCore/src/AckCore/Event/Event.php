<?php
namespace AckCore\Event;
class Event
{
    protected $type;
    protected $vars = array();

    //de autenticação para ser utilizada
    const TYPE_RESTRICTED_REQUEST = 1;
    //quando vai renderizar uma view
    const TYPE_ACTION_DISPATCH = 2;
    const TYPE_AFTER_MAIN_SAVE = 3;
    const TYPE_ACCESS_REQUEST = 4;
    const TYPE_ROW_CREATED = 5;
    const TYPE_NOT_PERMITED_ACCESS = 6;
    const TYPE_NEW_USER = 7;

    public static function createInstance()
    {
        return new Event;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getVars()
    {
        return $this->vars;
    }

    public function setVars($vars)
    {
        $this->vars = $vars;

        return $this;
    }

    public function __set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->vars)) {
        return $this->vars[$name];
        }
        $trace = debug_backtrace();
        trigger_error(
        'Undefined property via __get(): ' . $name .
        ' in ' . $trace[0]['file'] .
        ' on line ' . $trace[0]['line'],
        E_USER_NOTICE);

        return null;
    }

    public function __call($method, array $args)
    {
        /**
         * [$methodName description]
         * @var [type]
         */
        $attrName = strtolower(substr($method, 3));
        $action = substr($method,0,3);

        if ($action == "get") {
            return $this->getVar($attrName);
        } elseif ($action == "set") {

            $val = reset($args);

            return $this->setVar($attrName,$val);
        }

        throw new \Exception("método desconhecido (".$attrName.") - verfique System_DB_Table_Row");
    }

    public function setVar($column,$value)
    {
        $this->vars[$column] = $value;

        return $this;
    }

    public function getVar($key)
    {
        if ($this->vars[$key]) {
            return $this->vars[$key];
        } else {
            $var =  new \AckCore\Vars\Variable;
            $var->setValue("Coluna não existente ( $key )");

            return $var;
        }
    }
}
