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
                    <a href="#">departements</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ajouter departement</div>
            </div>
            <div class="card-body">
                <form @submit.prevent="createDepartement">
                  <router-link to="/departements" class="back-to"><i class="icon-arrow-left"></i> departements</router-link>
                  <div class="row">
                           
                  
                           
                            <input class="form-control" type="hidden" v-model="form.id"/>
                             
                
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                        <label>Titre</label>
                                          <input class="form-control" type="text" v-model="form.title"  maxlength="255" />
                                                                          <has-error :form="form" field="title"/>
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
  name: 'Departement',
  components: {HasError, VueIpInput},
  data: function(){
    return {
      departements : false,
      form: new Form({
          "id" : "",
          "title" : "",
          "created_at" : "",
          "updated_at" : "",
      })
    }
  },
  created: function(){
    this.listDepartements();
  },
  methods: {
    onIpChange(ip) {
            console.log('ip input change:', ip);
            this.form.ip = ip
    },
    listDepartements: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/departements')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200||response.status==201){
                  that.departements = response.data;
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
    createDepartement: function(){
      
      var that = this;
      this.form.post('/api/departements')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
              if (response.status==200||response.status==201){
                  that.departements.push(response.data);
                  that.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                  that.$router.push('/departements');
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