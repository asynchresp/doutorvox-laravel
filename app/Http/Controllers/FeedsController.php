<?php

namespace App\Http\Controllers;

use App\Feed;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FeedsController extends Controller
{

    private $feed;

    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $statusCode = 200;
            $response = [
                'feeds'  => []
            ];

            $feeds = $this->feed->orderBy('id','desc')->get();

            foreach($feeds as $feed){

                $response['feeds'][] = [
                    'id' => (int) $feed->id,
                    'url' => $feed->url,
                    'nome' => $feed->nome,
                    'status' => $feed->status,
                    'noticias' => $feed->noticias
                ];
            }

        }catch (Exception $e){
            $statusCode = 400;
        }finally{
            return response()->json($response, $statusCode);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            return  response()->json(array('success' => true,'feed' => $this->feed->create($request->all())->toArray()), 200);
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $feed = $this->feed->find($id);
            $statusCode = 200;
            $response = [ "feed" => [
                'id' => (int) $id,
                'url' => $feed->url,
                'nome' => $feed->nome,
                'status' => $feed->status,
                'noticias' => $feed->noticias
            ]];

        }catch(Exception $e){
            $response = [
                "error" => "data doesn`t exists"
            ];
            $statusCode = 400;
        }finally{
            return  response()->json($response, $statusCode);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try{
            $this->feed->find($id)->update($request->all());
            return  response()->json(array('success' => true, 'feed' => $this->feed->find($id)->toArray()), 200);
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $this->feed->find($id)->delete();
            return  response()->json(array('success' => true), 200);
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }
    }
}
