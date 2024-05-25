<?php

namespace App\Http\Controllers;
use App\Models\Temporary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class UploadController extends Controller
{
    public function store(Request $request){
        if($request->hasFile('document')){
            $file = $request->file('document');
            $folder = uniqid() . "-" . now()->timestamp;
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/public/temporary_docs/'. $folder, $filename);

                Temporary::create([
                        'folder' => $folder,
                        'filename' =>$filename
                ]);
                

                $result = [
                    'folder' => $folder,
                    'filename' => $filename
                ];
                return $result;
        }
        
        return 'empty';
    }
    public function deleteTemporary(Request $request)
    {
        try {
            // Get the folder name of the file to be deleted
            $folder = request()->getContent();
    
            if (empty($folder)) {
                return response()->json(['error' => 'Folder information is missing in the request'. $request->input('fileId')], 400);
            }
         
               
            // Delete the file from the temporary directory
            Storage::deleteDirectory('public/public/temporary_docs/' . $folder);
    
            // Delete the corresponding entry from the temporary table
            Temporary::where('folder', $folder)->delete();
    
            return response()->json(['message' => 'File deleted successfully']);
          
           
        } catch (\Exception $e) {
            // Handle exceptions, e.g., log the error
         
    
            // Return an error response with the exception message
            return response()->json(['error' => 'Failed to delete temporary file: ' . $e->getMessage()], 500);
        }
    }
}
