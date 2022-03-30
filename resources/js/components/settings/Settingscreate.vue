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
                    <a href="#">settings</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ajouter setting</div>
            </div>
            <div class="card-body">
                <form @submit.prevent="createSetting">
                  <router-link to="/settings" class="back-to"><i class="icon-arrow-left"></i> settings</router-link>
                  <div class="row">
                           
                  
                           
                            <input class="form-control" type="hidden" v-model="form.id"/>
                             
                
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                                                                      <label>Societe</label>
                                          <input class="form-control" type="text" v-model="form.societe"  maxlength="255" />
                                                                          <has-error :form="form" field="societe"/>
                                                          </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                                                                      <label>Logo_id</label>
                                          <input class="form-control" type="text" v-model="form.logo_id"  maxlength="255" />
                                                                                              </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                                                                      <label>Mail_driver</label>
                                          <input class="form-control" type="text" v-model="form.mail_driver"  maxlength="255" />
                                                                          <has-error :form="form" field="mail_driver"/>
                                                          </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                                                                      <label>Mail_host</label>
                                          <input class="form-control" type="text" v-model="form.mail_host"  maxlength="255" />
                                                                          <has-error :form="form" field="mail_host"/>
                                                          </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                                                                      <label>Mail_port</label>
                                          <input class="form-control" type="text" v-model="form.mail_port"  maxlength="255" />
                                                                          <has-error :form="form" field="mail_port"/>
                                                          </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                                                                      <label>Mail_username</label>
                                          <input class="form-control" type="text" v-model="form.mail_username"  maxlength="255" />
                                                                          <has-error :form="form" field="mail_username"/>
                                                          </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                                                                      <label>Mail_password</label>
                                          <input class="form-control" type="text" v-model="form.mail_password"  maxlength="255" />
                                                                          <has-error :form="form" field="mail_password"/>
                                                          </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                                                                      <label>Mail_encrypt</label>
                                          <input class="form-control" type="text" v-model="form.mail_encrypt"  maxlength="255" />
                                                                          <has-error :form="form" field="mail_encrypt"/>
                                                          </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                                                                      <label>From_address</label>
                                          <input class="form-control" type="text" v-model="form.from_address"  maxlength="255" />
                                                                          <has-error :form="form" field="from_address"/>
                                                          </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                                                                      <label>From_name</label>
                                          <input class="form-control" type="text" v-model="form.from_name"  maxlength="255" />
                                                                          <has-error :form="form" field="from_name"/>
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
  name: 'Setting',
  components: {HasError, VueIpInput},
  data: function(){
    return {
      settings : false,
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
          "created_at" : "",
          "updated_at" : "",
      })
    }
  },
  created: function(){
    this.listSettings();
  },
  methods: {
    onIpChange(ip) {
            ////console.log('ip input change:', ip);
            this.form.ip = ip
    },
    listSettings: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/settings')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200||response.status==201){
                  that.settings = response.data;
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
    createSetting: function(){
      
      var that = this;
      this.form.post('/api/settings')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
              if (response.status==200||response.status==201){
                  that.settings.push(response.data);
                  that.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                  that.$router.push('/settings');
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