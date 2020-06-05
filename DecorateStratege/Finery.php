<?php


class Finery extends Person
{
    protected $compent;

    public function Decorate(Person $compent)
    {
        $this->compent = $compent;
    }

    public function show()
    {
        if ($this->compent != NULL) {
            ($this->compent)->show();
        }
    }
}