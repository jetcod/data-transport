<?php

namespace Jetcod\DataTransport\Test\Stubs;

use Jetcod\DataTransport\AbstractDTO;
use Jetcod\DataTransport\Contracts\TypedEntity;
use Jetcod\DataTransport\Traits\HasValidator;

class TypedEntityObject extends AbstractDTO implements TypedEntity
{
    use HasValidator;
    
    private array $_schema = [];

    private bool $_strict = true;

    public function isStrict(): bool
    {
        return $this->_strict;
    }

    public function setSchema(array $schema)
    {
        $this->_schema = $schema;
    }

    public function getSchema(): array
    {
        return $this->_schema;
    }
}