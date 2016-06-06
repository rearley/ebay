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


class Trading extends Base{

	/**
	 * Trading constructor.
	 *
	 * @param string $call The Trading Call that you will be performing
	 * @param  string $user_token A user token needed for some calls
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

		$this->endpoint = $this->config['trading']['endpoint'];
		
		// Call
		$this->setCall($call);
		
		// User Token
		$this->user_token = $user_token;

		// Headers
		$this->headers = $this->get_headers();
		
		// XML Namespace
		$this->xmlns = 'urn:ebay:apis:eBLBaseComponents';
		
	}

	/**
	 * Sets up the headers needed for the Trading API.
	 * @return array
	 */
	private function get_headers()
	{
		$headers = array(
			'X-EBAY-API-COMPATIBILITY-LEVEL' => $this->config['SchemeVersion'],
			'X-EBAY-API-DEV-NAME' => $this->config['keys']['DevID'],
			'X-EBAY-API-APP-NAME' => $this->config['keys']['AppID'],
			'X-EBAY-API-CERT-NAME' => $this->config['keys']['CertID'],
			'X-EBAY-API-CALL-NAME' => $this->callName,
			'X-EBAY-API-SITEID' => $this->config['SiteID'],
			'Content-Type' => 'text/xml',
		);

		return $headers;
	}
}