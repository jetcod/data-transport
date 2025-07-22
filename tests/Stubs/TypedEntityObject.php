<?php

namespace Jetcod\DataTransport\Test\Stubs;

use Jetcod\DataTransport\AbstractDTO;
use Jetcod\DataTransport\Contracts\TypedEntity;

class TypedEntityObject extends AbstractDTO implements TypedEntity
{
    private array $_schema = [];

    public function setSchema(array $schema)
    {
        $this->_schema = $schema;
    }

    public function getSchema(): array
    {
        return $this->_schema;
    }
}