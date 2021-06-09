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
                    <a href="#">portes</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-btns">
                  <div class="card-title">Liste de portes</div>
                  <template v-if="['admin'].includes(user.role)">
                    <router-link to="/createportes" class="btn btn-border btn-round btn-secondary">
                            <i class="fas fa-plus"></i> Ajouter
                    </router-link>
                  </template>
              </div>
            </div>
            <div class="card-body">
                <div v-if="portes.length>0" class="p-2">
                    <button @click.prevent.stop="makePdf" class="btn btn-border btn-danger btn-round btn-sm">
                        <span class="btn-label">
                            <i class="far fa-file-pdf"></i>
                        </span> 
                        pdf
                    </button>

                    <download-excel
                        class="btn btn-border btn-success btn-round btn-sm"
                        header="Liste de portes"
                        :data="portes"
                        :fields="json_fields"
                        worksheet="portes"
                        name="portes.xls"
                        >
                        <i class="far fa-file-excel" style="font-size: 16px;"></i>
                        Excel
                        </download-excel> 
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" name="table" ref="table" id="pdf-make" v-if="portes.length > 0">
                        <thead>
                          <tr>
                                <th scope="col">Tite</th>                                                                                   
                                <th scope="col">Marque</th>
                                                                                         
                                <th scope="col">Model</th>
                                                                                         
                                <th scope="col">Ip</th>
                                                                                         
                                <th scope="col">Port</th>
                                                                                         
                                <th scope="col">Status</th>
                                                                                         
                                <th scope="col">Last update</th>                            
                                <th scope="col">Batiment</th>
                                <th scope="col">Zone</th>
                                                                                         
                                                                                                                                                                                                      <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="(porte,index) in portes"  >
                                <tr :key="porte.id">
                                          <td>
                                                
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <router-link :to="'/portes/'+porte.id">
                                                        <span v-html="porte.titre"> </span>
                                                    </router-link>
                                                    <template  v-if="porte.type=='in'">
                                                        <i class="icon-login" style="color: #64cf38;"></i>
                                                    </template>
                                                    <template  v-if="porte.type=='out'">
                                                        <i class="icon-logout" style="color: #f25961;"></i>
                                                    </template>
                                                    <template  v-if="porte.type=='inout'">
                                                        <i class="icon-directions" style="color: #6861ce;"></i>
                                                    </template>
                                                </div>
                                              
                                          </td>                                                                                                                 
                                          <td>
                                              <span v-html="porte.marque"> </span>
                                          </td>
                                                                                                                       
                                          <td>
                                              <span v-html="porte.model"> </span>
                                          </td>
                                                                                                                       
                                          <td>
                                              <span v-html="porte.ip"> </span>
                                          </td>
                                                                                                                       
                                          <td>
                                              <span v-html="porte.port"> </span>
                                          </td>
                                                                                                                       
                                          <td>
                                              <div class="align-items-center d-flex justify-content-center">
                                              <template v-if="porte.status=='Ok'">
                                                  <i class="icon-check" style="color: green;"></i>
                                              </template>
                                              <template v-if="porte.status=='Error'">
                                                  <i class="icon-close" style="color: red;"></i>  
                                              </template>
                                              <template v-else>

                                              </template>
                                              </div>
                                          </td>
                                                                                                                       
                                          <td>
                                              <span v-html="porte.last_update_status"> </span>
                                          </td>
                                          <td>
                                              <span v-html="porte.batiment"> </span>
                                          </td>
                                                                                                                       
                                          <td>
                                              <span v-html="porte.zone"> </span>
                                          </td>
                                                                                                                       
                                                                                                                                                                                                                                                                        <td>
                                      <div class="action-btns">
                                          <a href="#" @click.prevent.stop="SetTime(porte.id)">
                                                <i class="icon-refresh"></i>
                                          </a>
                                          <router-link :to="'/portes/'+porte.id" class="edit-btn">
                                              <i class="icon-note"></i>
                                          </router-link>

                                          <a href="#" @click.prevent.stop="deletePorte(porte,index)" class="delete-btn">
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
import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'
import TableExport from 'tableexport'
import {mapGetters} from 'vuex'
import { Form, HasError, AlertError } from 'vform'
import { setTimeout } from 'timers';


export default {
  name: 'Porte',
  components: {HasError},
  data: function(){
    return {
      portes : [],
      form: new Form({
          "id" : "",
          "marque" : "",
          "model" : "",
          "ip" : "",
          "port" : "",
          "status" : "",
          "last_update_status" : "",
          "zone_id" : "",
          "batiment_id" : "",
          "zone" : "",
          "batiment" : "",
          "created_at" : "",
          "updated_at" : "",
      }),
      json_fields: {
        'id': 'id',
        'titre': 'titre',
        'type': 'type',
        'marque' :  'marque',
        'model': 'model',
        'zone': 'zone',
    },
    }
  },
  created: function(){
    this.listPortes();
  },
  methods: {
      rtlog(){
          console.log('rtl')
          let res = fetch( 'http://192.168.1.10/cli/pldgetrtlogs/?address=192.168.1.89&password=',{
               headers : {
                    'Content-type' : 'Application/json',
                    // 'Accept':'application/json',
                    // 'X-Requested-With' : 'XMLHttpRequest',
                    // 'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                }
          })
          .then(resp => console.log(resp))
          .catch(error => console.log(error))

      },
    SetTime(porte_id){
        let that = this
        this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/settimedevice/'+ porte_id,{
                headers : {
                    'Content-type' : 'Application/json',
                    // 'Accept':'application/json',
                    'X-Requested-With' : 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then((response) => {
                if (response.ok) {
                return response.json();
                }else{
                    this.$store.dispatch('setLoader', false)
                    swal("Erreur", "Une erreur c'est produite", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                }
            })
            .then(data => {
                console.log(data.status)
                that.listPortes();
                if (data.status){
                    that.$notification.success("Envoyé avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                    this.$store.dispatch('setLoader', false)
                }else{
                    this.$store.dispatch('setLoader', false)
                    swal("Erreur", data.msg, {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                }
            })
            .catch(error => {
                console.log(error)
                this.$store.dispatch('setLoader', false)
                swal("Erreur", "Une erreur c'est produite", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
            })
    },
    makePdf(){
          const doc = new jsPDF()
          doc.autoTable({ html: '#pdf-make' })
          doc.save('portes.pdf')
      },
    listPortes: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/portes')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  
                  that.portes = response.data.data;
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
    createPorte: function(){
      
      var that = this;
      this.form.post('/api/portes').then(function(response){
        that.portes.push(response.data);
      })
      
    },
    deletePorte: function(porte, index){
          var that = this;
          swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Porte!",
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
                  this.form.delete('/api/portes/'+porte.id).then(function(response){
                    that.portes.splice(index,1);
                  })
                } else {
                    swal.close();
                }
            });
      
      
      
    },
    startRtlog(){
        var t=setInterval(()=> this.rtlog() ,3000);
    }
  },
  mounted(){
      
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
    thead > tr > th {
        text-align : center;
        padding : 5px !important;
    }
    .table td{
        padding : 0 5px!important;
    }
</style>