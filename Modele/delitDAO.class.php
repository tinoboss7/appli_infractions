<?php
    require_once("connexion.php");
    require_once("delit.class.php");

    class DelitDAO{
        private $bd;
        private $select; 

		function __construct()
		{
		    $this->bd=new Connexion();
            $this->select = 'SELECT id_delit, nature, montant FROM delit ';
		}

        function insert (Delit $Delit) : void {
            $this->bd->execSQL("INSERT INTO delit (nature, montant)
                                        VALUES (:nature, :montant)"
								,[':nature'=>$Delit->getNature(),':montant'=>$Delit->getMontant() ] );
		}

        function delete (string $id_delit) : void	{
            $this->bd->execSQL("DELETE FROM delit WHERE id_delit = :id_delit"
								,[':id_delit'=>$id_delit ] );
		}

        function update (Delit $Delit) : void
		{
			$this->bd->execSQL("UPDATE delit SET nature=:nature, montant=:montant WHERE id_delit=:id"
								,[':nature'=>$Delit->getNature(), ':montant'=>$Delit->getMontant(), ':id'=>$Delit->getIdDelit() ] );			 						
		}

        private function loadQuery (array $result) : array	{
			$Delits = [];
			foreach($result as $row)
			{
				$Delit = new Delit();
				$Delit->setIdDelit($row['id_delit']);
				$Delit->setNature($row['nature']);
				$Delit->setMontant($row['montant']);
				$Delits[] = $Delit; 
			}
			return $Delits;
		}

        function getAll () : array	{
			return	($this->loadQuery($this->bd->execSQL($this->select)));	
		}

		function getByNumInf( string $numInf): array | null {
			$this->select = $this->bd->execSQL("SELECT id_delit FROM comprend WHERE id_inf=:inf", [':inf' => $numInf]);
			if (empty($this->select)) {
				return null;
			}
			$delits = [];
	
			foreach($this->select as $del) {
				$delit = $this->bd->execSQL("SELECT * FROM delit WHERE id_delit=:numDelit", [':numDelit' => $del['id_delit']]);
				$delits[] = new Delit($delit[0]['id_delit'], $delit[0]['nature'], $delit[0]['montant']);
			}
			return $delits;
		}

        function getById ($id_delit) : Delit	{
			$unDelit= new Delit();
      		$lesDelits = $this->loadQuery($this->bd->execSQL($this->select ." WHERE id_delit=:id_delit", [':id_delit'=>$id_delit]) );
      		if (count($lesDelits) > 0) { $unDelit = $lesDelits[0];	}	
    		return $unDelit;
		}	

        function existe (string $id_delit) : bool {
			$req 	= "SELECT *  FROM  delit
					   WHERE id_delit = :id_delit";
			$res 	= ($this->loadQuery($this->bd->execSQL($req,[':id'=>$id_delit])));	
			return ($res != []);
		}

		function getNatureDelit(string $NatureDelit){
		return ($this->loadQuery($this->bd->execSQL($this->select
			. " WHERE id_delit NOT IN (SELECT id_delit FROM delit WHERE nature=:nature)", [':nature' => $NatureDelit])));
		}

		function deleteDelitDuneInfraction($idInfraction , $idDelit){
        	$this->bd->execSQL(" DELETE from comprend 
        	where  id_inf=:idInfraction
        	and id_delit=:idDelit",[':idInfraction' => $idInfraction,':idDelit'=>$idDelit]);
    	}
    }
?>