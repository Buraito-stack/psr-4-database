<?php

namespace MiniMarkPlace\Models;

use MiniMarkPlace\Libraries\Database;

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

        return [];
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
        return $stmt->execute();
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
        return $stmt->execute();
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
        return $stmt->execute();
    }

    /**
     * Prepare and return an SQL statement.
     *
     * @param string $query
     * @return \mysqli_stmt
     */
    private function prepareStatement(string $query): \mysqli_stmt
    {
        return $this->conn->prepare($query);
    }
}
