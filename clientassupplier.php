<?php

declare(strict_types=1);

use PrestaShop\PrestaShop\Core\Grid\Definition\GridDefinitionInterface;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\DataColumn;
use PrestaShop\PrestaShop\Core\Search\Filters\CustomerFilters;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use Symfony\Component\Form\Extension\Core\Type\TextType;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Clientassupplier extends Module
{
    public function __construct()
    {
        $this->name = 'clientassupplier';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Angélique Mignard - Agence SoKreative';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '8.1.2',
            'max' => '8.99.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Client as supplier', [], 'Modules.Clientassupplier.Admin');
        $this->description = $this->trans('Module pour définir un client en tant que fournisseur dans le back-office.', [], 'Modules.Clientassupplier.Admin');

        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', [], 'Modules.Clientassupplier.Admin');

        if (!Configuration::get('CLIENTASSUPPLIER')) {
            $this->warning = $this->trans('No name provided', [], 'Modules.Clientassupplier.Admin');
        }
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return (
            parent::install()
            && $this->registerHook('actionCustomerGridDefinitionModifier')
            && $this->registerHook('actionCustomerGridQueryBuilderModifier')
            && $this->registerHook('actionCustomerFormBuilderModifier')
            && $this->registerHook('actionAfterUpdateCustomerFormHandler')
            && $this->registerHook('actionFrontControllerSetMedia')
            && $this->registerHook('actionSupplierFormBuilderModifier')
            && $this->registerHook('actionAfterUpdateSupplierFormHandler')
            && $this->registerHook('actionAdminControllerSetMedia')
        );
    }

    public function uninstall()
    {
        return (
            parent::uninstall()
            && Configuration::deleteByName('CLIENTASSUPPLIER')
        );
    }

    /*Customer list*/
    public function hookActionCustomerGridDefinitionModifier(array $params)
    {
        $definition = $params['definition'];

        $definition
            ->getColumns()
            ->addAfter(
                'id_customer',
                (new DataColumn('id_supplier'))
                    ->setName($this->trans('ID Fournisseur', [], 'Modules.Clientassupplier'))
                    ->setOptions([
                        'field' => 'id_supplier',
                    ])
            );

        /*Remove unecessary columns and filters*/
        $columns = $definition->getColumns();
        $columns
            ->remove('active')
            ->remove('optin')
        ;

        $filters = $definition->getFilters();
        $filters
            ->remove('active')
            ->remove('optin')
        ;

        // Ajout de id_supplier dans la liste des champs à filtrer
        $definition->getFilters()->add(
            (new Filter('id_supplier', TextType::class))
                ->setAssociatedColumn('id_supplier')
        );
    }

    public function hookActionCustomerGridQueryBuilderModifier(array $params)
    {
        /*Afficher dans la liste des clients le champ id_supplier*/
        $searchQueryBuilder = $params['search_query_builder'];
        $searchCriteria = $params['search_criteria'];
        $searchQueryBuilder->addSelect('c.`id_supplier`');

        /*Ajout de la requête pour filtrer le champ id_supplier dans la liste des clients*/
        $searchCriteria = $params['search_criteria'];
        foreach ($searchCriteria->getFilters() as $filterName => $filterValue) {
            if ('id_supplier' === $filterName) {
                $searchQueryBuilder->andWhere('c.`id_supplier` = :id_supplier');
                $searchQueryBuilder->setParameter('id_supplier', $filterValue);
                if (!$filterValue) {
                    $searchQueryBuilder->orWhere('c.`id_supplier` IS NULL');
                }
            }
        }
    }

    public function hookActionSupplierFormBuilderModifier(array $params)
    {
        $formBuilder = $params['form_builder'];
        $allFields = $formBuilder->all();

        foreach ($allFields as $inputField => $input) {
            $formBuilder->remove($inputField);
        }

        foreach ($allFields as $inputField => $input) {
            if ($inputField == 'name') {
                $formBuilder->add($input);
                $formBuilder->add(
                    'firstname',
                    TextType::class,
                    ['label' => 'Prénom', 'required' => false]
                );
                $formBuilder->add(
                    'email',
                    TextType::class,
                    ['label' => 'Email', 'required' => false]
                );
            } else {
                $formBuilder->add($input);
            }
        }

        $supplierId = $params['id'];
        $firstname = Db::getInstance()->getValue('SELECT firstname FROM ' . _DB_PREFIX_ . 'address WHERE id_supplier = ' . $supplierId);
        $email = Db::getInstance()->getValue('SELECT email FROM ' . _DB_PREFIX_ . 'address WHERE id_supplier = ' . $supplierId);

        $params['data']['firstname'] = $firstname;
        $params['data']['email'] = $email;

        $formBuilder->setData($params['data']);

    }

    /*Appel de la fonction d'update de la fiche customer*/
    public function hookActionAfterUpdateSupplierFormHandler(array $params)
    {
        $this->updateSupplierfields($params);
    }

    /*Mise à jour de l'id fournisseur lors de la sauvegarde de la fiche dans le back office*/
    private function updateSupplierfields(array $params)
    {
        $supplierId = $params['id'];
        $customerFormData = $params['form_data'];
        $supplierName = $customerFormData['firstname'];
        $supplierEmail = $customerFormData['email'];

        $query = 'UPDATE `' . _DB_PREFIX_ . 'address` a '
            . ' SET  a.`firstname` = "' . pSQL($supplierName) . '", a.`email` = "' . pSQL($supplierEmail) . '"'
            . ' WHERE a.id_supplier = ' . (int) $supplierId;

        Db::getInstance()->execute($query);
    }

    /*Customer Page*/
    public function hookActionCustomerFormBuilderModifier(array $params)
    {
        /*Affiche le champ id_supplier sur la fiche client dans le backoffice*/
        $formBuilder = $params['form_builder'];
        $allFields = $formBuilder->all();
        foreach ($allFields as $inputField => $input) {
            $formBuilder->remove($inputField);
        }

        foreach ($allFields as $inputField => $input) {
            $formBuilder->add($input);
            if ($inputField == 'email') {
                /** @var TextType::class \Symfony\Component\Form\Extension\Core\Type\TextType */
                $formBuilder->add(
                    'id_supplier',
                    TextType::class,
                    ['label' => 'ID Fournisseur', 'required' => false, 'help' => $this->l('Champ id fournisseur à renseigner lorsque le client est un revendeur. Attribuer l\'id qui est visible sur la fiche dans catalogue > fournisseur pour le raccorder à sa fiche. Laisser le champ vide si le client n\'est pas revendeur.')],
                );
            }

            /*Récupère id_supplier dans la bdd et l'affiche dans le champ créé précédemment*/
            $customerId = $params['id'];
            $idsupplier = Db::getInstance()->getValue('SELECT id_supplier FROM ' . _DB_PREFIX_ . 'customer WHERE id_customer = ' . $params['id']);
            $params['data']['id_supplier'] = $idsupplier;
            $formBuilder->setData($params['data']);
        }
    }

    /*Appel de la fonction d'update de la fiche customer*/
    public function hookActionAfterUpdateCustomerFormHandler(array $params)
    {
        $this->updateCustomerSupplierId($params);
    }

    /*Mise à jour de l'id fournisseur lors de la sauvegarde de la fiche dans le back office*/
    private function updateCustomerSupplierId(array $params)
    {
        $customerId = $params['id'];
        $customerFormData = $params['form_data'];
        $idsupplier = $customerFormData['id_supplier'];

        $query = 'UPDATE `' . _DB_PREFIX_ . 'customer` c '
            . ' SET  c.`id_supplier` = "' . pSQL($idsupplier) . '"'
            . ' WHERE c.id_customer = ' . (int) $customerId;
        Db::getInstance()->execute($query);
    }

    public function hookActionFrontControllerSetMedia()
    {
        $this->context->controller->addJs($this->_path . 'views/js/jquery.conditionize2.min.js');
        $this->context->controller->addJs($this->_path . 'views/js/config.conditionize2.min.js');
    }

    public function hookActionAdminControllerSetMedia()
    {
        $this->context->controller->addJs($this->_path . 'views/js/tornike.js');
    }
}