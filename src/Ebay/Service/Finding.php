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
 * Finding Service Object
 * @package Ebay
 * @author Rick Earley <rick.earleyholdings.com>
 * @copyright (c) 2014
 * @version 1.0
 */
class Finding extends \Ebay\Service\Base {

    /**
     * Different Endpoints for the Finding Service
     * @var array
     */
    private $endpoints = array(
        'production' => 'http://svcs.ebay.com/services/search/FindingService/v1?',
        'sandbox' => 'http://svcs.sandbox.ebay.com/services/search/FindingService/v1?'
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
            'X-EBAY-SOA-SERVICE-VERSION: 1.12.0', // Not Required
            'X-EBAY-SOA-GLOBAL-ID: EBAY-US', // Required
            'X-EBAY-SOA-SECURITY-APPNAME: '. $appId, // Required
            'X-EBAY-SOA-MESSAGE-ENCODING: UTF-8' // Conditionally
        );
    }

    /**
     * Make a request to the service
     * @param \Ebay\Common\Request $request
     */
    public function makeRequest(\Ebay\Common\Request $request) {

        // Set Headers
        $this->setHeader('X-EBAY-SOA-REQUEST-DATA-FORMAT',$request->getRequestType())
                ->setHeader('X-EBAY-SOA-RESPONSE-DATA-FORMAT', $request->getResponseType())
                ->setHeader('X-EBAY-SOA-OPERATION-NAME', $request->getCallName());

        // Set Endpoint
        if($this->debugMode){
            $request->setEndpoint($this->endpoints['sandbox']);
        } else {
            $request->setEndpoint($this->endpoints['production']);
        }

        // Set XML Header/Footer
        $request->setCallHeader('<' . $request->getCallName() . 'Request xmlns="http://www.ebay.com/marketplace/search/v1/services">');
        $request->setCallFooter('</' . $request->getCallName() . 'Request>');
        
        // Call Parent Function
        return parent::makeRequest($request);
    }

}