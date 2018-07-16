<?php  
	/**
	 * @author Lawrence Kweku Adu
	 */
	class Example
	{
		
		function __construct()
		{
			$this->db = new Database();
		}

		public function all($offset = 0, $limit = 10) {
			$this->db->query("SELECT * FROM examples WHERE is_archived = false");
			$result = $this->db->result();

			if ($this->db->rowcount() > 0)
				return $result;
			else
				return false;
		}

		public function find($id){
			$this->db->query("SELECT * FROM examples WHERE id = :id AND is_archived = false");
			$this->db->bind(":id", $id);
			$row = $this->db->row();

			if ($this->db->rowcount() > 0)
				return $row;
			else 
				return false;
		}

		public function create($params) {
			$this->db->query("INSERT INTO examples() VALUES ()");
			foreach ($params as $key => $value)
				$this->db->bind(":{$key}", $value);

			return $this->db->execute();
		}

		public function update($params) {
			$this->db->query("UPDATE examples SET colum = :column WHERE id = :id");

			foreach ($params as $key => $value)
				$this->db->bind(":{$key}", $value);

			return $this->db->execute();
		}

		public function destroy($id) {
			$this->db->query("UPDATE examples SET is_archived = true WHERE id = :id");
			$this->db->bind(":id", $id);
			return $this->db->execute();
		}
	}
?>