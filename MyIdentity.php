<?php
class MyIdentity extends Identity implements IIdentity {

	public function getInfo($key)
	{
		if ($key === 'name' || $key === 'roles') {
			return parent::__get($key);

		} else {
			Debug::dump($this->data[$key]);
			return "X".$this->data[$key];
		}
	}








}

?>