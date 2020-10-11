<?php
class DatabaseTable
{
	/* //Setting class properties (or variables) */
	
	private $pdo;
	private $table;
	private $keyfield;
	private $keyfield2;
	
	public function __construct(PDO $pdo, string $table, string $keyfield ='', $keyfield2 =''){
		$this->pdo = $pdo;
		$this->table = $table;
		$this->keyfield = $keyfield;
		$this->keyfield2 = $keyfield2;
	}
	
	private function query( $sql, $parameters=[]){
		$query = $this->pdo->prepare($sql);
		$query->execute($parameters);
		return $query;
	}
	
	public function selectColumnRecords($value1,$value2=''){
		
		$sql = 'SELECT * FROM `'.$this->table .'`
		WHERE `'.$this->keyfield .'` = :value1 OR `'
		.$this->keyfield .'` = :value2';
		
		$parameters =['value1'=> $value1,
		'value2'=> $value2
		];

		$query = $this->query($sql, $parameters);
		
		return $query;
	}
	public function selectColumnsRecords($value1,$value2){
		
		$sql = 'SELECT * FROM `'.$this->table .'`
		WHERE `'.$this->keyfield .'` = :value1 OR `'
		.$this->keyfield2 .'` = :value2';
		
		$parameters =['value1'=> $value1,
		'value2'=> $value2
		];

		$query = $this->query($sql, $parameters);
		
		return $query;
	}
	public function selectMatchColumnsRecords($value1, $value2){
		
		$sql = 'SELECT * FROM `'.$this->table .'`
		WHERE `'.$this->keyfield .'` = :value1 AND `'
		.$this->keyfield2 .'` = :value2';
		
		$parameters =['value1'=> $value1,
		'value2'=> $value2
		];

		$query = $this->query($sql, $parameters);
		
		return $query;
		
	}
	public function selectAllRecords(){ 
		$sql = 'SELECT * FROM `'.$this->table .'`';
		
		$query = $this->query($sql);
		
		return $query;
	}
	public function selectCountAllRecords(){
		
		$sql = 'SELECT COUNT(*) FROM `'.$this->table .'`';
		
		$query = $this->query($sql);
		
		return $query;
	}
	
	public function insertRecord($fields) {
		$query = 'INSERT INTO `'.$this->table .'`(';
		
		foreach($fields as $key=>$value){
			$query .= '`'.$key.'`,';
		}
		
		$query = rtrim($query, ',');
		
		$query .= ') VALUES (';
		
		foreach ($fields as $key=>$value){
			$query .= ':'.$key. ',';
		}
		$query = rtrim($query, ',');
		$query .= ')';
		
		$this->query($query, $fields);
	}
	
	public function updateRecords($fields,$keyfield) {
		$query ='UPDATE `'.$this->table. '` SET ';
		
		foreach($fields as $key=>$value){
			$query .= '`'.$key .'` = :'.$key.','; 
		}
		$query = rtrim($query, ',');
		
		$query .= ' WHERE `'.$this->keyfield .'`= :keyfield';
		
		$fields ['keyfield'] = $keyfield;
		
		$this->query($query, $fields);
	}

	public function deleteRecords($value){
		
		$sql = 'DELETE FROM `'.$this->table .'` WHERE `'.$this->keyfield .'` = :value';
		$parameters = [':value' => $value];
		
		$this->query($sql, $parameters);
	}
}