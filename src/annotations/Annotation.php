<?php


namespace annotations;


interface Annotation{
    public function setProperties(array $positionProperties, array $namedProperties): void;
}