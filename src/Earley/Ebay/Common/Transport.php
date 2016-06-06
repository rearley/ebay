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

use \GuzzleHttp\Client;

/**
 * Class Transport
 * @package Earley\Ebay\Common
 */
class Transport {

	/**
	 * @var array $headers
	 */
	private $headers;

	/**
	 * @var array $endpoint
	 */
	private $endpoint = array();

	/**
	 * @var \GuzzleHttp\Client $client
	 */
	private $client;

	/**
	 * Transport constructor.
	 *
	 * @param $endpoint
	 * @param $headers
	 */
	public function __construct($endpoint,$headers)
	{
		$this->headers = $headers;
		$this->endpoint = $endpoint;

		// Setup Guzzle
		$this->client = new Client();
	}

	/**
	 * @param string $body The Request Body
	 *
	 * @return mixed|\Psr\Http\Message\ResponseInterface
	 */
	public function send($body){

		$response = $this->client->request( 'POST', $this->endpoint, [
			'body'    => $body,
			'headers' => $this->headers,
			'verify'  => false,
			'http_errors' => false
		] );

		return $response;
	}
}