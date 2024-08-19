<?php

namespace MiniMarkPlace\Models;

use MiniMarkPlace\Libraries\Database;
use mysqli_stmt;
use Exception;

class CategoryModel extends Database
{
    /**
     * Retrieve all categories.
     *
     * @return array
     */
    public function findAll(): array
    {
        $query = "SELECT * FROM categories";
        $result = $this->conn->query($query);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        throw new Exception("Error retrieving categories: " . $this->conn->error);
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $stmt = $this->prepareStatement("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $data['name']);

        if (!$stmt->execute()) {
            throw new Exception("Error creating category: " . $stmt->error);
        }

        return true;
    }

    /**
     * Update an existing category.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->prepareStatement("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $data['name'], $id);

        if (!$stmt->execute()) {
            throw new Exception("Error updating category: " . $stmt->error);
        }

        return true;
    }

    /**
     * Delete a category.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->prepareStatement("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            throw new Exception("Error deleting category: " . $stmt->error);
        }

        return true;
    }

    /**
     * Prepare and return an SQL statement.
     *
     * @param string $query
     * @return mysqli_stmt
     */
    private function prepareStatement(string $query): mysqli_stmt
    {
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            throw new Exception("Error preparing statement: " . $this->conn->error);
        }
        
        return $stmt;
    }
}
?>
