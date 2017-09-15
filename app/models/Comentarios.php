<?php

class Comentarios extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id_comentario;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $comentario;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $fecha_comentario;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id_reporte;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id_usuario;

    /**
     * Method to set the value of field id_comentario
     *
     * @param integer $id_comentario
     * @return $this
     */
    public function setIdComentario($id_comentario)
    {
        $this->id_comentario = $id_comentario;

        return $this;
    }

    /**
     * Method to set the value of field comentario
     *
     * @param string $comentario
     * @return $this
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Method to set the value of field fecha_comentario
     *
     * @param string $fecha_comentario
     * @return $this
     */
    public function setFechaComentario($fecha_comentario)
    {
        $this->fecha_comentario = $fecha_comentario;

        return $this;
    }

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
     * Returns the value of field id_comentario
     *
     * @return integer
     */
    public function getIdComentario()
    {
        return $this->id_comentario;
    }

    /**
     * Returns the value of field comentario
     *
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Returns the value of field fecha_comentario
     *
     * @return string
     */
    public function getFechaComentario()
    {
        return $this->fecha_comentario;
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
     * Returns the value of field id_usuario
     *
     * @return integer
     */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sistema");
        $this->setSource("comentarios");
        $this->belongsTo('id_usuario', '\Usuarios', 'id_usuario', ['alias' => 'Usuarios']);
        $this->belongsTo('id_reporte', '\Reporte', 'id_reporte', ['alias' => 'Reporte']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'comentarios';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Comentarios[]|Comentarios|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Comentarios|\Phalcon\Mvc\Model\ResultInterface
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
            'id_comentario' => 'id_comentario',
            'comentario' => 'comentario',
            'fecha_comentario' => 'fecha_comentario',
            'id_reporte' => 'id_reporte',
            'id_usuario' => 'id_usuario'
        ];
    }

}
