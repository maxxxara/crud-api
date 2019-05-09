<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
class Post {
	public $conn;
	public $table = 'posts';

	public function __construct($db) {
		$this->conn = $db;
	}

	public function read() {
		$result = mysqli_query($this->conn, "SELECT * FROM ". $this->table);
		$post_arr = array();
		$post_arr['data'] = array(); 
		while ($row = mysqli_fetch_assoc($result)) {
			$post_item = array(
				'id' => $row['id'],
				'title' => $row['title'],
				'body' => $row['body'],
				'category_id' => $row['category_id'],
				'user_id' => $row['user_id'],
				'created_at' => $row['created_at']
			);
			array_push($post_arr['data'], $post_item);
		}
		echo json_encode($post_arr);
	}
	public function read_single() {
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$table = $this->table;
			$result = mysqli_query($this->conn, "SELECT * FROM `{$table}` WHERE id='$id'");
			if (mysqli_num_rows($result) == 1) {
				$row = mysqli_fetch_assoc($result);
				$post_arr = array(
					'id' => $row['id'],
					'title' => $row['title'],
					'body' => $row['body'],
					'category_id' => $row['category_id'],
					'user_id' => $row['user_id'],
					'created_at' => $row['created_at']
				);
				echo json_encode($post_arr);
			} else {
				$post_arr = array('error' => 'not posts with id ' . $id);
				echo json_encode($post_arr);
			}
			
		}
	}

	public function create() {
		$data = json_decode(file_get_contents("php://input"));
		$table = $this->table;
		$title = $data->title;
		$body = $data->body;
		$category_id = $data->category_id;
		$user_id = $data->user_id;	
		$table = $this->table;
		$query = "INSERT INTO posts
			(title, body, category_id, user_id) VALUES
			('$title', '$body', '$category_id', '$user_id')";
		if ($this->conn->query($query) === TRUE) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $query . "<br>" . $this->conn->error;
		}
	}

	public function delete() {
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$table = $this->table;
			$query = mysqli_query($this->conn, "DELETE FROM posts WHERE id='$id' ");
		}
	}

	public function update() {
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$data = json_decode(file_get_contents("php://input"));
			$title = $data->title;
			$body = $data->body;
			$category_id = $data->category_id;
			$user_id = $data->user_id;	
			$query = "UPDATE posts SET 
			title = '$title',
			body = '$body',
			category_id = '$category_id',
			user_id = '$user_id'
			WHERE id='$id' 
			";
			if ($this->conn->query($query) === TRUE) {
    			echo "Record updated successfully";
			} else {
			    echo "Error updating record: " . $this->conn->error;
			}
		}
	}
}


?>