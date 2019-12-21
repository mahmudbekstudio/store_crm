<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Repositories\DistrictRepository;
use App\Repositories\DocumentRegionRepository;
use App\Repositories\DocumentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    private $documentRepository;
    private $documentRegionRepository;

    public function __construct(
        DocumentRepository $documentRepository,
        DocumentRegionRepository $documentRegionRepository
    )
    {
        $this->documentRepository = $documentRepository;
        $this->documentRegionRepository = $documentRegionRepository;
    }

    public function list($id)
    {
        $documents = $this->documentRepository->with(['region'])->findWhere(['type_id' => $id])->toArray();
        $list = [];

        foreach($documents as $item) {
            $list[$item['region']['name']][] = [
                'id' => $item['id'],
                'file' => $item['file']
            ];
        }

        return responseData(true, ['list' => $list, 'params' => $this->params($id)]);
    }

    public function uploadFile($id, Request $request)
    {
        $data = $request->all();
        $district = $this->documentRegionRepository->firstOrCreate(['name' => $data['district'], 'type_id' => $id]);
        $documentRepository = app(DocumentRepository::class);


        $uploadedFile = $request->file('file');
        $filename = $uploadedFile->getClientOriginalName();
        $file = time() . '/'.$filename;

        Storage::disk('local')->putFileAs(
            'files',
            $uploadedFile,
            $file
        );

        $documentRepository->create([
            'user_id' => auth()->user()->id,
            'district_id' => $district->id,
            'type_id' => $id,
            'file' => 'files/' . $file
        ]);

        return responseData(true);
        //return Storage::url('files/' . $file);
    }

    public function download($id)
    {
        $file = Document::find($id);
        return Storage::download($file->file);
    }

    public function deleteFile($id)
    {
        $file = Document::find($id);
        Storage::delete($file->file);
        $file->delete();

        return responseData(true);
    }

    public function params($id)
    {
        $regions = [];
        $documentRegions = $this->documentRegionRepository->findWhere(['type_id' => $id]);

        foreach($documentRegions as $item) {
            if($item->parent_id == 0) {
                $subList = [];

                foreach($documentRegions as $subItem) {
                    if($subItem->parent_id == $item->id) {
                        $subList[] = $subItem->name;
                    }
                }

                $regions[$item->name] = $subList;
            }
        }

        return $regions;
    }

    public function addRegion($id, Request $request)
    {
        $data = $request->only(['name']);
        $this->documentRegionRepository->firstOrCreate(['name' => $data['name'], 'type_id' => $id]);

        return responseData(true);
    }

    public function addDistrict($id, Request $request)
    {
        $data = $request->only(['name', 'region']);
        $region = $this->documentRegionRepository->firstOrCreate(['name' => $data['region'], 'type_id' => $id]);
        $this->documentRegionRepository->firstOrCreate(['name' => $data['name'], 'parent_id' => $region->id, 'type_id' => $id]);

        return responseData(true);
    }

    public function removeRegion($id, Request $request)
    {
        $data = $request->only(['region']);
        $region = $this->documentRegionRepository->firstOrCreate(['name' => $data['region'], 'type_id' => $id]);
        $this->documentRegionRepository->deleteWhere(['id' => $region->id, 'type_id' => $id]);
        $districtsList = $this->documentRegionRepository->findWhere(['type_id' => $id, 'parent_id' => $region->id]);

        foreach($districtsList as $item) {
            $this->documentRegionRepository->deleteWhere(['id' => $item->id, 'type_id' => $id]);
            $this->documentRepository->deleteWhere(['district_id' => $item->id, 'type_id' => $id]);
        }

        return responseData(true);
    }

    public function removeDistrict($id, Request $request)
    {
        $data = $request->only(['district']);
        $district = $this->documentRegionRepository->firstOrCreate(['name' => $data['district'], 'type_id' => $id]);
        $this->documentRegionRepository->deleteWhere(['id' => $district->id, 'type_id' => $id]);
        $this->documentRepository->deleteWhere(['district_id' => $district->id, 'type_id' => $id]);

        return responseData(true);
    }
}
