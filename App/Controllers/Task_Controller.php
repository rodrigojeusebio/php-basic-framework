<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Task;
use Core\Render;
use Core\Request;
use Core\Validation;

final class Task_Controller
{
    public static function index(): void
    {
        $filters = Request::parameters();

        if (isset($filters['description'])) {
            $tasks = Task::like('description', $filters['description'])
                ->all();
        } else {
            $tasks = Task::all();
        }

        Render::view('tasks/index', ['tasks' => $tasks]);
    }

    public static function show(int $id): void
    {
        $task = Task::find($id);

        Render::view('tasks/show', ['task' => $task]);
    }

    public static function create(): void
    {
        Render::view('tasks/create', []);
    }

    public static function edit(int $id): void
    {
        $task = Task::find($id);

        Render::view('tasks/edit', ['task' => $task]);
    }

    public static function store(): void
    {
        $attributes = Request::attributes();

        $attributes['complete'] = (int) get_val($attributes, 'complete', 0);

        $validation = (new Validation($attributes))
            ->add_rule('description', ['required'])
            ->add_rule('complete', ['required', 'int']);

        if ($validation->validate()) {
            $user = Task::create($validation->values);

            Request::redirect("/tasks/$user->id");
        } else {
            Request::redirect('tasks/create', [
                'values' => $validation->values,
                'errors' => $validation->errors
            ]);
        }

    }

    public static function update(int $id): void
    {
        $task = Task::find($id);

        $attributes = Request::attributes();

        $attributes['complete'] = (int) get_val($attributes, 'complete', 0);

        $validation = (new Validation($attributes))
            ->add_rule('task', ['required'])
            ->add_rule('complete', ['required', 'int']);

        if ($validation) {

            $task->update($validation->values);

        } else {
            Request::redirect(
                "/tasks/edit/$id",
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
        $user = Task::find($id);
        $user->delete();

        Request::redirect('/users');
    }
}
