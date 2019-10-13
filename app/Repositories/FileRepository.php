<?php

namespace App\Repositories;

class FileRepository extends AbstractRepository
{
    function model()
    {
        return "App\\Models\\File";
    }

    public function getByFolderId($id) {
        return $this->findByField('folder_id', $id);
    }

    public function getFileByPathInFolder($folderId, $fileName, $ext = false) {
        $where = [
            'folder_id' => $folderId,
            'name' => $fileName
        ];

        if($ext) {
            $where['extension'] = $ext;
        }

        return $this->findWhere($where);
    }

    public function createFile($folderId, $name, $ext, $size, $permission = 0) {
        return $this->withUser()->create([
            'folder_id' => $folderId,
            'name' => $name,
            'extension' => $ext,
            'size' => $size,
            'permission' => $permission
        ]);
    }

    public function getFileById($id) {
        return $this->findById($id);
    }
}