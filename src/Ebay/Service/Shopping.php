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
     * @param string $appId Ebay Application ID
     * @param boolean $debugMode Set object to debug mode.
     */
    public function __construct($appId,$debugMode = false) {
        parent::__construct($debugMode);

        // Headers
        $this->headers = array(
            'X-EBAY-API-VERSION: 867', // Not Required
            'X-EBAY-API-SITE-ID: 0', // Required
            'X-EBAY-API-APP-ID: '. $appId, // Required
        );
    }

    /**
     * Make a request to the service
     * @param \Ebay\Common\Request $request
     */
    public function makeRequest(\Ebay\Common\Request $request) {

        // Set Headers
        $this->setHeader('X-EBAY-API-REQUEST-ENCODING',$request->getRequestType())
                ->setHeader('X-EBAY-API-RESPONSE-ENCODING', $request->getResponseType())
                ->setHeader('X-EBAY-API-CALL-NAME', $request->getCallName())
                ->setHeader("Content-Type", "text/xml;charset=UTF-8");
        
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