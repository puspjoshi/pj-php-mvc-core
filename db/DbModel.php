<?php
namespace eork\phpmvc\db;

use eork\phpmvc\Application;
use eork\phpmvc\Model;

/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class DbModel
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package eork\phpmvc\db
  *
  */

  abstract class DbModel extends Model
  {
    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

    public function save()
    {
        $tableName = static::tableName();
        $attributes = $this->attributes();

        $params = array_map(fn($attr) => ":$attr",$attributes);
        $sql = "INSERT INTO $tableName (".implode(",",$attributes).") VALUES (".implode(',',$params).")";
        
        $statement = self::prepare($sql);
        
        foreach( $attributes as $attribute){
          $statement->bindValue(":$attribute",$this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public static function findOne($where)
    {
      $tableName = static::tableName();

      $attributes = array_keys($where);

      $sql = implode("AND ",array_map(fn($attr) => "$attr = :$attr", $attributes));

      $statement = self::prepare("select * from $tableName where $sql");

      foreach($where as $key => $value)
      {
        $statement->bindValue(":$key", $value);
      }
      $statement->execute();

      return $statement->fetchObject(static::class);

    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
  }