<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        try {
            $next();
        } catch (ValidationException $e) {
            $oldFormData = $_POST;
            $excluded_fields = ['password', 'confirmPassword'];
            $formattedFormData = array_diff_key(
                $oldFormData,
                array_flip($excluded_fields)
            );

            $_SESSION['errors'] = $e->errors;
            $_SESSION['oldFormData'] = $formattedFormData;

            $referer = $_SERVER['HTTP_REFERER'];
            redirectTo($referer);
        }
    }
}
