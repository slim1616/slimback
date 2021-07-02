<template>
  <div class="page-inner">
        <div class="page-header">
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="#">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $data['plural_lower'] }}</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ajouter {{$data['singular_lower']}}</div>
            </div>
            <div class="card-body">
                <form @submit.prevent="create{{ $data['singular'] }}">
                  <router-link to="/{{ $data['plural_lower'] }}" class="back-to"><i class="icon-arrow-left"></i> {{ $data['plural_lower'] }}</router-link>
                  <div class="row">
          @foreach($data['fields'] as $field)
              @if($field['name'] == 'id' || $field['name'] == 'updated_at' || $field['name'] == 'created_at' )   
                  
              @else
                  <div class="col-sm-4">
                      <div class="form-group">
              @endif
          @if($field['name'] == 'id' || $field['name'] == 'updated_at' || $field['name'] == 'created_at' )  

                            <input class="form-control" type="hidden" v-model="form.{{$field['name']}}"/>
          @elseif($field['simplified_type'] == 'text' || $field['type'] == 'enum' || $field['type'] == 'bigint' || $field['type'] == 'date')
                                        @if($field['type'] == 'enum')
                                            <label>{{ ucfirst($field['name']) }}</label>
                                            <select class="form-control" v-model="form.{{$field['name']}}">
                                                @foreach($field['options'] as $option)
                                                    <option value="{{$option}}">{{$option}}</option>
                                                @endforeach
                                            </select>
                                            @elseif($field['type'] == 'date')
                                       
                                                <datetime v-model="form.{{$field['name']}}"
                                                value-zone="Africa/Tunis"
                                                type="date"
                                                format="yyyy-MM-dd"
                                                input-class="form-control"/>
                                            @elseif(count($field['relation'])>0)

                                            <label>{{$field['relation']['relation_name']}}</label>
                                            <select class="form-control" v-model="form.{{$field['name']}}">
                                                    
                                                    <option v-for="{{strtolower($field['relation']['relation_name'])}} in {{strtolower(Str::plural($field['relation']['relation_name']))}}" :value="{{strtolower($field['relation']['relation_name'])}}.id">
                                                        {{ <?php echo strtolower($field['relation']['relation_name'])=='user'? strtolower($field['relation']['relation_name']) . '.name':strtolower($field['relation']['relation_name']) . '.title';?> }}
                                                    </option>

                                                </select>
                                            @else
                                                <label>{{ ucfirst($field['name']) }}</label>
                                                <input class="form-control" type="text" v-model="form.{{$field['name']}}" @if($field['max']) maxlength="{{$field['max']}}" @endif/>
                                            @endif
          @if($field['required'] && $field['name'] !== 'id')

                <has-error :form="form" field="{{$field['name']}}"/>
          @endif
          @elseif($field['simplified_type'] == 'textarea')
                            <label>{{ ucfirst($field['name']) }}</label>
                            <textarea class="form-control" v-model="form.{{$field['name']}}" @if($field['max']) maxlength="{{$field['max']}}" @endif></textarea>
          @if($field['required'] && $field['name'] !== 'id')
                            <has-error :form="form" field="{{$field['name']}}"/>
          @endif
          @else
                            <label>{{ ucfirst($field['name']) }}</label>
                            <input class="form-control" type="number" v-model="form.{{$field['name']}}"/>
          @if($field['required'] && $field['name'] !== 'id')
                            <has-error :form="form" field="{{$field['name']}}"/>
          @endif
          @endif
                @if($field['name'] == 'id' || $field['name'] == 'updated_at' || $field['name'] == 'created_at' )   
                
                @else

                      </div>
                  </div>
                @endif
          @endforeach
                  </div>
                  <div class="row">
                      <button class="btn btn-primary" type="submit" :disabled="form.busy" name="button">@{{ (form.busy) ? 'Please wait...' : 'Ajouter'}}</button>
                  </div>
                </form>
          </div>
      </div><!-- Card-body -->
  </div><!-- page-inner -->
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
import * as moment from 'moment';
import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css'
import {mapGetters} from 'vuex'


export default {
  name: '{{ $data['singular'] }}',
  components: {HasError, Datetime},
  data: function(){
    return {
      {{ $data['plural_lower'] }} : false,
        @foreach($data['fields'] as $field)
        
        @if(count($field['relation'])>0)
        
        {{strtolower(Str::plural($field['relation']['relation_name']))}} : [],
        @endif
        @endforeach
        
      form: new Form({
@foreach($data['fields'] as $field)
          {{$field['name']}} : "",
@endforeach
      })
    }
  },
  created: function(){
    this.listdata();
  },
  methods: {
    listdata: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('{{config('vueApi.vue_url_prefix')}}/data{{ $data['plural_lower'] }}')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200||response.status==201){
                    @foreach($data['fields'] as $field)
        
                    @if(count($field['relation'])>0)
                    
                    that.{{strtolower(Str::plural($field['relation']['relation_name']))}} =  response.data.{{strtolower(Str::plural($field['relation']['relation_name']))}};
                    @endif
                    @endforeach
              }else{
                that.$store.dispatch('setLoader', false)
                swal("Erreur", "Erreru de requete", {
                    icon : "error",
                    buttons: {
                        confirm: {
                            className : 'btn btn-danger'
                        }
                    },
                });
              }
          })
          .catch((response) => {
                that.$store.dispatch('setLoader', false)
                
            });
    },
    create{{ $data['singular'] }}: function(){
      
      var that = this;
        @foreach($data['fields'] as $field)
        
        @if($field['type']=='date')
            
        if (this.form.{{$field['name']}}!=""){
                this.form.{{$field['name']}} = moment(this.form.{{$field['name']}}).format('YYYY-MM-DD')
        }
        @endif
        @endforeach
      this.form.post('{{config('vueApi.vue_url_prefix')}}/{{ $data['plural_lower'] }}')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
              if (response.status==200||response.status==201){
                  that.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                  that.$router.push('/{{$data['plural_lower']}}');
              }else{
                swal("Erreur", "Erreru de requete", {
                    icon : "error",
                    buttons: {
                        confirm: {
                            className : 'btn btn-danger'
                        }
                    },
                });
              }
      })
      .catch((response) => {
          that.$store.dispatch('setLoader', false)
      });  
    },

  },
  computed:{
      ...mapGetters({
          user : 'getUser',
      })
  }
}
</script>

<style>
  .invalid-feedback{
    display: block;
  }
</style>