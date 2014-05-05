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

class Field {

    private $name;
    private $attributes;
    private $values;

    function __construct($name = null, $values = null) {
        $this->name = $name;
        $this->values = $values;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    public function setAttribute($name,$value) {        
        $this->attributes[] = array(
            'name' => $name,
            'value' => $value
        );
        return $this;
    }

    public function setValue($values) {
        $this->values[] = $values;
        return $this;
    }
    
    public function getName() {
        return $this->name;
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function getValues() {
        return $this->values;
    }
}