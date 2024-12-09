<?php

try {
    $dbPath = '../storage/test.db';
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	echo "Successfully connected to database\n";

	$pdo->exec("CREATE TABLE IF NOT EXISTS user (
		id INTEGER PRIMARY KEY,
		name TEXT NOT NULL,
		email TEXT NOT NULL,
		password TEXT NOT NULL,
		role TEXT NOT NULL
	)");

	echo "Created users table\n";

	$admin_password = password_hash('admin', PASSWORD_DEFAULT);
	$stmt = $pdo->prepare("INSERT INTO user (name, email, password, role) VALUES (?, ?, ?, ?)");
	$stmt->execute([
		'admin',
		'admin@example.com',
		$admin_password,
		'admin'
	]);

	echo "Created admin user\n";

	$pdo->exec("CREATE TABLE IF NOT EXISTS category (
		id INTEGER PRIMARY KEY,
		name TEXT NOT NULL,
		description TEXT NOT NULL,
		asset_count INTEGER NOT NULL DEFAULT 0
	)");
	echo "Created categories table\n";

	$pdo->exec("CREATE TABLE IF NOT EXISTS asset (
		id INTEGER PRIMARY KEY,
		name TEXT NOT NULL,
		info TEXT NOT NULL,
		description TEXT NOT NULL,
		images TEXT NOT NULL,
		price INTEGER NOT NULL,
		engine_version INTEGER NOT NULL,
		category_id INTEGER NOT NULL,
		user_id INTEGER NOT NULL,
		created_at INTEGER DEFAULT (strftime('%s', 'now')),
		purchase_count INTEGER DEFAULT 0
	)");

	echo "Created assets table\n";


} catch (Exception $e) {
    echo $e->getMessage();
    die();
}
