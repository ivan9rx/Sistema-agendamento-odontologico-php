<?php 

if(!function_exists('show_error_input')) {

    /**
     * exibeo erro de validação para o campo informado caso o mesmo tenha sido interceptado no form validation
     * @param string $inputField
     * @return string
     */

    function show_error_input(string $inputField): string 
    {

        $inputField = strtolower($inputField);

        if(!session()->has('errorsValidation')) {
            return '';
        }

        $errorsValidation = esc(session('errorsValidation'));

        return !array_key_exists($inputField, $errorsValidation) ? 
        '' : //retorna string vazia caso nao tenha
        "<span class='text-danger'>{$errorsValidation[$inputField]}</span>"; 
    }

}