<?php

class Reporte extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id_reporte;

    /**
     *
     * @var string
     * @Column(type="string", length=30, nullable=false)
     */
    protected $nombre;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $descripcion;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $sucursal;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $sistema;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $fecha_inicio;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $fecha_limite;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id_usuario;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id_status;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id_prioridad;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $archivo;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $ruta;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $archivo_viejo;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $archivo_nuevo;

    /**
     * Method to set the value of field id_reporte
     *
     * @param integer $id_reporte
     * @return $this
     */
    public function setIdReporte($id_reporte)
    {
        $this->id_reporte = $id_reporte;

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
     * Method to set the value of field descripcion
     *
     * @param string $descripcion
     * @return $this
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Method to set the value of field sucursal
     *
     * @param string $sucursal
     * @return $this
     */
    public function setSucursal($sucursal)
    {
        $this->sucursal = $sucursal;

        return $this;
    }

    /**
     * Method to set the value of field sistema
     *
     * @param string $sistema
     * @return $this
     */
    public function setSistema($sistema)
    {
        $this->sistema = $sistema;

        return $this;
    }

    /**
     * Method to set the value of field fecha_inicio
     *
     * @param string $fecha_inicio
     * @return $this
     */
    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    /**
     * Method to set the value of field fecha_limite
     *
     * @param string $fecha_fin
     * @return $this
     */
    public function setFechaLimite($fecha_limite)
    {
        $this->fecha_limite = $fecha_limite;

        return $this;
    }

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
     * Method to set the value of field id_status
     *
     * @param integer $id_status
     * @return $this
     */
    public function setIdStatus($id_status)
    {
        $this->id_status = $id_status;

        return $this;
    }

    /**
     * Method to set the value of field id_prioridad
     *
     * @param integer $id_prioridad
     * @return $this
     */
    public function setIdPrioridad($id_prioridad)
    {
        $this->id_prioridad = $id_prioridad;

        return $this;
    }

    /**
     * Method to set the value of field archivo
     *
     * @param string $archivo
     * @return $this
     */
    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;

        return $this;
    }

    /**
     * Method to set the value of field ruta
     *
     * @param string $ruta
     * @return $this
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;

        return $this;
    }

    /**
     * Method to set the value of field archivo
     *
     * @param string $archivo_viejo
     * @return $this
     */
    public function setArchivoViejo($archivo_viejo)
    {
        $this->archivo_viejo = $archivo_viejo;

        return $this;
    }

    /**
     * Method to set the value of field archivo
     *
     * @param string $archivo_nuevo
     * @return $this
     */
    public function setArchivoNuevo($archivo_nuevo)
    {
        $this->archivo_nuevo = $archivo_nuevo;

        return $this;
    }

    /**
     * Returns the value of field id_reporte
     *
     * @return integer
     */
    public function getIdReporte()
    {
        return $this->id_reporte;
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
     * Returns the value of field descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Returns the value of field sucursal
     *
     * @return string
     */
    public function getSucursal()
    {
        return $this->sucursal;
    }

    /**
     * Returns the value of field sistema
     *
     * @return string
     */
    public function getSistema()
    {
        return $this->sistema;
    }

    /**
     * Returns the value of field fecha_inicio
     *
     * @return string
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * Returns the value of field fecha_limite
     *
     * @return string
     */
    public function getFechaLimite()
    {
        return $this->fecha_limite;
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
     * Returns the value of field id_status
     *
     * @return integer
     */
    public function getIdStatus()
    {
        return $this->id_status;
    }

    /**
     * Returns the value of field id_prioridad
     *
     * @return integer
     */
    public function getIdPrioridad()
    {
        return $this->id_prioridad;
    }

    /**
     * Returns the value of field archivo
     *
     * @return string
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * Returns the value of field ruta
     *
     * @return string
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Returns the value of field archivo_viejo
     *
     * @return string
     */
    public function getArchivoViejo()
    {
        return $this->archivo_viejo;
    }

    /**
     * Returns the value of field archivo_nuevo
     *
     * @return string
     */
    public function getArchivoNuevo()
    {
        return $this->archivo_nuevo;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sistema");
        $this->setSource("reporte");
        $this->belongsTo('id_usuario', '\Usuarios', 'id_usuario', ['alias' => 'Usuarios']);
        $this->belongsTo('id_status', '\Status', 'id_status', ['alias' => 'Status']);
        $this->belongsTo('id_prioridad', '\Prioridad', 'id_prioridad', ['alias' => 'Prioridad']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Reporte[]|Reporte|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Reporte|\Phalcon\Mvc\Model\ResultInterface
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
            'id_reporte' => 'id_reporte',
            'nombre' => 'nombre',
            'descripcion' => 'descripcion',
            'sucursal' => 'sucursal',
            'sistema' => 'sistema',
            'fecha_inicio' => 'fecha_inicio',
            'fecha_limite' => 'fecha_limite',
            'id_usuario' => 'id_usuario',
            'id_status' => 'id_status',
            'id_prioridad' => 'id_prioridad',
            'archivo' => 'archivo',
            'ruta' => 'ruta',
            'archivo_viejo' => 'archivo_viejo',
            'archivo_nuevo' => 'archivo_nuevo'
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
        return 'reporte';
    }

}
