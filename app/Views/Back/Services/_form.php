<div class="row">
    <div class="form-group col-md-12">
        <label for="nome">Nome do Serviço</label>
        <input type="text" class="form-control" name="nome" value="<?php echo old('name', $servico->nome); ?>" id="nome" aria-describedby="nomeHelp" placeholder="Nome">
        <?php echo show_error_input('nome'); ?>
    </div>

    <div class="col-md-12 mb-3 mt-4">
        <div class="custom-control custom-checkbox">
            <?php echo form_hidden('active', 0); ?>
            <input type="checkbox" name="active" value="1" <?php if ($servico->active) : ?> checked <?php endif; ?> class="custom-control-input" id="active">
            <label for="active" class="custom-control-label">Registro Ativo</label>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-primary mt-4">Salvar</button>

<a href="<?php echo route_to('services') ?>" class="btn btn-secondary mt-4">Voltar</a>
