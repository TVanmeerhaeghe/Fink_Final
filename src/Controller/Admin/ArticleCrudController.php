<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            //Definis le nom de l'entity quandi l y en a plusieurs
            ->setEntityLabelInPlural('Les articles')
            //Pareil mais au singulier
            ->setEntityLabelInSingular('L\'article')
            ->setPageTitle("index", "Fink - Administration des articles")
            ->setPaginatorPageSize(20)
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');       
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('Titre'),
            TextField::new('Sujet'),
            TextareaField::new('contenu')
                ->hideOnIndex()
                ->setFormType(CKEditorType::class),
            DateTimeField::new('date')->setFormTypeOption('disabled', 'disabled'),
        ];
    }
}
