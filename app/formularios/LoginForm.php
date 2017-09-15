<?php
use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\Password,
	Phalcon\Forms\Element\Submit,
	Phalcon\Forms\Element\Hidden,
	Phalcon\Validation\Validator\PresenceOf,
	Phalcon\Validation\Validator\Identical;
 
class LoginForm extends Form
{
 
	public function initialize()
	{
		//añadimos el campo login
		$login = new Text('login', array(
			'placeholder' => 'Usuario'
		));
 
		//añadimos la validación para un campo de tipo login y como campo requerido
		$login->addValidator(
		new PresenceOf(array(
			'message' => 'El usuario es requerido'
		))
		);
 
		//label para el login
		$login->setLabel('Usuario');
		 
		//hacemos que se pueda llamar a nuestro campo login
		$this->add($login);
		 
		//añadimos el campo password
		$password = new Password('password', array(
			'placeholder' => 'Contraseña'
		));
 
		//añadimos la validación como campo requerido al password
		$password->addValidator(
		new PresenceOf(array(
			'message' => 'La contraseña es requerido'
		))
		);
		 
		//label para el Password
		$password->setLabel('Contraseña');
		 
		//hacemos que se pueda llamar a nuestro campo password
		$this->add($password);

		//añadimos un botón de tipo submit
		$entrar = $this->add(new Submit('Entrar', array(
			'class' => 'btn btn-success'
		)));
	}
}