<?php
namespace AckCore\View\Helper;
use Zend\View\Helper\AbstractHelper;
abstract class GoogleAnalytics extends AbstractHelper
{
    public function __invoke(array $params=null)
    {
        /**
         * seta o ga passado
         * @var [type]
         */
        $ga = $params['ga'];
        /**
         * se o GA não foi setado pega o default do sistema
         */
        if (!$ga) {
            $system = new \AckCore\Model\System;
            $result = $system->get($where);
            $ga =  $result[0]['ga'];
        }
            /**
             * estrutura do ga
             */
        ?>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', '<?= $ga ?>', 'imgstock.com.br');
          ga('send', 'pageview');

        </script>
        <?php
    }
}
