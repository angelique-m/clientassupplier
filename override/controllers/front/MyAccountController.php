<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */
class MyAccountController extends MyAccountControllerCore
{
    /** @var bool */
    public $auth = true;
    /** @var string */
    public $php_self = 'my-account';
    /** @var string */
    public $authRedirection = 'my-account';
    /** @var bool */
    public $ssl = true;

    /**
     * Assign template vars related to page content.
     *
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        /*
        * @deprecated since 1.7.8
        */
        $definition = $this->context->customer;
        $id_customer = $definition->id;
        $id_supplier = $this->getIdSupplier($id_customer);
        $this->context->smarty->assign([
            'logout_url' => $this->context->link->getPageLink('index', true, null, 'mylogout'),
        ]);

        $this->context->smarty->assign([
            'id_supplier' => $id_supplier,
        ]);

        parent::initContent();
        $this->setTemplate('customer/my-account');
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();

        return $breadcrumb;
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
}
