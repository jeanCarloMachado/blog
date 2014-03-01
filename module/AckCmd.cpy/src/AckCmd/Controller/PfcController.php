<?php
namespace AckCmd\Controller;
use AckMvc\Controller\ConsoleBase;
use AckCore\Utils\Cmd;
class PfcController extends ConsoleBase
{
    const LATENCY_SECONDS = 3600;

    public function checkchatstatusAction()
    {
        $room = \PfcAck\Model\Rooms::getCurrentForced();
        if (($room->getId()->getBruteVal())) {

                $dateChefe = strtotime($room->getHoraChefe()->getBruteVal());
                $dateVisitante = strtotime($room->getHoraVisitante()->getBruteVal());
                $dateMax = strtotime(\AckCore\Utils\Date::now());
                $dateMax-=10;
                if ($dateVisitante < $dateMax) {
                    $room->setStatus(0)->save();
                    Cmd::show("sala reaberta devido a desconexão do visitante");
                }

                if ($dateChefe < $dateMax) {
                    $room->setStatus(9)->save();
                } else {
                    Cmd::show("chat ainda válido");
                }
        } else {
            Cmd::show("Não há sala aberta.");
        }
    }
}
