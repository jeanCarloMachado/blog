<?php
namespace AckContact\Model;
use SiteJean\Db\TableAbstract as Table;
class Messages extends Table
{
    protected $relations = array(	"1:n" => array(	array("model" => "\SiteJean\Model\Usuarios", "reference" => "remetente_id", "elementTitle" => "Remetente", "relatedRowUrlTemplate" => "/usuarios/editar/{id}"),
    array("model" => "\SiteJean\Model\Usuarios", "reference" => "destinatario_id", "elementTitle" => "Destinatario", "relatedRowUrlTemplate" => "/usuarios/editar/{id}")));

    protected $meta = array(
        "humanizedIdentifier" => "titulo",
   );
    protected $colsNicks = array("remetente_id" => "Remetente", "destinatario_id" => "Destinatário", "titulo" => "Título
", "mensagem" => "Mensagem
", "data" => "Data
");
    protected $_name = "ackcontact_mensagem";
    protected $_row = "\AckContact\Model\Message";
}
