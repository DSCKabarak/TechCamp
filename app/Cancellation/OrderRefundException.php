<?php namespace App\Cancellation;

use Symfony\Component\HttpFoundation\Response;
use Exception;

class OrderRefundException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}