<?php

namespace App\Models;

use App\Core\Database;

class TodoModel {
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }
    public function insertTodo($todoName) {
       $this->db->query('INSERT INTO todos(todo_name) VALUES (?)');
       $this->db->execute([$todoName]);
    }

    public function selectAllTodo() {
        $this->db->query('SELECT * FROM todos');
        $this->db->execute();

        return $this->db->fetchAll();
        
    }

    public function deleteTodo($id) {
        $this->db->query('DELETE FROM todos WHERE id = ?');
        $this->db->execute([$id]);
    }
}