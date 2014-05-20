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

namespace Ebay\Common;

/**
 * Response Objetc
 * @package Ebay
 * @author Rick Earley <rick@earleyholdings.com>
 * @copyright (c) 2014
 * @version 1.0
 */
class Response {
    
    /**
     * cURL Response Body
     * @var string
     */
    private $responseBody;
    
    /**
     * cURL Information
     * @var array
     */
    private $curlInformation;

    /**
     * Response Object
     */
    function __construct() {
    }
    
    /**
     * Set the response body
     * @param string $body
     * @return \Ebay\Common\Response
     */
    public function setResponseBody($body){
        
        $this->responseBody = $body;
        
        return $this;
    }
    
    /**
     * Set cURL Information
     * @param array $information
     * @return \Ebay\Common\Response
     * @throws \InvalidArgumentException
     */
    public function setCurlInformation($information){
        
        if(empty($information) && !is_array($information)){
            throw new \InvalidArgumentException("cURL Information cannot be empty and must be an array.");
        }
        
        $this->curlInformation = $information;
        
        return $this;
    }
    
    /**
     * Get the response body
     * @param string $returnObject Reponse type XML,JSON,OBJECT
     * @return mixed (XML,JSON,OBJECT) Default is XML
     */
    public function getResponseBody($returnObject = 'XML'){
        
        $returnObject = strtoupper($returnObject);
        
        switch($returnObject){
            case 'XML':
                return $this->responseBody;
            case 'JSON':
                return json_encode(simplexml_load_string($this->responseBody));
                break;
            case 'OBJECT':
                return simplexml_load_string($this->responseBody);
                break;
            default;
                return $this->responseBody;
        }        
    }
    
    /**
     * Get the cURL information
     * @return array
     */
    public function getCurlInformation(){
        return $this->curlInformation;
    }
}