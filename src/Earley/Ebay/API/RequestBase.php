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
use \InvalidArgumentException;

/**
 * Class RequestBase
 * Base class used by the Request Libraries
 * @package Earley\Ebay\API
 */
abstract class RequestBase {

	/**
	 * @var array $request_array
	 */
	private $request_array = array();

	/**
	 * @var string $request_xml_string
	 */
	private $request_xml_string = '';

	/**
	 * @var string $call_name
	 */
	protected $call_name = '';

	/**
	 * @var string $call_request_name
	 */
	private $call_request_name = '';

	/**
	 * @var array $headers
	 */
	protected $headers = array();

	/**
	 * @var string $endpoint
	 */
	protected $endpoint = '';
	
	/**
	 * Adds an element to the Request
	 *
	 * @param string $name XML Element Name
	 * @param string|array $value XML Element Value
	 * @throws InvalidArgumentException
	 */
	public function addElement($name,$value)
	{		
		if(empty($name) || !is_string($name)){
			throw new InvalidArgumentException("Element name is requires and must be a string.");	
		}
		
		if(empty($value)){
			throw new InvalidArgumentException("The value is required!");
		}
		
		$element = array($name => $value);
		$this->request_array = array_merge($this->request_array,$element);
	}

	/**
	 * Adds elements to the Request
	 * 
	 * @param $elements
	 * @throws InvalidArgumentException
	 */
	public function addElements($elements)
	{
		if(!is_array($elements)){
			throw new InvalidArgumentException("Argument must be an array.");
		}
		
		$this->request_array = array_merge($this->request_array,$elements);
	}

	/**
	 * Add the User Authentication Token to the Request
	 * 
	 * @param $user_token
	 * @throws InvalidArgumentException
	 */
	public function addUserToken($user_token){
		
		if(empty($user_token) || !is_string($user_token)){
			throw new InvalidArgumentException("The user token must be a string!");
		}
		
		$this->addElement('RequesterCredentials',array('eBayAuthToken' => $user_token));
	}

	/**
	 * Set the API Call Name
	 * 
	 * @param string $call_name
	 * @param  string $xmlns
	 * @throws InvalidArgumentException
	 */
	public function setCallName($call_name,$xmlns){
		
		if(empty($call_name)){
			throw new InvalidArgumentException("The call name is required.");
		}
		
		if(empty($xmlns)){
			throw new InvalidArgumentException("The xmlns is required.");
		}
		
		// Call Attributes
		$this->addElement('@attributes',array('xmlns' => $xmlns));
		
		// Call Name
		$this->call_name = $call_name;		
		
		// Call Request Name
		$this->call_request_name = sprintf("%sRequest",$call_name);		
	}

	/**
	 * Build request XMl from array
	 * @throws Exception
	 */
	private function buildXml()
	{
		$xmlDoc = Array2XML::createXML( $this->call_request_name, $this->request_array );
		$this->request_xml_string = $xmlDoc->saveXML();		
	}

	/**
	 * Send Request
	 * 
	 * @return Response
	 * @throws Exception
	 */
	public function send( ){		

		// Build the request
		$this->buildXml();

		// Set Content Length
		$this->headers['Content-Length'] = strlen($this->request_xml_string);

		// Setup Transport
		$transport = new Transport($this->endpoint,$this->headers);

		// Send
		$response = $transport->send($this->request_xml_string);

		// Return Result Set
		return new Response($response);
	}

	/**
	 * Output the Request XML
	 * @return string XML String that would be sent to Ebay
	 * @throws Exception
	 */
	public function getRequestXml(){

		$this->buildXml();

		return $this->request_xml_string;
	}
	
}