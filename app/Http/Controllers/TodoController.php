<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTodoRequest;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * @var User $user
         */
        $user = auth()->user();


        return view('todos.index', [
            'todos' => $user->todos()->get() ?? []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('todos.create');
    }

    public function done(Todo $todo)
    {
        // dd($todo->toArray());

        $todo->fill(['completed_at' => now()])->save();

        return to_route('todos.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTodoRequest $request)
    {
        /**
         * @var User $user
         */
        $user = auth()->user();

        $user->todos()->create($request->validated());

        return to_route('todos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return to_route('todos.index');
    }
}
