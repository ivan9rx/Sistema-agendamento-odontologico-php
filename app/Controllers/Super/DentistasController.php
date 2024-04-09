<?php

namespace App\Controllers\Super;

use CodeIgniter\Config\Factories;
use App\Controllers\BaseController;
use App\Entities\Dentista;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DentistaModel;
use App\Libraries\DentistaService;
use Codeigniter\View\RendererInterface;

class DentistasController extends BaseController
{


    /** @var DentistaService */
    private DentistaService $dentistaService;

    /** @var DentistaModel */
    private DentistaModel $dentistaModel;

    /** constructor */
    public function __construct()
    {
        $this->dentistaService = Factories::class(DentistaService::class);
        $this->dentistaModel = model(DentistaModel::class);
    }




    /**
     * rendenriza a view para gerenciar os dentistas
     * 
     * @return RendererInterface
     * 
     */

    public function index()
    {



        $data = [
            'title' => 'Dentistas',
            'dentistas' => $this->dentistaService->renderDentistas()

        ];




        return view('Back/Dentistas/index', $data);
    }


    /**
     * rendenriza a view para criar os funcionários
     * 
     * @return RendererInterface
     * 
     */

    public function new()
    {

        $data = [
            'title'         => 'Criar funcionários',
            'dentista'      => new Dentista(),
            'timesInterval' => $this->dentistaService->renderTimesInterval()

        ];

        return view('Back/Dentistas/new', $data);
    }

    /**
     * processa a criação do registro na base de dados
     * 
     * @return RedirectResponse
     */
    public function create()
    {

        $this->checkMethod('post');



        $dentista = new Dentista($this->clearRequest());


        if (!$this->dentistaModel->insert($dentista)) {
            return redirect()->back()->withInput()->with('danger', 'verifique os erros e tente novamente')->with('errorsValidation', $this->dentistaModel->errors());
        }

        return redirect()->route('dentistas')->with('success', 'Sucesso ao atualizar');
    }




    /**
     * rendenriza a view para gerenciar os dentistas
     * 
     * @param integer $id
     * @return RendererInterface
     * 
     */

    public function edit(int $id)
    {



        $data = [
            'title'            => 'Editar Profissional',
            'dentista'         => $dentista = $this->dentistaModel->findOrFail($id),
            'timesInterval'     => $this->dentistaService->renderTimesInterval($dentista->servicetime)

        ];

        return view('Back/Dentistas/edit', $data);
    }


    /**
     * processa a atualização do registro na base de dados
     * @param integer $id
     * @return RedirectResponse
     */
    public function update(int $id)
    {

        $this->checkMethod('put');

        $dentista = $this->dentistaModel->findOrFail($id);


        $dentista->fill($this->clearRequest());

        if (!$dentista->hasChanged()) {
            return redirect()->back()->with('info', 'Não há dados para atualizar');
        }

        $success = $this->dentistaModel->save($dentista);


        if (!$success) {
            return redirect()->back()->withInput()->with('danger', 'verifique os erros e tente novamente')->with('errorsValidation', $this->dentistaModel->errors());
        }

        return redirect()->route('dentistas')->with('success', 'Sucesso ao atualizar');
    }



        /**
     * processa a ativação ou desativação do registro na base de dados
     * @param integer $id
     * @return RedirectResponse
     */
    public function action(int $id)
    {

        $this->checkMethod('put');

        $dentista = $this->dentistaModel->findOrFail($id);
        $dentista->setAction();

        $this->dentistaModel->save($dentista);

        
        return redirect()->route('dentistas')->with('success', 'Sucesso ao atualizar');
    }


            /**
     * processa a exclusão do registro na base de dados
     * @param integer $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {

        $this->checkMethod('delete');

        $dentista = $this->dentistaModel->findOrFail($id);


        $this->dentistaModel->delete($dentista->id);

        
        return redirect()->route('dentistas')->with('success', 'Sucesso ao atualizar');
    }

        /**
     * rendenriza a view para gerenciar os agendamentos do dentista
     * 
     * @param integer $id
     * @return RendererInterface
     * 
     */

     public function schedules(int $id)
     {
 
 
 
         $data = [
             'title'            => 'Gerenciar os agendamentos do Profissional',
             'dentista'         => $dentista = $this->dentistaModel->findOrFail($id),
             'schedules'        => $this->dentistaService->renderDentistaSchedules($dentista->id)
 
         ];
 
         return view('Back/Dentistas/schedules', $data);
     }
}
