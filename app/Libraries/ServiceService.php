<?php

namespace App\libraries;

use App\Entities\Dentista;
use App\Entities\Service;
use App\Models\DentistaModel;
use App\Models\ServiceModel;
use Config\Services;

class ServiceService extends MyBaseService
{




    public function renderServices(): string
    {
        $services = model(ServiceModel::class)->orderBy('nome', 'ASC')->findAll();

        if (empty($services)) {
            return self::TEXT_FOR_NO_DATA;
        }

        $this->htmlTable->setHeading('Ações', 'nome',   'Situação', 'criado');

        foreach ($services as $service) {

            $this->htmlTable->addRow(
                [
                    $this->renderBtnActions($service),
                    $service->nome,
                    $service->status(),
                    $service->createdAt(),
                ]
            );
        }

        return $this->htmlTable->generate();
    }


    /**
     *  renderiza o dropdown
     * 
     * @param Service $service
     * @return string
     * 
     * 
     */

    private function renderBtnActions(Service $service): string
    {

        $btnActions = '<div class="btn-group dropup">';
        $btnActions .= '<button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações</button>';
        $btnActions .= '<div class="dropdown-menu">';
        $btnActions .= anchor(route_to('services.edit', $service->id), 'Editar', ['class' => 'dropdown-item']);
        $btnActions .= view_cell(
            library: 'ButtonsCell::action', 
            params:[
            'route'        => route_to('services.action', $service->id),
            'text_action'  => $service->textToAction(),
            'activated'    => $service->isActivated(),
            'btn_class'    => 'dropdown-item py-2'
        ]);
        $btnActions .= view_cell(
            library: 'ButtonsCell::destroy', 
            params:[
            'route'        => route_to('services.destroy', $service->id),
            'btn_class'    => 'dropdown-item py-2'
        ]);
        $btnActions .= '</div> </div>';

        return $btnActions;
    }
}
