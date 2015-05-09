<?php
  namespace AckCore\View\Helper;
  use Zend\View\Helper\AbstractHelper;

    class Visible extends AbstractHelper
    {
        public function __invoke($row,$disableVisible=null)
        {
          if ($disableVisible || empty($row->vars["visivel"])) {
            return null;
          }

           \AckCore\HtmlElements\Visible::Factory($row->getVisivel())->render();
        }
    }
