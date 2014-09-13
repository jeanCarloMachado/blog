<?php
namespace AckContent\Model;
use AckDb\ZF1\RowAbstract;
class Institutional extends RowAbstract
{
    protected $_table = "AckContent\Model\Institutionals";

    public function getMyPhotos()
    {
        $photos = $this->seekMyPhotos("relacao_id","\AckMultimidia\Model\\");

        return $photos;
    }

    public function getMyFirstPhoto()
    {
        $photos = $this->getMyPhotos();
        if(empty($photos)) return new \AckMultimidia\Model\Photo;

        return reset($photos);
    }

}
