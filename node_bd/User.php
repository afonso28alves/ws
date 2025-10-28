<?
class User{
	public $data = array();
	public static $table = 'user';
	public function __construct($dt = null){
		$this->data = $dt;
	}
}

?>