<?php

class Tramo
{
    private $id;
    private $hora;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of hora
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set the value of hora
     */
    public function setHora($hora): self
    {
        $this->hora = $hora;

        return $this;
    }
}
