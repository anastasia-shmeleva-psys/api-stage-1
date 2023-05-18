<?php

namespace App\Controllers;

use App\HttpRequest;
use App\JsonResponse;
use App\Models\Todo;
use App\Repositories\TodoRepository;

class TodoController
{
    private TodoRepository $repository;
    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Read list of items
     */
    public function listTodo(): void
    {
        JsonResponse::ok(array_map(fn ($item) => $item, $this->repository->get_all()));
    }

    /**
     * Create and return item
     *
     * @param $todoData mixed
     */
    function createTodo (HttpRequest $request): void
    {
        JsonResponse::created((array)$this->repository->add($request->get_body()));
    }

    /**
     * Edit and return item by id
     *
     * @param HttpRequest $request
     */
    function editTodo(HttpRequest $request): void
    {
        if($this->repository->update(intval($request->get_params()['id']), $request->get_body()) == false) {
            JsonResponse::notFound();
        } else {
            JsonResponse::ok((array)$this->repository->update(intval($request->get_params()['id']), $request->get_body()));
        }
    }

    /**
     * Read item by id
     *
     * @param HttpRequest $request
     */
    function readTodo(HttpRequest $request): void
    {
        if($this->repository->get_by_id($request->get_params()['id']) == false) {
            JsonResponse::notFound();
        } else {
            JsonResponse::ok((array)$this->repository->get_by_id($request->get_params()['id']));
        }

    }

    /**
     * Delete item
     *
     * @param HttpRequest $request
     */
    function deleteTodo(HttpRequest $request): void
    {
        if($this->repository->delete($request->get_params()['id']) == false) {
            JsonResponse::notFound();
        } else {
            JsonResponse::noContent();
        }
    }

}
