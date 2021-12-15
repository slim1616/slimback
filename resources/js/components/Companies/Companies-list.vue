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
                    <a href="#">companies</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-btns">
                  <div class="card-title">Liste de companies</div>
                  <router-link to="/createcompanies" class="btn btn-border btn-round btn-secondary">
                        <i class="fas fa-plus"></i> Ajouter
                  </router-link>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="companies.length > 0">
                        <thead>
                          <tr>
                                                                                                                   
                                                                    <th scope="col">Title</th>
                                                                                                                         
                                                                    <th scope="col">Type</th>
                                                                                                                         
                                                                    <th scope="col">Adresse</th>
                                                                                                                         
                                                                    <th scope="col">Email</th>
                                                                                                                         
                                                                    <th scope="col">Tel</th>
                                                                                                                         
                                                                    <th scope="col">Codetva</th>
                                                                                                                         
                                
                                    <th scope="col">user</th>
                                                                                                                                                                                                                                      <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="(company,index) in companies"  >
                                <tr :key="company.id">
                                                                                                                                                           
                                                                                            <td>
                                                    <router-link :to="'/companies/'+company.id">
                                                    <span v-html="company.title"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/companies/'+company.id">
                                                    <span v-html="company.type"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/companies/'+company.id">
                                                    <span v-html="company.adresse"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/companies/'+company.id">
                                                    <span v-html="company.email"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/companies/'+company.id">
                                                    <span v-html="company.tel"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/companies/'+company.id">
                                                    <span v-html="company.codetva"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                            
                                                <td>
                                                    <router-link :to="'/users/'+company.user_id">
                                                        <span v-html="company.user"></span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                                                                                                                                                                    <td>
                                      <div class="action-btns">
                                          <router-link :to="'/companies/'+company.id" class="edit-btn">
                                              <i class="icon-note"></i>
                                          </router-link>

                                          <a href="#" @click.prevent.stop="deleteCompany(company,index)" class="delete-btn">
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
  name: 'Company',
  components: {HasError},
  data: function(){
    return {
      companies : false,
      form: new Form({
          id : "",
          title : "",
          type : "",
          adresse : "",
          email : "",
          tel : "",
          codetva : "",
          user_id : "",
          created_at : "",
          updated_at : "",
      })
    }
  },
  created: function(){
    this.listCompanies();
  },
  methods: {
    listCompanies: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/companies')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  that.companies = response.data;
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
    createCompany: function(){
      
      var that = this;
      this.form.post('/api/companies').then(function(response){
        that.companies.push(response.data);
      })
      
    },
    deleteCompany: function(company, index){
          var that = this;
          swal.fire({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Company!",
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
                  this.form.delete('/api/companies/'+company.id).then(function(response){
                    that.companies.splice(index,1);
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