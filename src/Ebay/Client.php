<?php

/*
 * Copyright (C) 2014 rick
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

namespace Ebay;

class Client {

    private $applicationId;
    private $debugMode = false;

    /**
     * Ebay Client Library
     * @param string $applicationId This is the application ID (AppID) for the service consumer. You obtain an AppID by joining the eBay Developers Program.
     * @param boolean $debugMode Sets application in debug for logging purposes and sandboxing.
     * @throws \InvalidArgumentException
     */
    function __construct($applicationId, $debugMode = false) {
        $this->applicationId = $applicationId;
        $this->debugMode = $debugMode;
    }

    /**
     * Write Debug Information
     * @param string $from Method or action that is cuasing message
     * @param string $message The message to write
     * @param mixed $extra Could be string or array of information to print out.
     */
    public static function writeDebug($from, $message, $extra = array()) {

        if ($this->debugMode) {
            // Check for exisiting log file
            if (!file_exists(__DIR__ . '/Logs/debug.log')) {
                mkdir(__DIR__ . '/Logs', 0777);
                file_put_contents(__DIR__ . '/Logs/debug.log', '');
            }

            // Initialize Logger
            $logger = new \Monolog\Logger($from);
            $logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/Logs/debug.log', \Monolog\Logger::DEBUG));

            $logger->addDebug($message, $extra);
        }
    }

    /**
     * Get an Ebay service object.
     * @param string $serviceName
     * @return \Ebay\Service\ Service Object
     * @throws \Exception
     */
    public function getService($serviceName) {

        $service = "\\Ebay\Service\\{$serviceName}";

        if (class_exists($service)) {
            return new $service($this->applicationId,$this->debugMode);
        } else {
            throw new \Exception("The service {$service} does not exisit.");
        }
    }

}