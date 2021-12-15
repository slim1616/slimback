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
                    <a href="#">abonnements</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-btns">
                  <div class="card-title">Liste de abonnements</div>
                  <router-link to="/createabonnements" class="btn btn-border btn-round btn-secondary">
                        <i class="fas fa-plus"></i> Ajouter
                  </router-link>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="abonnements.length > 0">
                        <thead>
                          <tr>
                                                                                                                   
                                
                                    <th scope="col">formule</th>
                                                                                                                         
                                
                                    <th scope="col">company</th>
                                                                                                                         
                                
                                    <th scope="col">user</th>
                                                                                                                         
                                                                    <th scope="col">Start_at</th>
                                                                                                                         
                                                                    <th scope="col">End_at</th>
                                                                                                                                                                                                                                      <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="(abonnement,index) in abonnements"  >
                                <tr :key="abonnement.id">
                                                                                                                                                           
                                            
                                                <td>
                                                    <router-link :to="'/formules/'+abonnement.formule_id">
                                                        <span v-html="abonnement.formule"></span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                            
                                                <td>
                                                    <router-link :to="'/companies/'+abonnement.company_id">
                                                        <span v-html="abonnement.company"></span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                            
                                                <td>
                                                    <router-link :to="'/users/'+abonnement.user_id">
                                                        <span v-html="abonnement.user"></span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/abonnements/'+abonnement.id">
                                                    <span>{{formatDate(abonnement.start_at)}} </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/abonnements/'+abonnement.id">
                                                    <span>{{formatDate(abonnement.end_at)}} </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                                                                                                                                                                    <td>
                                      <div class="action-btns">
                                          <router-link :to="'/abonnements/'+abonnement.id" class="edit-btn">
                                              <i class="icon-note"></i>
                                          </router-link>

                                          <a href="#" @click.prevent.stop="deleteAbonnement(abonnement,index)" class="delete-btn">
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
  name: 'Abonnement',
  components: {HasError},
  data: function(){
    return {
      abonnements : false,
      form: new Form({
          id : "",
          formule_id : "",
          company_id : "",
          user_id : "",
          start_at : "",
          end_at : "",
          created_at : "",
          updated_at : "",
      })
    }
  },
  created: function(){
    this.listAbonnements();
  },
  methods: {
    listAbonnements: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/abonnements')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  that.abonnements = response.data;
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
    createAbonnement: function(){
      
      var that = this;
      this.form.post('/api/abonnements').then(function(response){
        that.abonnements.push(response.data);
      })
      
    },
    deleteAbonnement: function(abonnement, index){
          var that = this;
          swal.fire({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Abonnement!",
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
                  this.form.delete('/api/abonnements/'+abonnement.id).then(function(response){
                    that.abonnements.splice(index,1);
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