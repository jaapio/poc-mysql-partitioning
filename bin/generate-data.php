#!/usr/local/bin/php
<?php

require __DIR__ . '/../vendor/autoload.php';

try {
    define('NUMBER_OF_ENTRIES', 10000);
    $faker = Faker\Factory::create();

    $pdo = new PDO('mysql:host=db;dbname=test', 'root', 'root');

    $pdo->exec('DROP TABLE IF EXISTS test_partitioning');
    $result = $pdo->exec("
CREATE TABLE test_partitioning (
    id BINARY(36) NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY(id, user_id)
)
PARTITION BY HASH(user_id)
PARTITIONS 10;"

    );

    $statement = $pdo->prepare('insert into test_partitioning (id, user_id) values (:id, :user_id)');

    for ($i = 1; $i <= NUMBER_OF_ENTRIES; $i++) {
        $id     = $faker->uuid;
        $userId = $faker->numberBetween();

        $statement->execute([
            'id' => $id,
            'user_id' => $userId,
        ]);
        echo $id . PHP_EOL;
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
}
