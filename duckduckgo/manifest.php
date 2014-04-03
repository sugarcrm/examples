<?php
/*
 * Copyright (c) 2014, SugarCRM
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 * 
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 * 
 * * Redistributions in binary form must reproduce the above copyright notice, this
 *   list of conditions and the following disclaimer in the documentation and/or
 *   other materials provided with the distribution.
 * 
 * * Neither the name of the SugarCRM nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

$manifest = array(
    'acceptable_sugar_versions' => array(
        'regex_matches' => array(
            '7\.[012345]\.\d\w*'
            ),
        ),
    'acceptable_sugar_flavors' => array(
        'PRO',
        'CORP',
        'ENT',
        'ULT',
        ),
    'readme' => '',
    'key' => 'Duck Duck Go for SugarCRM',
    'author' => '',
    'description' => 'Record dashlet that returns the Duck Duck Go search results for the given record',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'Duck Duck Go for SugarCRM',
    'published_date' => '2013-11-05 21:24:17',
    'type' => 'module',
    'version' => '20131105',
    'remove_tables' => false,
    );

$installdefs = array(
    'id' => 'duckduckgo',
    'post_install' => array('<basepath>/post_install.php'),
    'copy' => array(
        array(
            'from' => '<basepath>/dashlet/',
            'to' => 'custom/modules/Home/clients/base/views/duckduckgo/',
            ),
        ),
    'language' => array(
        array(
            'from' => '<basepath>/en_us.lang.php',
            'to_module' => 'application',
            'language' => 'en_us',
            ),
        ),
    );