<?php
require_once 'storage.php';

$blank_todo = [
    'id' => 0,
    'description'=> '',
    'completed' => "0"
];

/**
 * Read list of items
 *
 * @return array
 */
function listTodo(): array {
    $todos = read_data();
    if ($todos == null) {
        return[];
    }

    return read_data();
}

/**
 * Create and return item
 *
 * @param $todoData mixed
 * @return mixed
 */
function createTodo (mixed $todoData): mixed {

    global $blank_todo;
    $newTodo = array_merge($blank_todo, $todoData);
    $newTodo['id'] = uniqid();

    $todos = read_data();
    $todos[] = $newTodo;

    write_data($todos);
    return $newTodo;
}

/**
 * Edit and return item by id
 *
 * @param $todoId
 * @param $todoData
 * @return mixed
 */
function editTodo($todoId, $todoData): mixed {

    $todos = read_data();

    if ($todos == null) {
        return false;
    }
    foreach ($todos as $key => $todo) {
        if ($todo['id'] == $todoId) {
            $changedTodo = $todo;
            $id = $key;
            break;
        }
    }

    if (!$changedTodo) {
        return false;
    }

    $changedTodo = array_merge($changedTodo, $todoData);
    $todos[$id] = $changedTodo;

    write_data($todos);
    return $changedTodo;
}

/**
 * Read item by id
 *
 * @param $todoId
 * @return void
 */
function readTodo($todoId): mixed {
    $todos = read_data();

    foreach ($todos as $todo) {
        if ($todo['id'] == $todoId) {
            return $todo;
        }
    }
    return false;
}


/**
 * Delete item
 *
 * @param $todoId
 * @return bool
 */
function deleteTodo($todoId): mixed
{
    $todos = read_data();

    foreach ($todos as $key => $todo) {
        if ($todo['id'] == $todoId) {
            unset($todos[$key]);
            write_data($todos);
            return true;
        }
    }
    return false;
}
