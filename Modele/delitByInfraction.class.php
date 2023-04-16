<?php
	require_once("../modele/delit.class.php");
    require_once("../modele/infraction.class.php");
    

class DelitByInfraction {
    private $id_inf;
    private $delit;
    

    function __construct(Delit $delit=null, Infraction $id_inf= null) {
        $this->id_inf = $id_inf;
        $this->delit = $delit;
    }

    function getId() : Infraction{ return $this->id_inf;}
    function setId(string $id){ $this->id_inf=$id; }
    function getDelit() : Delit{ return $this->delit;}
    function setDelit(Delit $delit){ $this->delit=$delit; }
}
?>
