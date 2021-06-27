namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class {{ $data['singular'].'Resource' }} extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            @foreach($data['fields'] as $field)
        
                    '{{$field['name']}}' => $this->{{$field['name']}},
                    @if(count($field['relation'])>0)
        
                    '{{strtolower($field['relation']['relation_name'])}}' => $this->{{$field['relation']['relation_name']}}->title,
                    @endif
            @endforeach
        ];
    }
}
