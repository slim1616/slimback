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
                <div class="card-title">Modifier {{$data['singular_lower']}}</div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="update{{$data['singular']}}" v-if="loaded">
                  <router-link to="/{{ $data['plural_lower'] }}" class="back-to"><i class="icon-arrow-left"></i> {{ $data['plural_lower'] }}</router-link>
                  <div class="row">
                        @foreach($data['fields'] as $field)
                        @if(!($field['name'] == 'id' || $field['name'] == 'updated_at' || $field['name'] == 'created_at' ))
                            <div class="col-sm-4">
                                <div class="form-group">
                        @endif

                        @if($field['name'] == 'id' || $field['name'] == 'updated_at' || $field['name'] == 'created_at' )   
                                          <input class="form-control" type="hidden" v-model="form.{{$field['name']}}"/>
                        @elseif($field['simplified_type'] == 'text')
                                    @if($field['name'] == 'ip')
                                            <label>{{ ucfirst($field['name']) }}</label>
                                            <vue-ip-input :ip="form.{{$field['name']}}" v-model="form.{{$field['name']}}" :on-change="onIpChange" class="form-control"></vue-ip-input>
                                    @else
                                          <label>{{ ucfirst($field['name']) }}</label>
                                          <input class="form-control" type="text" v-model="form.{{$field['name']}}" @if($field['max']) maxlength="{{$field['max']}}" @endif/>
                                    @endif
                        @if($field['required'] && $field['name'] !== 'id')
                                          <has-error :form="form" field="{{$field['name']}}"></has-error>
                        @endif
                        @elseif($field['simplified_type'] == 'textarea')
                                          <label>{{ ucfirst($field['name']) }}</label>
                                          <textarea v-model="form.{{$field['name']}}" @if($field['max']) maxlength="{{$field['max']}}" @endif></textarea>
                        @if($field['required'] && $field['name'] !== 'id')
                                          <has-error :form="form" field="{{$field['name']}}"></has-error>
                        @endif
                        @else
                                          <label>{{ ucfirst($field['name']) }}</label>
                                          <input class="form-control" type="number" v-model="form.{{$field['name']}}"/>
                        @if($field['required'] && $field['name'] !== 'id')
                                          <has-error :form="form" field="{{$field['name']}}"></has-error>
                        @endif
                        @endif

                        @if(!($field['name'] == 'id' || $field['name'] == 'updated_at' || $field['name'] == 'created_at' ))
                                </div>
                            </div>
                        @endif
                        @endforeach
                  </div>
                    <div class="card-action">
                        <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">@{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                        <button class="btn btn-danger" @click.prevent="delete{{$data['singular']}}">@{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                    </div>
                    
              </form>
              <span v-else>Loading {{ $data['singular_lower'] }}...</span>
            </div>
        </div>
  </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
import VueIpInput from 'vue-ip-input';

export default {
  name: '{{ $data['singular'] }}',
  components: {HasError, VueIpInput},
  data: function(){
    return {
      loaded: false,
      form: new Form({
@foreach($data['fields'] as $field)
          "{{$field['name']}}" : "",
@endforeach        
      })
    }
  },
  created: function(){
    this.get{{$data['singular']}}();
  },
  methods: {
    onIpChange(ip) {
            console.log('ip input change:', ip);
            this.form.ip = ip
    },
    get{{$data['singular']}}: function({{$data['singular']}}){
      
      var that = this;
      this.form.get('{{config('vueApi.vue_url_prefix')}}/{{ $data['plural_lower'] }}/'+this.$route.params.id).then(function(response){
        that.form.fill(response.data);
        that.loaded = true;
      }).catch(function(e){
          if (e.response && e.response.status == 404) {
              that.$router.push('/404');
          }
      });
      
    },
    update{{$data['singular']}}: function(){
      var that = this;

        this.$store.dispatch('setLoader', true)
        this.form.put('{{config('vueApi.vue_url_prefix')}}/{{ $data['plural_lower'] }}/'+this.$route.params.id)
          .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                that.$notification.success("Modifié avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
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
    delete{{$data['singular']}}: function(){
      
      var that = this;
      swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer {{ $data['singular'] }}!",
                type: 'warning',
                buttons:{
                    
                    cancel: {
                        text : 'Annuler',
                        visible: true,
                        className: 'btn btn-danger'
                    },
                    confirm: {
                        text : 'Oui',
                        className : 'btn btn-success'
                    }
                }
            }).then((Delete) => {
                if (Delete) {
                  this.$store.dispatch('setLoader', true)
                  this.form.delete('{{config('vueApi.vue_url_prefix')}}/{{ $data['plural_lower'] }}/'+this.$route.params.id).then(function(response){
                    that.$store.dispatch('setLoader', false)
                      that.form.fill(response.data);
                      that.$router.push('/{{$data['plural_lower']}}');
                    })
                } else {
                    swal.close();
                }
            }); 
    }
  }
}
</script>



<style>
  .invalid-feedback{
    display: block;
  }
  .back-to{
    display: flex;
    align-items: center;
    text-decoration : none;
  }
  .back-to:hover{
    text-decoration : none;
  }
  .back-to i{
      margin-right : 7px;
  }
</style>