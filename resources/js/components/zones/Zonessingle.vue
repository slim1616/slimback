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
                    <a href="#">zones</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modifier zone</div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updateZone" v-if="loaded">
                  <router-link to="/zones" class="back-to"><i class="icon-arrow-left"></i> zones</router-link>
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
                        
                                                                                                      <label>Description</label>
                                          <input class="form-control" type="text" v-model="form.description"  maxlength="255" />
                                                                                    
                                                        </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                            <label>Batiment</label>
                                            <select class="form-control" v-model="form.batiment_id">
                                                    <option v-for="batiment in batiments" :value="batiment.id">{{batiment.title}}</option>
                                            </select>
                                            <has-error :form="form" field="batiment_id"></has-error>
                                                
                                </div>
                            </div>
                                                                        
                           
                                          <input class="form-control" type="hidden" v-model="form.created_at"/>
                        
                                                                        
                           
                                          <input class="form-control" type="hidden" v-model="form.updated_at"/>
                        
                                                                  </div>
                    <div class="card-action">
                        <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                        <button class="btn btn-danger" @click.prevent="deleteZone">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                    </div>
                    
              </form>
              <span v-else>Loading zone...</span>
            </div>
        </div>
  </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
import VueIpInput from 'vue-ip-input';

export default {
  name: 'Zone',
  components: {HasError, VueIpInput},
  data: function(){
    return {
      loaded: false,
      batiments : [],
      form: new Form({
          id : "",
          title : "",
          description : "",
          batiment_id : "",
          created_at : "",
          updated_at : "",
      })
    }
  },
  mounted: function(){
    this.getBatiements();
    this.getZone();
  },
  methods: {
   async getBatiements(){
     let res = fetch(window.location.origin + '/api/batiments',{
                headers : {
                    'Content-type' : 'Application/json',
                    // 'Accept':'application/json',
                    'X-Requested-With' : 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then((response) => {
                    if (response.ok) {
                    return response.json();
                    }else{
                        this.$store.dispatch('setLoader', false)
                        swal("Erreur", "Une erreur c'est produite", {
                            icon : "error",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-danger'
                                }
                            },
                        });
                    }
                })
                .then(data => {
                    this.$store.dispatch('setLoader', false)
                    if (data){

                        this.batiments = data
                    }
                })
                .catch(error => {
                    this.$store.dispatch('setLoader', false)
                    swal("Erreur", "Une erreur c'est produite", {
                            icon : "error",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-danger'
                                }
                            },
                        });
                })
    },
    onIpChange(ip) {
            this.form.ip = ip
    },
    getZone: function(Zone){
      
      var that = this;
      this.form.get('/api/zones/'+this.$route.params.id).then(function(response){
        that.form.fill(response.data);
        that.loaded = true;
      }).catch(function(e){
          if (e.response && e.response.status == 404) {
              that.$router.push('/404');
          }
      });
      
    },
    updateZone: function(){
      var that = this;

        this.$store.dispatch('setLoader', true)
        this.form.put('/api/zones/'+this.$route.params.id)
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
    deleteZone: function(){
      
      var that = this;
      swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Zone!",
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
                  this.form.delete('/api/zones/'+this.$route.params.id).then(function(response){
                    that.$store.dispatch('setLoader', false)
                      that.form.fill(response.data);
                      that.$router.push('/zones');
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