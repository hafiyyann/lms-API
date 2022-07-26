<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chapter;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try {
        $chapters = Chapter::all();

        return response()->json([
          'success' => true,
          'chapters' => $chapters
        ], 200);
      } catch (\Exception $e) {
        return response()->json([
          'success' => false,
          'message' => $e->getMessage()
        ], 500);
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      try {
        $validator = Validator::make($request->all(), [
          'title'        => 'required',
          'description'  => 'required',
          'course_id'    => 'required',
        ]);

        if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
        }

        $chapter = Chapter::updateOrCreate(
          [
            'id' => $request->id
          ],
          [
            'title'               => $request->title,
            'description'         => $request->description,
            'course_id'           => $request->course_id,
          ]
        );

        return response()->json([
          'success' => true,
          'course' => $chapter
        ], 200);
      } catch (\Exception $e) {
        return response()->json([
          'success' => false,
          'message' => $e->getMessage()
        ], 500);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try {
        $chapter = Chapter::with('course')->where('id', $id)->first();;

        return response()->json([
          'success' => true,
          'chapter' => $chapter
        ], 200);
      } catch (\Exception $e) {
        return response()->json([
          'success' => false,
          'message' => $e->getMessage()
        ], 500);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try {
        $chapter = Chapter::find($id);
        $chapter->delete();

        return response()->json([
          'success' => true,
        ], 200);
      } catch (\Exception $e) {
        return response()->json([
          'success' => false,
          'message' => $e->getMessage()
        ], 500);
      }
    }
}
