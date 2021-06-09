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
                <div class="header-btns">
                  <div class="card-title">Liste de departements</div>
                  <router-link to="/createdepartements" class="btn btn-border btn-round btn-secondary">
                        <i class="fas fa-plus"></i> Ajouter
                  </router-link>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="departements.length > 0">
                        <thead>
                          <tr>
                                                                                                                   
                                <th scope="col">Title</th>
                                                                                                                                                                                                      <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="(departement,index) in departements"  >
                                <tr :key="departement.id">
                                                                                                                                                           
                                          <td>
                                            <router-link :to="'/departements/'+departement.id">
                                              <span v-html="departement.title"> </span>
                                            </router-link>
                                          </td>
                                                                                                                                                                                                                                                                        <td>
                                      <div class="action-btns">
                                          <router-link :to="'/departements/'+departement.id" class="edit-btn">
                                              <i class="icon-note"></i>
                                          </router-link>

                                          <a href="#" @click.prevent.stop="deleteDepartement(departement,index)" class="delete-btn">
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
  name: 'Departement',
  components: {HasError},
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
    listDepartements: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/departements')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
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
    createDepartement: function(){
      
      var that = this;
      this.form.post('/api/departements').then(function(response){
        that.departements.push(response.data);
      })
      
    },
    deleteDepartement: function(departement, index){
          var that = this;
          swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Departement!",
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
                  this.form.delete('/api/departements/'+departement.id).then(function(response){
                    that.departements.splice(index,1);
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