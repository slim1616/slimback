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
                    <a href="#">formules</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-btns">
                  <div class="card-title">Liste de formules</div>
                  <router-link to="/createformules" class="btn btn-border btn-round btn-secondary">
                        <i class="fas fa-plus"></i> Ajouter
                  </router-link>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="formules.length > 0">
                        <thead>
                          <tr>
                                                                                                                   
                                                                    <th scope="col">Title</th>
                                                                                                                         
                                                                    <th scope="col">Online</th>
                                                                                                                         
                                                                    <th scope="col">Price</th>
                                                                                                                         
                                                                    <th scope="col">Nbsurvey</th>
                                                                                                                         
                                                                    <th scope="col">Nbsemplacements</th>
                                                                                                                                                                                                                                      <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="(formule,index) in formules"  >
                                <tr :key="formule.id">
                                                                                                                                                           
                                                                                            <td>
                                                    <router-link :to="'/formules/'+formule.id">
                                                    <span v-html="formule.title"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/formules/'+formule.id">
                                                    <span v-html="formule.online"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/formules/'+formule.id">
                                                    <span v-html="formule.price"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/formules/'+formule.id">
                                                    <span v-html="formule.nbsurvey"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/formules/'+formule.id">
                                                    <span v-html="formule.nbsemplacements"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                                                                                                                                                                    <td>
                                      <div class="action-btns">
                                          <router-link :to="'/formules/'+formule.id" class="edit-btn">
                                              <i class="icon-note"></i>
                                          </router-link>

                                          <a href="#" @click.prevent.stop="deleteFormule(formule,index)" class="delete-btn">
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
  name: 'Formule',
  components: {HasError},
  data: function(){
    return {
      formules : false,
      form: new Form({
          id : "",
          title : "",
          online : "",
          price : "",
          nbsurvey : "",
          nbsemplacements : "",
          created_at : "",
          updated_at : "",
      })
    }
  },
  created: function(){
    this.listFormules();
  },
  methods: {
    listFormules: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/formules')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  that.formules = response.data;
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
    createFormule: function(){
      
      var that = this;
      this.form.post('/api/formules').then(function(response){
        that.formules.push(response.data);
      })
      
    },
    deleteFormule: function(formule, index){
          var that = this;
          swal.fire({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Formule!",
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
                  this.form.delete('/api/formules/'+formule.id).then(function(response){
                    that.formules.splice(index,1);
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