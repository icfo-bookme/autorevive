<?php

namespace App\Http\Controllers\section;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\section\SectionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    /**
     * @name allSectionView
     * @role All category list view
     * @param
     * @edit
     *      edited by   - Usama
     *      edit detail - added this in the query section_order
     * @return view with compact array
     *
     */
    public function allSectionView(){
        $sections = SectionModel::where('soft_delete', 0)
                                ->orderBy('section_order')
                                ->get();

        $data = [
            'sections' => $sections
        ];

         return view('admin.section.allSectionView',$data);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * Returns all sections
     */
    public function getAllSections()
    {
        $sections = SectionModel::where('soft_delete', 0)
            ->orderBy('section_order')
            ->get();

        return response()->json($sections);
    }



    /**
     * @name sectionInsertAjax
     * @role insert section info into  database
     * @param Request from array
     * @return json response
     *
     */

    public function sectionInsertAjax(Request $request)
    {
        $userName = Auth::user()->first_name;
        $defaultStatus = 0;
        //gettings attributes
        $attributeNames = array(
            'name'              => $request->name,
            'created_by'        => $userName,
            'updated_by'        => $userName,
            'soft_delete'       => $defaultStatus

        );



        //return dd($attributeNames);

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            SectionModel::create($attributeNames);
            return response()->json("Success");
        }
    }






     /**
     * @name getSectionDetails
     * @role get section details from  database
     * @param Request from array
     * @return json response
     *
     */


    public function getSectionDetails(Request $request){
        $id = $request->id;
        $section = SectionModel::findOrFail($id);
        return response()->json($section);
    }






     /**
     * @name sectionUpdateAjax
     * @role update category details into  database
     * @param Request from array
     * @return json response
     *
     */
    public function sectionUpdateAjax(Request $request)
    {
        $id = $request->id;
        $section = SectionModel::findOrFail($id);

        $attributeNames = array(
            'name'              => $request->name,
        );

        $validator = Validator::make($attributeNames, [
            'name'                  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $section->update($attributeNames);
            return response()->json("Success");
        }
    }






     /**
     * @name categoryDeleteAjax
     * @role delete category  from  database
     * @param Request from array
     * @return json response
     *
     */
    public function sectionDeleteAjax(Request $request)
    {
        $id = $request->id;
        $section = SectionModel::findOrFail($id);
        $deletedAttribute = 1;
        $attributeNames = array(
            'soft_delete' => $deletedAttribute
        );

        try {
            $section->update($attributeNames);
            return response()->json("Deleted!");
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }
    }

    /**
     * @name reorderSectionAjax
     * @param Request $name, $order
     * @role reorder section
     * @author Usama
     * @return json response
     */
    public function reorderSectionAjax(Request $request)
    {
        // dd($request->row_serial);
        $serial_data = $request->row_serial;
        foreach ($serial_data as $row) {
            SectionModel::where('id', $row['original_serial'])
                        ->update([
                            'section_order' => $row['present_serial']
                        ]);
        }

        return response()->json('Section re-ordered!');
    }

}

