<?php

namespace App\Cells;


class ButtonsCell
{

    /**
     * renderiza um btn com formulario html para ativar ou desativação do registro
     * @param array $params
     * @return string
     */
    public function action(array $params): string
    {
        //classes padrão
        $btnClass = 'btn btn-sm';
        $btnClass .= $params['activated'] ? 'btn-warning' : 'btn-success';

        // dentistas/action/1
        $form =  form_open($params['route'], ['class' => 'd-inline'], hidden: ['_method' => 'PUT']);
        $form .= form_button([
            'class'    => $params['btn_class'] ?? $btnClass,
            'type'     => 'submit',
            'content'  => $params['text_action'] // o que sera exibido
        ]);

        $form .= form_close();

        return $form;
    }



    /**
     * renderiza um btn com formulario html para exclusão do registro
     * @param array $params
     * @return string
     */
    public function destroy(array $params): string
    {
        $formAttributes = [
            'class'     => 'd-inline',
            'onsubmit'  => 'return confirm("Tem certeza da exclusão?");',


        ];

        // dentistas/action/1
        $form =  form_open($params['route'], attributes: $formAttributes, hidden: ['_method' => 'DELETE']);
        $form .= form_button([
            'class'    => $params['btn_class'] ?? ' btn btn-sm btn-danger',
            'type'     => 'submit',
            'content'  => 'Excluir' // o que sera exibido
        ]);

        $form .= form_close();

        return $form;
    }
}
