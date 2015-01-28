<?php
$manifest = array (
    'acceptable_sugar_versions' =>  array (
        '7.2.*',
    ),
    'acceptable_sugar_flavors' =>  array (
        'ULT', 'ENT'
    ),
    'author' => 'SugarCRM, Inc.',
    'description' => 'For Use By SugarCRM employees for Custom Demo',
    'icon' => '',
    'is_uninstallable' => 'true',
    'name' => 'Simple Call Logger 1.0',
    'published_date' => '2014-06-17 16:17:56',
    'type' => 'module',
    'version' => '1357251479',
);

$installdefs = array (
    'id' => 'simple_call_logger',
    'copy' => array (
        0 =>
            array (
                'from' => '<basepath>/custom',
                'to' => 'custom',
            ),
    ),
);
?>