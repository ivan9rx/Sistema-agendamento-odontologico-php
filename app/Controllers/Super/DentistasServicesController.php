<?php

namespace App\Controllers\Super;

use CodeIgniter\View\RendererInterface;
use App\Controllers\BaseController;
use App\Libraries\DentistaService;
use App\Libraries\DentistaServiceService;
use App\Models\DentistaModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\HTTP\ResponseInterface;

class DentistasServicesController extends BaseController
{
    /** @var DentistaModel */
    private DentistaModel $dentistaModel;


    /** @var DentistaServiceService */
    private DentistaServiceService $dentistaServiceService;


    /** Construtor */
    public function __construct()
    {
        $this->dentistaModel = model(DentistaModel::class);
        $this->dentistaServiceService = Factories::class(DentistaServiceService::class);
    }

    /**
     * Renderiza a view para gerenciar os serviços do dentista
     * @param integer $dentistaId
     * @return RendererInterface 
     */
    public function services(int $dentistaId)
    {

        $data = [
            'title'             => 'Gerenciar serviços do dentista',
            'dentista'          => $dentista = $this->dentistaModel->findOrFail($dentistaId),
            'servicesOptions'   => $this->dentistaServiceService->renderServicesOptions($dentista->servicos),
        ];

        return view('Back/Dentistas/services', $data);
    }


    /** processa a associação ods serviços com o dentista
     * @param integer $dentistaId
     *  @return RedirectResponse
     */
    public function store(int $dentistaId)
    {

        $this->checkMethod('put');

        $dentista = $this->dentistaModel->findOrFail($dentistaId);

        $postServices =  $this->request->getPost('servicos');

      

        $dentista->servicos = $postServices ?? null;



        if (!$dentista->hasChanged()) {
            return redirect()->back()->with('info', 'Não há dados para atualizar');
        }

        $success = $this->dentistaModel->save($dentista);


        if (!$success) {
            return redirect()->back()->withInput()->with('danger', 'verifique os erros e tente novamente')->with('errorsValidation', $this->dentistaModel->errors());
        }

        return redirect()->back()->with('success', 'Sucesso ao atualizar');

        
    }
}
