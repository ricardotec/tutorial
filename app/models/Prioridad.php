<?php

class Prioridad extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id_prioridad;

    /**
     *
     * @var string
     * @Column(type="string", length=10, nullable=false)
     */
    public $prioridad;

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
     * Method to set the value of field prioridad
     *
     * @param integer $prioridad
     * @return $this
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;

        return $this;
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
     * Returns the value of field prioridad
     *
     * @return integer
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("sistema");
        $this->setSource("Prioridad");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Prioridad';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Prioridad[]|Prioridad|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
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
            'id_prioridad' => 'id_prioridad',
            'prioridad' => 'prioridad'
        ];
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Prioridad|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
