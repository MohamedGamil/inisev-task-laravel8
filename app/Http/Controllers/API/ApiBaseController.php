<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     host="",
 *     basePath="/api/v1",
 *     @SWG\SecurityScheme(
 *         securityDefinition="Bearer",
 *         type="apiKey",
 *         name="Authorization",
 *         in="header",
 *         description = "Authentication format: 'Bearer {AUTH-TOKEN}'",
 *     ),
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="SubDemoPlatform API documentation",
 *         description="SubDemoPlatform API-v1 endpoints documentation and testing interface.",
 *         termsOfService="",
 *         @SWG\Contact(
 *             email="gemy.dev@gmail.com"
 *         ),
 *         @SWG\License(
 *             name="Private License",
 *             url="#"
 *         )
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="DevOps Documentation",
 *         url="https://github.com/MohamedGamil"
 *     )
 * )
 */
class ApiBaseController extends Controller
{
    /**
     * Send API Response in JSON format.
     *
     * @param mixed $result
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    protected function sendResponse($result, $message = 'Request Complete')
    {
        return Response::json(static::makeResponse($message, $result));
    }

    /**
     * Send Error API Response in JSON format.
     *
     * @param mixed $result
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    protected function sendError($error = 'Error!', $code = 404)
    {
        return Response::json(static::makeError($error), $code);
    }

    /**
     * Send Successful API Response in JSON format.
     *
     * @param mixed $result
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    protected function sendSuccess($message = 'OK')
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    protected static function makeResponse($message, $data)
    {
        return [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    protected static function makeError($message, array $data = [])
    {
        return [
            'success' => false,
            'data' => $data,
            'message' => $message,
        ];
    }
}
