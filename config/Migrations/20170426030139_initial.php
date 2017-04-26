<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
  public function change()
  {
    $table = $this->table('sensors', ['id' => false, 'primary_key' => ['id']]);
    $table
      ->addColumn('id', 'string', [
          'limit' => 15,
          'null' => false,
      ])
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
