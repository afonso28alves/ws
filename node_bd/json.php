<?
class Json{
	public $data;
	public function __construct($dt = null){
		$this->data = $dt;
		$this->jsonSimple();
	}
	public function jsonSimple(){
		header('Content-Type: application/json');
		echo json_encode($this->data);
	}
}


?>