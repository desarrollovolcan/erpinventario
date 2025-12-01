<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Models\User;

class UserController extends Controller
{
    public function index(): void
    {
        Auth::requireRole(['admin']);
        $model = new User();
        $this->view('users/index', [
            'users' => $model->all(),
            'roles' => $model->roles(),
            'csrf' => Csrf::token(),
        ]);
    }

    public function store(): void
    {
        Auth::requireRole(['admin']);
        $token = $_POST['_token'] ?? '';
        if (!Csrf::validate($token)) {
            $this->redirect('/usuarios?error=csrf');
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $roleId = (int)($_POST['role_id'] ?? 0);

        if ($name === '' || $email === '' || $password === '' || $roleId === 0) {
            $this->redirect('/usuarios?error=datos');
        }

        $user = new User();
        $user->create([
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'role_id' => $roleId,
            'status' => 1,
        ]);

        $this->redirect('/usuarios?success=1');
    }
}
