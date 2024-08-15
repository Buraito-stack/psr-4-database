<?php

namespace MiniMarkPlace\Models;

use MiniMarkPlace\Libraries\Database;

class CategoryModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll()
    {
        $query = "SELECT * FROM categories";
        $result = $this->conn->query($query);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC); 
        }

        return [];
    }

    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $data['name']);
        $stmt->execute();
    }

    public function update($id, $data)
    {
        $stmt = $this->conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $data['name'], $id);
        $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
