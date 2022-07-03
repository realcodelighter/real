<?php

namespace Helper;

class Database
{
	private $DB;
	function __construct()
	{
		$this->DB = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ($this->DB->connect_error) die("Connection failed: " . $this->DB->connect_error);
		$this->DB->set_charset("utf8");
		return $this->DB;
	}
	function real_escape_string($string) {
		return $this->DB->real_escape_string($string);
	  }
	function query($q)
	{
		$this->sql = $q;
		$result = $this->DB->query($q) or die($this->DB->error . " => [" . $q . "]");;
		if ($this->DB->error)
			throw new \Exception($this->DB->error . " => [" . $q . "]");
		if (strpos(strtoupper($q), 'INSERT INTO') !== false)
			$result = $this->DB->insert_id;
		elseif (strpos(strtoupper($q), 'UPDATE') !== false)
			$result = $this->DB->affected_rows;
		return $result;
	}
	function select($q)
	{
		return $this->query($q)->fetch_all(MYSQLI_ASSOC);
	}
	function fetch($q)
	{
		return $this->query($q . " LIMIT 1")->fetch_array(MYSQLI_ASSOC);
	}
	function values($q)
	{
		return array_values($this->query($q . " LIMIT 1")->fetch_array(MYSQLI_ASSOC) ?? []);
	}
	function numRows($q)
	{
		return $this->check("SELECT count(id) FROM " . $q);
	}
	function escape($q)
	{
		return $this->DB->real_escape_string($q);
	}
	function check($q)
	{
		$data = $this->fetch($q);
		$data = is_array($data) ? end($data) : 0;
		return empty($data) ? 0 : $data;
	}
	function get($q)
	{
		$data = $this->fetch($q);
		$data = is_array($data) ? end($data) : null;
		return empty($data) ? null : $data;
	}
	// function try($t, $c, $q)
	// {
	// 	$data = $this->fetch("SELECT count(id) FROM " . $t . " WHERE " . $c . "='" . $q . "'");
	// 	$data = is_array($data) ? end($data) : 0;
	// 	return empty($data) ? 0 : $data;
	// }
	function confirm($for, $table, $q)
	{
		$query = "";
		foreach($q as $k=>$v)
			$query .= " $k='$v' AND";
		$query .= " 1=1";
		$data = $this->fetch("SELECT $for FROM $table WHERE $query");
		$data = is_array($data) ? end($data) : null;
		return empty($data) ? null : $data;
	}
}
