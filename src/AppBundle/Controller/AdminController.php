<?php

namespace AppBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;


class AdminController extends BaseAdminController
{
    public function createNewFennecUserEntity(){
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function prePersistFennecUserEntity($user){
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    public function preUpdateFennecUserEntity($user){
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }
}