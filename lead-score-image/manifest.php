<?php
$manifest = array (
    'acceptable_sugar_versions' =>  array (
        '7.5.*',
    ),
    'acceptable_sugar_flavors' =>  array (  
		'PRO', 'ULT', 'ENT'
    ),
    'author' => 'SugarCRM, Inc.',
    'description' => 'For Use By SugarCRM employees for Custom Demo',
    'icon' => '',
    'is_uninstallable' => 'true',
    'name' => 'Lead Score Field',
    'published_date' => '2014-06-17 16:17:56',
    'type' => 'module',
    'version' => '1357251479',
);

$installdefs = array (
    'id' => 'lead_score_image',
    'copy' => array (
        0 =>
            array (
                'from' => '<basepath>/custom',
                'to' => 'custom',
            ),
    ),
);
?>