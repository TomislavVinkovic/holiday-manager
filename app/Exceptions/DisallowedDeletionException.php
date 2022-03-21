<?php

namespace App\Exceptions;

use Exception;

class DisallowedDeletionException extends Exception {
    public function __construct(string $className,  $code = 0, Exception $previous = null) {
        $message = "This $className is not allowed to be removed";
        parent::__construct($message, $code);
        if (!is_null($previous)) {
            $this -> previous = $previous;
        }
    }
}
