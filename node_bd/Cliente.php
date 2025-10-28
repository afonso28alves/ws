<?
class Cliente{
	public $data = array();
	public static $table = 'cliente';
	public function __construct($dt = null){
		$this->data = $dt;
	}
}

?>