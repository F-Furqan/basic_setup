<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\GalleryFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class GalleryFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:gallery_folders,name',
        ];

        $messages = [
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
//            return response()->json($validator->errors(), 404);
            return self::validation($validator->errors(), 'Please provide appropriate data', 404);
        }

        try {
            DB::beginTransaction();
            $data = new GalleryFolder();
            $data->name = $request->name;
            $data->save();
            if ($data) {
                DB::commit();
                return self::resourcecreated($request->name, 'Folder Created Successfully', 202);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Something went wrong!please try again', ['exception' => $exception->getMessage()]);
            return self::error('Something went wrong!please try again');
        }
    }

    /**
     * Display the specified resource.
     */


    public function show()
    {
        $folders = GalleryFolder::latest()->get(); // Don't forget ->get()
        $output = '';

        if ($folders->count() > 0) {
            $output = '<div class="row">';
            foreach ($folders as $folder) {
                $output .= '
<div class="col-md-6 col-lg-2 mb-4">
    <div class="card folder-box shadow-sm border-0 text-center position-relative h-100">
        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 delete-folder" data-id="' . $folder->id . '" title="Delete Folder">
            <i class="fas fa-times"></i>
        </button>
        <button class="btn btn-sm btn-primary position-absolute top-0 start-0 m-1 edit-folder" data-id="' . $folder->id . '" title="Edit Folder">
            <i class="fas fa-edit"></i>
        </button>
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
            <i class="fa fa-folder fa-4x text-warning mb-2"></i>
            <p class="folder-name text-truncate mb-0" title="' . htmlspecialchars($folder->name) . '">' . htmlspecialchars($folder->name) . '</p>
        </div>
    </div>
</div>';

            }
            $output .= '</div>';
        } else {
            $output = '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }

        echo $output;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $folder = GalleryFolder::find($id);
        if($folder)
        {
            $folder->delete();
        }

        return response()->json(['message' => 'Folder deleted successfully.']);
    }


}
