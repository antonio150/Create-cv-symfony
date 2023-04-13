<?php

namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;

class Common
{
    public $db;

    public function __construct($em)
    {
        $this->db = $em;
    }

    public function getInfoTable($table = "", $param = array(), $type = "find") {
        $reposLocation = $this->db->getRepository("App\\Entity\\" . $table);
        if ($type == "find") {
            $infoTable = $reposLocation->find($param);
        } else if ($type == "findby"){
            $infoTable = $reposLocation->findBy($param);
        } else if ($type == "findall"){
            $infoTable = $reposLocation->findAll();
        }
        return $infoTable;
    }
}