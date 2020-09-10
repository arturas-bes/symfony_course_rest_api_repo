<?php

namespace App\Controller;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\VichUploaderBundle;
use function Sodium\add;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {

        return [
            TextField::new('name'),
            TextEditorField::new('description'),
            ImageField::new('image')
                ->setBasePath($this->getParameter('app.path.product_images'))
                ->hideOnForm(),

            ImageField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->setFormTypeOptions([
                    'required' => false,
                    'allow_delete' => true,
                    'delete_label' => 'Delete image',
                    'download_label' => 'Download image',
                    'download_uri' => true,
                    'image_uri' => true,
                    'asset_helper' => true,
                ])
                ->setBasePath($this->getParameter('app.path.product_images'))
                ->setLabel('Upload image')
                ->hideOnIndex(),
            AssociationField::new('offers')
                ->autocomplete()
                ->setFormTypeOption('by_reference', false)

        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
        return parent::configureActions($actions);
    }
}
