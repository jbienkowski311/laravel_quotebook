<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\User;
use App\Quote;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersQuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user = User::find($user_id);
        if(!$user){
            return response()->json([
                'status' => 404,
                'message' => 'User not found'
            ], 404);
        }
        $quotes = $user->quotes;
        return response()->json([
            'status' => 200,
            'metadata' => [
                'count' => count($quotes)
            ],
            'data' => $quotes
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id, $quote_id)
    {
        $user = User::find($user_id);
        if(!$user){
            return response()->json([
                'status' => 404,
                'message' => 'Author not found'
            ], 404);
        }
        $quote = $user->quotes()->where('id', $quote_id)->first();
        if(!$quote){
            return response()->json([
                'status' => 404,
                'message' => 'Quote not found'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $quote
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $quote_id)
    {
        $user = User::find($user_id);
        if(!$user){
            return response()->json([
                'status' => 404,
                'message' => 'User not found'
            ], 404);
        }
        $quote = $user->quotes();
        if(!$quote->where('id', $quote_id)->first()){
            return response()->json([
                'status' => 404,
                'message' => 'Quote not found'
            ], 404);
        }
        $quote->detach($quote_id);
        return response()->json([
        'status' => 200,
        'message' => 'User like deleted'
    ]);
    }
}
