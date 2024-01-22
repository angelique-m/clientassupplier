<?php
class ClientassupplierCustomersellsModuleFrontController extends ModuleFrontController
{
    /** @var bool */
    public $auth = true;
    /** @var bool */
    public $ssl = true;

    public function initContent()
    {
        /*Mise en place du template dans la page mon compte*/
        $this->setTemplate('module:clientassupplier/views/templates/front/customersells.tpl');
        /*https://localhost/presta/index.php?controller=customersells&fc=module&module=clientassupplier*/
        parent::initContent();
        $definition = $this->context->customer;
        $id_customer = $definition->id;
        $id_supplier = $this->getIdSupplier($id_customer);
        $this->checkIdSupplier($id_supplier);
        $this->getProductsSupplier($id_supplier);
    }

    /*Obtenir l'id fournisseur d'un client et le transmettre en tant que variable SMARTY*/
    private function getIdSupplier($id_customer){
        $query = 'SELECT id_supplier FROM `'._DB_PREFIX_.'customer` WHERE `id_customer`='.(int)$id_customer;
        $id_supplier = Db::getInstance()->ExecuteS($query);
        $id_supplier = ($id_supplier[0]['id_supplier']);

        /*Attribution de id fournisseur dans les variables smarty*/
        $this->context->smarty->assign([
            'id_supplier' => $id_supplier,
        ]);
        return $id_supplier;
    }

    /*Si le client n'est pas revendeur, on le redirige vers l'accueil*/
    private function checkIdSupplier($id_supplier){
        if($id_supplier==0){
            Tools::redirect('index.php');
        }
    }

    /*Obtenir la liste des articles à vendre par cet id fournisseur*/
    private function getProductsSupplier($id_supplier){
        $query = 'SELECT p.reference, p.id_product, i.id_image, plg.name, mn.name as mnname, p.id_manufacturer, p.price, ct.link_rewrite, sa.quantity
        FROM '._DB_PREFIX_.'product p
        LEFT JOIN '._DB_PREFIX_.'image i on i.id_product = p.id_product
        LEFT JOIN '._DB_PREFIX_.'product_lang plg on plg.id_product = p.id_product
        LEFT JOIN '._DB_PREFIX_.'manufacturer mn on mn.id_manufacturer = p.id_manufacturer
        LEFT JOIN '._DB_PREFIX_.'category_lang ct on ct.id_category = p.id_category_default
        LEFT JOIN '._DB_PREFIX_.'stock_available sa on sa.id_product = p.id_product
        WHERE p.id_supplier='.$id_supplier.'
        AND plg.id_lang=1
        GROUP BY p.id_product
        ';
        $id_products = Db::getInstance()->ExecuteS($query);

        $this->context->smarty->assign([
            'products' => $id_products,
        ]);
    }
}