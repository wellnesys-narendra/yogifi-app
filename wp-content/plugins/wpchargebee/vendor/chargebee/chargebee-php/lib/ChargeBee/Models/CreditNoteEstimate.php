<?php

class ChargeBee_CreditNoteEstimate extends ChargeBee_Model
{

    protected $allowed = array('referenceInvoiceId', 'type', 'priceType', 'currencyCode', 'subTotal', 'total',
    'amountAllocated', 'amountAvailable', 'lineItems', 'discounts', 'taxes', 'lineItemTaxes', 'lineItemDiscounts','lineItemTiers', 'roundOffAmount');



    // OPERATIONS
    // -----------

}

?>