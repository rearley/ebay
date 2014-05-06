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
 * Base Service Class
 * @package Ebay
 * @author Rick Earley <rick@earleyholdings.com>
 * @copyright (c) 2014
 * @version 1.0
 */
class Base {
    
    /**
     * Ebay HEaders
     * @var array
     */
    protected $headers;
    
    /**
     * Debug Mode
     * @var boolean
     */
    protected $debugMode;

    /**
     * Base Service Object
     * @param boolean $debugMode Set debug mode
     */
    function __construct($debugMode = false) {
        $this->debugMode = $debugMode;
    }
    
    /**
     * Make API Request
     * @param \Ebay\Common\Request $request
     * @return mixed
     * @throws \Ebay\Exception\Curl
     */
    protected function makeRequest(\Ebay\Common\Request $request){

        // cURL Options
        $options = array(
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $this->headers,
            CURLOPT_POSTFIELDS => $request->buildRequest(),
            CURLOPT_RETURNTRANSFER => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_URL => $request->getEndpoint()
        );        
        
        // Transport Object
        $curl = new \Ebay\Common\Curl();
        $curl->setOptionArray($options);
        $curl->send();
        
        // Handle cURL Errors
        $error = $curl->getError();
        if($error['number'] > 0){
            throw new \Ebay\Exception\Curl($error['message'],$error['number']);
        }    
        
        // TODO: Handle Response and Errors
        
        return $curl->getResponse();
    }
    
    /**
     * Set Ebay API Header
     * @param string $name
     * @param mixed $value
     * @return \Ebay\Common\Request
     * @throws \InvalidArgumentException
     */
    protected function setHeader($name,$value){
        
        if(empty($value)){
            throw new \InvalidArgumentException('Header values cannot be empty.');
        }
        
        $this->headers[] = "{$name}:{$value}";
        
        return $this;
    }
}