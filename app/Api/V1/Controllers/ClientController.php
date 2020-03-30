<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class ClientController extends Controller
{
    /**
     * @var
     */
    protected $user;

    /**
     * ClientController constructor.
     */
    // public function __construct()
    // {
    //     $this->user = JWTAuth::parseToken()->authenticate();
    // }

    /**
     * @return mixed
     */
    public function index()
    {
       
        $tasks = $this->user->tasks()->get(['title', 'description'])->all();
        // print_r($tasks);
        // exit;
        return $tasks;
    }

    public function show($id)
    {
        $task = $this->user->tasks()->find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, task with id ' . $id . ' cannot be found.'
            ], 400);
        }

        return $task;
    }

        /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //die('in this method');
       
        $this->validate($request, [
            'host' => 'required',
            'api_key' => 'required',
            'number' => 'required',
            'uuid' => 'required',
        ]);

        $client = new Client();
        $client->host = $request->host;
        $client->api_key = $request->api_key;
        $client->number = $request->number;
        $client->uuid = $request->uuid;
        
         
        if ($client->save())
        {
            return response()->json([
                'success' => true,
                'client' => $client
            ]);
        }   
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, client could not be added.'
            ], 500);
        }    
    }

      /**
     * @param $id
    * @return \Illuminate\Http\JsonResponse
    */
   public function update(Request $request, $id)
   {
       $task = $this->user->tasks()->find($id);
        // print_r($task);
        // exit;
       if (!$task) {
           return response()->json([
               'success' => false,
               'message' => 'Sorry, task with id ' . $id . ' cannot be found.'
           ], 400);
       }
   
       $updated = $task->fill($request->all())->save();
   
       if ($updated) {
           return response()->json([
               'success' => true
           ]);
       } else {
           return response()->json([
               'success' => false,
               'message' => 'Sorry, task could not be updated.'
           ], 500);
       }
   }

   /**
 * @param $id
 * @return \Illuminate\Http\JsonResponse
 */
    public function destroy($id)
    {
        $task = $this->user->tasks()->find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, task with id ' . $id . ' cannot be found.'
            ], 400);
        }

        if ($task->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Task could not be deleted.'
            ], 500);
        }
    }
}