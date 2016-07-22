<?
include_once('Players.php');
/*
 * @author: echart
 */
class Player extends Players{
	/*technical*/
	public $crossing;
	public $pass;
	public $technical;
	public $ballcontrol;
	public $dribble;
	public $longshot;
	public $finish;
	public $heading;
	public $freekick;
	public $marking;
	public $tackling;
	/*methods*/
	public function loadPlayer($id_player){
		$query=Connection::getInstance()->connect()->prepare("SELECT * FROM players p inner join players_attr pa using(id_player) inner join players_attr_line pal using(id_player) where id_player=:id_player");
		$query->bindParam(':id_player',$id_player);
		$query->execute();
		$data=$query->fetch();
		return $data;
	}
	public function deletePlayer($id_player){
		$query=Connection::getInstance()->connect()->prepare("DELETE CASCADE FROM players where id_player=:id_player");
		$query->bindParam(':id_player',$id_player);
		$query->execute();
	}
	//
	// public function rec(){
	//
	// }
	public function skillIndex(){
		$physical=$this->stamina+$this->speed+$this->resistance+$this->jump;
		$psychologic=$this->workrate+$this->concentration+$this->decision+$this->positioning+$this->vision+$this->unpredictability+$this->communication;
		$technical=$this->crossing+$this->pass+$this->technical+$this->ballcontrol+$this->dribble+$this->longshot+$this->finish+$this->heading+$this->freekick+$this->marking+$this->tackling;
		$this->skill_index=$physical+$technical+$psychologic;
		return $this->skill_index;
	}
	public static function addHistory($id_player,$id_club,$season){
		parent::addHistory($id_player,$id_club,$season);
	}
	public static function loadHistory($id_player){
		$query=Connection::getInstance()->connect()->prepare("SELECT * FROM players_history where id_player=:id_player");
		$query->bindParam(':id_player',$id_player);
		$query->execute();

		$query->setFetchMode(PDO::FETCH_OBJ);
		return $query;
	}
	// public static function loadPlayerByClub($id_club){
	// 	$query=Connection::getInstance()->connect()->prepare("SELECT * FROM players inner join players_attr using id_player inner join players_attr_line inner join id_player where id_club=:id_club");
	// 	$query->bindParam(':id_club',$id_club);
	// 	$query->execute();
	//
	// 	$query->setFetchMode(PDO::FETCH_OBJ);
	// 	return $query;
	// }
}