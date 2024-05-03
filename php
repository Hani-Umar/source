<?php

// This is a simple PHP script that demonstrates some advanced concepts

// Autoloading classes
spl_autoload_register(function ($class) {
  include 'classes/' . $class . '.php';
});

// Using a database (PDO)
$db = new PDO('mysql:host=localhost;dbname=test', 'username', 'password');

// Defining a class
class User {
  private $name;
  private $email;

  public function __construct($name, $email) {
    $this->name = $name;
    $this->email = $email;
  }

  public function save() {
    $stmt = $db->prepare('INSERT INTO users (name, email) VALUES (:name, :email)');
    $stmt->execute([':name' => $this->name, ':email' => $this->email]);
  }
}

// Using a dependency injection container
$container = new Container();
$container['db'] = $db;

// Using a routing system
$router = new Router();
$router->get('/', function () {
  echo 'Welcome to the home page!';
});
$router->get('/users', function () {
  $users = $db->query('SELECT * FROM users');
  foreach ($users as $user) {
    echo $user['name'] . "\n";
  }
});
$router->post('/users', function ($request) {
  $user = new User($request['name'], $request['email']);
  $user->save();
  echo 'User created!';
});

// Starting the application
$router->run();

?>
