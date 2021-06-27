namespace App;

use Illuminate\Database\Eloquent\Model;

class {{ $data['singular'] }} extends Model
{

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        ''
    ];
    @foreach($data['fields'] as $field)
        @if(count($field['relation'])>0)
        
            public function {{$field['relation']['relation_name']}}()
            {
                return $this->{{$field['relation']['type']}}('{{$field['relation']['model']}}', '{{$field['relation']['table_field']}}');
            }
        @endif
    @endforeach
    
    @if(count($data['relations'])>0)
        @foreach($data['relations'] as $relation)

            public function {{$relation['relation_name']}}(){
                return $this->{{$relation['type']}}('{{$relation['model']}}');
            }
        @endforeach

    @endif

    }