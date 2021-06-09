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
                    <a href="#">Historique</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Accés et pointage</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="align-items-center d-flex justify-content-between">
                    <div class="card-title">Accèes & Pointage</div>
                    <button class="btn btn-border btn-rounded btn-secondary"
                        @click.prevent.stop="importFromAllDevices">
                        <i class="icon-cloud-download"></i> Importer
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Date début</label>
                            <datetime v-model="date_deb"
                                        value-zone="Africa/Tunis"
                                        type="datetime"
                                        format="dd/MM/yyyy HH:mm"
                                        input-class="form-control">
                                </datetime>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Date fin</label>
                            <datetime v-model="date_fin"
                                        value-zone="Africa/Tunis"
                                        type="datetime"
                                        format="dd/MM/yyyy HH:mm"
                                        input-class="form-control">
                                </datetime>
                        </div>
                    </div>
                    <div class="col-sm-4">
                            <div class="form-group">
                                        <label>Batiment</label>
                                        <select class="form-control" v-model="batiment_id" @change="changeBatiment">
                                                <option v-for="batiment in batiments" :value="batiment.id">{{batiment.title}}</option>
                                        </select>
                            </div>
                        </div>

                    
                </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                    <label>Zone</label>

                                    <select class="form-control" v-model="zone_id" @change="changeZone">
                                            <option :value="0">Tous</option>
                                            <option v-for="zone in zones" :value="zone.id">{{zone.title}}</option>
                                    </select>       
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                    <label>Porte</label>

                                    <select class="form-control" v-model="porte_id">
                                            <option :value="0">Tous</option>
                                            <option v-for="porte in portes" :value="porte.id">{{porte.titre}}</option>
                                    </select>       
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Departement</label>
                                <select class="form-control" v-model="departement_id" >
                                    <option :value="0">Tous</option>
                                    <option v-for="departement in departements" :value="departement.id">{{departement.title}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Nature</label>
                                <select class="form-control" v-model="nature" >
                                    <option value="">Tous</option>
                                    <option value="access">Accèes</option>
                                    <option value="pointage">Pointage</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Type Carte</label>
                                <select class="form-control" v-model="type_carte" >
                                    <option value="employe">Employe</option>
                                    <option value="visiteur">Visiteur</option>
                                    <option value="intervenant">Intervenant</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="align-items-center align-items-end d-flex justify-content-end">
                                <button class="btn btn-border btn-round btn-success"  @click.prevent.stop="filter">filter</button>
                            </div>
                        </div>
                    </div>
                    <div v-if="historiques.length>0" class="align-items-center d-flex justify-content-between p-2">
                        <div class="">
                            <button @click.prevent.stop="makePdf" class="btn btn-border btn-danger btn-round btn-sm">
                                <span class="btn-label">
                                    <i class="far fa-file-pdf"></i>
                                </span> 
                                pdf
                            </button>

                            <download-excel
                                class="btn btn-border btn-success btn-round btn-sm"
                                header="Historique des accèes & Pointage"
                                :data="filtredhistorique"
                                :fields="json_fields"
                                worksheet="Historique"
                                name="Historique.xls"
                                >
                                <i class="far fa-file-excel" style="font-size: 16px;"></i>
                                Excel
                                </download-excel> 
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"  placeholder="recherche" v-model="search">
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                                <table class="table table-bordered table-head-bg-primary" name="table" ref="table" id="pdf-make" v-if="filtredhistorique.length > 0">
                                    <thead>
                                        <tr>                           
                                            <th scope="col">Nom & prenom</th>
                                            <th scope="col">Département</th>                                        
                                            <th scope="col">Batiment</th>                                                                                                                                   
                                            <th scope="col">Zone</th>                                                                                                                                   
                                            <th scope="col">Nature</th>                                                                                                                                   
                                            <th scope="col">Porte</th>                                                                                                                                   
                                            <th scope="col">
                                                
                                                 <label style="color:#fff !important">
                                                    Date/Heure
                                                </label>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-for="(historique,index) in filtredhistorique"  >
                                            <tr :key="historique.id">
                                                                                                                                                                    
                                                    <td>
                                                        <router-link :to="{name : 'editEmploye', params : {'id' : historique.employe_id}}" class="d-flex">
                                                            <template v-if="historique.employe_id!=0">
                                                                <div class="avatar avatar-xs" style="margin-right:3px">
                                                                    <img :src="historique.avatar" class="avatar-img rounded-circle"/>
                                                                </div>
                                                            </template>
                                                            <span v-html="historique.employe"> </span>
                                                        </router-link>
                                                    </td>
                                                                                                                                
                                                    <td>
                                                        {{historique.departement}} 
                                                    </td>
                                                    <td>
                                                        {{historique.batiement}} 
                                                    </td>                                                                            
                                                    <td>
                                                        {{historique.zone}} 
                                                    </td>
                                                    <td>
                                                        {{historique.nature_porte}} 
                                                    </td>
                                                    <td>
                                                        {{historique.porte}}
                                                    </td>
                                                    <td>
                                                         {{historique.datetime}}
                                                    </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import * as moment from 'moment';
import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css'
import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'
import TableExport from 'tableexport'

window.moment = moment

export default {
    components : {Datetime},
    data(){
        return {
            search : '',
            nature : '',
            type_carte : 'employe',
            historiques : [],
            departements : [],
            employes : [],
            selectedEmployes : [],
            zones : [],
            batiments : [],
            timezones : [],
            portes : [],
            timezone_id : 0,
            departement_id : 0,
            batiment_id : 0,
            zone_id : 0,
            porte_id : 0,
            checkall : false,
            date_deb : moment().startOf('month').toISOString(),
            date_fin : moment().endOf('month').toISOString(),
            json_fields: {
                'employe': 'employe',
                'departement': 'departement',
                'batiment': 'batiement',
                'zone' :  'zone',
                'porte': 'porte',
                'nature': 'nature_porte',
                'Type': 'type_emp',
                'Date/Heure': 'datetime',
            },
        }
    },
    methods : {
        makePdf(){
          const doc = new jsPDF()
          doc.autoTable({ html: '#pdf-make' })
          doc.save('portes.pdf')
      },
        async filter(){
            let that = this
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/filterhistorique',{
                method : 'post',
                body : JSON.stringify({zone_id : this.zone_id,
                                       type_carte : this.type_carte, 
                                       porte_id : this.porte_id, 
                                       nature : this.nature,
                                       batiment_id : this.batiment_id,
                                       departement_id : this.departement_id,
                                       date_deb : moment(this.date_deb).format('YYYY-MM-DD HH:mm:ss'),
                                       date_fin : moment(this.date_fin).format('YYYY-MM-DD HH:mm:ss')}),
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
                that.historiques = response.historiques
                
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
        async importFromAllDevices(){
            var that = this;
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/importelogsdevices',{
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
                })
                .catch((response) => {
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
        async changeZone(){
            let that = this
            this.porte_id = 0
            if (this.zone_id==0){
                return
            }
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/portesbyzone/' + this.zone_id,{
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
                    if (response.length>0){
                        // that.porte_id = response[0].id
                    }
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
            this.listZonesByBatiment(this.batiment_id)
        },
        listBatiments: async function(){
            var that = this;
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/batiments',{
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
                    that.batiments = response;
                    if (response.length>0){
                        that.batiment_id = response[0].id
                        that.listZonesByBatiment(response[0].id)
                    }
              
                    //   that.form.fill(response.data);
                })
                .catch((response) => {
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
        listZonesByBatiment: async function(batiment_id){
            var that = this;
            this.zone_id = 0
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/zonesbybatiment',{
                    method : 'post',
                    body : JSON.stringify({batiment_id : batiment_id}),
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
                        swal("Erreur", "Erreur... listZonesByBatiment", {
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
                console.log(response)
                    that.$store.dispatch('setLoader', false)
                    that.zones = response;
                    
                    if (response.length>0){
                        that.zone_id = response[0].id;
                        that.changeZone()
                    }
                })
                .catch((response) => {
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
        
        getdepartememnts(){
            let that = this
            this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/departements',{
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
                if (data){
                    that.departements = data
                    if (data.length>0){
                        that.departement_id = data[0].id
                    }
                    that.$store.dispatch('setLoader', false)
                    
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
        }
    },
    mounted(){
        this.getdepartememnts()
        this.listBatiments()
        this.filter()
    },
    computed:{
        ...mapGetters({
            user : 'getUser'
        }),
        filtredhistorique(){
            return this.historiques.filter((historique) => {
                    return historique.employe.toUpperCase().indexOf(this.search.toUpperCase()) >= 0 ;

		        });
        }
    }
}
</script>

<style scoped>
    .efface{
        color: #f25961;
    }
</style>
