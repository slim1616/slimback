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
                    <a href="#">bornes</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-btns">
                  <div class="card-title">Liste de bornes</div>
                  <template v-if="user.role=='superadmin'">
                    <router-link to="/createbornes" class="btn btn-border btn-round btn-secondary">
                            <i class="fas fa-plus"></i> Ajouter
                    </router-link>
                  </template>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="bornes.length > 0">
                        <thead>
                          <tr>                                                     
                            <th scope="col">Title</th>                         
                            <th scope="col">Code_borne</th>                                 
                            <th scope="col">Ip</th>                                
                            <th scope="col">Lat</th>                                
                            <th scope="col">Lng</th>
                            <th scope="col">company</th>
                            <template v-if="user.role=='superadmin'">
                                <th scope="col">Actions</th>
                            </template>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="(borne,index) in bornes"  >
                                <tr :key="borne.id">
                                                                                                                                                           
                                                                                            <td>
                                                    <router-link :to="'/bornes/'+borne.id">
                                                    <span v-html="borne.title"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/bornes/'+borne.id">
                                                    <span v-html="borne.code_borne"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/bornes/'+borne.id">
                                                    <span v-html="borne.ip"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/bornes/'+borne.id">
                                                    <span v-html="borne.lat"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/bornes/'+borne.id">
                                                    <span v-html="borne.lng"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                            
                                                <td>
                                                    <router-link :to="'/companies/'+borne.company_id">
                                                        <span v-html="borne.company"></span>
                                                    </router-link>
                                                </td>
                                                <template v-if="user.role=='superadmin'">                                                                                                                                                                                                                                             
                                                <td>
                                                    <div class="action-btns">
                                                        <router-link :to="'/bornes/'+borne.id" class="edit-btn">
                                                            <i class="icon-note"></i>
                                                        </router-link>

                                                        <a href="#" @click.prevent.stop="deleteBorne(borne,index)" class="delete-btn">
                                                            <i class="icon-close" ></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                </template>
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
import {mapGetters} from 'vuex'

export default {
  name: 'Borne',
  components: {HasError},
  data: function(){
    return {
      bornes : false,
      form: new Form({
          id : "",
          title : "",
          code_borne : "",
          ip : "",
          lat : "",
          lng : "",
          company_id : "",
          created_at : "",
          updated_at : "",
      })
    }
  },
  created: function(){
    this.listBornes();
  },
  methods: {
    listBornes: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/bornes')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  that.bornes = response.data;
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
    createBorne: function(){
      
      var that = this;
      this.form.post('/api/bornes').then(function(response){
        that.bornes.push(response.data);
      })
      
    },
    deleteBorne: function(borne, index){
          var that = this;
          swal.fire({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Borne!",
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
                  this.form.delete('/api/bornes/'+borne.id).then(function(response){
                      if (response.data.status){
                          that.bornes.splice(index,1);
                      }else{
                            swal("Erreur", response.data.msg, {
                                icon : "warning",
                                buttons: {
                                    confirm: {
                                        className : 'btn btn-warning'
                                    }
                                },
                            });
                      }
                  })
                } else {
                    swal.close();
                }
            });
      
      
      
    }
  },
  computed:{
      ...mapGetters({
          user : 'getUser',
      })
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