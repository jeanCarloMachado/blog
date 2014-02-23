<?php
namespace AckCore\Validate;
class Validator
{
    protected $data;
    /**
     * utilizada no controlador para quando campos são requeridos mas não passados
     * @param  array  $required [description]
     * @param  array  $fields   [description]
     * @return [type] [description]
     */
    public function assertNotEmpty(array $required)
    {
        if(empty($this->data))
            throw new \Exception("Nenhum dado passado ao sistema.", 1);

        foreach ($required as $entry) {
            if(!isset($this->data[$entry]))
                throw new \Exception("Não encontrou o campo necessário < $entry >.", 1);
            else if(isset($this->data[$entry]) && empty($this->data[$entry]))
                throw new \Exception("O campo necessário < $entry > está vazio.", 1);
        }

        return true;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData(&$data)
    {
        $this->data = &$data;

        return $this;
    }
}
