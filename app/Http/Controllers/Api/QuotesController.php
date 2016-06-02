<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Quote;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset = $request->has('offset') ? $request->input('offset') : 0;
        $limit = $request->has('limit') ? $request->input('limit') : 25;
        $all_quotes = Quote::count();
        $quotes = Quote::skip($offset)->take($limit)->get();
        return response()->json([
            'status' => 200,
            'metadata' => [
                'count' => $all_quotes,
                'offset' => $offset,
                'limit' => $limit
            ],
            'data' => $quotes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'author_id' => 'required|integer|exists:authors,id',
            'text' => 'required'
        ]);
        $quote = new Quote();
        $quote->author_id = $request->input('author_id');
        $quote->text = $request->input('text');
        $quote->save();
        return response()->json([
            'status' => 200,
            'data' => $quote
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quote = Quote::find($id);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $quote = Quote::find($id);
        if(!$quote){
            return response()->json([
                'status' => 404,
                'message' => 'Quote not found'
            ], 404);
        }
        if($request->has('author_id')) $quote->author_id = $request->input('author_id');
        if($request->has('text')) $quote->text = $request->input('text');
        $quote->update();
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
    public function destroy($id)
    {
        $quote = Quote::find($id);
        if(!$quote){
            return response()->json([
                'status' => 404,
                'message' => 'Quote not found'
            ], 404);
        }
        $quote->users()->detach();
        $quote->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Quote and its user likes deleted'
        ]);
    }
}
