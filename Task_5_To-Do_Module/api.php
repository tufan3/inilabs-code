<?php
$dsn = 'mysql:host=localhost;dbname=todo_app';
$username = 'root'; // replace with your DB username
$password = ''; // replace with your DB password

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Handle the request type
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        getTasks($pdo);
        break;
    case 'POST':
        createTask($pdo);
        break;
    case 'PUT':
        updateTask($pdo);
        break;
    case 'DELETE':
        deleteTask($pdo);
        break;
    default:
        echo json_encode(["message" => "Invalid Request Method"]);
}

// Function to fetch tasks
function getTasks($pdo) {
    $stmt = $pdo->query('SELECT * FROM tasks ORDER BY created_at DESC');
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tasks);
}

// Function to create a new task
function createTask($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!empty($data['title'])) {
        $stmt = $pdo->prepare('INSERT INTO tasks (title) VALUES (:title)');
        $stmt->execute(['title' => $data['title']]);
        echo json_encode(["message" => "Task created"]);
    } else {
        echo json_encode(["message" => "Title cannot be empty"]);
    }
}

// Function to update a task
function updateTask($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id'], $data['title'], $data['completed'])) {
        $stmt = $pdo->prepare('UPDATE tasks SET title = :title, completed = :completed WHERE id = :id');
        $stmt->execute(['title' => $data['title'], 'completed' => $data['completed'], 'id' => $data['id']]);
        echo json_encode(["message" => "Task updated"]);
    } else {
        echo json_encode(["message" => "Invalid data"]);
    }
}

// Function to delete a task
function deleteTask($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id'])) {
        $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
        $stmt->execute(['id' => $data['id']]);
        echo json_encode(["message" => "Task deleted"]);
    } else {
        echo json_encode(["message" => "Invalid task ID"]);
    }
}
?>
