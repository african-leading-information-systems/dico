<?php


namespace Alis\Dico;


interface DicoContract
{
    public function hasConstraint(): bool;

    public function scopeGetByTypeCodes($query, $codes);
}
