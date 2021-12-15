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
                    <a href="#">bornesreponses</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-btns">
                  <div class="card-title">Liste de bornesreponses</div>
                  <router-link to="/createbornesreponses" class="btn btn-border btn-round btn-secondary">
                        <i class="fas fa-plus"></i> Ajouter
                  </router-link>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="bornesreponses.length > 0">
                        <thead>
                          <tr>
                                                                                                                   
                                
                                    <th scope="col">company</th>
                                                                                                                         
                                
                                    <th scope="col">borne</th>
                                                                                                                         
                                                                    <th scope="col">Code_borne</th>
                                                                                                                         
                                                                    <th scope="col">Resp</th>
                                                                                                                                                                                                                                      <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="(bornesreponse,index) in bornesreponses"  >
                                <tr :key="bornesreponse.id">
                                                                                                                                                           
                                            
                                                <td>
                                                    <router-link :to="'/companies/'+bornesreponse.company_id">
                                                        <span v-html="bornesreponse.company"></span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                            
                                                <td>
                                                    <router-link :to="'/bornes/'+bornesreponse.borne_id">
                                                        <span v-html="bornesreponse.borne"></span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/bornesreponses/'+bornesreponse.id">
                                                    <span v-html="bornesreponse.code_borne"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/bornesreponses/'+bornesreponse.id">
                                                    <span v-html="bornesreponse.resp"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                                                                                                                                                                    <td>
                                      <div class="action-btns">
                                          <router-link :to="'/bornesreponses/'+bornesreponse.id" class="edit-btn">
                                              <i class="icon-note"></i>
                                          </router-link>

                                          <a href="#" @click.prevent.stop="deleteBornesreponse(bornesreponse,index)" class="delete-btn">
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
import {mapGetters} from 'vuex'

export default {
  name: 'Bornesreponse',
  components: {HasError},
  data: function(){
    return {
      bornesreponses : false,
      form: new Form({
          id : "",
          company_id : "",
          borne_id : "",
          code_borne : "",
          resp : "",
          created_at : "",
          updated_at : "",
      })
    }
  },
  created: function(){
    this.listBornesreponses();
  },
  methods: {
    listBornesreponses: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/bornesreponses')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  that.bornesreponses = response.data;
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
    createBornesreponse: function(){
      
      var that = this;
      this.form.post('/api/bornesreponses').then(function(response){
        that.bornesreponses.push(response.data);
      })
      
    },
    deleteBornesreponse: function(bornesreponse, index){
          var that = this;
          swal.fire({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Bornesreponse!",
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
                  this.form.delete('/api/bornesreponses/'+bornesreponse.id).then(function(response){
                    that.bornesreponses.splice(index,1);
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