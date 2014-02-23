<?php
    namespace AckContact\Controller;
    class SetoresController extends \AckMvc\Controller\TableRowAutomatorAbstract
    {
        protected $modelName = Sectors;
        protected $title = "Setor";

        protected $categoryModelName = null;

        //protected $debug = true;

        protected $config = array(

                "index"=> array("title"=>"Setores de contato")

            );
    }
