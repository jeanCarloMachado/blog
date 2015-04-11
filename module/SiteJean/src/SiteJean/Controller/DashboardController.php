<?php

namespace SiteJean\Controller;

use AckMvc\Controller\Base;

class DashboardController extends Base
{
    public function indexAction()
    {
        $auth = $this->getServiceLocator()->get('auth');

        if (!$auth->hasIdentity()) {
            $this->redirect()->toRoute("login");
        }

        return $this->viewModel;
    }
}
