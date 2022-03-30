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
                    <a href="#">compagnes</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ajouter compagne</div>
            </div>
            <div class="card-body">
                <form @submit.prevent="createCompagne">
                  <router-link to="/compagnes" class="back-to"><i class="icon-arrow-left"></i> compagnes</router-link>
                  <div class="row">
                           
                  
                          

                            <input class="form-control" type="hidden" v-model="form.id"/>
                             
                
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                                                                                <label>Question</label>
                                                <input class="form-control" type="text" v-model="form.question"  maxlength="255" />
                                                      
                <has-error :form="form" field="question"/>
                                    
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
                                                                                                       
                                                <datetime v-model="form.start_at"
                                                value-zone="Africa/Tunis"
                                                type="date"
                                                format="yyyy-MM-dd"
                                                input-class="form-control"/>
                                                                                
                      </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                                                                       
                                                <datetime v-model="form.end_at"
                                                value-zone="Africa/Tunis"
                                                type="date"
                                                format="yyyy-MM-dd"
                                                input-class="form-control"/>
                                                                                
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
  name: 'Compagne',
  components: {HasError, Datetime},
  data: function(){
    return {
      compagnes : false,
                
                        
                        
                
        companies : [],
                        
                        
                        
                        
                        
                        
      form: new Form({
          id : "",
          question : "",
          company_id : "",
          start_at : "",
          end_at : "",
          emploie : "",
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
      this.form.get('/api/datacompagnes')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200||response.status==201){
                            
                                                
                                                
                                        
                    that.companies =  response.data.companies;
                                                
                                                
                                                
                                                
                                                
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
    createCompagne: function(){
      
      var that = this;
                
                        
                        
                        
                    
        if (this.form.start_at!=""){
                this.form.start_at = moment(this.form.start_at).format('YYYY-MM-DD')
        }
                        
                    
        if (this.form.end_at!=""){
                this.form.end_at = moment(this.form.end_at).format('YYYY-MM-DD')
        }
                        
                        
                        
     this.form.post('/api/compagnes')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
              if (response.status==200||response.status==201){
                  ////console.log(response.data)
                  that.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                  that.$router.push('/compagnes/' + response.data.id);
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