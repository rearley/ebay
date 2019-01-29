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


return array(

    /**
     * Mode - The mode that the scrip will be running in.
     * This can be (dev,prod) as of now. The mode will load
     * a configuration file by the same name. For example if
     * the mode is set to 'dev' then the config file 'dev.php'
     * in the current directory will be used.
     */
    'mode' => 'dev',

    /**
     * Ebay Application Keys
     * You will need to sign up for Ebay's Developer Program and
     * generate these keys.
     */
    'keys' => array(
        'AppID' => '',
        'DevID' => '',
        'CertID' => ''
    ),

    /**
     * Ebay Scheme Version
     * See the developer guide for more information. This client library
     * was designed and tested with the defaulted scheme version.
     * @link http://developer.ebay.com/Devzone/XML/docs/HowTo/eBayWS/eBaySchemaVersioning.html
     */
    'SchemeVersion' => 963,

    /**
     * Ebay Site ID
     * See the Ebay Developer guide for more details on how the site ID effects
     * different API calls.
     * @link http://developer.ebay.com/Devzone/XML/docs/Reference/eBay/types/SiteCodeType.html
     */
    'SiteID' => 0,

    /**
     * Trading API Configuration Daata
     */
    'trading' => array(
        'endpoint' => 'https://api.sandbox.ebay.com/ws/api.dll', // Default is Sandbox
    ),

    /**
     * Finding API Configuration Data
     */
    'finding' => array(
        'endpoint' => 'http://svcs.sandbox.ebay.com/services/search/FindingService/v1', // Default is Sandbox
        'global_id' => 'EBAY-US',
        'service_version' => '1.13.0'
    ),

    /**
     * Shopping API Configuration Data
     */
    'shopping' => array(
        'endpoint' => 'http://open.api.sandbox.ebay.com/shopping?',
        'affiliate_tracking' => false,
        'affiliate' => array(
            'tracking_id' => '',
            'partner_code' => '',
            'user_id' => ''
        ),
    ),
);
