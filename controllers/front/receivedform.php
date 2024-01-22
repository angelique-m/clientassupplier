<?php
class ClientassupplierReceivedformModuleFrontController extends ModuleFrontController
{
    /** @var bool */
    public $auth = true;
    /** @var bool */
    public $ssl = true;

    public function initContent()
    {
       /*Mise en place du template dans la page mon compte*/
       $this->setTemplate('module:clientassupplier/views/templates/front/receivedform.tpl');
       /*https://localhost/presta/index.php?controller=submitproductform&fc=module&module=clientassupplier*/
       parent::initContent();
       $definition = $this->context->customer;
       $id_customer = $definition->id;
       if ($_POST && $_POST['email']) {
        
        $this->getSendMail($_POST['email'], $_POST);

        $this->context->smarty->assign([
            'messagetodisplay' => 1,
        ]);
       }
       else{
        $this->context->smarty->assign([
            'messagetodisplay' => 0,
        ]);
       }
    }

    private function getSendMail($emailclient, $posts){
        $i=0;
        $message='';
        foreach($posts as $k => $v){
            if(count($posts)==23){
                $i = $i+1;
                if($k=='qtySelected'){
                    $k='Nombre d\'articles';
                }
                $message = $message.'<br />'.$k.' : '.$v;
                if($i==17){
                    break;
                }
            }
            else{
                $i = $i+1;
                $message = $message.'<br />'.$k.' : '.$v;
                if($i==1){
                    break;
                }
            }
        }
        $email = 'mail@mail.com';
        $sendorders = Mail::Send($this->context->language->id,
        'templatemailclientpourclient',
        'Nouvelle demande via le formulaire JE VENDS',
            array(
                '{message}' => $message,
                '{firstname}' => $posts['firstname'],
                '{lastname}' => $posts['lastname'],
                '{email}' => $emailclient,
                '{address}' => $posts['address'],
                '{zip}' => $posts['zip'],
                '{city}' => $posts['city'],
            ),
            explode(';', $email), //$email,
            NULL, //receiver name
            'mail@mail.com', //from email address
            'Sender',  //from name
            $attach, //file attachment - no attachment = NULL
            NULL, //mode smtp
            _PS_MODULE_DIR_.'clientassupplier/mails',
            false,
            null
        );
    }
}