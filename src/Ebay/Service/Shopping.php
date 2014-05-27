<?php

/*
 * Copyright (C) 2014 rick
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Ebay\Service;

/**
 * Shopping Service Object
 * @package Ebay
 * @author Rick Earley <rick.earleyholdings.com>
 * @copyright (c) 2014
 * @version 1.0
 */
class Shopping extends \Ebay\Service\Base {

    /**
     * Different Endpoints for the Finding Service
     * @var array
     */
    private $endpoints = array(
        'production' => 'http://open.api.ebay.com/shopping?',
        'sandbox' => 'http://open.api.sandbox.ebay.com/shopping?'
    );

    /**
     * Finding Service
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Sets up the headers for the Finding Service.
     */
    private function setupHeaders($request){
        
        // API Level
        $this->setHeader('X-EBAY-API-VERSION',$this->callVersion);
        
        // Site ID
        $this->setHeader('X-EBAY-API-SITE-ID',$this->siteId);
        
        // AppId
        $this->setHeader('X-EBAY-API-APP-ID',$this->appId);
        
        // Content Type
        $this->setHeader("Content-Type", "text/xml;charset=UTF-8");
        
        // Request Encoding
        $this->setHeader("X-EBAY-API-REQUEST-ENCODING", $request->getRequestType());
        
        // Response Encoding
        $this->setHeader("X-EBAY-API-RESPONSE-ENCODING", $request->getResponseType());
        
        // Call Name
        $this->setHeader("X-EBAY-API-CALL-NAME", $request->getCallName());
    }

    /**
     * Make a request to the service
     * @param \Ebay\Common\Request $request
     * @return mixed
     */
    public function makeRequest(\Ebay\Common\Request $request) {

        // Set Headers
        $this->setupHeaders($request);
        
        // Set Endpoint
        if($this->debugMode){
            $request->setEndpoint($this->endpoints['sandbox']);
        } else {
            $request->setEndpoint($this->endpoints['production']);
        }

        // Set XML Header/Footer
        $request->setCallHeader('<' . $request->getCallName() . 'Request xmlns="urn:ebay:apis:eBLBaseComponents">');
        $request->setCallFooter('</' . $request->getCallName() . 'Request>');
    
        // Call Parent Function
        return parent::makeRequest($request);
    }

}