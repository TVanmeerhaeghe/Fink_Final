<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
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
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setFormTypeOption('disabled', 'disabled)'),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('email')->setFormTypeOption('disabled', 'disabled)'),
            //hideOnIndex cache dans la liste mais pas dans la modification
            ArrayField::new('roles')->hideOnIndex(),
            DateTimeField::new('createdAt')->setFormTypeOption('disabled', 'disabled'),
            IntegerField::new('telephone'),
        ];
    }
}
