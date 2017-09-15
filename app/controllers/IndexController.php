<?php
use LoginForm as FormLogin;

class IndexController extends ControllerBase
{
    public function indexAction()
    {

    	$form = new FormLogin();
		$login = $this->request->getPost('login', array('striptags', 'trim'));
    	$password = $this->request->getPost('password', array('striptags', 'trim'));
 
		//si es una petición post
		if ($this->request->isPost()) 
		{
			//si el formulario no pasa la validación que le hemos impuesto
			if ($form->isValid($this->request->getPost()) == false) 
			{
				//mostramos los mensajes con la clase error que hemos personalizado en los mensajes flash
				foreach ($form->getMessages() as $message) 
				{
					$this->flash->error($message);
				}
			}
			else 
			{
				//obtenemos al usuario por su login
				$usuario = Usuarios::findFirstByLogin($login);

				//si existe el usuario buscado por login
				if ($usuario)
				{
		         	//si el password que hay en la base de datos coincide con el que ha
		         	//ingresado encriptado, le damos luz verde, los datos son correctos
		            //if ($this->security->checkHash($password, $usuario->pass))
		            if ($usuario->pass == $password)
		            {
		            	if ($usuario->id_rol == 1)
		            	{
		            		//creamos la sesión del usuario con su login
			             	$this->session->set("login", $usuario->login);
			                $this->session->set("password", $usuario->pass);
	 						return $this->response->redirect('administrador');
		            	}
		            	else
		            	if ($usuario->id_rol == 2) 
		            	{
		            		//creamos la sesión del usuario con su login
			             	$this->session->set("login", $usuario->login);
			                $this->session->set("password", $usuario->pass);
	 						return $this->response->redirect('soporte');
		            	}
		            	else
		            	if ($usuario->id_rol == 3) 
		            	{
		            		//creamos la sesión del usuario con su login
			             	$this->session->set("login", $usuario->login);
			                $this->session->set("password", $usuario->pass);
	 						return $this->response->redirect('programador');
		            	}
		            }
		            else
		            {
             			//esto es horrible, nunca le déis esta información a un usuario, es para el tuto
             			$this->flash->error("Los datos estan equivocados");
             		}
         		}
         		else
         		{
         			//esto es horrible, nunca le déis esta información a un usuario, es para el tuto
         			$this->flash->error("El usuario no ha sido encontrado en la base de datos");
         		}
 			}
 		}
		$this->view->form = new FormLogin();
    }

    /**
	* @desc - renderiza la vista index/criteria, si es una petición post hace uso de criteria y devuelve un objeto
	*/
	public function criteriaAction()
	{
	 if ($this->request->isPost()) 
	 {
	        $query = Phalcon\Mvc\Model\Criteria::fromInput($this->di, 'Posts', $this->request->getPost());
	 
	        $this->persistent->searchParams = $query->getParams();
	 
	        if($this->persistent->searchParams) 
	        {
	            $this->view->posts = Posts::find($this->persistent->searchParams);
	        }
	        else
	        {
	        	$this->view->posts = "";
	        }
	    }
	    else
	    {
	    	$this->view->posts = "";
	    }
	}
}

