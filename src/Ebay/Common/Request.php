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
 * Ebay API Request Object
 * @package Ebay
 * @author Rick Earley <rick@earleyholdings.com>
 * @copyright (c) 2014
 * @version 1.0
 */
class Request {

    private $fields;
    private $callName;
    private $requestType = 'XML';
    private $responseType = 'XML';
    private $endpoint;
    private $callHeader;
    private $callFooter;

    function __construct($callName) {
        $this->callName = $callName;
    }

    public function getEndpoint() {
        return $this->endpoint;
    }

    public function setEndpoint($endpoint) {
        $this->endpoint = $endpoint;
    }

    public function setRequestType($type) {
        $this->requestType = $type;
    }

    public function getRequestType() {
        return $this->requestType;
    }

    public function setResponseType($type) {
        $this->responseType = $type;
    }

    public function getResponseType() {
        return $this->responseType;
    }

    public function getCallName() {
        return $this->callName;
    }

    public function getCallHeader() {
        return $this->callHeader;
    }

    public function getCallFooter() {
        return $this->callFooter;
    }

    public function setCallHeader($callHeader) {
        $this->callHeader = $callHeader;
    }

    public function setCallFooter($callFooter) {
        $this->callFooter = $callFooter;
    }

    public function addField($field) {
        $this->fields[] = $field;
    }

    public function buildRequest() {

        $xmlString = '<?xml version="1.0" encoding="utf-8"?>';
        $xmlString .= $this->callHeader;
        $xmlString .= $this->buildXmlBody();
        $xmlString .= $this->callFooter;

        return $xmlString;
    }

    private function buildXmlBody() {
        $xml = '';

        if (is_array($this->fields)) {
            foreach ($this->fields as $data) {
                $xml .= $this->buildInputField($data);
            }
        }

        return $xml;
    }

    private function buildInputField($data) {

        // Name
        $name = $data->getName();

        // Attributes
        $attribute = '';
        if (!is_null($data->getAttributes())) {
            foreach ($data->getAttributes() as $att) {
                $attribute .= " {$att['name']}=\"{$att['value']}\"";
            }
        }

        // Value
        $value = '';
        if (is_array($data->getValues())) {
            foreach ($data->getValues() as $values) {
                $value .= $this->buildInputField($values);
            }
        } else {
            $value .= $data->getValues();
        }

        return "<{$name}{$attribute}>{$value}</{$name}>";
    }

}
