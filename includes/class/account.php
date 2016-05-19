<?
class Account{
	public $account_id;
	protected $email;
	private $password;
	protected $prodays;
	private $refeer_id;
	public $language;
	protected $permissions;
	public $flag;

	public function __construct($id){
		$this->account_id=$id;
	}
	public function setEmail($e):boolean{

	}
	public function getEmail():string{
		return $this->email;
	}
	public function getProDays():int{

	}
	private function setProDays($days):boolean{
		$this->prodays=$days;
	}
	public function setPassword($p):boolean{
		$this->password=$p;
	}
	private function getPassword():string{

	}
	private function getPermission():string{

	}
	private function setPermission($perm){
		$this->permissions=$perm;
	}
	private function deleteAccount():boolean{

	}
}


/*
CREATE ACCOUNT CLASS
this class should create account and return account id for create a club
07/05/2015 - ADD checkclub name
*/

class CreateAccount{
	private $email;
	private $password;
	public $father;
	public $id_account;
	public $club;
	public $con;

	public function __construct($e,$p,$f='NULL'){
		$this->email=$e;
		$this->password=password_hash($p, PASSWORD_BCRYPT, array('cost' => 10));
		$this->father=$f;
	}
	public function isset():bool{

		$query=Connection::connect()->prepare("SELECT id_account FROM account where email= ? ");
		$query->bindParam(1,$this->email);
		$query->execute();

		$query2=Connection::connect()->prepare("SELECT id_club FROM club where clubname= ? ");
		$query2->bindParam(1,$this->club);
		$query2->execute();

		if($query->rowCount()>0 OR $query2->rowCount()>0){
			return true;
		}else{
			return false;
		}
	}
	function create(){
		$query= Connection::$con->prepare("INSERT INTO account(email, password, father, language, slvip) values ( ?, ?, ?, 1, 15) RETURNING id_account");

		$query->bindParam(1,$this->email);
		$query->bindParam(2,$this->password);
		$query->bindParam(3,$this->father);

		$query->execute();
		$this->id_account=Connection::$con->lastInsertedID();
	}
}