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
                    <a href="#">companies</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modifier company</div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updateCompany" v-if="loaded">
                  <router-link to="/companies" class="back-to"><i class="icon-arrow-left"></i> companies</router-link>
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
                        
                        
                                                                                <label>Type</label>
                                            <select class="form-control" v-model="form.type">
                                                                                                    <option value="SUARL">SUARL</option>
                                                                                                    <option value="SARL">SARL</option>
                                                                                                    <option value="SA">SA</option>
                                                                                            </select>
                                                            
                                          <has-error :form="form" field="type"></has-error>
                                                
                        
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
                                                            
                                          <has-error :form="form" field="user_id"></has-error>
                                                
                        
                                </div>
                            </div>
                                                                        
                           

                                          <input class="form-control" type="hidden" v-model="form.created_at"/>
                        
                                                                        
                           

                                          <input class="form-control" type="hidden" v-model="form.updated_at"/>
                        
                                                                  </div>
                    <div class="card-action">
                        <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                        <button class="btn btn-danger" @click.prevent="deleteCompany">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                    </div>
                    
              </form>
              <span v-else>Loading company...</span>
            </div>
        </div>
  </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform'


export default {
  name: 'Company',
  components: {HasError},
  data: function(){
    return {
      loaded: false,
                
                        
                        
                        
                
        users : [],
                        
                        
                      form: new Form({
                                id : "",
                                title : "",
                                type : "",
                                user_id : "",
                                created_at : "",
                                updated_at : "",
                  })
    }
  },
  created: function(){
    this.getCompany();
  },
  methods: {
   
    getCompany: function(Company){
      
      var that = this;
      this.form.get('/api/companies/'+this.$route.params.id).then(function(response){
        that.form.fill(response.data.company);
                
                        
                        
                        
                
        that.users =  response.data.users;
                        
                        
                        that.loaded = true;
      }).catch(function(e){
          if (e.response && e.response.status == 404) {
              that.$router.push('/404');
          }
      });
      
    },
    updateCompany: function(){
      var that = this;

        this.$store.dispatch('setLoader', true)
        this.form.put('/api/companies/'+this.$route.params.id)
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
    deleteCompany: function(){
      
      var that = this;
      swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Company!",
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
                  this.form.delete('/api/companies/'+this.$route.params.id).then(function(response){
                    that.$store.dispatch('setLoader', false)
                      that.form.fill(response.data);
                      that.$router.push('/companies');
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