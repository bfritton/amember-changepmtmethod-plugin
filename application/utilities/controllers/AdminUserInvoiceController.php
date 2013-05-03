<?php
<!--
/**
 * Controller providing custom invoice and payment sorts of actions
 *
 * @author		Brian Fritton <bfritton@gmail.com>
 * @copyright	GNU General Public License, version 3 (GPL-3.0)
 */
-->
class Utilities_AdminUserInvoiceController extends Am_Controller
{
    protected $user;
    protected $invoice;
    protected $admin;

    public function __construct(Zend_Controller_Request_Abstract $request,
                                Zend_Controller_Response_Abstract $response,
                                array $invokeArgs = array())
    {
        // Run Am_Controller construct
        parent::__construct($request, $response, $invokeArgs);
        // Load up the user and invoice
        $userId = intval($this->getRequest()->getParam('user_id'));
        if (!$userId) {
            throw new Am_Exception_InputError('A user ID must be specified');
        }
        $invoiceId = intval($this->getRequest()->getParam('invoice_id'));
        if (!$invoiceId) {
            throw new Am_Exception_InputError('A user ID must be specified');
        }

        $userTable = Am_Di::getInstance()->userTable;
        $this->user = $userTable->load($userId);
        if (!$this->user) {
            throw new Am_Exception_InputError('User with ID '.$userId.' does not exist in aMember');
        }

        $invoiceTable = Am_Di::getInstance()->invoiceTable;
        $this->invoice = $invoiceTable->load($invoiceId);
        if (!$this->invoice) {
            throw new Am_Exception_InputError('Invoice with ID '.$invoiceId.' does not exist in aMember');
        }

        // Set up the admin as a property
        $this->admin = Am_Di::getInstance()->authAdmin->getUser();
    }

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission('grid_user', 'edit');
    }

    /**
     * Change an invoices payment method
     */
    function changePmtMethodAction()
    {
        $newPaysys = htmlentities($this->_getParam('paysys_id'));

        // Load the plugin to see if we need to check for a credit card in the account
        try {
            $plugin = $this->getDi()->plugins_payment->loadGet($newPaysys, true);
        }
        catch (Exception $e) {
            Am_Controller::ajaxResponse(array('ok' => false, 'msg' => "Payment system with identifier of $newPaysys does not exist. Payment method was not changed!"));
        }
        if ($plugin->getRecurringType() == Am_Paysystem_Abstract::REPORTS_CRONREBILL) {
            // Plugin needs credit card record for rebilling, check to see if user has credit card on account
            if (!$this->_getCcHelper()->checkForCcByUser($this->user)) {
                Am_Controller::ajaxResponse(array('ok' => false, 'msg' => 'User does not have a credit card on file. Attach a CC first!'));
                return;
            }
        }
        // Everything is cool, change the invoice's payment method...
        try {
            $this->invoice->paysys_id = $newPaysys;
            $this->invoice->save();
                Am_Controller::ajaxResponse(array('ok' => true));
        }
        catch (Exception $e) {
            Am_Controller::ajaxResponse(array('ok' => false, 'msg' => "There was an issue saving the new payment method: {$e->getMessage()}"));
        }

    }

    protected function _getCcHelper()
    {
        return new UtilitiesCreditCard();
    }
}