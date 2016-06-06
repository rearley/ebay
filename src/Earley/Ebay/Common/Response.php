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

/**
 * Class Response
 * @package Earley\Ebay\Common
 */
class Response {

	/**
	 * @var \GuzzleHttp\Psr7\Response $response
	 */
	private $response;

	/**
	 * Response constructor.
	 *
	 * @param \GuzzleHttp\Psr7\Response $response
	 */
	public function __construct( \GuzzleHttp\Psr7\Response $response)
	{
		$this->response = $response;
	}

	/**
	 * Get Body in XML format
	 * @return string
	 */
	public function toString(){
		return $this->response->getBody()->getContents();
	}

	/**
	 * Get Response Body in Array
	 * @return array|boolean
	 */
	public function toArray(){

		$body = $this->response->getBody()->getContents();

		if(!empty($body)) {
			return json_decode( json_encode( (array) simplexml_load_string( $body ) ), 1 );
		} else {
			return false;
		}
	}

	/**
	 * Get Response Headers
	 * @return array
	 */
	public function getHeaders(){
		return $this->response->getHeaders();
	}

	/**
	 * Get HTTP Status Code
	 * @return int
	 */
	public function getStatusCode(){
		return $this->response->getStatusCode();
	}

	/**
	 * Get HTTP Status Phrase
	 * @return null|string
	 */
	public function getReasonPhrase(){
		return $this->response->getReasonPhrase();
	}
}