<?php
$manifest = array (
    'acceptable_sugar_versions' =>  array (
        '7.2.*',
    ),
    'acceptable_sugar_flavors' =>  array (
        'ULT', 'ENT', 'PRO'
    ),
    'author' => 'SugarCRM, Inc.',
    'description' => 'Statis graph dashlet example',
    'icon' => '',
    'is_uninstallable' => 'true',
    'name' => 'Product Purchase Treemap 1.0',
    'published_date' => '2014-06-17 16:17:56',
    'type' => 'module',
    'version' => '1357251478',
);

$installdefs = array (
    'id' => 'product_purchase_treemap',
    'copy' => array (
        0 =>
            array (
                'from' => '<basepath>/custom',
                'to' => 'custom',
            ),
    ),
);
?>
