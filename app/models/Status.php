<?php

class Status extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id_status;

    /**
     *
     * @var string
     * @Column(type="string", length=10, nullable=false)
     */
    public $nombre;

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
     * Method to set the value of field nombre
     *
     * @param integer $nombre
     * @return $this
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
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
     * Returns the value of field nombre
     *
     * @return integer
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sistema");
        $this->setSource("Status");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Status';
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
            'id_status' => 'id_status',
            'nombre' => 'nombre'
        ];
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Status[]|Status|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Status|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
