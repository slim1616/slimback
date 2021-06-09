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
                <div class="align-items-center d-flex justify-content-sm-between">
                    <div class="card-title">Modifier porte</div>
                    <div class="btn-group dropdown">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="btn-label">
                                <i class="fa fa-cog"></i>
                            </span>
                        </button>
                        <ul class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <li>
                                <a class="dropdown-item" href="#" @click.prevent.stop="collectFromPorte">Récuperer l'historique</a>
                                <a class="dropdown-item" href="#" @click.prevent.stop="collectListeUsers">Récuperer les employés</a>
                                <template v-if="form.nature=='access'">
                                    <a class="dropdown-item" href="#" @click.prevent.stop="collectTimezones">Récuperer les Timeszones</a>
                                </template>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" @click.prevent.stop="sendToDevice">Envoyer employes</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updatePorte" v-if="loaded">
                    <div class="align-items-center d-flex justify-content-sm-between">
                        <router-link to="/portes" class="back-to"><i class="icon-arrow-left"></i> portes</router-link>
                    </div>
                  <div class="row">
                                                
                           
                                          <input class="form-control" type="hidden" v-model="form.id"/>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Titre</label>
                                <input class="form-control" type="text" v-model="form.titre"  maxlength="255" />
                                <has-error :form="form" field="titre"/>
                            </div>
                        </div>
                        
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                                                      <label>Marque</label>
                                          <input class="form-control" type="text" v-model="form.marque"  maxlength="255" />
                                                                                                      <has-error :form="form" field="marque"></has-error>
                                                
                                                        </div>
                            </div>
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                                                      <label>Model</label>
                                          <input class="form-control" type="text" v-model="form.model"  maxlength="255" />
                                                                                    
                                                        </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                            <label>Type</label>
                                            <select class="form-control" v-model="form.type">
                                                    <option  value="in">In</option>
                                                    <option  value="out">Out</option>
                                                    <option  value="inout">In/Out</option>
                                            </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                        <label>SdK</label>
                                        <select class="form-control" v-model="form.sdk">
                                                <option  value="standalone">standalone</option>
                                                <option  value="pull">pull</option>
                                        </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                        <label>Nature</label>
                                        <select class="form-control" v-model="form.nature">
                                                <option  value="access">access</option>
                                                <option  value="pointage">pointage</option>
                                        </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                                                        <label>Ip</label>
                                            <vue-ip-input :ip="form.ip" v-model="form.ip" :on-change="onIpChange" class="form-control"></vue-ip-input>
                                                                                                      <has-error :form="form" field="ip"></has-error>
                                                
                                                        </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                        <label>Port</label>
                                        <input class="form-control" type="number" v-model="form.port"/>
                                        <has-error :form="form" field="port"></has-error>
                                                
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                        <label>Mot de passe</label>
                                        <input class="form-control" type="password" v-model="form.password"/>
                                        <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                            <label>Batiment</label>
                                            <select class="form-control" v-model="form.batiment_id" @change="changeBatiment">
                                                    <option v-for="batiment in batiments" :value="batiment.id">{{batiment.title}}</option>
                                            </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                        <label>Zone</label>

                                        <select class="form-control" v-model="form.zone_id">
                                                <option v-for="zone in zones" :value="zone.id">{{zone.title}}</option>
                                        </select>
                                        <has-error :form="form" field="zone_id"></has-error>
                                                
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" v-model="form.rtlogshow">
                                        <span class="form-check-sign">Activer Rtl</span>
                                    </label>
                                </div>
                            </div>
                                                                        
                           
                                          <input class="form-control" type="hidden" v-model="form.created_at"/>
                        
                                                                        
                           
                                          <input class="form-control" type="hidden" v-model="form.updated_at"/>
                        
                                                                  </div>
                    <div class="card-action">
                        <div class="align-items-center d-flex justify-content-between p-2">
                            <div>
                                <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                                <button class="btn btn-danger" @click.prevent="deletePorte">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                            </div>
                            
                            <div class="btn-group dropdown">
                                <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="btn-label">
                                        <i class="fa fa-cog"></i>
                                    </span>
                                </button>
                                <ul class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <li>
                                        <a class="dropdown-item" href="#" @click.prevent.stop="effaceAllLogs">Effacer l'historique</a>
                                        <a class="dropdown-item" href="#" @click.prevent.stop="effaceAllusers">Effacer les employés</a>
                                        <template v-if="form.nature=='access'">
                                            <a class="dropdown-item" href="#" @click.prevent.stop="effaceAllTimezones">Effacer les Timeszones</a>
                                        </template>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
              </form>
              <span v-else>Loading porte...</span>
            </div>
        </div>
  </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
