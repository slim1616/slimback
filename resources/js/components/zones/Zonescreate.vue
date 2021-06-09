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
                <div class="card-title">Ajouter zone</div>
            </div>
            <div class="card-body">
                <form @submit.prevent="createZone">
                  <router-link to="/zones" class="back-to"><i class="icon-arrow-left"></i> zones</router-link>
                  <div class="row">
                           
                  
                           
                            <input class="form-control" type="hidden" v-model="form.id"/>
                             
                
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                                                                      <label>Title</label>
                                          <input class="form-control" type="text" v-model="form.title"  maxlength="255" />
                                                                          <has-error :form="form" field="title"/>
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
import VueIpInput from 'vue-ip-input';
export default {
  name: 'Zone',
  components: {HasError, VueIpInput},
  data: function(){
    return {
      zones : false,
      batiments : [],
      form: new Form({
          "id" : "",
          "title" : "",
          "description" : "",
          "batiment_id" : "",
          "created_at" : "",
          "updated_at" : "",
      })
    }
  },
  created: function(){
      this.getBatiements()
    this.listZones();
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
            console.log('ip input change:', ip);
            this.form.ip = ip
    },
    listZones: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/zones')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200||response.status==201){
                  that.zones = response.data;
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
    createZone: function(){
      
      var that = this;
      this.form.post('/api/zones')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
              if (response.status==200||response.status==201){
                  that.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                  that.$router.push('/zones');
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
          swal("Erreur", "Erreru de requete", {
                    icon : "error",
                    buttons: {
                        confirm: {
                            className : 'btn btn-danger'
                        }
                    },
                });
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