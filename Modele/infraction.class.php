<?php
class Infraction {
    private $id_inf;
    private $date_inf;
    private $no_immat;
    private $no_permis;
    
    function __construct(string $id_inf= '', string $date_inf = '', string $no_immat='', string $no_permis=''){
        $this-> id_inf = $id_inf;
        $this-> date_inf = $date_inf;
        $this->no_immat = $no_immat;
        $this->no_permis = $no_permis;
    }

    function getIdInf(): string {return $this -> id_inf;}
    function setIdInf(string $id_inf){$this->id_inf = $id_inf;}
    function getDateInf(): string {return $this -> date_inf;}
    function setDateInf(string $date_inf){$this->date_inf = $date_inf;}
    function getNumImmat(): string {return $this -> no_immat;}
    function setNumImmat(string $no_immat){$this->no_immat = $no_immat;}
    function getNoPermis(): string {return $this -> no_permis;}
    function setNoPermis(string $no_permis){$this->no_permis = $no_permis;}
}

?>