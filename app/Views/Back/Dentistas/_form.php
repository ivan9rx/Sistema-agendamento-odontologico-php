<div class="row">
                <div class="form-group col-md-4">
                    <label for="nome">Nome do Funcionario</label>
                    <input type="text" class="form-control" name="nome" value="<?php echo old('name', $dentista->nome); ?>" id="nome" aria-describedby="nomeHelp" placeholder="Nome">
                    <?php echo show_error_input('nome'); ?>
                </div>

                <div class="form-group col-md-4">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo old('email', $dentista->email); ?>" id="email" aria-describedby="emailHelp" placeholder="Email">
                    <?php echo show_error_input('email'); ?>
                </div>

                <div class="form-group col-md-4">
                    <label for="phone">Telefone</label>
                    <input type="tel" class="form-control phone_with_ddd" name="phone" value="<?php echo old('phone', $dentista->phone); ?>" id="phone" aria-describedby="phoneHelp" placeholder="Telephone">
                    <?php echo show_error_input('phone'); ?>
                </div>

                <div class="form-group col-md-4">
                    <label for="starttime">Inicio expediente</label>
                    <input type="time" class="form-control" name="starttime" value="<?php echo old('starttime', $dentista->starttime); ?>" id="starttime" aria-describedby="starttimeHelp" placeholder="Inicio expediente">
                    <?php echo show_error_input('starttime'); ?>
                </div>

                <div class="form-group col-md-4">
                    <label for="endtime">Final do Expediente</label>
                    <input type="time" class="form-control" name="endtime" value="<?php echo old('endtime', $dentista->endtime); ?>" id="endttime" aria-describedby="endttimeendtimeHelp" placeholder="Final do Expediente">
                    <?php echo show_error_input('endtime'); ?>
                </div>

                <div class="form-group col-md-4">
                    <label for="servicetime">Tempo de cada atendimento</label>
                    <?php echo $timesInterval; ?>
                    <?php echo show_error_input('servicetime'); ?>
                </div>

                <div class="form-group col-md-4">
                    <label for="endereco">Endereço</label>
                    <input type="text" class="form-control" name="endereco" value="<?php echo old('name', $dentista->endereco); ?>" id="endereco" aria-describedby="enderecoHelp" placeholder="Endereço">
                    <?php echo show_error_input('endereco'); ?>
                </div>


                <div class="col-md-12 mb-3 mt-4">
                    <div class="custom-control custom-checkbox">
                        <?php echo form_hidden('active', 0); ?>
                        <input type="checkbox" name="active"  value="1" <?php if($dentista->active): ?> checked <?php endif; ?> class="custom-control-input" id="active">
                        <label for="active" class="custom-control-label">Registro Ativo</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Salvar</button>

            <a href="<?php echo route_to('dentistas') ?>" class="btn btn-secondary mt-4">Voltar</a>