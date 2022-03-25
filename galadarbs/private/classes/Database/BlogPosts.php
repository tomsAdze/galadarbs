<?php
namespace Database;

class BlogPosts extends DB
{
    private $table_name = 'blog_posts';

    public function get(int $id) {
        return $this->getById($id, $this->table_name);
    }

    public function getAll() {
        return $this->selectAll($this->table_name);
    }

    public function addEntity(array $entity) {
        return $this->insertEntity($entity, $this->table_name);
    }

    public function updateEntity(array $entity) {
        return $this->updateEntityChanges($entity, $this->table_name);
    }

    public function delete(int $id) {
        return $this->deleteEntityById($id, $this->table_name);
    }
}