<?php

class ChargeBee_Subscription extends ChargeBee_Model
{

    protected $allowed = array('id', 'customerId', 'currencyCode', 'planId', 'planQuantity', 'planUnitPrice',
    'setupFee', 'planAmount', 'billingPeriod', 'billingPeriodUnit', 'planFreeQuantity', 'status','startDate', 'trialStart', 'trialEnd', 'currentTermStart', 'currentTermEnd', 'nextBillingAt','remainingBillingCycles', 'poNumber', 'createdAt', 'startedAt', 'activatedAt', 'giftId', 'pauseDate','resumeDate', 'cancelledAt', 'cancelReason', 'affiliateToken', 'createdFromIp', 'resourceVersion','updatedAt', 'hasScheduledChanges', 'paymentSourceId', 'autoCollection', 'dueInvoicesCount','dueSince', 'totalDues', 'mrr', 'exchangeRate', 'baseCurrencyCode', 'addons', 'eventBasedAddons','chargedEventBasedAddons', 'coupon', 'coupons', 'shippingAddress', 'referralInfo', 'invoiceNotes','metaData', 'deleted');



    // OPERATIONS
    // -----------

    public static function create($params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions"), $params, $env, $headers);
    }

    public static function createForCustomer($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "subscriptions"), $params, $env, $headers);
    }

    public static function all($params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::sendListRequest(ChargeBee_Request::GET, ChargeBee_Util::encodeURIPath("subscriptions"), $params, $env, $headers);
    }

    public static function subscriptionsForCustomer($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::GET, ChargeBee_Util::encodeURIPath("customers", $id, "subscriptions"), $params, $env, $headers);
    }

    public static function retrieve($id, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::GET, ChargeBee_Util::encodeURIPath("subscriptions", $id), array(), $env, $headers);
    }

    public static function retrieveWithScheduledChanges($id, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::GET, ChargeBee_Util::encodeURIPath("subscriptions", $id, "retrieve_with_scheduled_changes"), array(), $env, $headers);
    }

    public static function removeScheduledChanges($id, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "remove_scheduled_changes"), array(), $env, $headers);
    }

    public static function removeScheduledCancellation($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "remove_scheduled_cancellation"), $params, $env, $headers);
    }

    public static function removeCoupons($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "remove_coupons"), $params, $env, $headers);
    }

    public static function update($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id), $params, $env, $headers);
    }

    public static function changeTermEnd($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "change_term_end"), $params, $env, $headers);
    }

    public static function cancel($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "cancel"), $params, $env, $headers);
    }

    public static function reactivate($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "reactivate"), $params, $env, $headers);
    }

    public static function addChargeAtTermEnd($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "add_charge_at_term_end"), $params, $env, $headers);
    }

    public static function chargeAddonAtTermEnd($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "charge_addon_at_term_end"), $params, $env, $headers);
    }

    public static function chargeFutureRenewals($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "charge_future_renewals"), $params, $env, $headers);
    }

    public static function importSubscription($params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", "import_subscription"), $params, $env, $headers);
    }

    public static function importForCustomer($id, $params, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("customers", $id, "import_subscription"), $params, $env, $headers);
    }

    public static function overrideBillingProfile($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "override_billing_profile"), $params, $env, $headers);
    }

    public static function delete($id, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "delete"), array(), $env, $headers);
    }

    public static function pause($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "pause"), $params, $env, $headers);
    }

    public static function resume($id, $params = array(), $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "resume"), $params, $env, $headers);
    }

    public static function removeScheduledPause($id, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "remove_scheduled_pause"), array(), $env, $headers);
    }

    public static function removeScheduledResumption($id, $env = null, $headers = array())
    {
        return ChargeBee_Request::send(ChargeBee_Request::POST, ChargeBee_Util::encodeURIPath("subscriptions", $id, "remove_scheduled_resumption"), array(), $env, $headers);
    }

}

?>