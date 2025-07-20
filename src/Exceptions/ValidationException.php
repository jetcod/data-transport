<?php

namespace Jetcod\DataTransport\Exceptions;

class ValidationException extends \Exception
{
    protected array $messages = [];

    public function __construct(array|string $messages, int $code = 0, ?\Exception $previous = null)
    {
        $messages = is_array($messages) ? $messages : [$messages];
        $message  = implode("\n", $messages);

        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the array of validation messages.
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
