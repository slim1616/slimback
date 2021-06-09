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
          @elseif($field['simplified_type'] == 'text' || $field['type'] == 'enum')
                                    @if($field['name'] == 'ip')
                                            <label>{{ ucfirst($field['name']) }}</label>
                                            <vue-ip-input :ip="form.{{$field['name']}}" :on-change="onIpChange" v-model="form.{{$field['name']}}" class="form-control"></vue-ip-input>
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
import VueIpInput from 'vue-ip-input';
export default {
  name: '{{ $data['singular'] }}',
  components: {HasError, VueIpInput},
  data: function(){
    return {
      {{ $data['plural_lower'] }} : false,
      form: new Form({
@foreach($data['fields'] as $field)
          "{{$field['name']}}" : "",
@endforeach
      })
    }
  },
  created: function(){
    this.list{{$data['plural']}}();
  },
  methods: {
    onIpChange(ip) {
            console.log('ip input change:', ip);
            this.form.ip = ip
    },
    list{{ $data['plural'] }}: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('{{config('vueApi.vue_url_prefix')}}/{{ $data['plural_lower'] }}')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200||response.status==201){
                  that.{{ $data['plural_lower'] }} = response.data;
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
      this.form.post('{{config('vueApi.vue_url_prefix')}}/{{ $data['plural_lower'] }}')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
              if (response.status==200||response.status==201){
                  that.{{ $data['plural_lower'] }}.push(response.data);
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

  }
}
</script>

<style>
  .invalid-feedback{
    display: block;
  }
</style>