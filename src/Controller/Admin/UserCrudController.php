<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            //Definis le nom de l'entity quandi l y en a plusieurs
            ->setEntityLabelInPlural('Les utilisateurs')
            //Pareil mais au singulier
            ->setEntityLabelInSingular('L\'utilisateur')
            ->setPageTitle("index", "Fink - Administration des utilisateurs")
            ->setPaginatorPageSize(20);       
    }
}
