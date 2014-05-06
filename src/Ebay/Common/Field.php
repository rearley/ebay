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

namespace Ebay\Common;

/**
 * Field Object
 * @package Ebay
 * @author Rick Earley <rick@earleyholdings.com>
 * @copyright (c) 2014
 * @version 1.0
 */
class Field {

    /**
     * Field Name
     * @var string
     */
    private $name;
    
    /**
     * Field attributes
     * @var array
     */
    private $attributes;
    
    /**
     * Field Value
     * @var mixed Could be other field objects
     */
    private $values;

    /**
     * Create Field Object
     * @param string $name
     * @param mixed $values
     */
    function __construct($name = null, $values = null) {
        $this->name = $name;
        $this->values = $values;
    }

    /**
     * Set the field name
     * @param string $name
     * @return \Ebay\Common\Field
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Set the field attribute
     * @param string $name
     * @param string $value
     * @return \Ebay\Common\Field
     */
    public function setAttribute($name,$value) {        
        $this->attributes[] = array(
            'name' => $name,
            'value' => $value
        );
        return $this;
    }

    /**
     * Set the field value
     * @param mixed $values
     * @return \Ebay\Common\Field
     */
    public function setValue($values) {
        $this->values[] = $values;
        return $this;
    }
    
    /**
     * Get the field name
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get the field attributes
     * @return array
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * Get the field values
     * @return mixed
     */
    public function getValues() {
        return $this->values;
    }
}