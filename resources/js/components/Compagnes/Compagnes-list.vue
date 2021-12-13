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
                    <a href="#">compagnes</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-btns">
                  <div class="card-title">Liste de compagnes</div>
                  <template v-if="user.role=='superadmin'">
                    <router-link to="/createcompagnes" class="btn btn-border btn-round btn-secondary">
                            <i class="fas fa-plus"></i> Ajouter
                    </router-link>
                  </template>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="compagnes.length > 0">
                        <thead>
                          <tr>
                                                                                                                   
                                <th scope="col">Question</th>
                                                                                        
                                <th scope="col">company</th>
                                                                                        
                                <th scope="col">Start_at</th>
                                                                                        
                                <th scope="col">End_at</th>
                                                                                        
                                <th scope="col">Nb Bornes</th>
                                                                                                                                                                                                                                      <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="(compagne,index) in compagnes"  >
                                <tr :key="compagne.id">                                                                                            
                                                <td>
                                                    <router-link :to="'/compagnes/'+compagne.id">
                                                    <span v-html="compagne.question"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                            
                                                <td>
                                                    <router-link :to="'/companies/'+compagne.company_id">
                                                        <span v-html="compagne.company"></span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                <td>
                                                    <span>{{compagne.start_at | frDate}} </span>
                                                </td>
                                                                                                                                                                   
                                                <td>
                                                    <span>{{compagne.end_at | frDate}} </span>
                                                </td>
                                                                                                                                                                   
                                                <td>
                                                    <router-link :to="'/compagnes/'+compagne.id">
                                                    <span v-html="compagne.nbBornes"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                                                                                                                                                                    <td>
                                      <div class="action-btns">
                                          <router-link :to="'/compagnes/'+compagne.id" class="edit-btn">
                                              <i class="icon-note"></i>
                                          </router-link>
                                            <template v-if="user.role=='superadmin'">
                                                    <a href="#" @click.prevent.stop="deleteCompagne(compagne,index)" class="delete-btn">
                                                        <i class="icon-close" ></i>
                                                    </a>
                                            </template>
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
import {mapGetters} from 'vuex'
import * as moment from 'moment';

export default {
  name: 'Compagne',
  components: {HasError},
  data: function(){
    return {
      compagnes : false,
      form: new Form({
          id : "",
          question : "",
          company_id : "",
          start_at : "",
          end_at : "",
          emploie : "",
          created_at : "",
          updated_at : "",
      })
    }
  },
  created: function(){
    this.listCompagnes();
  },
  filters:{
      frDate(value){
          return moment(value).format('DD/MM/YYYY')
      }
  },
  methods: {
    listCompagnes: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/compagnes')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  that.compagnes = response.data;
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
    createCompagne: function(){
      
      var that = this;
      this.form.post('/api/compagnes').then(function(response){
        that.compagnes.push(response.data);
      })
      
    },
    deleteCompagne: function(compagne, index){
          var that = this;
          swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Compagne!",
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
                  this.form.delete('/api/compagnes/'+compagne.id).then(function(response){
                    if (response.data.status){
                          that.compagnes.splice(index,1);
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
  },
  mounted(){

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