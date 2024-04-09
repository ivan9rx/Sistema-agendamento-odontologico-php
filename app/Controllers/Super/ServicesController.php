<?php

namespace App\Controllers\Super;

use CodeIgniter\Config\Factories;
use App\Controllers\BaseController;
use App\Entities\Service;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\ServiceService;
use App\Models\ServiceModel;
use Codeigniter\View\RendererInterface;

class ServicesController extends BaseController
{


    /** @var ServiceService */
    private ServiceService $serviceService;

    /** @var ServiceModel */
    private ServiceModel $serviceModel;

    /** constructor */
    public function __construct()
    {
        $this->serviceService = Factories::class(ServiceService::class);
        $this->serviceModel = model(ServiceModel::class);
    }




    /**
     * rendenriza a view para gerenciar os serviços
     * 
     * @return RendererInterface
     * 
     */

    public function index()
    {



        $data = [
            'title'     => 'Serviços',
            'servicos'  => $this->serviceService->renderServices()

        ];




        return view('Back/Services/index', $data);
    }


    /**
     * rendenriza a view para criar os serviços
     * 
     * @return RendererInterface
     * 
     */

    public function new()
    {

        $data = [
            'title'         => 'Criar Serviço',
            'servico'       => new Service(),

        ];

        return view('Back/Services/new', $data);
    }

    /**
     * processa a criação do registro na base de dados
     * 
     * @return RedirectResponse
     */
    public function create()
    {

        $this->checkMethod('post');



        $service = new Service($this->clearRequest());


        if (!$this->serviceModel->insert($service)) {
            return redirect()->back()->withInput()->with('danger', 'verifique os erros e tente novamente')->with('errorsValidation', $this->serviceModel->errors());
        }

        return redirect()->route('services')->with('success', 'Sucesso ao atualizar');
    }




    /**
     * rendenriza a view para editar o registro
     * 
     * @param integer $id
     * @return RendererInterface
     * 
     */

    public function edit(int $id)
    {



        $data = [
            'title'             => 'Editar Serviço',
            'servico'           => $this->serviceModel->findOrFail($id),

        ];

        return view('Back/Services/edit', $data);
    }


    /**
     * processa a edição do registro na base de dados
     * @param integer $id
     * @return RedirectResponse
     */
    public function update(int $id)
    {

        $this->checkMethod('put');

        $servico = $this->serviceModel->findOrFail($id);


        $servico->fill($this->clearRequest());

        if (!$servico->hasChanged()) {
            return redirect()->back()->with('info', 'Não há dados para atualizar');
        }

        $success = $this->serviceModel->save($servico);


        if (!$success) {
            return redirect()->back()->withInput()->with('danger', 'verifique os erros e tente novamente')->with('errorsValidation', $this->serviceModel->errors());
        }

        return redirect()->route('services')->with('success', 'Sucesso ao atualizar');
    }



        /**
     * processa a ativação ou desativação do registro na base de dados
     * @param integer $id
     * @return RedirectResponse
     */
    public function action(int $id)
    {

        $this->checkMethod('put');

        $servico = $this->serviceModel->findOrFail($id);
        $servico->setAction();

        $this->serviceModel->save($servico);

        
        return redirect()->route('services')->with('success', 'Sucesso ao atualizar');
    }


            /**
     * processa a exclusão do registro na base de dados
     * @param integer $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {

        $this->checkMethod('delete');

        $servico = $this->serviceModel->findOrFail($id);


        $this->serviceModel->delete($servico->id);

        
        return redirect()->route('services')->with('success', 'Sucesso ao atualizar');
    }
}
