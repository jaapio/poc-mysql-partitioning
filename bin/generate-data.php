#!/usr/local/bin/php
<?php

require __DIR__ . '/../vendor/autoload.php';

try {
    define('NUMBER_OF_ENTRIES', 100);
    define('NUMBER_OF_USERS', 10);
    $faker = Faker\Factory::create();

    $pdo = new PDO('mysql:host=db;dbname=test', 'root', 'root');

    $pdo->exec('DROP TABLE IF EXISTS test_partitioning');
    $result = $pdo->exec("
CREATE TABLE test_partitioning (
    id BINARY(36) NOT NULL,
    user_id BINARY(36) NOT NULL,
    PRIMARY KEY(id, user_id)
)
PARTITION BY KEY(user_id)
PARTITIONS 10;"
    );

    var_dump($pdo->errorInfo());
    if ($result === false) {
        exit(1);
    }

    $statement = $pdo->prepare('insert into test_partitioning (id, user_id) values (:id, :user_id)');

    for ($i = 1; $i < NUMBER_OF_USERS; $i++) {
        $userId = $faker->uuid;

        for ($e = 1; $e <= NUMBER_OF_ENTRIES; $e++) {
            $id = $faker->uuid;

            $statement->execute([
                'id' => $id,
                'user_id' => $userId,
            ]);
            echo $id . PHP_EOL;
        }
    }
} catch (\Throwable $exception) {
    echo $exception->getMessage();
}
