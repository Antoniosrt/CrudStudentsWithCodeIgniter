<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Entities\User;
class RegisterController extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
    }

    public function register(): ResponseInterface
    {
        $userRules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[auth_identities.secret]',
            'password' => 'required|min_length[8]',
        ];

        if (!$this->validate($userRules)) {
            return $this->fail($this->validator->getErrors());
        }

        $users = auth()->getProvider();
        $user = new User([
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ]);

        $users->save($user);
        $user = $users->findById($users->getInsertID());
        // Add to default group
        $users->addToDefaultGroup($user);
        return $this->respondCreated(['message' => 'Usuário criado com sucesso!']);
    }

}
