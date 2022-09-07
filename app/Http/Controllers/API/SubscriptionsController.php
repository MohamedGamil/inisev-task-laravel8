<?php

namespace App\Http\Controllers\API;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionsController extends ApiBaseController
{
    /**
     * @return \Illuminate\Http\Response
     *
     * @SWG\Post(
     *      path="/subscribe",
     *      summary="Subscribe to a website.",
     *      tags={"post"},
     *      description="Ssubscribe to a website using given email address and website ID.",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="email",
     *          description="Email address",
     *          in="formData",
     *          required=true,
     *          type="string",
     *          format="varchar"
     *      ),
     *      @SWG\Parameter(
     *          name="website_id",
     *          description="Website ID of new subscription",
     *          in="formData",
     *          required=true,
     *          type="number",
     *          format="integer"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @SWG\Response(
     *          response=400,
     *          description="Bad Request"
     *       ),
     *      @SWG\Response(
     *          response=404,
     *          description="Resources Not Found"
     *       ),
     *     )
     */
    public function subscribe(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'website_id' => 'required|exists:App\Models\Website,id',
        ];

        $this->validate($request, $rules);

        $keys = array_keys($rules);
        $inputs = collect($request->input())
            ->only($keys)
            ->toArray();

        $inputs['start_date'] = now();

        $subscription = new Subscription($inputs);

        if (false === $subscription->save()) {
            return $this->sendError('Unable to create subscription');
        }

        \Log::debug("User subscriped.");

        return $this->sendResponse([
            'subscription' => $subscription,
        ]);
    }
}
