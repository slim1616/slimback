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
                    <a href="#">timezones</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-btns">
                  <div class="card-title">Liste de timezones</div>
                  <router-link to="/createtimezones" class="btn btn-border btn-round btn-secondary">
                        <i class="fas fa-plus"></i> Ajouter
                  </router-link>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="timezones.length > 0">
                        <thead>
                          <tr>                                                         
                                <th scope="col">Titre</th>                         
                                <th scope="col">Heure debut</th>                           
                                <th scope="col">Heure fin</th>                        
                                <th scope="col">Marge entree</th>                        
                                <th scope="col">Marge sortie</th>                 
                                <th scope="col">Marge entree retard</th>                 
                                <th scope="col">Marge sortie retard</th>
                                                                                                                                                                                                      <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="(timezone,index) in timezones"  >
                                <tr :key="timezone.id">
                                                                                                                                                           
                                          <td>
                                            <router-link :to="'/timezones/'+timezone.id">
                                              <span v-html="timezone.titre"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/timezones/'+timezone.id">
                                              <span v-html="timezone.heure_debut"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/timezones/'+timezone.id">
                                              <span v-html="timezone.heure_fin"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/timezones/'+timezone.id">
                                              <span v-html="timezone.marge_entree"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/timezones/'+timezone.id">
                                              <span v-html="timezone.marge_sortie"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/timezones/'+timezone.id">
                                              <span v-html="timezone.marge_entree_retard"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/timezones/'+timezone.id">
                                              <span v-html="timezone.marge_sortie_retard"> </span>
                                            </router-link>
                                          </td>
                                                                                                                                                                                                                                                                        <td>
                                      <div class="action-btns">
                                          <router-link :to="'/timezones/'+timezone.id" class="edit-btn">
                                              <i class="icon-note"></i>
                                          </router-link>

                                          <a href="#" @click.prevent.stop="deleteTimezone(timezone,index)" class="delete-btn">
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
  name: 'Timezone',
  components: {HasError},
  data: function(){
    return {
      timezones : false,
      form: new Form({
          "id" : "",
          "titre" : "",
          "heure_debut" : "",
          "heure_fin" : "",
          "marge_entree" : "",
          "marge_sortie" : "",
          "marge_entree_retard" : "",
          "marge_sortie_retard" : "",
          "planning" : "",
          "created_at" : "",
          "updated_at" : "",
      })
    }
  },
  created: function(){
    this.listTimezones();
  },
  methods: {
    listTimezones: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/timezones')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  that.timezones = response.data.data;
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
    createTimezone: function(){
      
      var that = this;
      this.form.post('/api/timezones').then(function(response){
        that.timezones.push(response.data);
      })
      
    },
    deleteTimezone: function(timezone, index){
          var that = this;
          swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Timezone!",
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
                  this.form.delete('/api/timezones/'+timezone.id).then(function(response){
                    that.timezones.splice(index,1);
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