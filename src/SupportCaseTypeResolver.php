<?php

namespace Inventas\ContactSupport;

use Exception;

class SupportCaseTypeResolver
{
    /**
     * @throws Exception
     */
    public static function type(string $type)
    {

        $types = config('contact-support.support_case_types');

        if (! array_key_exists($type, $types)) {
            throw new Exception('Invalid support case type');
        }

        return $types[$type];
    }
}
