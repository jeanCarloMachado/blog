<?php
namespace AckContent\Model;
use AckDb\ZF1\TableAbstract;
class Highlights extends TableAbstract
{
    protected $_name = "ack_destaques";
    protected $_row = "\AckContent\Model\Highlight";

    const moduleName = "destaques";
    const moduleId = 6;

    protected $colsNicks = array(
        "titulo_pt" => "Título",
        "visivel" => "Visível",
        "descricao_pt" => "Descrição",
        "url_pt" => "URL",
        "fakeid" => "Id",
    );
    /**
     * retorna um destaque randomizado (melhorar a clausula)
     * @return mixed
     */
    public function getRandomWithImage($where=null)
    {
        $result = $this->get($where);

        if(empty($result))
            throw new \Exception("Nenhum destaque com imagem");

        $validElements = array();
        foreach ($result as $elementId => $element) {

                if($element->getFirstPhoto()->getId()->getBruteVal())
                    $validElements[] = $element;
        }

        if(empty($validElements))

            return new Photo();

        $index = rand(0,(count($validElements)-1));

        return $validElements[$index];
    }

    /**
     * retorna todos os destaques com imagens
     * @param  string             $where
     * @throws Exception
     * @return multitype:Ambigous <[type], mixed>
     */
    public function getAllWithImage($where=null)
    {
        $result = $this->get($where);

        if(empty($result))
            throw new \Exception("Nenhum destaque com imagem");

        $validElements = array();
        foreach ($result as $elementId => $element) {

            if($element->getFirstPhoto()->getId()	->getBruteVal())
                $validElements[] = $element;
        }

        return $validElements;
    }

    public function getRandom($where)
    {
        $result = $this->get($where);
        $index = rand(0,(count($result)-1));

        return $result[$index];
    }

    public function getFirstWithImage($where = null)
    {
        $result = $this->get($where);
        if(empty($result))
            throw new \Exception("Nenhum destaque");

        $validElements = array();
        foreach ($result as $elementId => $element) {

            $tmp = $element->getFirstPhoto()->getId()->getBruteVal();
            if(!empty($tmp))

                return $element;
        }

        throw new \Exception("Nenhum destaque com imagem");
    }
}
