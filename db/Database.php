<?php
namespace eork\phpmvc\db;

use eork\phpmvc\Application;
use PDO;

/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class Database
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package eork\phpmvc\db
  *
  */

  class Database
  {
    public \PDO $pdo;

    /**
     * Database constructor
     */

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
      $this->createMigrationsTable();
      $appliedMigrations = $this->getAppliedMigrations();
      $newMigrations = [];
      $files = scandir(Application::$ROOT_DIR.'/migrations');

      $toApplyMigrations = array_diff($files, $appliedMigrations);

      foreach($toApplyMigrations as $migration){
        if($migration == '.' || $migration == '..'){
          continue;
        }

        require_once Application::$ROOT_DIR.'/migrations/'.$migration;
        $className = pathinfo($migration, PATHINFO_FILENAME);
        
        $instance = new $className();

        $this->log("Applying Migration ".$migration);
        $instance->up();
        $this->log("Applied Migration ".$migration);
        $newMigrations[] = $migration;
      }

      if(!empty($newMigrations)){
        $this->saveMigrations($newMigrations);
      }else{
        $this->log("All migrations are applied");
      }


    }

    public function createMigrationsTable()
    {
      $this->pdo->exec("
        CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration varchar(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;
      ");
    }

    public function getAppliedMigrations()
    {
      $statement = $this->pdo->prepare("select migration from migrations");
      $statement->execute();
      
      return $statement->fetchAll(\PDO::FETCH_COLUMN);
    } 

    public function saveMigrations(array $migration)
    {

        $str = implode(",",array_map( 
          fn($m) => "('$m')", 
          $migration
        ));


        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
          $str
        ");

        $statement->execute();
    }

    public function prepare($sql)
    {
      return $this->pdo->prepare($sql);
    }

    protected function log($message)
    {
      echo '['.date("Y-m-d H:i:s").'] - '.$message.PHP_EOL;
    }
    
  }