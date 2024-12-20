<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class Super extends Seeder
{
    public function run()
    {
        try {
            //abertura da transaction
            $this->db->transStart();

            $userModel = new UserModel();

            $user = new User([
                'email' => 'ivan@gmail.com',
                'username' => 'ivan dentista',
                'password' => '12345678'

            ]);

            $userModel->save($user);

            $user = $userModel->findById($userModel->getInsertID());

            $user->activate();

            $user->addGroup('superadmin');

            //fecha a transaction
            $this->db->transComplete();

            echo "User user criado";

        } catch (\Throwable $th) {

            echo $th->getMessage();
        }
    }
}
