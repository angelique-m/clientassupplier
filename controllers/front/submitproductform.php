<?php
class ClientassupplierSubmitproductformModuleFrontController extends ModuleFrontController
{
    /** @var bool */
    public $auth = true;
    /** @var bool */
    public $ssl = true;

    public function initContent()
    {
        /*Mise en place du template dans la page mon compte*/
        $this->setTemplate('module:clientassupplier/views/templates/front/submitproductform.tpl');
        /*https://localhost/presta/index.php?controller=submitproductform&fc=module&module=clientassupplier*/
        parent::initContent();
        $definition = $this->context->customer;
        $id_customer = $definition->id;
        $this->context->controller->addJquery();
        /*$id_supplier = $this->getIdSupplier($id_customer);*/
    }
}