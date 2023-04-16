<?php
require_once("connexion.php");
require_once("infraction.class.php");
require_once("delit.class.php");

class InfractionDAO
{
	private $bd;
	private $select;

	function __construct()
	{
		$this->bd = new Connexion();
		$this->select = 'SELECT id_inf, no_immat, date_inf, no_permis FROM infraction ORDER BY id_inf';
	}

	function insert(Infraction $Infraction): void
	{
		$this->bd->execSQL(
			"INSERT INTO infraction (id_inf, date_inf, no_immat, no_permis)
                                        VALUES (:date_inf, :no_immat, :no_permis)",
			[':id_inf' => $Infraction->getIdInf(), ':date_inf' => $Infraction->getDateInf(), ':no_immat' => $Infraction->getNumImmat(), ':no_permis' => $Infraction->getNoPermis()]
		);
	}

	function delete(string $id_inf): void
	{
		$this->bd->execSQL(
			"DELETE FROM infraction WHERE id_inf = :idInf",
			[':idInf' => $id_inf]
		);
	}

	function update(Infraction $Infraction): void
	{
		$this->bd->execSQL(
			"UPDATE infraction SET date_inf=:date_inf, no_immat=:no_immat , no_permis=:no_permis WHERE id_inf=:id_inf",
			[
				':date_inf' => $Infraction->getDateInf(), ':no_immat' => $Infraction->getNumImmat(), ':no_permis' => $Infraction->getNoPermis(), ':id_inf' => $Infraction->getIdInf()
			]
		);
	}

	private function loadQuery(array $result): array
	{
		$Infractions = [];
		foreach ($result as $row) {
			$Infraction = new Infraction();
			$Infraction->setIdInf($row['id_inf']);
			$Infraction->setDateInf($row['date_inf']);
			$Infraction->setNumImmat($row['no_immat']);
			$Infraction->setNoPermis($row['no_permis']);
			
			$Infractions[] = $Infraction;
		}
		return $Infractions;
	}

	function getAll(): array
	{
		return ($this->loadQuery($this->bd->execSQL($this->select)));
	}

	function getById(string $id_inf): Infraction
	{
		$uneInfraction = new Infraction();
		$lesInfractions = $this->loadQuery($this->bd->execSQL("SELECT id_inf, no_immat, date_inf, no_permis FROM infraction WHERE
			  id_inf= :id", [":id" => $id_inf]));
		if (count($lesInfractions) > 0) {
			$uneInfraction = $lesInfractions[0];
		}
		return $uneInfraction;
	}

	function existe(string $id): bool | null
	{
		$req 	= "SELECT *  FROM  infraction
					   WHERE id_inf = :id";
		$res 	= ($this->loadQuery($this->bd->execSQL($req, [':id' => $id])));
		return ($res != []);
	}



	function getNomPermis(string $noPermis): array | null
	{
		$arrayInf = $this->bd->execSQL(" SELECT * FROM infraction WHERE no_permis = :noPermis  ", [':noPermis' => $noPermis]);

		$infras = array();
		foreach ($arrayInf as $inf) {
			$infra = new Infraction($inf['id_inf'], $inf['date_inf'], $inf['no_immat'], $inf['no_permis']);
			$infras[] = $infra;
		}
		return $infras;
	}

	function getDetail(string $id)
	{
		return ($this->bd->execSQL("SELECT concat('   Infraction: ',id_inf ,'  du : ',date_format( date_inf , '%d/%d/%Y')
		,'    véhicule : ' ,v.no_immat ,'   ',   v.marque ,' ' , v.modele ,'   imatriculé  le : ' 
		,date_format( v.date_immat  , '%d/%d/%Y') ) as véhicule 

		, concat('   Propriétaire:  ' ,co.nom ,'  ' , co.prenom , '   N° premis : ',co.no_permis, '  obtenu le : ' 
		,date_format( co.date_permis , '%d/%d/%Y') ) as propriétaire ,

		concat ('   Conducteur : ' , c.nom ,'  ' , c.prenom , ' N° premis : ',c.no_permis, ' obtenu le : '
		,date_format( c.date_permis , '%d/%d/%Y')) as conducteur
		
		FROM  infraction i 
        	inner join  vehicule v  on i.no_immat = v.no_immat 
			inner join  conducteur c on c.no_permis = i.no_permis
			inner join  conducteur co on v.no_permis =co.no_permis 
			where id_inf = :id ", [':id' => $id]));
	}

	function getTotalMontantInfByTd(string $id): int|null
	{
		$res = $this->bd->execSQL("SELECT SUM(montant) as total FROM comprend, infraction, delit
		WHERE infraction.id_inf = comprend.id_inf
					AND delit.id_delit = comprend.id_delit 
					AND infraction.id_inf = :id", [':id' => $id]);
		return $res[0]['total'];
	}
	function getMontant(string $id)
	{
		$res = $this->bd->execSQL("SELECT sum(d.montant) as total
		from delit d, infraction i, comprend c
		where i.id_inf=c.id_inf
		and c.id_delit=d.id_delit 
		and i.id_inf=.id",[':id' => $id]);
		return $res[0]['total'];
	}
}
