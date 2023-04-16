<?php
class Connexion {
	private $db;
	//private $db_admin;

	function __construct() {
		$db_config['SGBD']    = 'mysql';
		$db_config['HOST']    = 'localhost';
		$db_config['DB_NAME']  = 'ernoult4u_infraction';
		$db_config['USER']    = 'root';
		$db_config['PASSWORD']  = '';
		try
		{
			$this->db = new PDO($db_config['SGBD'] .':host='. $db_config['HOST'] .';dbname='. $db_config['DB_NAME'],
								$db_config['USER'],	$db_config['PASSWORD'],
								array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
								// permet d’afficher les caractères utf8 si la BdD est définie en utf8 (accents...)						
			unset($db_config);
		}
		catch( Exception $exception )
		{
			die($exception->getMessage()) ;
		}
	}

	function execSQL(string $req, array $valeurs=[]) : array {
		try
		{	
			$sql=$this->db->prepare($req); 
			$sql->execute($valeurs);
			return $sql->fetchAll(PDO::FETCH_ASSOC);// retourne uniquement chaque ligne sous forme d'un tableau associatif (clé) sinon retourne chaque ligne avec double colonne : indice et clé
		}
		catch( Exception $exception )
		{
			die($exception->getMessage()) ;
			$sql=[];
		}
		return $sql;
	}

	/*function estAdmin($login, $mdp) : bool {
		return ( $login==$this->db_admin['login']  and  $mdp==$this->db_admin['mdp'] );
	}*/

}	


?>
