<?php

namespace App\Controller\Admin;

use App\Entity\DemandeSalon;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class DemandeSalonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DemandeSalon::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            //Definis le nom de l'entity quand il y en a plusieurs
            ->setEntityLabelInPlural('Les demandes de partenariats')
            //Pareil mais au singulier
            ->setEntityLabelInSingular('La demande de partenariat')
            ->setPageTitle("index", "Fink - Administration des demandes de partenariat")
            ->setPaginatorPageSize(20);    
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('Propietaire', 'Propriétaire')->setFormTypeOption('disabled', 'disabled'),
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
            IntegerField::new('siret')->setFormTypeOption('disabled', 'disabled'),
        ];
    }
}
