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
 * Class Shopping
 * @package Earley\Ebay\API
 */
class Shopping extends RequestBase{

	/**
	 * Shopping constructor.
	 *
	 * @param string $call The Shopping Call that you will be performing
	 * @param  string $user_token A user token needed for some calls
	 * 
	 * @throws Exception
	 */
	public function __construct( $call, $user_token = null ) {

		// Config
		$config = Config::getConfig();

		// End Point
		$this->endpoint = $config['shopping']['endpoint'];

		// Call
		$this->setCallName($call,"urn:ebay:apis:eBLBaseComponents");

		// Headers
		$this->headers = array(
			'X-EBAY-API-APP-ID' => $config['keys']['AppID'],
			'X-EBAY-API-CALL-NAME' => $this->call_name,
			'X-EBAY-API-REQUEST-ENCODING' => 'XML',
			'X-EBAY-API-RESPONSE-ENCODING' => 'XML',
			'X-EBAY-API-SITE-ID' => $config['SiteID'],
			'X-EBAY-API-VERSION' => $config['SchemeVersion'],
		);

		// Affiliate Tracking Headers
		if($config['shopping']['affiliate_tracking'] == 'true'){
			$this->headers['X-EBAY-API-TRACKING-ID'] = $config['shopping']['affiliate']['tracking_id'];
			$this->headers['X-EBAY-API-TRACKING-PARTNER-CODE'] = $config['shopping']['affiliate']['partner_code'];
			$this->headers['X-EBAY-API-AFFILIATE-USER-ID'] = $config['shopping']['affiliate']['user_id'];
		}

		// User Token
		if(!is_null($user_token)){
			$this->addUserToken($user_token);
		}
	}
}