import VueIpInput from 'vue-ip-input';

export default {
  name: 'Porte',
  components: {HasError, VueIpInput},
  data: function(){
    return {
      loaded: false,
      zones:[],
      batiments : [],
      batiment_id : 0,
      form: new Form({
          id : "",
          marque : "",
          titre : "",
          model : "",
          sdk : "",
          type : "",
          rtlogshow : "",
          password : "",
          nature :"",
          ip : "",
          port : "",
          status : "",
          last_update_status : "",
          zone_id : "",
          created_at : "",
          updated_at : "",
          batiment_id : 0
        
      })
    }
  },
  created: function(){
    this.getPorte();
    this.listBatiments();
    
  },
  methods: {
      effaceAllTimezones(){
           var that = this;
            swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer les times zones dans le lecteur!",
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
                    this.$store.dispatch('setLoader', true)
                    let res = fetch(window.location.origin + '/api/effacetoustimezones/'+ this.form.id,{
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
                        console.log(data)
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
                } else {
                    swal.close();
                }
            }); 

        
      },
      effaceAllusers(){
        var that = this;
        swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer les employés enregistré dans le lecteur!",
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
                    this.$store.dispatch('setLoader', true)
                    let res = fetch(window.location.origin + '/api/effacetoususers/'+ this.form.id,{
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
                        console.log(data)
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
                } else {
                    swal.close();
                }
            }); 
        
            
      },
      effaceAllLogs(){
        var that = this;
        swal({
                    title: 'Vous êtes sure?',
                    text: "Vous allez effacer l'historique des accès du lecteur!",
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
                        this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/effacetouslogs/'+ this.form.id,{
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
                console.log(data)
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
                    } else {
                        swal.close();
                    }
                }); 
            
      },
      collectTimezones(){
          let that = this
        this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/gettimezonesbyeporte/'+ this.form.id,{
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
                console.log(data)
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
      collectListeUsers(){
          let that = this
        this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/collectelistuseres/'+ this.form.id,{
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
                // console.log(data)
                if (data.status){
                    that.$notification.success("Envoyé avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                    this.$store.dispatch('setLoader', false)
                    if (data.usersnotindevice.length>0){
                        swal("Attention", 'Il y a des employés non envoyés au lecteur', {
                            icon : "warning",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-warning'
                                }
                            },
                        });
                    }
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
      collectFromPorte(){
        let that = this
        this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/attendancefromporte/'+ this.form.id,{
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
                console.log(data)
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
    sendToDevice(){
        let that = this
        this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/sendporte/'+ this.form.id,{
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
                console.log(data)
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
    changeBatiment(){
        this.listZonesByBatiment(this.form.batiment_id)
    },
    listBatiments: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/batiments')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  that.batiments = response.data;
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
    listZonesByBatiment: async function(batiement_id){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
     let res = await this.form.post('/api/zonesbybatiment')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  that.zones = response.data;
                //   let zone = response.data.find(zone =>  zone.id==that.form.zone_id)

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
              console.log(response)
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
    onIpChange(ip) {
            // console.log('ip input change:', ip);
            this.form.ip = ip
    },
    getBatiements: function(Porte){
      
      var that = this;
      this.form.get('/api/batiments').then(function(response){
        that.zones = responses.data
      }).catch(function(e){
          if (e.response && e.response.status == 404) {
              that.$router.push('/404');
          }
      });
      
    },
    getPorte: function(Porte){
      
      var that = this;
      this.form.get('/api/portes/'+this.$route.params.id).then(function(response){
        that.form.fill(response.data);
        that.listZonesByBatiment(response.data.batiment_id);
        that.loaded = true;
      }).catch(function(e){
          if (e.response && e.response.status == 404) {
              that.$router.push('/404');
          }
      });
      
    },
    updatePorte: function(){
      var that = this;

        this.$store.dispatch('setLoader', true)
        this.form.put('/api/portes/'+this.$route.params.id)
          .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                that.$notification.success("Modifié avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
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
          })
          .catch((response) => {
              that.$store.dispatch('setLoader', false)
            });
    },
    deletePorte: function(){
      
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
                  this.$store.dispatch('setLoader', true)
                  this.form.delete('/api/portes/'+this.$route.params.id).then(function(response){
                    that.$store.dispatch('setLoader', false)
                      that.form.fill(response.data);
                      that.$router.push('/portes');
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
  .back-to{
    display: flex;
    align-items: center;
    text-decoration : none;
  }
  .back-to:hover{
    text-decoration : none;
  }
  .back-to i{
      margin-right : 7px;
  }
</style>