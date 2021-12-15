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
                <div class="header-btns">
                  <div class="card-title">Liste de {{ $data['plural_lower'] }}</div>
                  <router-link to="/create{{ $data['plural_lower'] }}" class="btn btn-border btn-round btn-secondary">
                        <i class="fas fa-plus"></i> Ajouter
                  </router-link>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="{{ $data['plural_lower'] }}.length > 0">
                        <thead>
                          <tr>
                          @foreach($data['fields'] as $field)
                              @if(!($field['name'] == 'id' || $field['name'] == 'updated_at' || $field['name'] == 'created_at' ))   
                                @if(count($field['relation'])>0)

                                    <th scope="col">{{strtolower($field['relation']['relation_name'])}}</th>
                                @else
                                    <th scope="col">{{ ucfirst($field['name'])}}</th>
                                @endif
                              @endif
                          @endforeach
                              <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="({{ $data['singular_lower'] }},index) in {{ $data['plural_lower'] }}"  >
                                <tr :key="{{ $data['singular_lower'] }}.id">
                                    @foreach($data['fields'] as $field)
                                        @if(!($field['name'] == 'id' || $field['name'] == 'updated_at' || $field['name'] == 'created_at' ))   
                                            @if(count($field['relation'])>0)

                                                <td>
                                                    <router-link :to="'/{{strtolower(Str::plural($field['relation']['relation_name']))}}/'+{{$data['singular_lower']}}.{{ $field['name']}}">
                                                        <span v-html="{{$data['singular_lower']}}.{{strtolower($field['relation']['relation_name'])}}"></span>
                                                    </router-link>
                                                </td>
                                            @else
                                                <td>
                                                    <router-link :to="'/{{ $data['plural_lower'] }}/'+{{ $data['singular_lower'] }}.id">
                                                    <span v-html="{{$data['singular_lower']}}.{{ $field['name']}}"> </span>
                                                    </router-link>
                                                </td>
                                            @endif
                                        @endif
                                    @endforeach
                                    <td>
                                      <div class="action-btns">
                                          <router-link :to="'/{{ $data['plural_lower'] }}/'+{{ $data['singular_lower'] }}.id" class="edit-btn">
                                              <i class="icon-note"></i>
                                          </router-link>

                                          <a href="#" @click.prevent.stop="delete{{$data['singular']}}({{ $data['singular_lower'] }},index)" class="delete-btn">
                                            <i class="icon-close" ></i>
                                          </a>
                                      </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                      </table>
                  </div>
              </div>
      </div><!-- Card -->
  </div><!-- page-inner -->
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
import {mapGetters} from 'vuex'

export default {
  name: '{{ $data['singular'] }}',
  components: {HasError},
  data: function(){
    return {
      {{ $data['plural_lower'] }} : false,
      form: new Form({
@foreach($data['fields'] as $field)
          {{$field['name']}} : "",
@endforeach
      })
    }
  },
  created: function(){
    this.list{{$data['plural']}}();
  },
  methods: {
    list{{ $data['plural'] }}: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('{{config('vueApi.vue_url_prefix')}}/{{ $data['plural_lower'] }}')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
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
            //   that.form.fill(response.data);
          })
          .catch((response) => {
              that.$store.dispatch('setLoader', false)
              swal("Erreur", "Une erreur c'est produite", {
                      icon : "error",
                      buttons: {
                          confirm: {
                              className : 'btn btn-danger'
                          }
                      },
                  });
            });
      
    },
    create{{ $data['singular'] }}: function(){
      
      var that = this;
      this.form.post('{{config('vueApi.vue_url_prefix')}}/{{ $data['plural_lower'] }}').then(function(response){
        that.{{ $data['plural_lower'] }}.push(response.data);
      })
      
    },
    delete{{$data['singular']}}: function({{ $data['singular_lower'] }}, index){
          var that = this;
          swal.fire({
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
                  this.form.delete('{{config('vueApi.vue_url_prefix')}}/{{ $data['plural_lower'] }}/'+{{ $data['singular_lower'] }}.id).then(function(response){
                    that.{{ $data['plural_lower'] }}.splice(index,1);
                  })
                } else {
                    swal.close();
                }
            });
      
      
      
    }
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

<style scoped>
    .header-btns{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .action-btns{
        display: flex;
        justify-content: space-evenly;
        align-items: center;
    }
    .edit-btn{
      color: #31ce36!important;
      margin: 0 10px;
      text-decoration : none;
    }
    .delete-btn{
      color: #f25961!important;
      text-decoration : none;
    }
</style>