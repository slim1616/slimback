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
                    <a href="#">bornes</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modifier borne</div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updateBorne" v-if="loaded">
                  <router-link to="/bornes" class="back-to"><i class="icon-arrow-left"></i> bornes</router-link>
                  <div class="row">

                                                
                           

                                          <input class="form-control" type="hidden" v-model="form.id"/>
                        
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                        
                                                                            
                                          <label>Title</label>
                                          <input class="form-control" type="text" v-model="form.title"  maxlength="255" />
                                                            
                                          <has-error :form="form" field="title"></has-error>
                                                
                        
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                                                            
                                        <label>Company</label>
                                        <select class="form-control" v-model="form.company_id">    
                                            <option v-for="company in companies" :value="company.id">
                                                {{ company.title }}
                                            </option>
                                        </select>             
                                        <has-error :form="form" field="company_id"/>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                        
                                                                            
                                          <label>Code_borne</label>
                                          <input class="form-control" type="text" v-model="form.code_borne"  maxlength="255" />
                                                                                    
                        
                                </div>
                            </div>
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                        
                                                                            
                                          <label>Ip</label>
                                          <input class="form-control" type="text" v-model="form.ip"  maxlength="255" />
                                                                                    
                        
                                </div>
                            </div>
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                  <label>Lat</label>
                                          <input class="form-control" type="number" v-model="form.lat"/>
                                                
                        
                                </div>
                            </div>
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                  <label>Lng</label>
                                          <input class="form-control" type="number" v-model="form.lng"/>
                                                
                        
                                </div>
                            </div>
                                                                        
                           

                                          <input class="form-control" type="hidden" v-model="form.created_at"/>
                        
                                                                        
                           

                                          <input class="form-control" type="hidden" v-model="form.updated_at"/>
                        
                                                                  </div>
                    <template v-if="user.role=='superadmin'">
                        <div class="card-action">
                            <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                            <button class="btn btn-danger" @click.prevent="deleteBorne">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                        </div>
                    </template>
                    
              </form>
              <span v-else>Loading borne...</span>
            </div>
        </div>
  </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
import * as moment from 'moment';
import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css'
import {mapGetters} from 'vuex'

export default {
  name: 'Borne',
  components: {HasError, Datetime},
  data: function(){
    return {
      loaded: false,
                
                        
                        
                        
                        
                        
                        
                
        companies : [],
                        
                        
                      form: new Form({
                                id : "",
                                title : "",
                                code_borne : "",
                                ip : "",
                                lat : "",
                                lng : "",
                                company_id : "",
                                created_at : "",
                                updated_at : "",
                  })
    }
  },
  created: function(){
    this.getBorne();
  },
  methods: {
   
    getBorne: function(Borne){
      
      var that = this;
      this.form.get('/api/bornes/'+this.$route.params.id).then(function(response){
        that.form.fill(response.data.borne);
                
                        
                        
                        
                        
                        
                        
                
        that.companies =  response.data.companies;
                        
                        
                        that.loaded = true;
      }).catch(function(e){
          if (e.response && e.response.status == 404) {
              that.$router.push('/404');
          }
      });
      
    },
    updateBorne: function(){
      var that = this;

        this.$store.dispatch('setLoader', true)
                
                        
                        
                        
                        
                        
                        
                        
                        
                
        this.form.put('/api/bornes/'+this.$route.params.id)
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
    deleteBorne: function(){
      
      var that = this;
      swal.fire({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Borne!",
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
                  this.form.delete('/api/bornes/'+this.$route.params.id).then(function(response){
                    that.$store.dispatch('setLoader', false)
                      if (response.data.status){
                          that.$router.push('/bornes');
                      }else{
                            swal("Erreur", response.data.msg, {
                                icon : "warning",
                                buttons: {
                                    confirm: {
                                        className : 'btn btn-warning'
                                    }
                                },
                            });
                      }
                      
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