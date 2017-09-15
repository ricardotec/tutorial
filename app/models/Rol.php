<?php

class Rol extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id_rol;

    /**
     *
     * @var string
     * @Column(type="string", length=15, nullable=false)
     */
    protected $rol;

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
     * Method to set the value of field rol
     *
     * @param string $rol
     * @return $this
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
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
     * Returns the value of field rol
     *
     * @return string
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sistema");
        $this->setSource("rol");
        $this->hasMany('id_rol', 'Usuarios', 'id_rol', ['alias' => 'Usuarios']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'rol';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Rol[]|Rol|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Rol|\Phalcon\Mvc\Model\ResultInterface
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
            'id_rol' => 'id_rol',
            'rol' => 'rol'
        ];
    }

}
