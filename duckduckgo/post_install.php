<?php
/*
 * Copyright (c) 2013, John Mertic
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

if (!defined('sugarEntry')) define('sugarEntry', true);


function addDashletToUsersDashboard($user_id,$dashlet_name,$dashlet_json)
{
    $home = BeanFactory::getBean('Dashboards');

    $fields = array(
        'name' => 'LBL_DEFAULT_DASHBOARD_TITLE',
        'dashboard_module' => 'Home',
        'created_by' => $user_id,
        'modified_user_id' => $user_id,
        'assigned_user_id' => $user_id,
    );
    $home_bean = $home->retrieve_by_string_fields($fields);

    $metadata = html_entity_decode($home_bean->metadata);

    // check if dashlet is already installed
    if (strpos($metadata, '"'.$dashlet_name.'"') === false) {
        $home_json = json_decode($metadata);

        // if dashlet metadata cannot be read, don't do anything
        if (!is_null($home_json)) {
            array_push($home_json->components[0]->rows, $dashlet_json);
            $metadata = json_encode($home_json);

            /*
	     * We must do a raw SQL statement here because Sugar beans always
	     * override the value of assigned_user_id to 1 (i.e. admin), which
	     * is not what we want since the dashboard data will be rendered
	     * as invalid to the Dashboard module code and simply create a new
	     * one, effectively ignoring our change.
             */
            $sql = "UPDATE dashboards SET metadata = '$metadata' WHERE id = '{$home_bean->id}'";
            $home_bean->db->query($sql);
        }
    }
}


function addDashletToGivenModules($user_id,$name,$json,$modules,$views)
{
    $dashlet_json = array(
        'components' => array(array(
            'rows' => array(
                $json,
            ),
            'width' => 12,
        )),
    );
    $metadata = json_encode($dashlet_json);

    foreach ($modules as $module) {
        foreach ($views as $view) {

            $dash_bean = BeanFactory::getBean('Dashboards');

            $fields = array(
                'name' => $name,
                'dashboard_module' => $module,
                'view' => $view,
                'created_by' => $user_id,
                'modified_user_id' => $user_id,
                'assigned_user_id' => $user_id,
            );

            // don't install dashlet if it is already installed
            if (!is_null($dash_bean->retrieve_by_string_fields($fields)->id)) {
                continue;
            }

            // create a new Dashboard record
            $dash_bean->name = $name;
            $dash_bean->dashboard_module = $module;
            $dash_bean->view = $view;
            $dash_bean->save();

            /*
    	     * We must do a raw SQL statement here because Sugar beans always
    	     * override the value of assigned_user_id to 1 (i.e. admin), which
    	     * is not what we want since the dashboard data will be rendered
    	     * as invalid to the Dashboard module code and simply create a new
    	     * one, effectively ignoring our change.
             */
            $sql = "UPDATE dashboards SET metadata = '$metadata', created_by = '$user_id', modified_user_id = '$user_id', assigned_user_id = '$user_id' WHERE id = '{$dash_bean->id}'";
            $dash_bean->db->query($sql);
        }
    }
}


function post_install()
{
    // Add Duck Duck Go as a default dashlet on the given modules
    $dashlet_json = array(array(
        'width' => 12,
        'context' => array(
            'module' => 'Home',
        ),
        'view' => array(
            'label' => 'LBL_DASHLET_DUCKDUCKGO_NAME',
            'name' => 'duckduckgo',
            'module' => 'Home',
        ),
    ));
    $dashlet_name = "duckduckgo";
    $dashlet_modules = array(
        'Accounts',
        'Contacts',
        'Leads',
        'Prospects',
        );
    $dashlet_views = array(
        'record', // normal record view
        );

    $usersBean = BeanFactory::getBean('Users');
    $users = $usersBean->get_full_list();

    echo '<p>Adding Duck Duck Go dashlet to all user views...';
    foreach ($users as $user) {
        addDashletToGivenModules($user->id,$dashlet_json,$dashlet_name,$dashlet_modules,$dashlet_views);
    }
}