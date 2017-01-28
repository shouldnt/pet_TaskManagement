<?php

namespace App\Http\Controllers;
use App\Task;
use DB;
//use Request;
use Illuminate\Http\Request;

class TasksController extends Controller
{
public function index()
    {
    	//$tasks = Task::all()->orderBy('updated_at', 'desc')->get();
    	return view('tasks.index', compact('tasks'));
    }

    public function tasks()
    {
    	return Task::orderBy('updated_at', 'desc')->get();
    }

    public function store(Request $request)
    {
    	//return json_encode(['done' => $request]);
    	$validation = $this->validate($request, [
    			'body' => 'required'
    		]);
    	$task = new Task;
    	$task->body = $request->body ;
    	$task->save();
    	return $task;
    }
    public function update(Request $request)
    {
    	$tasks = Task::find($request->tasks);
    	foreach($tasks as $task)
    	{
    		$task->completed = $task->completed == 1 ? 0 : 1;
    		$task->save();
    	}
    	return "success";
    }
}

