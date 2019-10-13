<?php

namespace App\Repositories;

class FolderRepository extends AbstractRepository
{
    function model()
    {
        return "App\\Models\\Folder";
    }

    public function getRootFolder() {
        return $this->getFolderByParentId(0);
    }

    public function getFolderById($id) {
        return $this->findById($id);
    }

    public function getFolderByParentId($id) {
        return $this->findByField('parent_id', $id);
    }

    public function createFolder($parentId, $name, $path) {
        return $this->withUser()->create(['parent_id' => $parentId, 'name' => $name, 'path' => $path]);
    }

    public function getFolderByPath($path, $id = 0) {
        return $this->findWhere(
            [
                ['id', '<>', $id],
                ['path', '=', $path]
            ]
        );
    }

    public function renameFoldersPath($oldPath, $newPath) {
        return $this->getModel()
            ->where('path', 'like', $oldPath . '%')
            ->where('path', '<>', $oldPath)
            ->update(['path' => DB::raw("REPLACE(path, '" . $oldPath . "', '" . $newPath . "')")]);
    }
}