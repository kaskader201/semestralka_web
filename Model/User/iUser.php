<?php

/**
 * Interface iUser
 * Definuje funkce/metody které jsou potřeba na objektu User a dalších
 */
interface iUser
{
    /**
     * Ulož objekt do DB
     * @return mixed
     */
    public function save();
    
    /**
     * Smaž objekt z DB
     * @return mixed
     */
    public function delete();
}