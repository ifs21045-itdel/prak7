<?php
require_once(__DIR__ . '/../models/Todo.php');

class TodoController
{
  public function index()
  {
    $todoModel = new Todo();
    $todos = $todoModel->getAllTodos();
    include(__DIR__ . '/../views/index.php');
  }

  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $activity = $_POST['activity'];

      $todoModel = new Todo();

      // Memeriksa apakah aktivitas sudah ada sebelum menambahkannya
      if (!$todoModel->isActivityUnique($activity)) {
        $_SESSION['error_message'] = "Aktivitas sudah ada. Silakan coba lagi.";
      } else {
        $todoModel->createTodo($activity);
      }
    }

    header('Location: index.php');
  }

  public function update()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id = $_POST['id'];
      $activity = $_POST['activity'];
      $status = $_POST['status'];

      $todoModel = new Todo();

      // Memeriksa apakah aktivitas sudah ada selain aktivitas yang sedang diubah
      if (!$todoModel->isActivityUnique($activity, $id)) {
        $_SESSION['error_message'] = "Aktivitas sudah ada. Silakan coba lagi.";
      } else {
        $todoModel->updateTodo($id, $activity, $status);
      }
    }

    header('Location: index.php');
  }

  public function delete()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
      $id = $_GET['id'];

      $todoModel = new Todo();
      $todoModel->deleteTodo($id);
    }

    header('Location: index.php');
  }
}
