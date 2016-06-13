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
use \InvalidArgumentException;

/**
 * Class Trading
 * @package Earley\Ebay\API
 */
class Trading extends RequestBase{

	/**
	 * Trading constructor.
	 *
	 * @param string $call The Trading Call that you will be performing
	 * @param  string $user_token A user token needed for some calls
	 *
	 * @throws Exception
	 * @throws InvalidArgumentException
	 */
	public function __construct( $call, $user_token = null ) {
		
		// Config
		$config = Config::getConfig();

		// EndPoint
		$this->endpoint = $config['trading']['endpoint'];

		// Call Name
		$this->setCallName($call,"urn:ebay:apis:eBLBaseComponents");

		// Setup Headers
		$this->headers = array(
			'X-EBAY-API-COMPATIBILITY-LEVEL' => $config['SchemeVersion'],
			'X-EBAY-API-DEV-NAME' => $config['keys']['DevID'],
			'X-EBAY-API-APP-NAME' => $config['keys']['AppID'],
			'X-EBAY-API-CERT-NAME' => $config['keys']['CertID'],
			'X-EBAY-API-CALL-NAME' => $this->call_name,
			'X-EBAY-API-SITEID' => $config['SiteID'],
			'Content-Type' => 'text/xml',
		);

		// User Token
		if(!is_null($user_token)){
			$this->addUserToken($user_token);
		}
	}
}