<?php

class ChargeBee_Customer extends ChargeBee_Model
{

    protected $allowed = array('id', 'firstName', 'lastName', 'email', 'phone', 'company', 'vatNumber', 'autoCollection',
    'netTermDays', 'vatNumberValidatedTime', 'vatNumberStatus', 'allowDirectDebit', 'isLocationValid','createdAt', 'createdFromIp', 'exemptionDetails', 'taxability', 'entityCode', 'exemptNumber','resourceVersion', 'updatedAt', 'locale', 'consolidatedInvoicing', 'billingDate', 'billingDateMode','billingDayOfWeek', 'billingDayOfWeekMode', 'piiCleared', 'cardStatus', 'fraudFlag', 'primaryPaymentSourceId','backupPaymentSourceId', 'billingAddress', 'referralUrls', 'contacts', 'paymentMethod', 'invoiceNotes','preferredCurrencyCode', 'promotionalCredits', 'unbilledCharges', 'refundableCredits', 'excessPayments','balances', 'metaData', 'deleted', 'registeredForGst', 'customerType');



    // OPERATIONS
    // -----------

    public static function create($params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers"), $params, $env, $headers);
    }

    public static function all($params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::sendListRequest(ChargeBee_Request::GET, ChargeBee_Util::encodeURIPath("customers"), $params, $env, $headers);
    }

    public static function retrieve($id, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::GET, ChargeBee_Util::encodeURIPath("customers", $id), array(), $env, $headers);
    }

    public static function update($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id), $params, $env, $headers);
    }

    public static function updatePaymentMethod($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "update_payment_method"), $params, $env, $headers);
    }

    public static function updateBillingInfo($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "update_billing_info"), $params, $env, $headers);
    }

    public static function contactsForCustomer($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::GET, ChargeBee_Util::encodeURIPath("customers", $id, "contacts"), $params, $env, $headers);
    }

    public static function assignPaymentRole($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "assign_payment_role"), $params, $env, $headers);
    }

    public static function addContact($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "add_contact"), $params, $env, $headers);
    }

    public static function updateContact($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "update_contact"), $params, $env, $headers);
    }

    public static function deleteContact($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "delete_contact"), $params, $env, $headers);
    }

    public static function addPromotionalCredits($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "add_promotional_credits"), $params, $env, $headers);
    }

    public static function deductPromotionalCredits($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "deduct_promotional_credits"), $params, $env, $headers);
    }

    public static function setPromotionalCredits($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "set_promotional_credits"), $params, $env, $headers);
    }

    public static function recordExcessPayment($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "record_excess_payment"), $params, $env, $headers);
    }

    public static function collectPayment($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "collect_payment"), $params, $env, $headers);
    }

    public static function delete($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "delete"), $params, $env, $headers);
    }

    public static function move($params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", "move"), $params, $env, $headers);
    }

    public static function changeBillingDate($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "change_billing_date"), $params, $env, $headers);
    }

    public static function merge($params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", "merge"), $params, $env, $headers);
    }

    public static function clearPersonalData($id, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "clear_personal_data"), array(), $env, $headers);
    }

}

?>