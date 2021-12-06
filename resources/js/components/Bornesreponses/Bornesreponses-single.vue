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
                    <a href="#">bornesreponses</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modifier bornesreponse</div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updateBornesreponse" v-if="loaded">
                  <router-link to="/bornesreponses" class="back-to"><i class="icon-arrow-left"></i> bornesreponses</router-link>
                  <div class="row">

                                                
                           

                                          <input class="form-control" type="hidden" v-model="form.id"/>
                        
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                        
                                    
                                    <label>Company</label>
                                    <select class="form-control" v-model="form.company_id">
                                            
                                            <option v-for="company in companies" :value="company.id">
                                                 {{ company.title }}
                                            </option>

                                        </select>
                                                            
                                          <has-error :form="form" field="company_id"></has-error>
                                                
                        
                                </div>
                            </div>
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                        
                                    
                                    <label>Borne</label>
                                    <select class="form-control" v-model="form.borne_id">
                                            
                                            <option v-for="borne in bornes" :value="borne.id">
                                                 {{ borne.title }}
                                            </option>

                                        </select>
                                                            
                                          <has-error :form="form" field="borne_id"></has-error>
                                                
                        
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
                        
                                                                  <label>Resp</label>
                                          <input class="form-control" type="number" v-model="form.resp"/>
                        
                                          <has-error :form="form" field="resp"></has-error>
                                                
                        
                                </div>
                            </div>
                                                                        
                           

                                          <input class="form-control" type="hidden" v-model="form.created_at"/>
                        
                                                                        
                           

                                          <input class="form-control" type="hidden" v-model="form.updated_at"/>
                        
                                                                  </div>
                    <div class="card-action">
                        <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                        <button class="btn btn-danger" @click.prevent="deleteBornesreponse">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                    </div>
                    
              </form>
              <span v-else>Loading bornesreponse...</span>
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
  name: 'Bornesreponse',
  components: {HasError, Datetime},
  data: function(){
    return {
      loaded: false,
                
                        
                
        companies : [],
                        
                
        bornes : [],
                        
                        
                        
                        
                      form: new Form({
                                id : "",
                                company_id : "",
                                borne_id : "",
                                code_borne : "",
                                resp : "",
                                created_at : "",
                                updated_at : "",
                  })
    }
  },
  created: function(){
    this.getBornesreponse();
  },
  methods: {
   
    getBornesreponse: function(Bornesreponse){
      
      var that = this;
      this.form.get('/api/bornesreponses/'+this.$route.params.id).then(function(response){
        that.form.fill(response.data.bornesreponse);
                
                        
                
        that.companies =  response.data.companies;
                        
                
        that.bornes =  response.data.bornes;
                        
                        
                        
                        
                        that.loaded = true;
      }).catch(function(e){
          if (e.response && e.response.status == 404) {
              that.$router.push('/404');
          }
      });
      
    },
    updateBornesreponse: function(){
      var that = this;

        this.$store.dispatch('setLoader', true)
                
                        
                        
                        
                        
                        
                        
                
        this.form.put('/api/bornesreponses/'+this.$route.params.id)
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
    deleteBornesreponse: function(){
      
      var that = this;
      swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Bornesreponse!",
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
                  this.form.delete('/api/bornesreponses/'+this.$route.params.id).then(function(response){
                    that.$store.dispatch('setLoader', false)
                      that.form.fill(response.data);
                      that.$router.push('/bornesreponses');
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