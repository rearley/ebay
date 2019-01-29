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
class Finding extends RequestBase
{

    /**
     * Finding constructor.
     *
     * @param string $call Finding Call
     * @param string|null $user_token
     *
     * @throws Exception
     */
    public function __construct($call, $user_token = null)
    {

        // Config
        $config = Config::getConfig();

        // End Point
        $this->endpoint = $config['finding']['endpoint'];

        // Call
        $this->setCallName($call, 'http://www.ebay.com/marketplace/search/v1/services');

        // Headers
        $this->headers = array(
            'X-EBAY-SOA-SERVICE-NAME' => 'FindingService',
            'X-EBAY-SOA-REQUEST-DATA-FORMAT' => 'XML',
            'X-EBAY-SOA-RESPONSE-DATA-FORMAT' => 'XML',
            'X-EBAY-SOA-SECURITY-APPNAME' => $config['keys']['AppID'],
            'X-EBAY-SOA-OPERATION-NAME' => $this->call_name,
            'X-EBAY-SOA-SERVICE-VERSION' => $config['finding']['service_version'],
            'X-EBAY-SOA-GLOBAL-ID' => $config['finding']['global_id']
        );

        // User Token
        if (!is_null($user_token)) {
            $this->addUserToken($user_token);
        }
    }
}