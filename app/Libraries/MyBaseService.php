<?php  

namespace App\Libraries;

use CodeIgniter\Config\Factories;
use CodeIgniter\View\Table as HTMLTable;

class MyBaseService
{
    /** @var HTMLTable */
    protected HTMLTable $htmlTable;


    /** Elemento a ser exibido em caso de nao ter dados a apresentar */
    protected const TEXT_FOR_NO_DATA = '<div class="text-info">Não há dados para serem exibidos</div>';

    public function __construct()
    {
        $this->htmlTable = Factories::class(HTMLTable::class);

       
        
        $this->htmlTable->setTemplate([
            'table_open' => '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">'
        ]);

    }
}

