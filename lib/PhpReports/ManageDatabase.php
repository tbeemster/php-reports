<?php

use PhpReports\Model\DatabaseSource;

class ManageDatabase {

	/** @var PDO */
	protected $database;

	/**
	 * ManageDatabase constructor.
	 *
	 * @param DatabaseSource $databaseSource
	 * @throws PDOException
	 */
	public function __construct(DatabaseSource $databaseSource) {
		$database = array(
			'dsn' => $databaseSource->getDsn(),
			'user' => $databaseSource->getUsername(),
			'pass' => $databaseSource->getPassword(),
		);
		$this->database = $this->connect($database);
	}

	/**
	 * @param array $database
	 * @throws PDOException
	 * @return PDO
	 */
	public static function connect(array $database) {
		return new PDO($database['dsn'], $database['user'], $database['pass']);
	}

	public function configureTables() {
		$template_vars = array('tables' => $this->getTables());
		return PhpReports::render('html/manage_database', $template_vars);
	}

	protected function getTables() {
		$result = $this->database->query("SHOW TABLES");
		$tables = $result->fetchAll(PDO::FETCH_ASSOC);

		$i = 0;

		foreach ($tables as $table) {
			$result = $this->database->query("DESCRIBE " . current($table));

			$columns = $result->fetchAll(PDO::FETCH_ASSOC);
			$rows[$i]['Table'] = current($table);
			$rows[$i]['ColumnCount'] = count($columns);

			$result = $this->database->query("SELECT COUNT(*) FROM " . current($table));
			$count = $result->fetch();
			$rowCount = current($count);
			$rows[$i]['RowCount'] = $rowCount;
			$disabled = ($rowCount == 0 ? 1 : 0);
			$rows[$i]['Hidden'] = $disabled;

			$i++;
		}
		return $rows;
	}

}
