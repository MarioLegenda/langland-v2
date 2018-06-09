<?php

namespace App\Symfony\Resolver;

use Symfony\Component\HttpFoundation\Request;

trait ResolvableRequestValidator
{
    /**
     * @param Request $request
     * @return bool
     */
    public function getHttpData(Request $request): bool
    {
        $http = $request->request->get('http');

        if (is_null($http)) {
            $http = $request->query->get('http');

            if (is_null($http)) {
                $http = $request->get('http');
            }
        }

        if (is_null($http) or empty($http)) {
            return false;
        }

        return $http;
    }
}