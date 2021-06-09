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
                    <a href="#">batiments</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modifier batiment</div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updateBatiment" v-if="loaded">
                  <router-link to="/batiments" class="back-to"><i class="icon-arrow-left"></i> batiments</router-link>
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
                                                                        
                           
                                          <input class="form-control" type="hidden" v-model="form.created_at"/>
                        
                                                                        
                           
                                          <input class="form-control" type="hidden" v-model="form.updated_at"/>
                        
                                                                  </div>
                    <div class="card-action">
                        <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                        <button class="btn btn-danger" @click.prevent="deleteBatiment">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                    </div>
                    
              </form>
              <span v-else>Loading batiment...</span>
            </div>
        </div>
  </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
import VueIpInput from 'vue-ip-input';

export default {
  name: 'Batiment',
  components: {HasError, VueIpInput},
  data: function(){
    return {
      loaded: false,
      form: new Form({
          "id" : "",
          "title" : "",
          "description" : "",
          "created_at" : "",
          "updated_at" : "",
        
      })
    }
  },
  created: function(){
    this.getBatiment();
  },
  methods: {
    onIpChange(ip) {
            console.log('ip input change:', ip);
            this.form.ip = ip
    },
    getBatiment: function(Batiment){
      
      var that = this;
      this.form.get('/api/batiments/'+this.$route.params.id).then(function(response){
        that.form.fill(response.data);
        that.loaded = true;
      }).catch(function(e){
          if (e.response && e.response.status == 404) {
              that.$router.push('/404');
          }
      });
      
    },
    updateBatiment: function(){
      var that = this;

        this.$store.dispatch('setLoader', true)
        this.form.put('/api/batiments/'+this.$route.params.id)
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
    deleteBatiment: function(){
      
      var that = this;
      swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Batiment!",
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
                  this.form.delete('/api/batiments/'+this.$route.params.id).then(function(response){
                    that.$store.dispatch('setLoader', false)
                      that.form.fill(response.data);
                      that.$router.push('/batiments');
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