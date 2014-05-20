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
 * Trading Service Object
 * @package Ebay
 * @author Rick Earley <rick.earleyholdings.com>
 * @copyright (c) 2014
 * @version 1.0
 */
class Trading extends \Ebay\Service\Base {

    /**
     * Different Endpoints for the Finding Service
     * @var array
     */
    private $endpoints = array(
        'production' => 'https://api.ebay.com/ws/api.dll',
        'sandbox' => 'https://api.sandbox.ebay.com/ws/api.dll'
    );

    /**
     * Finding Service
     * @param string $appId Ebay Application ID
     * @param boolean $debugMode Set object to debug mode.
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Sets up the headers for the Finding Service.
     */
    private function setupHeaders($request){
        
        // API Level
        $this->setHeader('X-EBAY-API-COMPATIBILITY-LEVEL',$this->callVersion);
        
        // Site ID
        $this->setHeader('X-EBAY-API-SITEID',$this->siteId);
        
        // AppId
        $this->setHeader('X-EBAY-API-APP-NAME',$this->appId);
        
        // DevId
        $this->setHeader('X-EBAY-API-DEV-NAME',$this->devId);
        
        // CertId
        $this->setHeader('X-EBAY-API-CERT-NAME',$this->certId);
        
        // Content Type
        $this->setHeader("Content-Type", "text/xml");        
        
        // Call Name
        $this->setHeader("X-EBAY-API-CALL-NAME", $request->getCallName());
        
        $this->setHeader("Expect", "");
    }

    /**
     * Make a request to the service
     * @param \Ebay\Common\Request $request
     */
    public function makeRequest(\Ebay\Common\Request $request, $requireCredntials = true) {
        
        // Trading Call Headers
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
        
        // Setup Call Credentials
        if($requireCredntials){
            $RequesterCredentialsField = new \Ebay\Common\Field();
            $RequesterCredentialsField->setName('RequesterCredentials')->setValue(new \Ebay\Common\Field('eBayAuthToken',$this->userToken));

            $request->addField($RequesterCredentialsField);
        }
        
        // Content Length
        $this->setHeader("Content-Length",  strlen($request->buildRequest()));
    
        // Call Parent Function
        return parent::makeRequest($request);
    }
}