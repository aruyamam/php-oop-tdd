<?php

namespace App\Database;

use App\Exception\InvalidArgumentException;
use ReflectionClass;

class MySQLiQueryBuilder extends QueryBuilder
{
   private $resultSet;
   private $results;

   const PARAM_TYPE_INT = 'i';
   const PARAM_TYPE_STRING = 's';
   const PARAM_TYPE_DOUBLE = 'd';

   public function get()
   {
      if (!$this->resultSet) {
         $this->resultSet = $this->statement->get_result();
         $this->results = $this->resultSet->fetch_all(MYSQLI_ASSOC);
      }
      return $this->results;
   }

   public function count()
   {
      if (!$this->resultSet) {
         $this->get();
      }
      return $this->resultSet ? $this->resultSet->num_rows : false;
   }

   public function lastInsertedId()
   {
      return $this->connection->insert_id;
   }

   public function prepare($query)
   {
      return $this->connection->prepare($query);
   }

   public function execute($statement)
   {
      if (!$statement) {
         throw new InvalidArgumentException('MySQLi statement is false');
      }

      if ($this->bindings) {
         $bindings = $this->parseBindings($this->bindings);
         $reflectionObj = new ReflectionClass('msyqli_stmt');
         $method = $reflectionObj->getMethod('bind_param');
         $method->invokeArgs($statement, $bindings);
      }
      $statement->execute();
      $this->bindings = [];
      $this->placeholders = [];

      return $statement;
   }

   private function parseBindings(array $params)
   {
      $bindings = [];
      $count = count($params);
      if ($count === 0) {
         return $this->bindings;
      }

      $bindingType = $this->parseBindingTypes();
      $bindings[] = &$bindingType;
      for ($index = 0; $index < $count; $index++) {
         $bindings[] = &$params[$index];
      }
      return $bindings;
   }

   public function parseBindingTypes()
   {
      $bindingTypes = [];
      foreach ($this->bindings as $binding) {
         if (is_int($binding)) {
            $bindingTypes[] = self::PARAM_TYPE_INT;
         }
         if (is_string($binding)) {
            $bindingTypes[] = self::PARAM_TYPE_STRING;
         }
         if (is_float($binding)) {
            $bindingTypes[] = self::PARAM_TYPE_DOUBLE;
         }
      }
      return implode('', $bindingTypes);
   }

   public function fetchInto($className)
   {
      $results = [];
      $this->resultSet = $this->statement->get_result();
      while ($object = $this->resultSet->fetch_object($className)) {
         $results[] = $object;
      }
      return $this->results = $results;
   }
}