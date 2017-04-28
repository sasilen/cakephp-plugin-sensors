<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
  public function change()
  {
    $table = $this->table('sensors');
    $table
      ->addColumn('name', 'string', [
          'limit' => 255,
          'null' => false,
      ])
      ->addColumn('datetime', 'datetime', [
          'null' => false,
      ])
      ->addColumn('description', 'string', [
          'limit' => 255,
          'null' => false,
      ])
      ->addColumn('tag_count', 'integer', [
          'default' => null,
          'limit' => 5,
          'null' => true,
      ])
      ->create();

    $table = $this->table('sensor_values');
    $table
      ->addColumn('sensor_id', 'string', [
          'limit' => 15,
          'null' => false,
      ])
      ->addColumn('datetime', 'datetime', [
          'null' => false,
      ])
      ->addColumn('value', 'float', [
          'limit' => 255,
          'null' => false,
      ])
      ->addColumn('type', 'string', [
          'limit' => 15,
          'null' => false,
      ])
      ->create();
  }
}
