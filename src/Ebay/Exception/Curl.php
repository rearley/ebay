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

namespace Ebay\Exception;

/**
 * Curl Exception
 * @package Ebay
 * @author Rick Earley <rick@earleyholdings.com>
 * @copyright (c) 2014
 * @version 1.0
 * @access public
 */
class Curl extends \Exception {


    /**
     * New Curl Exception
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * toString for Curl Exception
     * @return string
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}