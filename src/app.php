<?php
/**
 * 🌳🌿🍄   puf message  🍁🌿🌳
 * src/app.php
 * This is the main place where you app code goes.
 */ 

require_once '_puf/Puf.php';

session_start();

$router = new Puf\Core\Router();
$auth = new Puf\Core\Auth();
$storage = new Puf\Core\Storage();
$templating = new Puf\Core\Templating();

// Fetch all todo files
$router->addRoute('GET', '/', function () use ($templating, $storage) {
    $todos = $storage->getAllFiles('todo');
    echo $templating->render('index', ['todos' => array_values($todos)]);
});

// Create a new todo
$router->addRoute('POST', '/todos', function () use ($storage) {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    if (empty($title) || empty($description)) {
        http_response_code(400);
        echo "Title and description are required.";
        return;
    }

    $id = uniqid(); // Unique ID instead of sequential
    $todo = [
        'id' => $id,
        'title' => $title,
        'description' => $description,
        'completed' => false
    ];

    $storage->saveFile("todo-$id", $todo);
    header('Location: /');
    exit;
});

// View a single todo
$router->addRoute('GET', '/todos/{id}', function ($id) use ($storage) {
    header('Content-Type: application/json');

    $todo = $storage->getFile("todo-$id");
    if (!$todo) {
        http_response_code(404);
        echo json_encode(["error" => "Todo not found."]);
        return;
    }

    echo json_encode($todo);
});


// Update a todo
$router->addRoute('POST', '/todos/{id}/update', function ($id) use ($storage) {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    if (empty($title) || empty($description)) {
        http_response_code(400);
        echo "Title and description are required.";
        return;
    }

    $todo = $storage->getFile("todo-$id");
    if (!$todo) {
        http_response_code(404);
        echo "Todo not found.";
        return;
    }

    $todo['title'] = $title;
    $todo['description'] = $description;
    $storage->saveFile("todo-$id", $todo);
    header('Location: /');
    exit;
});

// Delete a todo
$router->addRoute('POST', '/todos/{id}/delete', function ($id) use ($storage) {
    if (!$storage->deleteFile("todo-$id")) {
        http_response_code(404);
        echo "Todo not found.";
        return;
    }
    header('Location: /');
    exit;
});

$router->run();
