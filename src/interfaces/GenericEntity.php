<?php
namespace Interfaces;

interface GenericEntity
{
    public function getPkValue();
    public function setPkValue($value);
    public function getTableName();
    public function toArray($deep = false);
}
