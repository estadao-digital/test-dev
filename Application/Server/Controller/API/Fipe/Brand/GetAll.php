<?php

namespace Application\Server\Controller\API\Fipe\Brand
{
    use Application\Server\Component;

    class GetAll extends \Controller
    {
        public static function onRequest($input)
        {
            // Check method
            if (\Connection::getRequestMethod() !== 'get')
                return self::error('INVALID_METHOD', ['message' => 'Only GET method available.']);

            return self::success(['brands' => Component\Fipe::getBrands()]);
        }
    }
}