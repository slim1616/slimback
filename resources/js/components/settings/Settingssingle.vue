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
                    <a href="#">Paramètres</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modifier les Paramètres</div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updateSetting" v-if="loaded">
                  <div class="row">
                                                
                           
                                          <input class="form-control" type="hidden" v-model="form.id"/>
                        
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                                                      <label>Sociète</label>
                                          <input class="form-control" type="text" v-model="form.societe"  maxlength="255" />
                                                                                                      <has-error :form="form" field="societe"></has-error>
                                                
                                                        </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                                                      <label>Mail driver</label>
                                          <input class="form-control" type="text" v-model="form.mail_driver"  maxlength="255" />
                                                                                                      <has-error :form="form" field="mail_driver"></has-error>
                                                
                                                        </div>
                            </div>
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                                                      <label>Mail host</label>
                                          <input class="form-control" type="text" v-model="form.mail_host"  maxlength="255" />
                                                                                                      <has-error :form="form" field="mail_host"></has-error>
                                                
                                                        </div>
                            </div>
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                                                      <label>Mail port</label>
                                          <input class="form-control" type="number" v-model="form.mail_port"  maxlength="255" />
                                                                                                      <has-error :form="form" field="mail_port"></has-error>
                                                
                                                        </div>
                            </div>
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                                                      <label>Mail username</label>
                                          <input class="form-control" type="email" v-model="form.mail_username"  maxlength="255" />
                                                                                                      <has-error :form="form" field="mail_username"></has-error>
                                                
                                                        </div>
                            </div>
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                                                      <label>Mail password</label>
                                          <input class="form-control" type="password" v-model="form.mail_password"  maxlength="255" />
                                                                                                      <has-error :form="form" field="mail_password"></has-error>
                                                
                                                        </div>
                            </div>
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                                                      <label>Mail encryptation</label>
                                          <input class="form-control" type="text" v-model="form.mail_encrypt"  maxlength="255" />
                                                                                                      <has-error :form="form" field="mail_encrypt"></has-error>
                                                
                                                        </div>
                            </div>
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                                                      <label>From address</label>
                                          <input class="form-control" type="email" v-model="form.from_address"  maxlength="255" />
                                                                                                      <has-error :form="form" field="from_address"></has-error>
                                                
                                                        </div>
                            </div>
                            <!-- <div class="col-sm-4">
                                <div class="form-group">
                        
                                            <label>From name</label>
                                          <input class="form-control" type="text" v-model="form.from_name"  maxlength="255" />
                                                                                                      <has-error :form="form" field="from_name"></has-error>
                                                
                                </div>
                            </div> -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                        <label>Adresse serveur zk</label>
                                        <vue-ip-input :ip="form.adresse_serveur_zk" v-model="form.adresse_serveur_zk" :on-change="onIpChange" class="form-control"></vue-ip-input>
                                        <has-error :form="form" field="adresse_serveur_zk"/>
                                    </div>
                                </div>
                            <!-- <div class="col-sm-4">
                                <div class="form-group">
                        
                                            <label>Logo</label>
                                            <input class="form-control" type="text" v-model="form.logo_id"  maxlength="255" />
                                                                                    
                                </div>
                            </div>                                                                         -->
                           
                                          <input class="form-control" type="hidden" v-model="form.created_at"/>
                        
                                                                        
                           
                                          <input class="form-control" type="hidden" v-model="form.updated_at"/>
                        
                                                                  </div>
                    <div class="card-action">
                        <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                    </div>
                    
              </form>
              <span v-else>Loading setting...</span>
            </div>
        </div>
  </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
import VueIpInput from 'vue-ip-input';

export default {
  name: 'Setting',
  components: {HasError, VueIpInput},
  data: function(){
    return {
      loaded: false,
      form: new Form({
          "id" : "",
          "societe" : "",
          "logo_id" : "",
          "mail_driver" : "",
          "mail_host" : "",
          "mail_port" : "",
          "mail_username" : "",
          "mail_password" : "",
          "mail_encrypt" : "",
          "from_address" : "",
          "from_name" : "",
          "adresse_serveur_zk" : "",
          "created_at" : "",
          "updated_at" : "",
        
      })
    }
  },
  created: function(){
    this.getSetting();
  },
  methods: {
    onIpChange(ip) {
            // console.log('ip input change:', ip);
            this.form.adresse_serveur_zk = ip
    },
    getSetting: function(Setting){
      
      var that = this;
      this.form.get('/api/settings/'+this.$route.params.id).then(function(response){
        that.form.fill(response.data);
        that.loaded = true;
      }).catch(function(e){
          if (e.response && e.response.status == 404) {
              that.$router.push('/404');
          }
      });
      
    },
    updateSetting: function(){
      var that = this;

        this.$store.dispatch('setLoader', true)
        this.form.put('/api/settings')
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