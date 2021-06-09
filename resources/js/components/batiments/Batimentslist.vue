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
                    <a href="#">batiments</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-btns">
                  <div class="card-title">Liste de batiments</div>
                  <template v-if="['admin'].includes(user.role)">
                    <router-link to="/createbatiments" class="btn btn-border btn-round btn-secondary">
                            <i class="fas fa-plus"></i> Ajouter
                    </router-link>
                  </template>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="batiments.length > 0">
                        <thead>
                          <tr>
                                                                                                                   
                                <th scope="col">Title</th>
                                <th scope="col">Zones</th>                                    
                                <th scope="col">Description</th>
                                <template v-if="['admin'].includes(user.role)">
                                    <th scope="col">Actions</th>
                                </template>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="(batiment,index) in batiments"  >
                                <tr :key="batiment.id">
                                                                                                                                                           
                                            <td>
                                                <router-link :to="'/batiments/'+batiment.id">
                                                <span v-html="batiment.title"> </span> ({{batiment.zonecount}} {{batiment.zonecount==1? 'porte': 'portes'}})
                                                </router-link>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li v-for="zone in batiment.zones">
                                                        <router-link :to="'/zones/'+zone.id">
                                                            {{zone.title}}
                                                        </router-link>
                                                    </li>
                                                </ul>
                                            </td>                                                                      
                                            <td>
                                                <router-link :to="'/batiments/'+batiment.id">
                                                <span v-html="batiment.description"> </span>
                                                </router-link>
                                            </td>
                                            <template v-if="['admin'].includes(user.role)">
                                                <td>
                                                    <div class="action-btns">
                                                        <router-link :to="'/batiments/'+batiment.id" class="edit-btn">
                                                            <i class="icon-note"></i>
                                                        </router-link>

                                                        <a href="#" @click.prevent.stop="deleteBatiment(batiment,index)" class="delete-btn">
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
  name: 'Batiment',
  components: {HasError},
  data: function(){
    return {
      batiments : false,
      form: new Form({
          "id" : "",
          "title" : "",
          "description" : "",
          "created_at" : "",
          "updated_at" : "",
      })
    }
  },
  created: function(){
    this.listBatiments();
  },
  methods: {
    listBatiments: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/batimentsall')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  that.batiments = response.data.data;
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
    createBatiment: function(){
      
      var that = this;
      this.form.post('/api/batiments').then(function(response){
        that.batiments.push(response.data);
      })
      
    },
    deleteBatiment: function(batiment, index){
          var that = this;
          swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Batiment!",
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
                  this.form.delete('/api/batiments/'+batiment.id).then(function(response){
                      if (response.data.status){
                          that.batiments.splice(index,1);
                      }else{
                          swal("Erreur", "Vous ne pouvez pas effacer ce Batiemnt! effacez les zones avant d'effacer le batiment", {
                                icon : "error",
                                buttons: {
                                    confirm: {
                                        className : 'btn btn-danger'
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
            user : 'getUser'
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