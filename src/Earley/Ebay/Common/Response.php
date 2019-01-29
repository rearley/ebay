<?php
/*
 * Copyright (C) 2016
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

namespace Earley\Ebay\Common;

use \Exception;

/**
 * Class Response
 * @package Earley\Ebay\Common
 */
class Response
{

    /**
     * @var \GuzzleHttp\Psr7\Response $response
     */
    private $response;

    /**
     * Response constructor.
     *
     * @param \GuzzleHttp\Psr7\Response $response
     */
    public function __construct(\GuzzleHttp\Psr7\Response $response)
    {
        $this->response = $response;
    }

    /**
     * Get Body in XML format
     * @return string
     */
    public function toString()
    {
        return $this->response->getBody()->getContents();
    }

    /**
     * Get Response in array format
     *
     * @return bool|mixed
     * @throws Exception
     */
    public function toArray()
    {

        try {
            $body = $this->toXML();
        } catch (Exception $e) {
            throw new Exception("The response was not a valid XML file. Report Error:" . $e->getMessage());
        }

        return json_decode(json_encode($body), 1);
    }

    /**
     * Returns response in XML format
     * @return \SimpleXMLElement
     * @throws Exception
     */
    public function toXML()
    {

        // Allow Internal Error Processing
        libxml_use_internal_errors(true);

        // Load Response to XML
        $xml = simplexml_load_string($this->response->getBody()->getContents());

        // Check for Errors
        $xml_error = libxml_get_last_error();

        if ($xml_error !== false) {
            // Clear errors for next request
            libxml_clear_errors();
            throw new Exception($xml_error->message, $xml_error->code);
        }

        return $xml;
    }

    /**
     * Get Response Headers
     * @return array
     */
    public function getHeaders()
    {
        return $this->response->getHeaders();
    }

    /**
     * Get HTTP Status Code
     * @return int
     */
    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     * Get HTTP Status Phrase
     * @return null|string
     */
    public function getReasonPhrase()
    {
        return $this->response->getReasonPhrase();
    }
}