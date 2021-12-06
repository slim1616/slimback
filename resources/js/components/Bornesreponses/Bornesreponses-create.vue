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
                <div class="card-title">Ajouter bornesreponse</div>
            </div>
            <div class="card-body">
                <form @submit.prevent="createBornesreponse">
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
                                                      
                <has-error :form="form" field="company_id"/>
                                    
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
                                                      
                <has-error :form="form" field="borne_id"/>
                                    
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
                                      <has-error :form="form" field="resp"/>
                                    
                      </div>
                  </div>
                                           
                  
                          

                            <input class="form-control" type="hidden" v-model="form.created_at"/>
                             
                
                                           
                  
                          

                            <input class="form-control" type="hidden" v-model="form.updated_at"/>
                             
                
                                            </div>
                  <div class="row">
                      <button class="btn btn-primary" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Ajouter'}}</button>
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
  name: 'Bornesreponse',
  components: {HasError, Datetime},
  data: function(){
    return {
      bornesreponses : false,
                
                        
                
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
    this.listdata();
  },
  methods: {
    listdata: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/databornesreponses')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200||response.status==201){
                            
                                                
                                        
                    that.companies =  response.data.companies;
                                                
                                        
                    that.bornes =  response.data.bornes;
                                                
                                                
                                                
                                                
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
    createBornesreponse: function(){
      
      var that = this;
                
                        
                        
                        
                        
                        
                        
                      this.form.post('/api/bornesreponses')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
              if (response.status==200||response.status==201){
                  that.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                  that.$router.push('/bornesreponses');
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