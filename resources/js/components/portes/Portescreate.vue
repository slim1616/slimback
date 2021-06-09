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
                <div class="card-title">Ajouter porte</div>
            </div>
            <div class="card-body">
                <form @submit.prevent="createPorte">
                  <router-link to="/portes" class="back-to"><i class="icon-arrow-left"></i> portes</router-link>
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
                            <has-error :form="form" field="marque"/>
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
                                            <vue-ip-input :ip="form.ip" :on-change="onIpChange" v-model="form.ip" class="form-control"></vue-ip-input>
                                            <has-error :form="form" field="ip"/>
                        </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                    <label>Port</label>
                            <input class="form-control" type="number" v-model="form.port"/>
                                      <has-error :form="form" field="port"/>
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
                                <select class="form-control" v-model="form.zone_id" @change="changeZone">
                                        <option v-for="zone in zones" :value="zone.id">{{zone.title}}</option>
                                </select>
                                <has-error :form="form" field="zone_id"></has-error>
                                <div>
                                    <template v-if="portes.length>0">
                                        <h2>Portes existantes</h2>
                                        <ul>
                                            <li v-for="porte in portes">{{porte.marque}} {{porte.model}}</li>
                                        </ul>
                                    </template>
                                    <template v-else>
                                        <p class="text-warning" style="text-align:center">Pas encore de portes</p>

                                    </template>
                                </div>  
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
                  <div class="row">
                      <button class="btn btn-border btn-icon btn-primary btn-rounded btn-success m-1" @click.prevent.stop="testCnx"><i class="icon-energy"></i></button>
                      <button class="btn btn-primary btn-round btn-secondary" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Ajouter'}}</button>
                  </div>
                </form>
          </div>
      </div><!-- Card-body -->
  </div><!-- page-inner -->
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
import VueIpInput from 'vue-ip-input';
export default {
  name: 'Porte',
  components: {HasError, VueIpInput},
  data: function(){
    return {
      portes : [],
      zones:[],
      batiments : [],
      form: new Form({
          "id" : "",
          "titre" : "",
          "type" : "in",
          "rtlogshow" : true,
          "sdk" : "pull",
          "marque" : "",
          "model" : "",
          "ip" : "",
          "port" : "",
          "nature" : "",
          "status" : "",
          "last_update_status" : "",
          "zone_id" : "",
          "batiment_id" : "",
          "created_at" : "",
          "updated_at" : "",
           batiment_id : 0
      })
    }
  },
  created: function(){
    this.listBatiments();
  },
  methods: {
      testCnx(){
        let that = this
        if (this.form.ip.trim()==""){
            return 
        }
        this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/testcnxdevice',{
                method : 'post',
                body : JSON.stringify({device_ip : this.form.ip, password : this.form.password}),
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
                // console.log(data.status)
                if (data.status){
                    swal("Succes", "Connection avec succes", {
                        icon : "success",
                        buttons: {
                            confirm: {
                                className : 'btn btn-success'
                            }
                        },
                    });
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
      async changeZone(){
            let that = this
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/portesbyzone/' + this.form.zone_id,{
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
            .then(function(response){
                    that.$store.dispatch('setLoader', false)
                    that.portes = response;
                })
                .catch((error) => {
                    console.log(error)
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
    changeBatiment(){
        this.listZonesByBatiment(this.form.batiment_id)
    },
    onIpChange(ip) {
            this.form.ip = ip
    },
    listBatiments: function(){
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/batiments')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  that.batiments = response.data;
                  that.form.batiment_id = response.data[0].id
                  that.listZonesByBatiment(response.data[0].id)
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
          .catch((error) => {
              console.log(error)
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
        this.portes = []
      var that = this;
      this.$store.dispatch('setLoader', true)
     let res = await this.form.post('/api/zonesbybatiment')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  that.zones = response.data;
                //   let zone = response.data.find(zone =>  zone.id==that.form.zone_id)
                if (response.data.length>0){
                    that.form.zone_id = response.data[0].id
                    that.changeZone()
                }

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
    createPorte: function(){
      
      var that = this;
      this.form.post('/api/portes')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
              if (response.status==200||response.status==201){
                  that.portes.push(response.data);
                  that.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                  that.$router.push('/portes');
              }else{
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
      .catch((error) => {
          console.log(error)
          that.$store.dispatch('setLoader', false)
      });  
    },

  }
}
</script>

<style>
  .invalid-feedback{
    display: block;
  }
</style>