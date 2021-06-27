namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{{ $data['singular'] }};
use App\Http\Resources\{{ $data['singular'].'Resource' }};

class {{ $data['singular'] }}Controller extends Controller
{
    public function get(Request $request, $id){
        $response = [];
        $response['{{strtolower($data['singular'])}}'] = new {{ $data['singular'].'Resource' }}({{ $data['singular'] }}::findOrFail($id));
        @foreach($data['fields'] as $field)
        
        @if(count($field['relation'])>0)

        $response['{{strtolower(Str::plural($field['relation']['relation_name']))}}'] = \{{$field['relation']['model']}}::all();
        @endif
        @endforeach

        return response($response);
    }

     public function data(Request $request){
        $response = [];
        @foreach($data['fields'] as $field)
        
        @if(count($field['relation'])>0)

        $response['{{strtolower(Str::plural($field['relation']['relation_name']))}}'] = \{{$field['relation']['model']}}::all();
        @endif
        @endforeach

        return response($response);
    }
    
    public function list(Request $request){
      return response({{ $data['singular'].'Resource' }}::collection({{ $data['singular'] }}::get()));
    }
    
    public function create(Request $request){
        
      $validatedData = $request->validate([
@foreach($data['fields'] as $field)
@if($field['required'] && $field['name'] !== 'id')
        '{{ $field['name'] }}' => 'required @if($field['max'])|max:{{$field['max']}} @endif',
@endif
@endforeach
      ],[
@foreach($data['fields'] as $field)
@if($field['required'] && $field['name'] !== 'id')
        '{{ $field['name'] }}.required' => '{{ $field['name'] }} est obligatoire.',
@if($field['max'])
        '{{ $field['name'] }}.max' => '{{ $field['name'] }} doit avoir aux max {{$field['max']}} characters.',
@endif
@endif
@endforeach
      ]);

        ${{ $data['plural_lower'] }} = {{ $data['singular'] }}::create($request->all());    
        return ${{ $data['plural_lower'] }};
    }
    
    public function update(Request $request, $id){
      
      $validatedData = $request->validate([
@foreach($data['fields'] as $field)
@if($field['required'] && $field['name'] !== 'id')
        '{{ $field['name'] }}' => 'required @if($field['max'])|max:{{$field['max']}} @endif',
@endif
@endforeach
      ],[
@foreach($data['fields'] as $field)
@if($field['required'] && $field['name'] !== 'id')
        '{{ $field['name'] }}.required' => '{{ $field['name'] }} est obligatoire.',
@if($field['max'])
        '{{ $field['name'] }}.max' => '{{ $field['name'] }} doit avoir aux max {{$field['max']}} characters.',
@endif
@endif
@endforeach
      ]);

        ${{ $data['plural_lower'] }} = {{ $data['singular'] }}::findOrFail($id);
        $input = $request->all();
        ${{ $data['plural_lower'] }}->fill($input)->save();
        return ${{ $data['plural_lower'] }};
    }
    
    public function delete(Request $request, $id){
        ${{$data['plural_lower']}} = {{$data['singular']}}::findOrFail($id);
        ${{$data['plural_lower']}}->delete();
    }
}
