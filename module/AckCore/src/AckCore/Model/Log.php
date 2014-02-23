<?php
namespace AckCore\Model;
use AckDb\ZF1\RowAbstract;

    class Log extends RowAbstract
    {
        protected $_table = "\AckCore\Model\Logs";

        public function getUsuarioObject()
        {
            $modelUser = new \AckUsers\Model\Users();
            $resultUser = $modelUser->toObject()->get(array("id"=>$this->getusuario()->getBruteVal()));

            $resultUser = reset($resultUser);
            if(empty($resultUser))

                return new \AckUsers\Model\User();

            return $resultUser;
        }
    }
