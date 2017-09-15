<?php

class ProgramadorController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
    	//Check if the variable is defined 
    	if ($this->session->has("login")) {
    	}
    	else
    	{
    		$this->dispatcher->forward([
            	'controller' => "index",
            	'action' => 'index'
        	]);
    	}

        $tabla = $this->modelsManager->createBuilder()
            ->from('Reporte')
            ->join('Usuarios')//recordemos que no necesitamos hacer la on
            ->join('Status')//recordemos que no necesitamos hacer la on
            ->join('Prioridad')//recordemos que no necesitamos hacer la on
            ->columns("Reporte.id_reporte,Reporte.nombre as Reporte,descripcion,sucursal,sistema,fecha_inicio,fecha_limite,
                Status.nombre as Estado, Status.id_status, Prioridad.id_prioridad,prioridad")
            ->where('login = :login:', array('login' => $this->session->get("login")))
            ->orderBy('Prioridad.id_prioridad Desc')
            ->getQuery()
            ->execute();

        $this->view->tabla = $tabla;
    }

    //elimina la sesión username
    public function salirAction()
    {
        //Remove a session variable
        $this->session->remove("login");

        $this->response->redirect("");
    }

    /**
     * Liberar y subir archivos
     *
     * @param string $id_reporte
     */
    public function revisionAction($id_reporte)
    {
        //Check if the variable is defined 
        if ($this->session->has("login")) {
        }
        else
        {
            $this->response->redirect("");
        }

        $Reporte = Reporte::findFirstByid_reporte($id_reporte);
        $this->tag->setDefault("id_reporte", $Reporte->getIdReporte());

        $ruta=$Reporte->getRuta();
        $archivo=$Reporte->getArchivo();

        $this->view->ruta = $ruta;
        $this->view->archivo = $archivo;

        $comentarios = $this->modelsManager->createBuilder()
            ->from('Comentarios')
            ->join('Usuarios')//recordemos que no necesitamos hacer la on
            ->columns("comentario, fecha_comentario, concat(Usuarios.nombre,' ',paterno,' ',materno) as nombre")
            ->where('id_reporte = :id_reporte:', array('id_reporte' => $id_reporte))
            ->orderBy('id_comentario Desc')
            ->getQuery()
            ->execute();

        $this->view->comentarios = $comentarios;
    }

    /**
     * Edits a soporte
     *
     * @param string $id_reporte
     */
    public function subirAction()
    {
        //Check if the variable is defined 
        if ($this->session->has("login")) {
        }
        else
        {
            $this->response->redirect("");
        }

        $id_reporte = $this->request->getPost("id_reporte");
        $Reporte = Reporte::findFirstByid_reporte($id_reporte);

        if (!$Reporte) {
            $this->flash->error("Error: No se encontro reporte " . $id_reporte);

            $this->dispatcher->forward([
                'controller' => "programador",
                'action' => 'index'
            ]);

            return;
        }

        $carpeta = $Reporte->ruta;

        if (!file_exists($carpeta)) {
            $nombre = $Reporte->nombre;
            $nombre = str_replace(' ','_',$nombre);
            $carpeta = "files/".$nombre."".date('Ymd_his');
            mkdir($carpeta, 0777, true);
            $Reporte->ruta = $carpeta;
        }

        $server = $carpeta.'/'.basename( $_FILES['Servidor']['name']);
        $new = $carpeta.'/'.basename( $_FILES['Nuevo']['name']);
        $server_name = $_FILES['Servidor']['name'];
        $new_name = $_FILES['Nuevo']['name'];

        if(move_uploaded_file($_FILES['Nuevo']['tmp_name'], $new))
        {
            move_uploaded_file($_FILES['Servidor']['tmp_name'], $server);
            $Reporte->archivo_viejo = $server_name;
            $Reporte->archivo_nuevo = $new_name;

            $this->flash->success("Archivo subido");
            $this->dispatcher->forward([
                'controller' => "programador",
                'action' => 'index'
            ]);
        }

        $Reporte->id_status=4;

        if (!$Reporte->save()) {

            foreach ($Reporte->getMessages() as $message) {
                $this->flash->error($message);
            }
        }
    }

    /**
     * Asignar tarea
     *
     */
    public function tomarAction($id_reporte)
    {
        //Check if the variable is defined 
        if ($this->session->has("login")) {
        }
        else
        {
            $this->response->redirect("");
        }

        $Reporte = Reporte::findFirstByid_reporte($id_reporte);

        //$this->view->id_reporte = $Reporte->getIdReporte();

        if (!$Reporte) {
            $this->flash->error("Error: No se encontro reporte " . $id_reporte);

            $this->dispatcher->forward([
                'controller' => "programador",
                'action' => 'index'
            ]);

            return;
        }

        $Reporte->id_status=3;

        if (!$Reporte->save()) {

            foreach ($Reporte->getMessages() as $message) {
                $this->flash->error($message);
            }
        }

        $this->flash->success("Tarea seleccionada correctamente");

        $this->dispatcher->forward([
            'controller' => "programador",
            'action' => 'index'
        ]);
    }

    /**
     * Vista de incidencias terminadas
     */
    public function terminadoAction()
    {
        //Check if the variable is defined 
        if ($this->session->has("login")) {
        }
        else
        {
            $this->response->redirect("");
        }

        $status="5";

        $terminado = $this->modelsManager->createBuilder()
            ->from('Reporte')
            ->join('Usuarios')//recordemos que no necesitamos hacer la on
            ->join('Status')//recordemos que no necesitamos hacer la on
            ->join('Prioridad')//recordemos que no necesitamos hacer la on
            ->inWhere('Reporte.id_status',[5])
            ->columns("Reporte.nombre as Reporte,descripcion,sucursal,sistema,fecha_inicio,fecha_limite,
                Status.nombre as Estado,prioridad")
            ->getQuery()
            ->execute();

        $this->view->terminado = $terminado;
    }
}