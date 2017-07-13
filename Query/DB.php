<?php
include_once('../DbConnection/DbConnect.php');

class DB
{
    private static $table;
    private static $sql;
    private static $sort ;
    private static $conn;
    private $conditionArray;

    public function __construct(){
        self::$sort = 'desc';
    }

    public static function table($table){
        self::$conn = DbConnect::connect();
        self::$table = $table;
        self::$sort = 'desc';
        self::$sql = "select * from $table";
        return new DB();
    }

    public function select(){
        $tempSql = " select  ";
        $columns  =func_get_args();
        foreach($columns as $column){
            $tempSql = $tempSql . "  " . $column . ' , ';
        }
        $tempSql = substr($tempSql,0,-2);
        $tempSql = $tempSql . " from " . self::$table;
        self::$sql = $tempSql;
        return $this;
    }

    public function where($column,$operator = '=',$value){
        $this->conditionArray[$value] = $value;
        self::$sql = self::$sql . " where $column $operator :$value";
        return $this;
    }

    public function orWhere($column,$operator = '=',$value){
        $this->conditionArray[$value] = $value;
        self::$sql = self::$sql . " or $column $operator :$value";
        return $this;
    }

    public function andWhere($column,$operator = '=',$value){
        $this->conditionArray[$value]=$value;
        self::$sql = self::$sql . " and $column $operator :$value  " ;
        return $this;
    }

    public function whereBetween($column, $firstValue,$secondValue){
        self::$sql = self::$sql . " where $column between $firstValue and $secondValue ";
        return $this;
    }

    public function whereNotBetween($column, $firstValue,$secondValue){
        self::$sql = self::$sql . " where $column not between $firstValue and $secondValue ";
        return $this;
    }

    public function whereIn($column){
        $scopeValues = func_get_args();
        $column = $scopeValues[0];
        $scopeValues = array_slice($scopeValues,1,count($scopeValues));
        $concatScopeValues = " where $column in ( ";
        foreach($scopeValues as $value){
            $concatScopeValues = $concatScopeValues . $value . ' , ' ;
        }
        $concatScopeValues = substr($concatScopeValues , 0 , strlen($concatScopeValues)-2);
        $concatScopeValues .= ' ) ';
        self::$sql = self::$sql . $concatScopeValues;
        return $this;
    }

    public function whereNotIn($column){
        $scopeValues = func_get_args();
        $column = $scopeValues[0];
        $scopeValues = array_slice($scopeValues,1,count($scopeValues));
        $concatScopeValues = " where $column not in ( ";
        foreach($scopeValues as $value){
            $concatScopeValues = $concatScopeValues . $value . ' , ';
        }
        $concatScopeValues = substr($concatScopeValues, 0 , strlen($concatScopeValues) - 2);
        $concatScopeValues .= ' ) ';
        self::$sql = self::$sql . $concatScopeValues;
        return $this;
    }

    public function whereNotNull($column){
        self::$sql  = self::$sql . " where $column is not null";
        return $this;
    }

    public function whereNull($column){
        self::$sql = self::$sql . " where $column is null";
        return $this; 
    }

    public function orderBy($column,$sort = 'asc'){
        self::$sql = self::$sql . " order by $column $sort";
        return $this;
    }

    public function groupBy($column){
        self::$sql = self::$sql . " group by $column";
        return $this; 
    }

    public function get(){
        $query = self::$conn->prepare(self::$sql);
        $query->execute($this->conditionArray);
        $result = $query->fetch();
        self::$conn = null;
        self::$sql = null;
        return $result;
    }

    public function getAll(){
        $query = self::$conn->prepare(self::$sql);
        $query->execute($this->conditionArray);
        $results = $query->fetchAll();
        self::$conn = null;
        self::$sql = null;
        return $results;
    }

    public function insert($scopeValues){
        $multipleArgument = $scopeValues[0];
        self::$sql = "insert into  " . self::$table . " ";
        $columns = " ( ";
        $values = "  values ( ";
        foreach($multipleArgument as $key => $value){
           $columns = $columns . $key . ' , ';
           $values = $values . ':'.$key . ' , ';
           $this->conditionArray[$key] = $value;
        }
        $columns = substr($columns,0,strlen($columns)-2);
        $columns .= ' ) ';
        $values = substr($values, 0 , strlen($values) - 2);
        $values  .= ') ';
        self::$sql = self::$sql . $columns . $values;
        $query = self::$conn->prepare(self::$sql);
        $query->execute($this->conditionArray);
        $rowCount = $query->rowCount();
        if($rowCount > 0 ){
            return 'success';
        }
        return 'error';
    }

    public function update($scopeValues){
        self::$sql = " update " . self::$table . "  set ";
        $updatedColumnAndValue = '';
        foreach($scopeValues as $key=>$value){ 
            $updatedColumnAndValue = $updatedColumnAndValue . $key . ' = :' . $value . ' , ';
            $this->conditionArray[$value] = $value;
        }
        $updatedColumnAndValue = substr($updatedColumnAndValue,0,strlen($updatedColumnAndValue)-2);
        self::$sql = self::$sql . $updatedColumnAndValue;
        $query = self::$conn->prepare(self::$sql);
        $query->execute($this->conditionArray);
        $rowCount = $query->rowCount();
        return $this;
    }
}
?>