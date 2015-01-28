<?php
$module_name = 'Calls';
$viewdefs[$module_name] =
    array (
        'base' =>
            array (
                'view' =>
                    array (
                        'record' =>
                            array (
                                'panels' =>
                                    array (
                                        0 =>
                                            array (
                                                'name' => 'panel_header',
                                                'label' => 'LBL_RECORD_HEADER',
                                                'header' => true,
                                                'fields' =>
                                                    array (
                                                        0 =>
                                                            array (
                                                                'name' => 'picture',
                                                                'type' => 'avatar',
                                                                'width' => 42,
                                                                'height' => 42,
                                                                'dismiss_label' => true,
                                                                'readonly' => true,
                                                            ),
                                                        1 => 'name',
                                                        2 =>
                                                            array (
                                                                'name' => 'favorite',
                                                                'label' => 'LBL_FAVORITE',
                                                                'type' => 'favorite',
                                                                'readonly' => true,
                                                                'dismiss_label' => true,
                                                            ),
                                                        3 =>
                                                            array (
                                                                'name' => 'follow',
                                                                'label' => 'LBL_FOLLOW',
                                                                'type' => 'follow',
                                                                'readonly' => true,
                                                                'dismiss_label' => true,
                                                            ),
                                                    ),
                                            ),
                                        1 =>
                                            array (
                                                'name' => 'panel_body',
                                                'label' => 'LBL_RECORD_BODY',
                                                'columns' => 2,
                                                'labelsOnTop' => true,
                                                'placeholders' => true,
                                                'fields' =>
                                                    array (
                                                        0 => 'assigned_user_name',
                                                        1 => 'team_name',
                                                        2 =>
                                                            array (
                                                                'name' => 'parent_name',
                                                            ),
                                                        3 =>
                                                            array (
                                                                'name' => 'status',
                                                            ),
                                                        4 =>
                                                            array (
                                                                'name' => 'description',
                                                                'span' => 12,
                                                            ),
                                                        5 => array(
                                                            'name' => 'date_start',
                                                            'display_default' => 'now',
                                                        ),
                                                        6 => array(
                                                            'name' => 'date_end',
                                                            'display_default' => 'now',
                                                        ),
                                                        7 => 'date_modified',
                                                        8 => 'date_entered',
                                                    ),
                                            ),
                                    ),
                            ),
                    ),
            ),
    );
