<?php
class ClientassupplierEnvoyerformModuleFrontController extends ModuleFrontController
{
    /** @var bool */
    public $auth = true;
    /** @var bool */
    public $ssl = true;

    public function initContent()
    {
       /*Mise en place du template dans la page mon compte*/
       $this->setTemplate('module:clientassupplier/views/templates/front/envoyerform.tpl');
       /*https://localhost/presta/index.php?controller=submitproductform&fc=module&module=clientassupplier*/
       parent::initContent();
       $definition = $this->context->customer;
       $id_customer = $definition->id;
       if ($_POST) {
        /*On récupère le nombre d'article à vendre*/
        $this->context->smarty->assign([
            'qtyToSubmit' => $_POST,
        ]);
       }
       else{
        Tools::redirect('#');
       }
    }
}