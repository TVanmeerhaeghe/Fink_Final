<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            //Definis le nom de l'entity quandi l y en a plusieurs
            ->setEntityLabelInPlural('Les demandes de contacts')
            //Pareil mais au singulier
            ->setEntityLabelInSingular('La demande de contact')
            ->setPageTitle("index", "Fink - Administration des des demandes de contact")
            ->setPaginatorPageSize(20);       
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('Nom')->setFormTypeOption('disabled', 'disabled'),
            TextField::new('Prenom')->setFormTypeOption('disabled', 'disabled')->hideOnIndex(),
            TextField::new('Email')->setFormTypeOption('disabled', 'disabled'),
            TextField::new('Sujet')->setFormTypeOption('disabled', 'disabled'),
            DateTimeField::new('sendAt')->setFormTypeOption('disabled', 'disabled'),
            TextareaField::new('message')->hideOnIndex()->setFormTypeOption('disabled', 'disabled')                
        ];
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
