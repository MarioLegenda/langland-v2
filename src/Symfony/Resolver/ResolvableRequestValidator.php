<?php

namespace App\Symfony\Resolver;

use Symfony\Component\HttpFoundation\Request;

trait ResolvableRequestValidator
{
    /**
     * @param Request $request
     * @return bool|array
     */
    public function getHttpData(Request $request)
    {
        $http = $request->request->get('http');

        if (is_null($http)) {
            $http = $request->query->get('http');

            if (is_null($http)) {
                $http = $request->get('http');
            }
        }

        if (is_null($http) or empty($http)) {
            return null;
        }

        return $http;
    }
}