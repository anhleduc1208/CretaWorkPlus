<?php 

// register_rest_field('cr_account', 'account_number', array(
//     'get_callback'      => function ( $post ) {         
//         return get_post_meta( $post['id'], 'account_number', true );
//     },
//     'update_callback'   => function ( $value, $object ) {
//         update_post_meta( $object->ID, 'account_number', $value );
//     },
//     'schema'            => null
// ));

// register_rest_field('cr_deal', 'date_deal', array(
//     'get_callback'      => function ( $post ) {         
//         return get_post_meta( $post['id'], 'date_deal', true );
//     },
//     'update_callback'   => function ( $value, $object ) {
//         update_post_meta( $object->ID, 'date_deal', $value );
//     },
//     'schema'            => null
// ));

// register_rest_field('cr_deal', 'staff_deal', array(
//     'get_callback'      => function ( $post ) {         
//         return get_post_meta( $post['id'], 'staff_deal', true );
//     },
//     'update_callback'   => function ( $value, $object ) {
//         update_post_meta( $object->ID, 'staff_deal', $value );
//     },
//     'schema'            => null
// ));

// register_rest_field('cr_deal', 'define_deal', array(
//     'get_callback'      => function ( $post ) {         
//         return get_post_meta( $post['id'], 'define_deal', true );
//     },
//     'update_callback'   => function ( $value, $object ) {
//         update_post_meta( $object->ID, 'define_deal', $value );
//     },
//     'schema'            => null
// ));

// register_rest_field('cr_deal', 'amount', array(
//     'get_callback'      => function ( $post ) {         
//         return get_post_meta( $post['id'], 'amount', true );
//     },
//     'update_callback'   => function ( $value, $object ) {
//         update_post_meta( $object->ID, 'amount', $value );
//     },
//     'schema'            => null
// ));

// register_rest_field('cr_define_deal', 'debit', array(
//     'get_callback'      => function ( $post ) {         
//         return get_post_meta( $post['id'], 'debit', true );
//     },
//     'update_callback'   => function ( $value, $object ) {
//         update_post_meta( $object->ID, 'debit', $value );
//     },
//     'schema'            => null
// ));

// register_rest_field('cr_define_deal', 'credit', array(
//     'get_callback'      => function ( $post ) {         
//         return get_post_meta( $post['id'], 'credit', true );
//     },
//     'update_callback'   => function ( $value, $object ) {
//         update_post_meta( $object->ID, 'credit', $value );
//     },
//     'schema'            => null
// ));

// Minh - cr_customer register

register_rest_field('cr_customer','code',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'code', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'code', $value );
    },
    'schema'            => null
));

register_rest_field('cr_customer','c_codes',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'c_codes', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'c_codes', $value );
    },
    'schema'            => null
));
register_rest_field('cr_customer','customerInfo',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'customerInfo', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'customerInfo', $value );
    },
    'schema'            => null
));
register_rest_field('cr_customer','recentInvoices',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'recentInvoices', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'recentInvoices', $value );
    },
    'schema'            => null
));

register_rest_field('cr_carrier','code',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'code', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'code', $value );
    },
    'schema'            => null
));

register_rest_field('cr_carrier','address',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'address', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'address', $value );
    },
    'schema'            => null
));

// register_rest_field('cr_customer','carrierInfo',array(
//     'get_callback'      => function ( $post ) {         
//         return get_post_meta( $post['id'], 'carrierInfo', true );
//     },
//     'update_callback'   => function ( $value, $object ) {
//         update_post_meta( $object->ID, 'carrierInfo', $value );
//     },
//     'schema'            => null
// ));

// End of Minh - cr_customer register

register_rest_field('cr_invoice','code',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'code', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'code', $value );
    },
    'schema'            => null
));
register_rest_field('cr_invoice','statusInv',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'statusInv', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'statusInv', $value );
    },
    'schema'            => null
));
register_rest_field('cr_invoice','contentInvoice',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'contentInvoice', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'contentInvoice', $value );
    },
    'schema'            => null
));
register_rest_field('cr_invoice','planInfo',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'planInfo', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'planInfo', $value );
    },
    'schema'            => null
));
register_rest_field('cr_invoice','customerCode',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'customerCode', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'customerCode', $value );
    },
    'schema'            => null
));
register_rest_field('cr_invoice','deliveryStatus',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'deliveryStatus', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'deliveryStatus', $value );
    },
    'schema'            => null
));
register_rest_field('cr_invoice','purchaseDate',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'purchaseDate', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'purchaseDate', $value );
    },
    'schema'            => null
));
register_rest_field('cr_invoice','customerInfo',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'customerInfo', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'customerInfo', $value );
    },
    'schema'            => null
));
register_rest_field('cr_invoice','deliveryRealTime',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'deliveryRealTime', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'deliveryRealTime', $value );
    },
    'schema'            => null
));
register_rest_field('cr_invoice','hiddenCode',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'hiddenCode', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'hiddenCode', $value );
    },
    'schema'            => null
));
register_rest_field('cr_invoice','logHistory',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'logHistory', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'logHistory', $value );
    },
    'schema'            => null
));
register_rest_field('cr_log','code',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'code', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'code', $value );
    },
    'schema'            => null
));
register_rest_field('cr_log','datetime',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'datetime', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'datetime', $value );
    },
    'schema'            => null
));
register_rest_field('cr_log','description',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'description', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'description', $value );
    },
    'schema'            => null
));
register_rest_field('cr_log','type',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'type', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'type', $value );
    },
    'schema'            => null
));
register_rest_field('cr_log','dangerousLevel',array(
    'get_callback'      => function ( $post ) {         
        return get_post_meta( $post['id'], 'dangerousLevel', true );
    },
    'update_callback'   => function ( $value, $object ) {
        update_post_meta( $object->ID, 'dangerousLevel', $value );
    },
    'schema'            => null
));