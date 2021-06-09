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
                    <a href="#">zones</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-btns">
                  <div class="card-title">Liste de zones</div>
                  <template v-if="['admin'].includes(user.role)">
                    <router-link to="/createzones" class="btn btn-border btn-round btn-secondary">
                            <i class="fas fa-plus"></i> Ajouter
                    </router-link>
                  </template>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="zones.length > 0">
                        <thead>
                          <tr>
                                                                                                                   
                                <th scope="col">Zone</th>
                                <th scope="col">Porte</th>                                                                                             
                                <th scope="col">Description</th>
                                                                                         
                                <th scope="col">Batiment</th>
                                <template v-if="['admin'].includes(user.role)">
                                    <th scope="col">Actions</th>
                                </template>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="(zone,index) in zones"  >
                                <tr :key="zone.id">
                                                                                                                                                           
                                          <td>
                                            <router-link :to="'/zones/'+zone.id">
                                              <span v-html="zone.title"> </span> ({{zone.portescount}} {{zone.portescount==1 ? 'porte' : 'portes'}})
                                            </router-link>
                                          </td>
                                          <td>
                                              <ul>
                                                    <li v-for="porte in zone.portes">
                                                        <router-link :to="'/portes/'+porte.id">
                                                            {{porte.marque}} {{porte.model}}
                                                        </router-link>
                                                    </li>
                                              </ul>
                                          </td>
                                                                                                                       
                                          <td>
                                            <router-link :to="'/zones/'+zone.id">
                                              <span v-html="zone.description"> </span>
                                            </router-link>
                                          </td>
                                                                                                                       
                                          <td>
                                              <router-link :to="'/batiments/'+zone.batiment_id">
                                                    <span v-html="zone.batiment"> </span>
                                              </router-link>
                                          </td>
                                          <template v-if="['admin'].includes(user.role)">
                                                <td>
                                                    <div class="action-btns">
                                                        <router-link :to="'/zones/'+zone.id" class="edit-btn">
                                                            <i class="icon-note"></i>
                                                        </router-link>

                                                        <a href="#" @click.prevent.stop="deleteZone(zone,index)" class="delete-btn">
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
  name: 'Zone',
  components: {HasError},
  data: function(){
    return {
      zones : false,
      form: new Form({
          "id" : "",
          "title" : "",
          "description" : "",
          "batiment_id" : "",
          "batiment" : "",
          "created_at" : "",
          "updated_at" : "",
      })
    }
  },
  created: function(){
    this.listZones();
  },
  methods: {
    listZones: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/zones')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                    // console.log(response.data)
                  that.zones = response.data.data;
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
    createZone: function(){
      
      var that = this;
      this.form.post('/api/zones').then(function(response){
        that.zones.push(response.data);
      })
      
    },
    deleteZone: function(zone, index){
          var that = this;
          swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Zone!",
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
                  this.form.delete('/api/zones/'+zone.id).then(function(response){
                      if (response.data.status){
                          that.zones.splice(index,1);
                      }else{
                          swal("Erreur", "Vous ne pouvez pas effacer cette zone! effacez les portes avant d'effacer la zone", {
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