<?php

try {
    $dbPath = '../storage/unreal-asset-store.db';
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	echo "Successfully connected to database\n";

	$pdo->exec("DROP TABLE IF EXISTS user");

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

	$pdo->exec("DROP TABLE IF EXISTS category");

	$pdo->exec("CREATE TABLE IF NOT EXISTS category (
		id INTEGER PRIMARY KEY,
		name TEXT NOT NULL,
		description TEXT NOT NULL,
		asset_count INTEGER NOT NULL DEFAULT 0
	)");
	echo "Created categories table\n";

	$pdo->exec("DROP TABLE IF EXISTS asset");

	$pdo->exec("CREATE TABLE IF NOT EXISTS asset (
		id TEXT PRIMARY KEY,
		name TEXT NOT NULL,
		info TEXT NOT NULL,
		description TEXT NOT NULL,
		price INTEGER NOT NULL,
		preview_image TEXT NOT NULL,
		engine_version TEXT NOT NULL,
		category_id INTEGER NOT NULL,
		user_id INTEGER NOT NULL,
		created_at INTEGER DEFAULT (strftime('%s', 'now')),
		purchase_count INTEGER DEFAULT 0
	)");

	echo "Created assets table\n";

	$pdo->exec("DROP TABLE IF EXISTS image");

	$pdo->exec("CREATE TABLE IF NOT EXISTS image (
		id INTEGER PRIMARY KEY,
		asset_id TEXT NOT NULL,
		image_order INTEGER NOT NULL,
		path TEXT NOT NULL
	)");

	echo "Created images table\n";

	$pdo->exec("DROP TABLE IF EXISTS file");

	$pdo->exec("CREATE TABLE IF NOT EXISTS file (
		id INTEGER PRIMARY KEY,
		asset_id TEXT NOT NULL,
		name TEXT NOT NULL,
		path TEXT NOT NULL,
		version TEXT NOT NULL,
		description TEXT NOT NULL,
		size INTEGER NOT NULL,
		created_at INTEGER DEFAULT (strftime('%s', 'now'))
	)");

	echo "Created files table\n";

} catch (Exception $e) {
    echo $e->getMessage();
    die();
}
