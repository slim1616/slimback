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
                <div class="header-btns">
                  <div class="card-title">Liste de settings</div>
                  <router-link to="/createsettings" class="btn btn-border btn-round btn-secondary">
                        <i class="fas fa-plus"></i> Ajouter
                  </router-link>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="settings.length > 0">
                        <thead>
                          <tr>
                                                                                                                   
                                <th scope="col">Societe</th>
                                                                                         
                                <th scope="col">Logo_id</th>
                                                                                         
                                <th scope="col">Mail_driver</th>
                                                                                         
                                <th scope="col">Mail_host</th>
                                                                                         
                                <th scope="col">Mail_port</th>
                                                                                         
                                <th scope="col">Mail_username</th>
                                                                                         
                                <th scope="col">Mail_password</th>
                                                                                         
                                <th scope="col">Mail_encrypt</th>
                                                                                         
                                <th scope="col">From_address</th>
                                                                                         
                                <th scope="col">From_name</th>
                                                                                                                                                                                                      <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="(setting,index) in settings"  >
                                <tr :key="setting.id">
                                                                                                                                                           
                                          <td>
                                            <router-link :to="'/settings/'+setting.id">
                                              <span v-html="setting.societe"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/settings/'+setting.id">
                                              <span v-html="setting.logo_id"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/settings/'+setting.id">
                                              <span v-html="setting.mail_driver"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/settings/'+setting.id">
                                              <span v-html="setting.mail_host"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/settings/'+setting.id">
                                              <span v-html="setting.mail_port"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/settings/'+setting.id">
                                              <span v-html="setting.mail_username"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/settings/'+setting.id">
                                              <span v-html="setting.mail_password"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/settings/'+setting.id">
                                              <span v-html="setting.mail_encrypt"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/settings/'+setting.id">
                                              <span v-html="setting.from_address"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/settings/'+setting.id">
                                              <span v-html="setting.from_name"> </span>
                                            </router-link>
                                          </td>
                                                                                                                                                                                                                                                                        <td>
                                      <div class="action-btns">
                                          <router-link :to="'/settings/'+setting.id" class="edit-btn">
                                              <i class="icon-note"></i>
                                          </router-link>

                                          <a href="#" @click.prevent.stop="deleteSetting(setting,index)" class="delete-btn">
                                            <i class="icon-close" ></i>
                                          </a>
                                      </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                      </table>
                  </div>
              </div>
      </div><!-- Card -->
  </div><!-- page-inner -->
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
export default {
  name: 'Setting',
  components: {HasError},
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
    listSettings: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/settings')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
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
            //   that.form.fill(response.data);
          })
          .catch((response) => {
              that.$store.dispatch('setLoader', false)
              swal("Erreur", "Une erreur c'est produite", {
                      icon : "error",
                      buttons: {
                          confirm: {
                              className : 'btn btn-danger'
                          }
                      },
                  });
            });
      
    },
    createSetting: function(){
      
      var that = this;
      this.form.post('/api/settings').then(function(response){
        that.settings.push(response.data);
      })
      
    },
    deleteSetting: function(setting, index){
          var that = this;
          swal.fire({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Setting!",
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
                  this.form.delete('/api/settings/'+setting.id).then(function(response){
                    that.settings.splice(index,1);
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
</style>

<style scoped>
    .header-btns{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .action-btns{
        display: flex;
        justify-content: space-evenly;
        align-items: center;
    }
    .edit-btn{
      color: #31ce36!important;
      margin: 0 10px;
      text-decoration : none;
    }
    .delete-btn{
      color: #f25961!important;
      text-decoration : none;
    }
</style>