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
                    <a href="#">abonnements</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ajouter abonnement</div>
            </div>
            <div class="card-body">
                <form @submit.prevent="createAbonnement">
                  <router-link to="/abonnements" class="back-to"><i class="icon-arrow-left"></i> abonnements</router-link>
                  <div class="row">
                           
                  
                          

                            <input class="form-control" type="hidden" v-model="form.id"/>
                             
                
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                            
                                            <label>Formule</label>
                                            <select class="form-control" v-model="form.formule_id">
                                                    
                                                    <option v-for="formule in formules" :value="formule.id">
                                                        {{ formule.title }}
                                                    </option>

                                                </select>
                                                                                  <has-error :form="form" field="formule_id"/>
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
                                                            
                                            <label>User</label>
                                            <select class="form-control" v-model="form.user_id">
                                                    
                                                    <option v-for="user in users" :value="user.id">
                                                        {{ user.name }}
                                                    </option>

                                                </select>
                                                                                  <has-error :form="form" field="user_id"/>
                                                          </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                    <label>Start_at</label>
                            <input class="form-control" type="number" v-model="form.start_at"/>
                                                          </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                    <label>End_at</label>
                            <input class="form-control" type="number" v-model="form.end_at"/>
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

export default {
  name: 'Abonnement',
  components: {HasError},
  data: function(){
    return {
      abonnements : false,
                
                        
                
        formules : [],
                        
                
        companies : [],
                        
                
        users : [],
                        
                        
                        
                        
                        
      form: new Form({
          id : "",
          formule_id : "",
          company_id : "",
          user_id : "",
          start_at : "",
          end_at : "",
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
      this.form.get('/api/dataabonnements')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200||response.status==201){
                            
                                                
                                        
                    that.formules =  response.data.formules;
                                                
                                        
                    that.companies =  response.data.companies;
                                                
                                        
                    that.users =  response.data.users;
                                                
                                                
                                                
                                                
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
    createAbonnement: function(){
      
      var that = this;
      this.form.post('/api/abonnements')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
              if (response.status==200||response.status==201){
                  that.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                  that.$router.push('/abonnements');
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