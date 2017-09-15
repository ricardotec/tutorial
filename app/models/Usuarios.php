<?php
use Phalcon\Validation\Validator\PresenceOf;

class Usuarios extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id_usuario;

    /**
     *
     * @var string
     * @Column(type="string", length=15, nullable=false)
     */
    protected $login;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $nombre;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $paterno;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $materno;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $pass;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id_rol;

    /**
     * Method to set the value of field id_usuario
     *
     * @param integer $id_usuario
     * @return $this
     */
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    /**
     * Method to set the value of field login
     *
     * @param string $login
     * @return $this
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Method to set the value of field nombre
     *
     * @param string $nombre
     * @return $this
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Method to set the value of field paterno
     *
     * @param string $paterno
     * @return $this
     */
    public function setPaterno($paterno)
    {
        $this->paterno = $paterno;

        return $this;
    }

    /**
     * Method to set the value of field materno
     *
     * @param string $materno
     * @return $this
     */
    public function setMaterno($materno)
    {
        $this->materno = $materno;

        return $this;
    }

    /**
     * Method to set the value of field pass
     *
     * @param integer $pass
     * @return $this
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Method to set the value of field id_rol
     *
     * @param integer $id_rol
     * @return $this
     */
    public function setIdRol($id_rol)
    {
        $this->id_rol = $id_rol;

        return $this;
    }

    /**
     * Returns the value of field id_usuario
     *
     * @return integer
     */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    /**
     * Returns the value of field login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Returns the value of field nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Returns the value of field paterno
     *
     * @return string
     */
    public function getPaterno()
    {
        return $this->paterno;
    }

    /**
     * Returns the value of field materno
     *
     * @return string
     */
    public function getMaterno()
    {
        return $this->materno;
    }

    /**
     * Returns the value of field pass
     *
     * @return integer
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Returns the value of field id_rol
     *
     * @return integer
     */
    public function getIdRol()
    {
        return $this->id_rol;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sistema");
        $this->setSource("usuarios");
        $this->hasMany('id_usuario', 'Reporte', 'id_usuario', ['alias' => 'Reporte']);
        $this->belongsTo('id_rol', '\Rol', 'id_rol', ['alias' => 'Rol']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarios[]|Usuarios|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarios|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'id_usuario' => 'id_usuario',
            'login' => 'login',
            'nombre' => 'nombre',
            'paterno' => 'paterno',
            'materno' => 'materno',
            'pass' => 'pass',
            'id_rol' => 'id_rol'
        ];
    }

    /*
    * @desc - personalizamos los mensajes para cada caso
    */
    public function getMessages($filter = NULL)
    {
        $messages = array();
        foreach (parent::getMessages() as $message) 
        {
            switch ($message->getType()) 
            {
 
                case 'PresenceOf':
                    $messages[] = 'El campo ' . $message->getField() . ' es obligatorio.';
                    break;
            }
        }
        return $messages;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuarios';
    }
}
