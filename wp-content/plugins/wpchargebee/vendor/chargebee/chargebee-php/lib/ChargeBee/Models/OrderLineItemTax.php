<?php

class ChargeBee_OrderLineItemTax extends ChargeBee_Model
{
    protected $allowed = array('line_item_id', 'tax_name', 'tax_rate', 'is_partial_tax_applied', 'is_non_compliance_tax', 'taxable_amount', 'tax_amount', 'tax_juris_type', 'tax_juris_name', 'tax_juris_code');

}

?>