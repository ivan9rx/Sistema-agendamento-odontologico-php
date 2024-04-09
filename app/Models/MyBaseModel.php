<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Exceptions\PageNotFoundException;


class MyBaseModel extends Model
{
    


    /**
     * Escapa os dados antes de inserir
     * @param array $data   
     * @return array
     */
    protected function escapeData(array $data): array
    {
        if(!isset($data['data'])){
            return $data;
        }

        return esc($data);
    }


    /**
     * Recupera o registro
     * @param integer/string $id
     * @throws PageNotFoundException
     * @return object
     */
    public function findOrFail(int|string $id): object {
        $row = $this->find($id);

        return $row ?? throw new PageNotFoundException("Registro {$id} não encontrado");
    }
}
