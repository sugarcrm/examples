<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Copyright (c) 2014, John Mertic
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

require_once('include/connectors/sources/SourceFactory.php');
require_once('clients/base/api/ConnectorApi.php');

class NytDashletApi extends ConnectorApi
{
	public function registerApiRest() {
        return array(
            'exportRecord' => array(
                'reqType' => 'GET',
                'path' => array('connector','NytDashlet', 'search', '?'),
                'pathVars' => array('connector', 'module', 'search', 'query'),
                'method' => 'newsSearch',
                'rawReply'=> true,
                'shortHelp' => 'Returns the API key given by the user',
                'longHelp' => '',
            ),
        );
    }

	/**
     * Returns the API key given by the user
     * @param ServiceBase $api
     * @param array $args Arguments array built by the service base
     * @return null
     */
    public function newsSearch(ServiceBase $api, array $args)
    {
    	$source = 'ext_rest_nytsearch';
        $s = SourceFactory::getSource($source);
        $config = $s->getConfig();
        $apiKey = $config['properties']['api_key'];

        $url = "http://api.nytimes.com/svc/search/v2/articlesearch.json?hl=1&q=".$args['query']."&api-key=".$apiKey;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;
    }
}