<?php
/**
 * @var \Phalcon\Mvc\View\Engine\Php $this
 */
$this->view->disable();
?>



<div class="page-header" id="prueba">
    <h1>Insidencias Terminadas</h1>
</div>



<div class="row">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Prioridad</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Sucursal</th>
                <th>Sistema</th>
                <th>Fecha Inicio</th>
                <th>Fecha Limite</th>
                <th>Nombre del usuario</th>
                <th>Estado</th>
            </tr>
        </thead>
        <div><?= $hola ?></div>
        <div>%hola%</div>
        <div><?php echo $this->view->hola;?></div>
        <tbody>
        <?php if ($terminado->count() > 0) { ?>
            <tr>
                <?php foreach ($terminado as $reporte): ?>
                <td><?php echo $reporte->prioridad ?></td>
                <td><?php echo $reporte->Reporte ?></td>
                <td><?php echo $reporte->descripcion ?></td>
                <td><?php echo $reporte->sucursal ?></td>
                <td><?php echo $reporte->sistema ?></td>
                <td><?php echo $reporte->fecha_inicio ?></td>
                <td><?php echo $reporte->fecha_limite ?></td>
                <td><?php echo $reporte->nombreC ?></td>
                <td><?php echo $reporte->Estado ?></td>
            </tr>
        <?php endforeach;
        }
        else{
            $this->flash->error("No hay datos");
        }
        ?>
        </tbody>
    </table>
</div>