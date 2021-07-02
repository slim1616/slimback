<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Section;
use App\Iconquestion;
use App\Choixquestion;

use App\Http\Resources\QuestionResource;

class QuestionController extends Controller
{
    public function get(Request $request, $id){
        $response = [];
        $response['question'] = new QuestionResource(Question::findOrFail($id));
        $response['companies'] = \App\Company::all();
        $response['users'] = \App\User::all();
        $response['enquetes'] = \App\Enquete::all();        
        return response($response);
    }

    

     public function data(Request $request){
        $response = [];
        $response['companies'] = \App\Company::all();
        $response['users'] = \App\User::all();
        $response['enquetes'] = \App\Enquete::all();
        return response($response);
    }
    
    public function list(Request $request){
      return response(QuestionResource::collection(Question::get()));
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
        'question' => 'required |max:255 ',
        'type' => 'required ',
        'options' => 'required ',
        'company_id' => 'required |max:20 ',
        'user_id' => 'required |max:20 ',
        'enquete_id' => 'required |max:20 ',
      ],[
        'question.required' => 'question est obligatoire.',
        'question.max' => 'question doit avoir aux max 255 characters.',
        'type.required' => 'type est obligatoire.',
        'options.required' => 'options est obligatoire.',
        'company_id.required' => 'company_id est obligatoire.',
        'company_id.max' => 'company_id doit avoir aux max 20 characters.',
        'user_id.required' => 'user_id est obligatoire.',
        'user_id.max' => 'user_id doit avoir aux max 20 characters.',
        'enquete_id.required' => 'enquete_id est obligatoire.',
        'enquete_id.max' => 'enquete_id doit avoir aux max 20 characters.',
      ]);

        $questions = Question::create($request->all());    
        return $questions;
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
        'question' => 'required |max:255 ',
        'type' => 'required ',
        'options' => 'required ',
        'company_id' => 'required |max:20 ',
        'user_id' => 'required |max:20 ',
        'enquete_id' => 'required |max:20 ',
      ],[
        'question.required' => 'question est obligatoire.',
        'question.max' => 'question doit avoir aux max 255 characters.',
        'type.required' => 'type est obligatoire.',
        'options.required' => 'options est obligatoire.',
        'company_id.required' => 'company_id est obligatoire.',
        'company_id.max' => 'company_id doit avoir aux max 20 characters.',
        'user_id.required' => 'user_id est obligatoire.',
        'user_id.max' => 'user_id doit avoir aux max 20 characters.',
        'enquete_id.required' => 'enquete_id est obligatoire.',
        'enquete_id.max' => 'enquete_id doit avoir aux max 20 characters.',
      ]);

        $questions = Question::findOrFail($id);
        $input = $request->all();
        $questions->fill($input)->save();
        return $questions;
    }
    
    public function delete(Request $request, $id){
        $questions = Question::findOrFail($id);
        $questions->delete();
    }

    public function saveQuestions(Request $request){
        
      $user = $request->user();
      
      foreach ($request->questions as $ques) {
          if ($ques['id']!=0){
              $section = Section::find($ques['id']);
              // $section->user_id = $user->id;
              // $section->enquete_id = $request->enquete_id;
              
          }else{
              $section = new Section();
              $section->user_id = $user->id;
              $section->enquete_id = $request->enquete_id;
              $section->company_id = $request->company_id;
          }
            switch ($ques['question_type']) {
                
                case 'choix':
                    $questionType = new Choixquestion();
                    $questionType->label = $ques['label'];
                    $questionType->typeinput = $ques['typeinput'];
                    break;
                case 'icons':
                    $questionType = new Iconquestion();
                    $questionType->label = $ques['label'];
                    $questionType->typeIcon = $ques['typeIcon'];
                    
                    break;
                default:
                    break;
            }
              // dd($ques['questions']);
              
              $questionType->user_id = $user->id;
              $questionType->enquete_id = $request->enquete_id;
              $questionType->company_id = $request->company_id;
              $questionType->textquestion = $ques['textquestion'];
              $questionType->question_type = $ques['question_type'];
              // dd(json_encode($ques['questions']));
              $questionType->questions = $ques['questions'];
              $questionType->save();


              $section->obligatoire = $ques['obligatoire'];
              $section->status = $ques['status'];
              $section->order = $ques['order'];
              $section->type = $ques['question_type'];
              $section->sectionnable_id = $questionType->id;
              $section->sectionnable_type = get_class($questionType);
              
              

          $section->save();
      }
      $questions = Section::where('enquete_id', $request->enquete_id)
                          ->orderBy('order')
                          ->get();
      if($questions){
          return response(['status' => true, 'questions' => QuestionResource::collection($questions)]);
      }else{
          return response(['status' => false, 'msg' => 'Error...']);
      }
  }
  
  public function QuestionsByEnquete(Request $request){
    $user = $request->user();
    $questions = Section::where('enquete_id', $request->enquete_id)
                          ->orderBy('order')
                          ->get();
      if($questions){
          return response(['status' => true, 'questions' => QuestionResource::collection($questions)]);
      }else{
          return response(['status' => false, 'msg' => 'Error...']);
      }
  }
  public function deleteSection(Request $request, $section_id){
    $section = Section::find($section_id);
    $user = $request->user();
    if ($user->Company->id==$section->company_id){
        if ($section){
            if ($section->sectionnable){
                $section->sectionnable->delete();
            }
            $section->delete();
            $questions = Section::where('enquete_id', $request->enquete_id)
                            ->orderBy('order')
                            ->get();
            if($questions){
                return response(['statue' => true, 'questions' => QuestionResource::collection($questions)]);
            }else{
                return response(['statue' => false, 'msg' => 'Error...']);
            }
        }else{
            return response(['statue' => false, 'msg' => 'Error...']);
        }
    }else{
        return response(['statue' => false, 'msg' => 'Not Allowed']);
    }
}
}
 ?>