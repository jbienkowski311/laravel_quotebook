<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Author;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AuthorsController extends Controller
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
        $all_authors = Author::count();
        $authors = Author::skip($offset)->take($limit)->get();
        return response()->json([
            'status' => 200,
            'metadata' => [
                'count' => $all_authors,
                'offset' => $offset,
                'limit' => $limit
            ],
            'data' => $authors
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
            'name' => 'required|unique:authors',
            'country' => 'required',
            'date_of_birth' => 'required|date'
        ]);
        $author = new Author();
        $author->name = $request->input('name');
        $author->country = $request->input('country');
        $author->date_of_birth = $request->input('date_of_birth');
        $author->save();
        return response()->json([
            'status' => 200,
            'data' => $author
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
        $author = Author::find($id);
        if(!$author){
            return response()->json([
                'status' => 404,
                'message' => 'Author not found'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $author
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
        $author = Author::find($id);
        if(!$author){
            return response()->json([
                'status' => 404,
                'message' => 'Author not found'
            ], 404);
        }
        if($request->has('name')) $author->country = $request->input('name');
        if($request->has('country')) $author->country = $request->input('country');
        if($request->has('date_of_birth')) $author->date_of_birth = $request->input('date_of_birth');
        $author->update();
        return response()->json([
            'status' => 200,
            'data' => $author
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
        $author = Author::find($id);
        if(!$author){
            return response()->json([
                'status' => 404,
                'message' => 'Author not found'
            ], 404);
        }
        $author->quotes()->delete();
        $author->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Author and his quotes deleted'
        ]);
    }
}
