<?php
App::uses('AppModel', 'Model');

class Product extends AppModel {
	//public $primaryKey = 'ID';
	public $displayField='Name';
	public $hasAndBelongsToMany = array(

	);
	
	public $hasOne = array('Description'=>array(
	//'conditions' => array('Profile.published' => '1'),
	
	));

}
