<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class InfoController extends Controller
{
    /**
     * Get the basic info for API.
     *
     * @return object
     */
    public function default() : object
    {
        return response()->json([
            'message' => (string) 'Test API',
            'version' => (float) 1,
        ], 200);
    }
}