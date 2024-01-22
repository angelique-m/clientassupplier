<?php
class ClientassupplierCronModuleFrontController extends ModuleFrontController
{
    public $auth = false;

    public $ajax;

    public function initContent()
    {
    }

    public function display()
    {
        $this->ajax = 1;

        /*https://localhost/module/clientassupplier/cron*/
        $id_retailers = $this->getRetailersIds();
        /*$message = $this->getMailMessage($id_retailers);*/
        
        $this->getSendMail($id_retailers);
    }

    private function getRetailersIds(){
        $query = 'SELECT id_supplier, firstname, lastname, email FROM `'._DB_PREFIX_.'customer` WHERE `id_supplier`>0';
        $id_retailers = Db::getInstance()->ExecuteS($query);

        return $id_retailers;
    }

    private function getRetailersSells($id_retailer){

        $query = 'SELECT p.id_product, p.reference, plg.name, p.price, physical_quantity
        FROM '._DB_PREFIX_.'product p
        LEFT JOIN '._DB_PREFIX_.'product_lang plg on plg.id_product = p.id_product
        LEFT JOIN '._DB_PREFIX_.'stock_available sa on sa.id_product = p.id_product
        WHERE p.id_supplier='.$id_retailer.'
        AND physical_quantity=0
        AND plg.id_lang=1
        GROUP BY p.id_product
        ';

        $retailers_sells = Db::getInstance()->ExecuteS($query);

        var_dump($retailers_sells);
        return $retailers_sells;
    }

    private function getCalculRetribution($sell){
        $retrib = 0;
        $price = $sell['price'];
        //var_dump($sell['price']);

        if(($price*1.2) < 300){
            $retrib= $price*0.5;
        }
        else if(($price*1.2) < 800){
            $retrib= $price*0.6;
        }
        else if(($price*1.2) < 1500){
            $retrib= $price*0.7;
        }
        else{
            $retrib= $price*0.8;
        }

        return round($retrib,2);
    }

    private function getMailMessage($id_retailer){
        $message = '';
        
        $retailers_sells = $this->getRetailersSells($id_retailer['id_supplier']);
        $total_retribution = 0;
        
        if(count($retailers_sells) > 0){
            if(count($retailers_sells) == 1){
                $message='Félicitations, vous avez généré '.count($retailers_sells).' vente ce mois-ci !<br /><br />';
            }
            else{
                $message='Félicitations, vous avez généré '.count($retailers_sells).' ventes ce mois-ci !<br /><br />';
            }
            /*$message = $message.'Pour le revendeur n°'.$id_retailer['id_supplier'].' nommé '.$id_retailer['firstname'].' '.$id_retailer['lastname'].'.
        <br />Informations du contact : '.$id_retailer['email'].'.<br/><br/>';*/
            $message=$message.' Liste des produits vendus :<br />';
            foreach($retailers_sells as $sell){
                $calcul_retribution = $this->getCalculRetribution($sell);
                $total_retribution = $total_retribution+$calcul_retribution;
                $message=$message.$sell['name'].', référence '.$sell['reference'].', vendu '.round($sell['price'],2).' € HT, avec une rétribution de '.$calcul_retribution.' € TTC<br />';
            }
            $message=$message.'<br />Soit '.$total_retribution.' € TTC de bénéfices pour vous.<br /><br />Vous n\'avez rien à faire, le virement arrivera sur votre compte dans les prochains jours.';
        }
        else{
            $message='Il n\'y a malheureusement eu aucune vente ce mois-ci.';
        }
    
        return $message;
    }

    private function getSendMail($id_retailers){
        //$message = $this->getMailMessage($id_retailers);

        $query = 'SELECT cr.code
        FROM '._DB_PREFIX_.'cart_rule_lang cl
        LEFT JOIN '._DB_PREFIX_.'cart_rule cr on cr.id_cart_rule = cl.id_cart_rule
        WHERE cl.name="Revendeur 10%"
        ';

        $codepromo = Db::getInstance()->ExecuteS($query);

        foreach($id_retailers as $id_retailer){
            $message = $this->getMailMessage($id_retailer);
            var_dump($message);
            $email = $id_retailer['email'];
            $sendorders = Mail::Send($this->context->language->id,
            'templatemailclientassupplier',
            'Rapport mensuel concernant vos ventes ',
                array(
                    '{message}' => $message,
                    '{firstname}' => $id_retailer['firstname'],
                    '{lastname}' => $id_retailer['lastname'],
                    '{codepromo}' => $codepromo[0]['code'],
                ),
                explode(';', $email),
                //$email,
                NULL, //receiver name
                'mail@mail.com', //from email address
                'Sender',  //from name
                $attach, //file attachment - no attachment = NULL
                NULL, //mode smtp
                _PS_MODULE_DIR_.'clientassupplier/mails',
                false,
                null,
                'mail@mail.com'

            );
        }
    }
}