<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Chapter;
use App\Models\ChapterComponent;
use App\Models\ChapterVideo;
use App\Models\ChapterExam;
use App\Models\ChapterMeeting;
use App\Models\ChapterArticle;

class ChapterComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
          'type'        => 'required',
          'title'       => 'required',
          'chapter_id'  => 'required',
        ]);

        if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
        }

        $chapter = Chapter::find($request->chapter_id);

        if ($chapter === null) {
          return response()->json([
            'success' => false,
            'message' => 'CHAPTER_NOT_FOUND'
          ], 404);
        }

        $type = $request->type;

        if (in_array($type, ['video', 'meeting', 'article', 'exam'])) {


          if ($type == 'video') {
            if ($request->hasFile('video')) {
              $validator = Validator::make($request->all(), [
                'video'       => 'mimes:mp4,mov,ogg,qt|max:100000',
              ]);

              if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
              }

              // upload_to_storage_here

              $component = ChapterComponent::create([
                'title'       => $request->title,
                'created_by'  => auth()->user()->id,
                'visibility'  => $request->visibility ? 1 : 0,
                'chapter_id'  => $request->chapter_id,
                'type'        => $type,
                'order'       => $request->order,
                'description' => $request->description
              ]);

              $component_source = ChapterVideo::create([
                'filename'  => $request->filename,
                'component_id' => $component->id
              ]);
            }
          }

          if ($type == 'article') {
            $validator = Validator::make($request->all(), [
              'article_title' => 'required',
              'content'       => 'required'
            ]);

            if ($validator->fails()) {
              return response()->json($validator->errors(), 422);
            }

            $component = ChapterComponent::create([
              'title'       => $request->title,
              'created_by'  => auth()->user()->id,
              'visibility'  => $request->visibility ? 1 : 0,
              'chapter_id'  => $request->chapter_id,
              'type'        => $type,
              'order'       => $request->order,
              'description' => $request->description
            ]);

            $component_source = ChapterArticle::create([
              'title'         => $request->article_title,
              'content'       => $request->content,
              'component_id'  => $component->id
            ]);
          }

          if ($type == 'exam') {
            $validator = Validator::make($request->all(), [
              'max_attept'          => 'required|numeric',
              'duration'            => 'required|numeric',
              'questions'           => 'required|array|min:1',
              'questions.question'  => 'required',
              'questions.type'      => 'required'
            ]);

            if ($validator->fails()) {
              return response()->json($validator->errors(), 422);
            }

            $component = ChapterComponent::create([
              'title'       => $request->title,
              'created_by'  => auth()->user()->id,
              'visibility'  => $request->visibility ? 1 : 0,
              'chapter_id'  => $request->chapter_id,
              'type'        => $type,
              'order'       => $request->order,
              'description' => $request->description
            ]);

            $component_source = ChapterExam::create([
              'max_attempt' => $request->max_attempt,
              'duration' => $request->duration,
              'component_id' => $component->id
            ]);

            // foreach ($request->questions as $question) {
            //   $exam_questions = ExamQuestion::create([
            //     'question' => $question->question,
            //     'type' => $question->type,
            //     'answer' => $question->answer
            //   ]);
            // }
          }

          if ($type == 'meeting') {
            $validator = Validator::make($request->all(), [
              'topic'       => 'required',
              'url'         => 'required'
            ]);

            if ($validator->fails()) {
              return response()->json($validator->errors(), 422);
            }

            $component = ChapterComponent::create([
              'title'       => $request->title,
              'created_by'  => auth()->user()->id,
              'visibility'  => $request->visibility ? 1 : 0,
              'chapter_id'  => $request->chapter_id,
              'type'        => $type,
              'order'       => $request->order,
              'description' => $request->description
            ]);

            $component_source = ChapterMeeting::create([
              'topic' => $request->topic,
              'url' => $request->url,
              'component_id' => $component->id
            ]);
          }

          // return $component->source;

          $component_response = [
            'title'       => $component->title,
            'visibility'  => $component->visibility,
            'created_by'  => $component->author->name,
            'chapter'     => $component->chapter->title,
            'type'        => $component->type,
            'order'       => $component->order,
            'description' => $component->description,
            'source'      => $component_source
          ];

          return response()->json([
            'success' => true,
            'component' => $component_response
          ], 200);
        } else {
          return response()->json([
            'success' => false,
            'message' => 'TYPE_NOT_FOUND'
          ], 404);
        }
      } catch (\Exception $e) {
        return $e->getMessage();
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
        //
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
        //
    }
}
