<?php

namespace App\Http\Controllers\Api;

use App\Author;
use App\Quote;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AuthorsQuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $author_id
     * @return \Illuminate\Http\Response
     */
    public function index($author_id)
    {
        $author = Author::find($author_id);
        if(!$author){
            return response()->json([
                'status' => 404,
                'message' => 'Author not found'
            ], 404);
        }
        $quotes = $author->quotes;
        return response()->json([
            'status' => 200,
            'metadata' => [
                'count' => count($quotes)
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
    public function store(Request $request, $author_id)
    {
        $author = Author::find($author_id);
        if(!$author){
            return response()->json([
                'status' => 404,
                'message' => 'Author not found'
            ], 404);
        }
        $this->validate($request, [
            'text' => 'required'
        ]);
        $quote = new Quote();
        $quote->author_id = $author->id;
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
    public function show($author_id, $quote_id)
    {
        $author = Author::find($author_id);
        if(!$author){
            return response()->json([
                'status' => 404,
                'message' => 'Author not found'
            ], 404);
        }
        $quote = $author->quotes()->where('id', $quote_id)->first();
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
    public function update(Request $request, $author_id, $quote_id)
    {
        $author = Author::find($author_id);
        if(!$author){
            return response()->json([
                'status' => 404,
                'message' => 'Author not found'
            ], 404);
        }
        $quote = $author->quotes()->where('id', $quote_id)->first();
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
    public function destroy($author_id, $quote_id)
    {
        $author = Author::find($author_id);
        if(!$author){
            return response()->json([
                'status' => 404,
                'message' => 'Author not found'
            ], 404);
        }
        $quote = $author->quotes()->where('id', $quote_id)->first();
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
