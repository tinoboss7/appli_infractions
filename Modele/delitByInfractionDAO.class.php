<?php
	require_once("connexion.php");
    require_once("delitByInfraction.class.php");
	require_once("delitDAO.class.php");
	require_once("infractionDAO.class.php");
	
	class DelitByInfractionDAO{
        private $bd;
        private $select; 

		function __construct()
		{
		    $this->bd=new Connexion();
            $this->select = 'SELECT id_inf, id_delit 
							FROM comprend';
		}

        function insert (DelitByInfraction $delitByInfraction) : void {
            $this->bd->execSQL("INSERT INTO comprend (id_inf, id_delit)
                                        VALUES (:idInf, :idDelit)"
								,[':idInf'=>$delitByInfraction->getId()->getIdInf(), ':idDelit'=>$delitByInfraction->getDelit()->getIdDelit() ] );
		}

		function insertDelitByInfraction(int $idInf, array $idDelits){
			foreach($idDelits as $IdDelit){
				$this->bd->execSQL("INSERT INTO comprend (id_delit, id_inf) VALUES (:idDelit, :idInf)", [':idDelit'=>$IdDelit, ':idInf' =>$idInf]);
			}
		}

		function deleteByIdInfByIdDelit (string $idInf, string $idDelit) : void	{
            $this->bd->execSQL("DELETE FROM comprend WHERE id_inf = :idInf AND id_delit=:idDelit"
								,[':idInf'=>$idInf, ':idDelit'=>$idDelit ] );
		}

		function deleteByIdInf (string $idInf) : void	{
            $this->bd->execSQL("DELETE FROM comprend WHERE id_inf = :idInf"
								,[':idInd'=>$idInf ] );
		}
		function deleteByIdDelit (string $idDelit) : void	{
            $this->bd->execSQL("DELETE FROM comprend WHERE id_Delit = :idDelit"
								,[':idDelit'=>$idDelit ] );
		}



		private function loadQuery (array $result) : array	{
			$infractionDAO = new InfractionDAO();
			$lesDelitByInfraction = [];
			foreach($result as $row)
			{
				$infraction = $infractionDAO->getById($row['id_delit']);
				$lesDelitByInfraction[]= new DelitByInfraction($row['id_inf'],$infraction);
			}
			return $lesDelitByInfraction;
		}

		function getAll () : array	{
			return	($this->loadQuery($this->bd->execSQL($this->select)));	
		}

		function getByidInf (string $idInf) : array	{
			return	($this->loadQuery($this->bd->execSQL($this->select ." WHERE id_delit=:idDelit", [':idInf'=>$idInf]) ));
		}	

		function getByidDelit (string $idDelit) : array	{
			return	($this->loadQuery($this->bd->execSQL($this->select ." WHERE id_inf=:idInf", [':idDelit'=>$idDelit]) ));
		}	
	
		function getByidInfByIdDelit (string $idInf, string $idDelit) : DelitByInfraction	{
			return	($this->loadQuery($this->bd->execSQL($this->select ." AND id_inf=:idInf AND id_delit=:idDleit"
									, [':idInf'=>$idInf, ':idDelit'=>$idDelit] )))[0];
		}	

		function getLesDelitByIdInf( $id){
			return	($this->bd->execSQL(" SELECT d.id_delit , d.nature , d.montant from  comprend 
			inner join  infraction on infraction.id_inf = comprend.id_inf
			inner join delit  d on comprend.id_delit = d.id_delit where infraction.id_inf = :id ", [':id' => $id] ));
		}

    }
?>
