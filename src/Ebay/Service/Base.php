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
abstract class Base {

    /**
     * Ebay HEaders
     * @var array
     */
    protected $headers;

    /**
     * Debug Mode
     * @var boolean
     */
    protected $debugMode = false;
    
    /**
     * Ebay DevID
     * @var string
     */
    protected $devId;
    
    /**
     * Ebay AppID
     * @var string
     */
    protected $appId;
    
    /**
     * Ebay CertID
     * @var string
     */
    protected $certId;
    
    /**
     * Ebay User Token
     * @var string
     */
    protected $userToken;
    
    /**
     * Call Version
     * @var string
     */
    protected $callVersion;
    
    /**
     * Ebay Site ID
     * @var string
     */
    protected $siteId;

    /**
     * Base Service Object
     */
    function __construct() {
        
    }

    /**
     * Set the DevID provided by Ebay
     * @param string $devId
     * @return \Ebay\Service\Base
     */
    public function setDevId($devId) {
        $this->devId = $devId;
        return $this;
    }

    /**
     * Set the AppID provided by Ebay
     * @param string $appId
     * @return \Ebay\Service\Base
     */
    public function setAppId($appId) {
        $this->appId = $appId;
        return $this;
    }

    /**
     * Set the certID provided by Ebay
     * @param string $certId
     * @return \Ebay\Service\Base
     */
    public function setCertId($certId) {
        $this->certId = $certId;
        return $this;
    }
    
    /**
     * Set User Token
     * @param string $userToken
     * @return \Ebay\Service\Base
     */
    public function setUserToken($userToken){
        $this->userToken = $userToken;
        return $this;
    }
    
    /**
     * Set the Library debug mode
     * @param boolean $debugMode
     * @return \Ebay\Service\Base
     */
    public function setDebugMode($debugMode){
        $this->debugMode = $debugMode;
        return $this;
    }
    
    /**
     * Set call version
     * @param string $callVersion
     * @return \Ebay\Service\Base
     */
    public function setCallVersion($callVersion){
        $this->callVersion = $callVersion;
        return $this;
    }
    
    /**
     * Set the Site ID for the Request
     * @param string $siteId
     * @return \Ebay\Service\Base
     */
    public function setSiteId($siteId){
        $this->siteId = $siteId;
        return $this;
    }

    /**
     * Make API Request
     * @param \Ebay\Common\Request $request
     * @return \Ebay\Common\Response
     * @throws \Ebay\Exception\Curl
     */
    protected function makeRequest(\Ebay\Common\Request $request) {

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
        if ($error['number'] > 0) {
            throw new \Ebay\Exception\Curl($error['message'], $error['number']);
        }

        // Return Reponse Object
        $response = new \Ebay\Common\Response();

        $response->setResponseBody($curl->getResponse())
                ->setCurlInformation($curl->getInformation());

        return $response;
    }

    /**
     * Set Ebay API Header
     * @param string $name
     * @param mixed $value
     * @return \Ebay\Common\Request
     * @throws \InvalidArgumentException
     */
    protected function setHeader($name, $value) {

        $this->headers[] = "{$name}:{$value}";

        return $this;
    }
}