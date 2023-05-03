<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Salon;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SalonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Salon::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            //Definis le nom de l'entity quandi l y en a plusieurs
            ->setEntityLabelInPlural('Les salons')
            //Pareil mais au singulier
            ->setEntityLabelInSingular('Le salon')
            ->setPageTitle("index", "Fink - Administration des salons")
            ->setPaginatorPageSize(20)
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');       
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            IntegerField::new('telephone'),
            TextField::new('Ville'),
            TextField::new('email')->setFormTypeOption('disabled', 'disabled)'),
            IntegerField::new('latitude')->hideOnIndex()->hideOnForm(),
            IntegerField::new('longitude')->hideOnIndex()->hideOnForm(),
            TextareaField::new('description')
            ->hideOnIndex()
            ->setFormType(CKEditorType::class),
            TextField::new('style')->setFormTypeOption('disabled', 'disabled'),
        ];
    }
}
