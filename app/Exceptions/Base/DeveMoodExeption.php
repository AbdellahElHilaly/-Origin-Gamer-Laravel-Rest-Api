<?php

namespace App\Exceptions\Base;

use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Database\Eloquent\RelationNotFoundException;

trait DeveMoodExeption
{
    private function handleException(\Exception $e)
    {
        switch (true) {
            case $e instanceof ModelNotFoundException:
                $modelName = strtolower(class_basename($e->getModel()));
                return $this->apiResponse(null, false, 'Database ERROR : this '.$modelName.' not found!   /// '. $e->getMessage() , Response::HTTP_NOT_FOUND);
            case $e instanceof RelationNotFoundException:
                return $this->apiResponse(null, false, 'The requested resource was not found :  '. $e->getMessage(), Response::HTTP_NOT_FOUND);
            case $e instanceof InvalidCastException:
                return $this->apiResponse(null, false, 'The requested resource was not found :  '. $e->getMessage(), Response::HTTP_NOT_FOUND);
            case $e instanceof JsonEncodingException:
                return $this->apiResponse(null, false, 'The requested resource was not found :  '. $e->getMessage(), Response::HTTP_NOT_FOUND);
            case $e instanceof HttpResponseException:
                return $this->apiResponse(null, false, 'The requested resource was not found :  '. $e->getMessage(), Response::HTTP_NOT_FOUND);
            case $e instanceof PostTooLargeException:
                return $this->apiResponse(null, false, 'The requested resource was not found :  '. $e->getMessage(), Response::HTTP_NOT_FOUND);
            case $e instanceof ThrottleRequestsException:
                return $this->apiResponse(null, false, 'The requested resource was not found :  '. $e->getMessage(), Response::HTTP_NOT_FOUND);
            case $e instanceof TokenMismatchException:
                return $this->apiResponse(null, false, 'The requested resource was not found :  '. $e->getMessage(), Response::HTTP_NOT_FOUND);
            case $e instanceof RequestException:
                return $this->apiResponse(null, false, 'The requested resource was not found :  '. $e->getMessage(), Response::HTTP_NOT_FOUND);
            case $e instanceof ConnectionException:
                return $this->apiResponse(null, false, 'The requested resource was not found :  '. $e->getMessage(), Response::HTTP_NOT_FOUND);
            case $e instanceof QueryException:
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    preg_match('/Duplicate entry \'(.*?)\' for key \'(.*?)\'/', $e->getMessage(), $matches);
                    return $this->apiResponse(null, false, 'The requested resource was not found :  [ '. $matches[1] . ' ] is already taken', Response::HTTP_NOT_FOUND);
                } else {
                    return $this->apiResponse(null, false, 'The requested resource was not found :  '. $e->getMessage(), Response::HTTP_NOT_FOUND);
                }
            case $e instanceof AuthenticationException:
                return $this->apiResponse(null, false, 'Unauthenticated :  '. $e->getMessage(), Response::HTTP_UNAUTHORIZED);
            case $e instanceof AuthorizationException:
                return $this->apiResponse(null, false, 'You are not authorized to perform this action :  '. $e->getMessage(), Response::HTTP_FORBIDDEN);
            case $e instanceof UnauthorizedException:
                return $this->apiResponse(null, false, 'You are not authorized to perform this action :  '. $e->getMessage(), Response::HTTP_FORBIDDEN);
            case $e instanceof RelationNotFoundException:
                return $this->apiResponse(null, false, 'The requested relation was not found :  '. $e->getMessage(), Response::HTTP_NOT_FOUND);
            case $e instanceof InvalidCastException:
                return $this->apiResponse(null, false, 'An invalid cast occurred :  '. $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            case $e instanceof JsonEncodingException:
                return $this->apiResponse(null, false, 'An error occurred while encoding the JSON data :  '. $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            case $e instanceof RequestException:
                return $this->apiResponse(null, false, 'An error occurred while sending the request :  '. $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            case $e instanceof ConnectionException:
                return $this->apiResponse(null, false, 'An error occurred while processing the request :  '. $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            case $e instanceof ThrottleRequestsException:
                return $this->apiResponse(null, false, 'Too many requests :  '. $e->getMessage(), Response::HTTP_TOO_MANY_REQUESTS);
            case $e instanceof TokenMismatchException:
                return $this->apiResponse(null, false, 'The provided CSRF token is invalid :  '. $e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
            case $e instanceof HttpResponseException:
                return $this->apiResponse(null, false, 'An HTTP response exception occurred :  '. $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            case $e instanceof PostTooLargeException:
                return $this->apiResponse(null, false, 'The uploaded file is too large :  '. $e->getMessage(), Response::HTTP_REQUEST_ENTITY_TOO_LARGE);
            case $e instanceof \Exception && strpos($e->getMessage(), 'SYSTEM_CLIENT_ERROR') === 0 :
                return $this->apiResponse(null, false, $e->getMessage() , Response::HTTP_UNAUTHORIZED);
            default:
                return $this->apiResponse(null, false, 'An unexpected error occurred :  '. $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
