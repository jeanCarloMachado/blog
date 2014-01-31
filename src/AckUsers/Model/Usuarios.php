<?php
namespace AckUsers\Model;
use Zend\Math\Rand;
class Usuarios extends Users
{
    protected $_name = "estg_usuario";
    protected $_row = "\AckUsers\Model\Usuario";

    protected $colsNicks = array(
        "fakeid"=>"Id",
        "visivel"=>"Visível",
    );

   /**
     * sobreescreveu o criar
     * @param  array  $set [description]
     * @return [type] [description]
     */
    public function create(array $set, array $params = null)
    {
        $set['salt'] = base64_encode(Rand::getBytes(8,true));

        return parent::create($set,$params);
    }

    protected $meta = array(
        "humanizedIdentifier" => "nome",
    );

    protected $relations = array(
        '1:n' => array(
            array('model'=>'\AckAcl\Model\PapelUsuarios','reference'=>'usuario_id','elementTitle'=>'Papéis','relatedRowUrlTemplate'=>'/acl/papeisdeusuarios/editar/{id}/id','exibitionTemplate'=>'[getMyPapelStr]'),
        ),

    );

     /**
     * retorna o usuário associado com o email em questão
     * @param  [type] $mail [description]
     * @return [type] [description]
     */
    public static function getFromEmail($mail)
    {
        $model = new Usuarios;
        $resultUser = $model
                    ->toObject()
                    ->onlyAvailable()
                    ->getOne(array("email"=>$mail));

        return $resultUser;
    }
}
