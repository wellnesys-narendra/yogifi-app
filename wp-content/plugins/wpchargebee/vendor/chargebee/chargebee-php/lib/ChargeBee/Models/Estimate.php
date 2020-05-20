<?php

class ChargeBee_Estimate extends ChargeBee_Model
{

    protected $allowed = array('createdAt', 'subscriptionEstimate', 'invoiceEstimate', 'invoiceEstimates', 'nextInvoiceEstimate',
    'creditNoteEstimates', 'unbilledChargeEstimates');



    // OPERATIONS
    // -----------

    public static function createSubscription($params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("estimates", "create_subscription"), $params, $env, $headers);
    }

    public static function createSubForCustomerEstimate($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::GET, ChargeBee_Util::encodeURIPath("customers", $id, "create_subscription_estimate"), $params, $env, $headers);
    }

    public static function updateSubscription($params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("estimates", "update_subscription"), $params, $env, $headers);
    }

    public static function renewalEstimate($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::GET, ChargeBee_Util::encodeURIPath("subscriptions", $id, "renewal_estimate"), $params, $env, $headers);
    }

    public static function upcomingInvoicesEstimate($id, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::GET, ChargeBee_Util::encodeURIPath("customers", $id, "upcoming_invoices_estimate"), array(), $env, $headers);
    }

    public static function changeTermEnd($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "change_term_end_estimate"), $params, $env, $headers);
    }

    public static function cancelSubscription($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "cancel_subscription_estimate"), $params, $env, $headers);
    }

    public static function pauseSubscription($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "pause_subscription_estimate"), $params, $env, $headers);
    }

    public static function resumeSubscription($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "resume_subscription_estimate"), $params, $env, $headers);
    }

}

?>