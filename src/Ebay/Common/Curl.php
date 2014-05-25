<?php

/*
 * Copyright (C) 2014 Rick Earley
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
 * Curl Wrapper Class
 * @package Ebay
 * @author Rick Earley <rick@earleyholdings.com>
 * @copyright (c) 2014
 * @version 1.0
 */
class Curl {

    /**
     * cURL Handle
     * @var resource
     */
    private $ch;
    
    /**
     * Stores the last cURL Session Errors $error['number'] and $error['message']
     * @var array 
     */
    private $error;
    
    /**
     * Stores the last cURL sessions information
     * @var array
     */
    private $information;
    
    /**
     * Stores the last cURL Response Body
     * @var type 
     */
    private $response;

    /**
     * New Curl Wrapper Object
     * @throws \Ebay\Exception\Curl
     */
    function __construct() {

        // cURL Object
        $this->ch = curl_init();

        if ($this->ch === FALSE) {
            throw new \Ebay\Exception\Curl(curl_error($this->ch));
        }
    }

    /**
     * Set a single cURL option
     * @param int $option
     * @param mixed $value
     * @return boolean
     * @throws \Ebay\Exception\Curl
     * @throws \InvalidArgumentException
     */
    public function setOption($option, $value) {

        if (!is_int($option)) {
            throw new \Ebay\Exception\Curl("The CURLOPT_XXX option is not a vaild option.", 1);
        }

        if (empty($value)) {
            throw new \InvalidArgumentException("The cURL option value cannot be empty", 1);
        }

        if (curl_setopt($this->ch, $option, $value) === false) {
            throw new \Ebay\Exception\Curl('The cURL option could not be set: ' . curl_error($this->ch));
        }

        return true;
    }

    /**
     * Set cURL options with array.
     * @param array $options Array of option=>value
     * @return boolean
     * @throws \InvalidArgumentException
     * @throws \Ebay\Exception\Curl
     */
    public function setOptionArray($options) {

        if (!is_array($options)) {
            throw new \InvalidArgumentException("cURL options must be in a option=>value array.");
        }

        if (curl_setopt_array($this->ch, $options) === false) {
            throw new \Ebay\Exception\Curl("Cound not set the cURL option array. " . curl_error($this->ch));
        }

        return true;
    }

    /**
     * Send cURL session
     * @return boolean
     */
    public function send() {

        // Send cURL Request
        $this->response = curl_exec($this->ch);
        
        if($this->response === false){
            return false;
        }

        // Get Error codes
        $this->error = array(
            'number' => curl_errno($this->ch),
            'message' => curl_error($this->ch)
        );

        // Get transfer information
        $this->information = curl_getinfo($this->ch);
        
        return true;
    }
    
    /**
     * Get cURL Response
     * @return mixed
     */
    public function getResponse(){
        return $this->response;
    }
    
    /**
     * Get cURL Errors
     * @return mixed
     */
    public function getError() {
        return $this->error;
    }

    /**
     * Get cURL Session Information
     * @return array
     */
    public function getInformation() {
        return $this->information;
    }
}