<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Task;
use App\Policies\TaskPolicy;
use Core\Render;
use Core\Request;
use Core\Validation;
use Libs\Auth;

final class Task_Controller
{
    public static function index(): void
    {
        $filters = Request::parameters();

        $tasks = Task::where('user_id', '=', Auth::user()->id)
            ->orderby('complete', 'DESC');
        if (isset($filters['description'])) {
            $tasks = $tasks->like('description', $filters['description'])
                ->all();
        } else {
            $tasks = $tasks->all();
        }

        Render::view('tasks/index', ['tasks' => $tasks]);
    }

    public static function show(int $id): void
    {
        $task = Task::find($id);
        TaskPolicy::view($task, Auth::user());

        Render::view('tasks/show', ['task' => $task]);
    }

    public static function create(): void
    {
        Render::view('tasks/create', []);
    }

    public static function edit(int $id): void
    {
        $task = Task::find($id);
        TaskPolicy::view($task, Auth::user());

        Render::view('tasks/edit', ['task' => $task]);
    }

    public static function store(): void
    {
        $attributes = Request::attributes();

        $attributes['complete'] = (int) get_val($attributes, 'complete', 0);
        $attributes['user_id'] = Auth::user()->id;

        $validation = (new Validation($attributes))
            ->add_rule('description', ['required'])
            ->add_rule('complete', ['required', 'int'])
            ->add_rule('user_id', ['required', 'int']);

        if ($validation->validate()) {
            $task = Task::create($validation->values);

            Request::redirect("/tasks/$task->id");
        } else {
            Request::redirect('tasks/create', [
                'values' => $validation->values,
                'errors' => $validation->errors,
            ]);
        }

    }

    public static function update(int $id): void
    {
        $task = Task::find($id);
        TaskPolicy::view($task, Auth::user());

        $attributes = Request::attributes();

        $attributes['complete'] = (int) get_val($attributes, 'complete', 0);
        $attributes['user_id'] = Auth::user()->id;

        $validation = (new Validation($attributes))
            ->add_rule('description', ['required'])
            ->add_rule('complete', ['required', 'int'])
            ->add_rule('user_id', ['required', 'int']);

        if ($validation->validate()) {
            $task->update($validation->values);
        } else {
            Request::redirect(
                "/tasks/$id/edit",
                [
                    'values' => $validation->values,
                    'errors' => $validation->errors,
                ]
            );
        }

        Request::redirect("/tasks/$task->id");
    }

    public static function destroy(int $id): void
    {
        $task = Task::find($id);
        TaskPolicy::view($task, Auth::user());

        $task->delete();

        Request::redirect('/users');
    }
}
