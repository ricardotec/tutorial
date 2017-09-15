<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class AdministradorController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
    	//Check if the variable is defined 
    	if ($this->session->has("login")) {
    	}
    	else
    	{
            $this->response->redirect("");
    	}

        $tabla = $this->modelsManager->createBuilder()
            ->from('Reporte')
            ->join('Usuarios')//recordemos que no necesitamos hacer la on
            ->join('Status')//recordemos que no necesitamos hacer la on
            ->join('Prioridad')//recordemos que no necesitamos hacer la on
            ->inwhere('Reporte.id_status', [0,1,2,3,4])
            ->columns("Usuarios.nombre as Uname,paterno,materno, Reporte.nombre as Reporte,descripcion,fecha_inicio,fecha_limite,
                Status.nombre as Estado, Prioridad.id_prioridad,prioridad")
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
     * Displays the creation form
     */
    public function registroAction()
    {
    	//Check if the variable is defined 
    	if ($this->session->has("login")) {
    	}
    	else
    	{
            $this->response->redirect("");
    	}
    }

    /**
     * Crear un nuevo usuario
     */
    public function createAction()
    {
    	//Check if the variable is defined 
    	if ($this->session->has("login")) {
    	}
    	else
    	{
            $this->response->redirect("");
    	}

        if (!$this->request->isPost()) {
            $this->response->redirect("administrador");
        }

        $Usuario = new Usuarios();
        $Usuario->setLogin($this->request->getPost("login"));

        $User = Usuarios::findFirstBylogin($Usuario->login);

        if ($User) {

            $this->flash->error("El login ya exite");

            $this->dispatcher->forward([
                'controller' => "administrador",
                'action' => 'registro'
            ]);
        }
        else
        {
        	$Usuario->setNombre($this->request->getPost("nombre"));
	        $Usuario->setPaterno($this->request->getPost("paterno"));
	        $Usuario->setMaterno($this->request->getPost("materno"));
	        $Usuario->setPass($this->request->getPost("pass"));
	        $Usuario->setIdRol($this->request->getPost("id_rol"));

	        if (!$Usuario->save()) {
	            foreach ($Usuario->getMessages() as $message) {
	                $this->flash->error($message);
	            }

                $this->response->redirect("administrador/registro");
	        }
	        else
	        {
	        	$this->tag->setDefault('login', '');
		        $this->tag->setDefault('nombre', '');
		        $this->tag->setDefault('paterno', '');
		        $this->tag->setDefault('materno', '');
		        $this->tag->setDefault('pass', '');

		        $this->flash->success("Registro Exitoso");

		        $this->dispatcher->forward([
		            'controller' => "administrador",
		            'action' => 'registro'
		        ]);
	        }
        }
    }

    /**
     * Busqueda de usuarios
     */
    public function consultaAction()
    {
    	//Check if the variable is defined 
    	if ($this->session->has("login")) {
    	}
    	else
    	{
            $this->response->redirect("");
    	}

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Usuarios', $_POST);
            $this->persistent->parameters = $query->getParams();
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id_usuario";

        $Usuarios = Usuarios::find($parameters);
        if (count($Usuarios) == 0) {
            $this->flash->notice("El usuario no se encontro");

            $this->dispatcher->forward([
                "controller" => "administrador",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $Usuarios,
            'limit'=> 100
            //'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Vista de reporte
     */
    public function reporteAction()
    {
        //Check if the variable is defined 
        if ($this->session->has("login")) {
        }
        else
        {
            $this->response->redirect("");
        }

        $prioridad = Prioridad::find();

        $this->view->prioridad = $prioridad;
    }

    /**
     * Crear reporte
     */
    public function reportAction()
    {
    	//Check if the variable is defined 
    	if ($this->session->has("login")) {
    	}
    	else
    	{
            $this->response->redirect("");
    	}

        if (!$this->request->isPost()) {

            $this->response->redirect("administrador");
        }

        $nombre = $this->request->getPost("nombre");
        $nombre = str_replace(' ','_',$nombre);

        $carpeta = "files/".$nombre."".date('Ymd_his');

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $Reporte = new Reporte();

        //comprueba si hay archivos por subir
        if ($this->request->hasFiles() == true) 
        {
            // Print the real file names and sizes
            foreach ($this->request->getUploadedFiles() as $file) {
 
                //guardamos dentro del directorio img
                $file->moveTo($carpeta.'/' . $file->getName());
            }

            $Reporte->archivo = $file->getName();
            $Reporte->ruta = $carpeta;
        }

        $Reporte->setNombre($this->request->getPost("nombre"));
        $Reporte->setDescripcion($this->request->getPost("descripcion"));
        $Reporte->setSucursal($this->request->getPost("sucursal"));
        $Reporte->setSistema($this->request->getPost("sistema"));
        $Reporte->fecha_inicio = date('Y-m-d');
        $Reporte->setFechaLimite($this->request->getPost("fecha_limite"));
        $Reporte->id_usuario = "0";
        $Reporte->id_status = "1";
        $Reporte->setIdPrioridad($this->request->getPost("id_prioridad"));

        if (!$Reporte->save()) {
            foreach ($Reporte->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "administrador",
                'action' => 'reporte'
            ]);

            return;
        }
	    else
	    {
		    $this->tag->setDefault('nombre', '');
		    $this->tag->setDefault('descripcion', '');
		    $this->tag->setDefault('fecha_limite', '');

		    $this->flash->success("Registro Exitoso");

		    $this->dispatcher->forward([
		        'controller' => "administrador",
		        'action' => 'reporte'
		    ]);
        }
    }

    /**
     * Editar a usuario
     *
     * @param string $id_usuario
     */
    public function actualizarAction($id_usuario)
    {
    	//Check if the variable is defined 
    	if ($this->session->has("login")) {
    	}
    	else
    	{
            $this->response->redirect("");
    	}

        if (!$this->request->isPost()) {

            $Usuario = Usuarios::findFirstByid_usuario($id_usuario);
            if (!$Usuario) {
                $this->flash->error("usuario no encontrado");

                $this->dispatcher->forward([
                    'controller' => "administrador",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id_usuario = $Usuario->getIdUsuario();

            $this->tag->setDefault("id_usuario", $Usuario->getIdUsuario());
            $this->tag->setDefault("login", $Usuario->getLogin());
            $this->tag->setDefault("nombre", $Usuario->getNombre());
            $this->tag->setDefault("paterno", $Usuario->getPaterno());
            $this->tag->setDefault("materno", $Usuario->getMaterno());
            $this->tag->setDefault("pass", $Usuario->getPass());
            $this->tag->setDefault("id_rol", $Usuario->getIdRol());
            
        }
    }

    /**
     * Saves a usuario edited
     *
     */
    public function actualizaAction()
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

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "administrador",
                'action' => 'index'
            ]);

            return;
        }

        $id_usuario = $this->request->getPost("id_usuario");
        $Usuario = Usuarios::findFirstByid_usuario($id_usuario);

        if (!$Usuario) {
            $this->flash->error("usuario no existe " . $id_usuario);

            $this->dispatcher->forward([
                'controller' => "administrador",
                'action' => 'index'
            ]);

            return;
        }

        $Usuario->setLogin($this->request->getPost("login"));
        $Usuario->setNombre($this->request->getPost("nombre"));
        $Usuario->setPaterno($this->request->getPost("paterno"));
        $Usuario->setMaterno($this->request->getPost("materno"));
        $Usuario->setPass($this->request->getPost("pass"));
        $Usuario->setIdRol($this->request->getPost("id_rol"));
        
        if (!$Usuario->save()) {

            foreach ($Usuario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "administrador",
                'action' => 'actualizar',
                'params' => [$Usuario->getIdUsuario()]
            ]);

            return;
        }

        $this->flash->success("usuario se actualizo");

        $this->dispatcher->forward([
            'controller' => "administrador",
            'action' => 'index'
        ]);
    }

    /**
     * Vista de incidencias terminadas
     */
    public function terminadoAction()
    {
        //Check if the variable is defined 
        /*if ($this->session->has("login")) {
        }
        else
        {
            $this->response->redirect("");
        }*/
        $this->view->hola="soy un mensaje";

        /*$this->view->terminado = */$terminado = $this->modelsManager->createBuilder()
            ->from('Reporte')
            ->join('Usuarios')//recordemos que no necesitamos hacer la on
            ->join('Status')//recordemos que no necesitamos hacer la on
            ->join('Prioridad')//recordemos que no necesitamos hacer la on
            ->inWhere('Reporte.id_status',[5])
            ->columns("concat (Usuarios.nombre,paterno,materno) as nombreC, Reporte.nombre as Reporte,descripcion,sucursal,sistema,fecha_inicio,fecha_limite,
                Status.nombre as Estado,prioridad")
            ->getQuery()
            ->execute();

        //$this->view->disable();
    }
}