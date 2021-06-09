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
                <div class="card-title">Ajouter batiment</div>
            </div>
            <div class="card-body">
                <form @submit.prevent="createBatiment">
                  <router-link to="/batiments" class="back-to"><i class="icon-arrow-left"></i> batiments</router-link>
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
  name: 'Batiment',
  components: {HasError, VueIpInput},
  data: function(){
    return {
      batiments : false,
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
    this.listBatiments();
  },
  methods: {
    onIpChange(ip) {
            console.log('ip input change:', ip);
            this.form.ip = ip
    },
    listBatiments: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/batiments')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200||response.status==201){
                  that.batiments = response.data;
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
    createBatiment: function(){
      
      var that = this;
      this.form.post('/api/batiments')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
              if (response.status==200||response.status==201){
                  that.batiments.push(response.data);
                  that.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                  that.$router.push('/batiments');
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