<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Task::paginate(3);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $task = Task::where('name', 'like', $request->name)->get();
    if (!$task->isEmpty()) return Response(['message' => 'Already exists'], 400);
    $request->validate([
      'name' => 'required',
      'day' => 'required',
      'reminder' => 'required',
    ]);

    return Task::create($request->all());
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return Task::find($id);
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
    $task = Task::find($id);
    $task->update($request->all());
    return $task;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $task = Task::find($id);
    if(!$task) return Response(['message' => 'Cannot find task with id ' . $id], 404);

    Task::destroy($id);
    return [
      'message' => 'Task deleted successfully!',
      'data' => [
        'id' => $task->id,
        'name' => $task->name
      ],
    ];
  }

  /**
   * Search for a name.
   *
   * @param  string  $name
   * @return \Illuminate\Http\Response
   */
  public function search($name)
  {
      return Task::where('name', 'like', '%'.$name.'%')->get();
  }
}
