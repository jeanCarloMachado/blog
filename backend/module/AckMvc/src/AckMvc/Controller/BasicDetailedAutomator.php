<?php

namespace AckMvc\Controller;

trait BasicDetailedAutomator
{
    public function visualizarAction()
    {
        $id = $this->params('id');

        $entity = $this->getModelInstance()
            ->toObject()
            ->onlyAvailable()
            ->getOne(array('id'=>$id)); 

        $this->viewModel->setVariables(array('row'=> $entity));
        return $this->viewModel;
    }
}
