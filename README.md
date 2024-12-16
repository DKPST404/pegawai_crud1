# Aplikasi CRUD Pegawai

## Fitur
- Menampilkan daftar pegawai
- Menambah pegawai baru
- Mengedit data pegawai
- Menghapus data pegawai

## Cara Menjalankan
1. Clone repository.
2. Jalankan `composer install`.
3. Konfigurasi database di file `.env`.
4. Jalankan migration dengan `php spark migrate`.
5. Jalankan server dengan `php spark serve`.


________________________________________________________________________________________________________________________________________

# CRUD Application using CodeIgniter 4

This project demonstrates a simple CRUD application built with CodeIgniter 4. Below are the steps to set up and run the project.

---

## Prerequisites
- PHP >= 7.4 (PHP 8.1 recommended)
- Composer (latest version)
- MySQL/MariaDB
- CodeIgniter 4 (latest stable version)
- A web server (e.g., Apache or Nginx, or use PHP's built-in server)

---

## Installation Steps

### 1. Clone or Create the Project
Run the following commands to create a new CodeIgniter 4 project:
```bash
composer create-project codeigniter4/appstarter crud_app
```

Navigate to the project directory:
```bash
cd crud_app
```

---

### 2. Configure the Application

#### Update Environment Settings
1. Rename the `.env` file (if not already done):
   ```bash
   cp env .env
   ```
2. Open the `.env` file and configure the database settings:
   ```dotenv
   database.default.hostname = localhost
   database.default.database = your_database_name
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
   ```

#### Set the Base URL
In the `.env` file, set the application base URL (if required):
```dotenv
app.baseURL = 'http://localhost:8080'
```

---

### 3. Create the Database
1. Open phpMyAdmin or any MySQL client.
2. Create a new database (e.g., `crud_db`).

---

### 4. Create Migration File
Run the following command to generate a migration file:
```bash
php spark make:migration CreateStudentsTable
```

#### Define the Migration
Open the migration file in `app/Database/Migrations/` and define the table structure:
```php
<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}
```

Run the migration:
```bash
php spark migrate
```

---

### 5. Create the Model
Create a `StudentModel` in `app/Models/StudentModel.php`:
```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'address'];
}
```

---

### 6. Create the Controller
Create a `StudentController` in `app/Controllers/StudentController.php`:
```php
<?php

namespace App\Controllers;

use App\Models\StudentModel;
use CodeIgniter\Controller;

class StudentController extends Controller
{
    protected $studentModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
    }

    public function index()
    {
        $data['students'] = $this->studentModel->findAll();
        return view('students/index', $data);
    }

    public function create()
    {
        return view('students/create');
    }

    public function store()
    {
        $this->studentModel->save([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
        ]);
        return redirect()->to('/students');
    }

    public function edit($id)
    {
        $data['student'] = $this->studentModel->find($id);
        return view('students/edit', $data);
    }

    public function update($id)
    {
        $this->studentModel->update($id, [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
        ]);
        return redirect()->to('/students');
    }

    public function delete($id)
    {
        $this->studentModel->delete($id);
        return redirect()->to('/students');
    }
}
```

---

### 7. Define Routes
Edit `app/Config/Routes.php` to add routes for the CRUD operations:
```php
$routes->get('/students', 'StudentController::index');
$routes->get('/students/create', 'StudentController::create');
$routes->post('/students/store', 'StudentController::store');
$routes->get('/students/edit/(:num)', 'StudentController::edit/$1');
$routes->post('/students/update/(:num)', 'StudentController::update/$1');
$routes->post('/students/delete/(:num)', 'StudentController::delete/$1');
```

---

### 8. Create Views
Create the following views in `app/Views/students/`:

#### **`index.php`**
```php
<h1>Student List</h1>
<a href="/students/create">Add New Student</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($students as $student): ?>
    <tr>
        <td><?= $student['id'] ?></td>
        <td><?= $student['name'] ?></td>
        <td><?= $student['email'] ?></td>
        <td><?= $student['address'] ?></td>
        <td>
            <a href="/students/edit/<?= $student['id'] ?>">Edit</a>
            <form action="/students/delete/<?= $student['id'] ?>" method="post" style="display:inline;">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
```

#### **`create.php`**
```php
<h1>Create Student</h1>
<form action="/students/store" method="post">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="address">Address:</label>
    <textarea name="address" id="address"></textarea>

    <button type="submit">Save</button>
</form>
```

#### **`edit.php`**
```php
<h1>Edit Student</h1>
<form action="/students/update/<?= $student['id'] ?>" method="post">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?= $student['name'] ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?= $student['email'] ?>" required>

    <label for="address">Address:</label>
    <textarea name="address" id="address"><?= $student['address'] ?></textarea>

    <button type="submit">Update</button>
</form>
```

---

### 9. Run the Application
Start the development server:
```bash
php spark serve
```

Access the application at `http://localhost:8080/students`.

---

### 10. Testing
Test the CRUD functionalities by accessing the respective routes and performing operations like creating, editing, and deleting records.

---
