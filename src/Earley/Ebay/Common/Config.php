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

use \Exception;
use \InvalidArgumentException;

/**
 * Class Config
 * @package Earley\Ebay\Common
 */
class Config
{
    /**
     * Get Configuration Options
     * @param string|null $key A specific configuration key
     *
     * @return array|mixed Array for the configuration options
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public static function getConfig($key = null)
    {
        // Get Main Configuration File
        if (!file_exists(__DIR__ . '/../config/all.php')) {
            throw new Exception("Main configuration file not found.");
        } else {
            $config = require(__DIR__ . '/../config/all.php');
        }

        // Get Environment Configuration File
        $env_config_file = sprintf('%s/../config/%s.php', __DIR__, $config['mode']);
        if (file_exists($env_config_file)) {
            $env_config = require($env_config_file);
            $config = array_replace_recursive($config, $env_config);
        }

        // Return just the key selected
        if (!is_null($key)) {
            if (!isset($config[$key])) {
                throw new InvalidArgumentException("Configuration key does not exist");
            }

            return $config[$key];
        }

        return $config;
    }
}