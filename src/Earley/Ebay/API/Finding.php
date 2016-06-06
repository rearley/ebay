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

use Earley\Ebay\Common\Config;
use \Exception;

/**
 * Class Finding
 * @package Earley\Ebay\API
 */
class Finding extends Base{

	/**
	 * Finding constructor.
	 *
	 * @param string $call Finding Call
	 * @param string|null $user_token
	 * 
	 * @throws Exception
	 */
	public function __construct( $call, $user_token = null ) {

		// Config
		try {
			$this->config = Config::getConfig();
		} catch (Exception $e){
			throw $e;
		}

		$this->endpoint = $this->config['finding']['endpoint'];

		// Call
		$this->setCall($call);

		// User Token
		$this->user_token = $user_token;

		// Headers
		$this->headers = $this->get_headers();
		
		// XML Namespace
		$this->xmlns = 'http://www.ebay.com/marketplace/search/v1/services';

	}

	/**
	 * Sets up the headers needed for the Finding API.
	 * @return array
	 */
	private function get_headers()
	{
		
		$headers = array(
			'X-EBAY-SOA-SERVICE-NAME' => 'FindingService',
			'X-EBAY-SOA-REQUEST-DATA-FORMAT' => 'XML',
			'X-EBAY-SOA-RESPONSE-DATA-FORMAT' => 'XML',
			'X-EBAY-SOA-SECURITY-APPNAME' => $this->config['keys']['AppID'],
			'X-EBAY-SOA-OPERATION-NAME' => $this->callName,
			'X-EBAY-SOA-SERVICE-VERSION' => $this->config['finding']['service_version'],
			'X-EBAY-SOA-GLOBAL-ID' => $this->config['finding']['global_id']
		);

		return $headers;
	}
}