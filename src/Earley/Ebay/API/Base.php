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

namespace Earley\Ebay\API;

use Earley\Ebay\Common\Array2XML;
use Earley\Ebay\Common\Response;
use Earley\Ebay\Common\Transport;
use \Exception;

/**
 * Class Base
 * @package Earley\Ebay\API
 */
class Base {

	/**
	 * @var string $call API Call that is being made
	 */
	protected $call;

	/**
	 * @var string $callName Canonical name of the call
	 */
	protected $callName;

	/**
	 * @var string $xml Request XML
	 */
	protected $xml;

	/**
	 * @var array $raw_call Array containing the call elements
	 */
	protected $raw_call = array();

	/**
	 * @var array $headers Required Headers for the call
	 */
	protected $headers = array();
	
	/**
	 * @var array $config System Configuration Options
	 */
	protected $config = array();

	/**
	 * @var string $endpoint The API Endpoint used to send the request to
	 */
	protected $endpoint;

	/**
	 * @var string $user_token Needed to authenticate some calls
	 */
	protected $user_token = null;

	/**
	 * @var string $xmlns XML namespace
	 */
	protected $xmlns = '';


	/**
	 * Set the API call for the selected API
	 * @param string $call
	 */
	protected function setCall($call)
	{
		$this->callName = $call;
		$this->call = sprintf("%sRequest",$this->callName);
	}

	/**
	 * Adds elements that will compose the Request XML. Uses the Array2XML Library.
	 * 
	 * @param string|array $parts Can be a single value or an array of values
	 * @param bool $element
	 * @link http://www.lalit.org/lab/convert-php-array-to-xml-with-attributes/
	 */
	public function addElement($parts,$element = false)
	{
		if($element){
			$this->raw_call[$element] = $parts;
		} else {
			$this->raw_call = array_merge($this->raw_call,$parts);
		}
	}

	/**
	 * Builds the final XML for the API call
	 * @throws Exception
	 */
	private function buildXml()
	{
		// Call
		if(!empty($this->call)){
			$this->raw_call['@attributes'] =  
				array(
					'xmlns' => $this->xmlns
				);
		}

		// User Authentication
		if(!is_null($this->user_token)){
			$this->raw_call['RequesterCredentials'] = array(
				'eBayAuthToken' => $this->user_token
			);
		}

		// Build XML
		try {
			$xmlDoc    = Array2XML::createXML( $this->call, $this->raw_call );
			$this->xml = $xmlDoc->saveXML();
		} catch (Exception $e){
			throw $e;
		}

		// Set Content Length
		$this->headers['Content-Length'] = strlen($this->xml);
	}

	/**
	 * Sends the Request
	 * @return Response
	 */
	public function send( ){
		
		// Build the request
		$this->buildXml();
		
		// Setup Transport
		$transport = new Transport($this->endpoint,$this->headers);
		
		// Send
		$response = $transport->send($this->xml);
		
		// Return Result Set
		return new Response($response);
	}

}