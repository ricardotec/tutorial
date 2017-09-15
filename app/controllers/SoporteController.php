<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class SoporteController extends \Phalcon\Mvc\Controller
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
            ->inWhere('Reporte.id_status', [0,1,2,3,4])
            ->columns("Usuarios.id_usuario,Usuarios.nombre as Uname,paterno,materno, Reporte.id_reporte,Reporte.nombre as Reporte,descripcion,sucursal,sistema,fecha_inicio,fecha_limite,
                Status.nombre as Estado,Status.id_status, Prioridad.id_prioridad,prioridad")
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
     * Formulario de registro de usuarios
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
     * Registro de usuarios
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
            $this->dispatcher->forward([
                'controller' => "soporte",
                'action' => 'index'
            ]);

            return;
        }

        $Usuario = new Usuarios();
        $Usuario->setLogin($this->request->getPost("login"));

        $User = Usuarios::findFirstBylogin($Usuario->login);

        if ($User) {

            $this->flash->error("El login ya exite");

            $this->dispatcher->forward([
                'controller' => "soporte",
                'action' => 'registro'
            ]);
        }
        else
        {
        	$Usuario->setNombre($this->request->getPost("nombre"));
	        $Usuario->setPaterno($this->request->getPost("paterno"));
	        $Usuario->setMaterno($this->request->getPost("materno"));
	        $Usuario->setPass($this->request->getPost("pass"));
	        $Usuario->id_rol = '2';

	        if (!$Usuario->save()) {
	            foreach ($Usuario->getMessages() as $message) {
	                $this->flash->error($message);
	            }

	            $this->dispatcher->forward([
	                'controller' => "soporte",
	                'action' => 'registro'
	            ]);

	            return;
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
		            'controller' => "soporte",
		            'action' => 'registro'
		        ]);
	        }
        }
    }

    /**
     * Editar usuario
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
            $this->dispatcher->forward([
                'controller' => "index",
                'action' => 'index'
            ]);
        }

        if (!$this->request->isPost()) {

            $Usuario = Usuarios::findFirstByid_usuario($id_usuario);
            if (!$Usuario) {
                $this->flash->error("usuario no encontrado");

                $this->dispatcher->forward([
                    'controller' => "soporte",
                    'action' => 'index'
                ]);

                return;
            }

            //$this->view->id_usuario = $Usuario->getIdUsuario();

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
     * Guardar cambios de usuario
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
                'controller' => "soporte",
                'action' => 'index'
            ]);

            return;
        }

        $id_usuario = $this->request->getPost("id_usuario");
        $Usuario = Usuarios::findFirstByid_usuario($id_usuario);

        if (!$Usuario) {
            $this->flash->error("usuario no existe " . $id_usuario);

            $this->dispatcher->forward([
                'controller' => "soporte",
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
                'controller' => "soporte",
                'action' => 'actualizar',
                'params' => [$Usuario->getIdUsuario()]
            ]);

            return;
        }

        $this->flash->success("usuario se actualizo");

        $this->dispatcher->forward([
            'controller' => "soporte",
            'action' => 'consulta'
        ]);
    }

    /**
     * Buscar usuarios
     */
    public function consultaAction()
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

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Usuarios', $_POST);
            $this->persistent->parameters = $query->getParams();
        }/* else {
            $numberPage = $this->request->getQuery("page", "int");
        }*/

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id_usuario";

        $Usuarios = Usuarios::find($parameters);
        if (count($Usuarios) == 0) {
            $this->flash->notice("The search did not find any usuarios");

            $this->dispatcher->forward([
                "controller" => "soporte",
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
     * Displays the creation form
     */
    public function newAction()
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

    }

    /**
     * Asignar actividad
     *
     * @param string $id_reporte
     */
    public function asignarAction($id_reporte)
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

            $Reporte = Reporte::findFirstByid_reporte($id_reporte);
            if (!$Reporte) {
                $this->flash->error("Error: No encontrado");

                $this->dispatcher->forward([
                    'controller' => "soporte",
                    'action' => 'index'
                ]);

                return;
            }

            $Prioridad = Prioridad::findFirstByid_prioridad($Reporte->getIdPrioridad());

            $usuario = $this->modelsManager->createBuilder()
                ->from('Usuarios')
                ->where('id_rol >= 2')
                ->columns("id_usuario, concat(nombre,' ',paterno,' ',materno) as nombreC")
                ->getQuery()
                ->execute();

            $this->view->usuario = $usuario;

            $ruta=$Reporte->getRuta();
            $archivo=$Reporte->getArchivo();
            $this->view->ruta = $ruta;
            $this->view->archivo = $archivo;

            $this->tag->setDefault("id_reporte", $Reporte->getIdReporte());
            $this->tag->setDefault("nombre", $Reporte->getNombre());
            $this->tag->setDefault("descripcion", $Reporte->getDescripcion());
            $this->tag->setDefault("prioridad", $Prioridad->getPrioridad());
            
        }
    }

    /**
     * Guardar cambios de la actividad
     *
     */
    public function saveAction()
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
                'controller' => "soporte",
                'action' => 'index'
            ]);

            return;
        }

        $id_reporte = $this->request->getPost("id_reporte");

        $Reporte = Reporte::findFirstByid_reporte($id_reporte);

        if (!$Reporte) {
            $this->flash->error("El reporte no existe " . $id_reporte);

            $this->dispatcher->forward([
                'controller' => "soporte",
                'action' => 'index'
            ]);

            return;
        }

        $Reporte->setIdUsuario($this->request->getPost("id_usuario"));
        $Reporte->id_status = '2';

        if (!$Reporte->save()) {

            foreach ($Reporte->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "soporte",
                'action' => 'asignar',
                'params' => [$Reporte->getIdReporte()]
            ]);

            return;
        }

        if ($this->request->getPost("comentario") != NULL) {
            
            $User = Usuarios::findFirstBylogin($this->session->get("login"));

            $Comentarios = new Comentarios();
            $Comentarios->setComentario($this->request->getPost("comentario"));
            $Comentarios->setIdReporte($this->request->getPost("id_reporte"));
            $Comentarios->fecha_comentario = date('Y-m-d');
            $Comentarios->setIdUsuario($User->id_usuario);

            if (!$Comentarios->save()) {
                foreach ($Comentarios->getMessages() as $message) {
                    $this->flash->error($message);
                }

                $this->dispatcher->forward([
                    'controller' => "soporte",
                    'action' => 'new'
                ]);

                return;
            }
        }

        $this->flash->success("Asignacion corecta!!");

        $this->dispatcher->forward([
            'controller' => "soporte",
            'action' => 'index'
        ]);
    }

    public function revisarAction($id_reporte)
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

            $Reporte = Reporte::findFirstByid_reporte($id_reporte);
            if (!$Reporte) {
                $this->flash->error("Error: No encontrado");

                $this->dispatcher->forward([
                    'controller' => "soporte",
                    'action' => 'index'
                ]);

                return;
            }

            $prioridad = Prioridad::findFirstByid_prioridad($Reporte->getIdPrioridad());

            $ruta=$Reporte->getRuta();
            $archivo=$Reporte->getArchivo();
            $archivoV=$Reporte->getArchivoViejo();
            $archivoN=$Reporte->getArchivoNuevo();
            $this->view->ruta = $ruta;
            $this->view->archivo = $archivo;
            $this->view->archivoV = $archivoV;
            $this->view->archivoN = $archivoN;

            $this->tag->setDefault("id_reporte", $Reporte->getIdReporte());
            $this->tag->setDefault("nombre", $Reporte->getNombre());
            $this->tag->setDefault("descripcion", $Reporte->getDescripcion());
            $this->tag->setDefault("id_prioridad", $prioridad->getPrioridad());
        }
    }

    public function descargarAction()
    {
        //echo $this->request->getPost("ruta1");

        //$archivo = "prueba.php";
        $dir = $_POST["ubicacion"];
        $archivo1 = $_POST["arch1"];
        $archivo2 = $_POST["arch2"];
        $filename = 'archivos.zip';

        $zip = new ZipArchive();
         
        if($zip->open($filename,ZIPARCHIVE::CREATE)===true) {
            $zip->addFile($dir.'/'.$archivo1, $archivo1);
            if ($archivo2!=NULL) {
                $zip->addFile($dir.'/'.$archivo2, $archivo2);
            }
            $zip->close();
        }

        rename ($filename,$dir."/".$filename);

        $ruta = $dir."/".$filename;
        $this->view->disable();
        echo $ruta;
        //unlink('files/Prueba_de_imagen20170911_014659/'.$filename);//Destruyearchivo temporal
    }

    /**
     * Creates a new reporte
     */
    public function comentariosAction()
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
                'controller' => "soporte",
                'action' => 'index'
            ]);

            return;
        }

        $id_usuario = Usuarios::findFirstBylogin($this->session->get("login"));

        $Comentarios = new Comentarios();
        $Comentarios->setComentario($this->request->getPost("comentario"));
        $Comentarios->setIdReporte($this->request->getPost("id_reporte"));
        $Comentarios->setIdUsuario($id_usuario->id_usuario);

        if (!$Comentarios->save()) {
            foreach ($Comentarios->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "soporte",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Comentario guardado");

        $this->dispatcher->forward([
            'controller' => "soporte",
            'action' => 'index'
        ]);
    }

        /**
     * Asignar tarea
     *
     */
    public function liberarAction()
    {
        //Check if the variable is defined 
        if ($this->session->has("login")) {
        }
        else
        {
            $this->response->redirect("");
        }

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "soporte",
                'action' => 'index'
            ]);

            return;
        }

        $id_reporte = $_POST['id_reporte'];

        $Reporte = Reporte::findFirstByid_reporte($id_reporte);

        if (!$Reporte) {
            $this->flash->error("reporte no existe " . $id_reporte);

            $this->dispatcher->forward([
                'controller' => "soporte",
                'action' => 'index'
            ]);

            return;
        }

        $Reporte->setIdStatus(5);        

        if (!$Reporte->save()) {

            foreach ($Reporte->getMessages() as $message) {
                $this->flash->error($message);
            }
        }

        $this->flash->success("Tarea liberada");

        $this->dispatcher->forward([
            'controller' => "soporte",
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
            ->columns("concat (Usuarios.nombre,paterno,materno) as nombreC, Reporte.nombre as Reporte,descripcion,sucursal,sistema,fecha_inicio,fecha_limite,
                Status.nombre as Estado,prioridad")
            ->getQuery()
            ->execute();

        $this->view->terminado = $terminado;
    }
}