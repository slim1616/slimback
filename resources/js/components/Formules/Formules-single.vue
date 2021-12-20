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
                    <a href="#">formules</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modifier formule</div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updateFormule" v-if="loaded">
                  <router-link to="/formules" class="back-to"><i class="icon-arrow-left"></i> formules</router-link>
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
                            <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" v-model="form.online">
                                        <span class="form-check-sign">Actif</span>
                                    </label>
                                </div>
                            </div>                                      
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                  <label>Price</label>
                                          <input class="form-control" type="number" v-model="form.price"/>
                        
                                          <has-error :form="form" field="price"></has-error>
                                                
                        
                                </div>
                            </div>
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                  <label>Nbsurvey</label>
                                          <input class="form-control" type="number" v-model="form.nbsurvey"/>
                        
                                          <has-error :form="form" field="nbsurvey"></has-error>
                                                
                        
                                </div>
                            </div>
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                                        <label>Nbsemplacements</label>
                                        <input class="form-control" type="number" v-model="form.nbsemplacements"/>
                                        <has-error :form="form" field="nbsemplacements"></has-error>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" v-model="form.type">
                                            <option value="borne">Borne</option>
                                            <option value="app">Applications</option>
                                            <option value="multiple">Borne + Application</option>
                                    </select>
                                    <has-error :form="form" field="type"/>            
                                </div>
                            </div>
                                                                        
                           

                                          <input class="form-control" type="hidden" v-model="form.created_at"/>
                        
                                                                        
                           

                                          <input class="form-control" type="hidden" v-model="form.updated_at"/>
                        
                                                                  </div>
                    <div class="card-action">
                        <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                        <button class="btn btn-danger" @click.prevent="deleteFormule">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                    </div>
                    
              </form>
              <span v-else>Loading formule...</span>
            </div>
        </div>
  </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
import * as moment from 'moment';
import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css'

export default {
  name: 'Formule',
  components: {HasError, Datetime},
  data: function(){
    return {
      loaded: false,
                
                        
                        
                        
                        
                        
                        
                        
                      form: new Form({
                                id : "",
                                title : "",
                                online : "",
                                price : "",
                                nbsurvey : "",
                                type : "",
                                nbsemplacements : "",
                                created_at : "",
                                updated_at : "",
                  })
    }
  },
  created: function(){
    this.getFormule();
  },
  methods: {
   
    getFormule: function(Formule){
      
      var that = this;
      this.form.get('/api/formules/'+this.$route.params.id).then(function(response){
        that.form.fill(response.data.formule);
                
                        
                        
                        
                        
                        
                        
                        
                        that.loaded = true;
      }).catch(function(e){
          if (e.response && e.response.status == 404) {
              that.$router.push('/404');
          }
      });
      
    },
    updateFormule: function(){
      var that = this;

        this.$store.dispatch('setLoader', true)
                
                        
                        
                        
                        
                        
                        
                        
                
        this.form.put('/api/formules/'+this.$route.params.id)
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
    deleteFormule: function(){
        var that = this;
        swal.fire({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer une formule!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'oui',
                cancelButtonText: 'annuler',
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
            }).then((Delete) => {
                if (Delete.isConfirmed) {
                    this.$store.dispatch('setLoader', true)
                    this.form.delete('/api/formules/'+this.$route.params.id).then(function(response){
                        that.$store.dispatch('setLoader', false)
                        that.form.fill(response.data);
                        that.$router.push('/formules');
                        })
                .catch(error => {
                    that.$store.dispatch('setLoader', false)
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Erreur!',
                        customClass: {
                        confirmButton: 'btn btn-danger',
                    },
                        })
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