<?php

namespace App\libraries;

use App\Models\ServiceModel;

class DentistaServiceService extends MyBaseService
{


    /**
     * renderiza a lista com  as opções de serviços disponíveis para associação através de checkbox
     */
    public function renderServicesOptions(?array $existingServicosIds = null): string
    {

        $servicos = model(ServiceModel::class)->orderBy('nome', 'ASC')->findAll();

        if (empty($servicos)) {
            $anchor = '<div class="text-info mt-5" >Não há serviços disponíveis</div>';
            $anchor .= anchor(route_to('services'), 'ver serviços', ['class' => 'btn btn-sm btn-outline-primary']);

            return $anchor;
        }

        $ul = '<ul class="list-group">';

        foreach($servicos as $servico) {
            $checked = in_array($servico->id, $existingServicosIds ?? []) ? 'checked' : '';

            $checkbox = '<div class="custom-control custom-checkbox">';
            $checkbox .= "<input type='checkbox' {$checked} name='servicos[]' value='{$servico->id}' class='custom-control-input' id='servico-{$servico->id}'>";
            $checkbox .= "<label class='custom-control-label' for='servico-{$servico->id}'>{$servico->nome}</label>";
            $checkbox .= '</div>';

            $ul .= "<li class='list-group-item'>{$checkbox}</li>";
        }

        $ul .= '</ul>';

        // retorna a lista de opções
        return $ul;
    }

    /**
     * renderiza a lista html nao ordenada dos servicos associados ao dentista quando for o caso
     */
    public function renderDentistaServices(?array $existingServicosIds = null): string 
    {
        if($existingServicosIds === null || empty($existingServicosIds)) {
            return self::TEXT_FOR_NO_DATA;
        }

        $servicos = model(ServiceModel::class)->whereIn('id',$existingServicosIds)->orderBy('nome', 'ASC')->findAll();

        if(empty($servicos)) {
            return self::TEXT_FOR_NO_DATA;
        }

        $list = [];

        foreach($servicos as $servico){
            $list[] = "{$servico->nome} - {$servico->status()}";
        }

        return ul($list);

    }
}
