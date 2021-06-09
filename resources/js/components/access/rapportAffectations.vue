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
                    <a href="#">Gestions des accès</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Affectation</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Rapport</div>
            </div>
            <div class="card-body">
                <form>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                        <label>Batiment</label>
                                        <select class="form-control" v-model="batiment_id" @change="changeBatiment">
                                                <option v-for="batiment in batiments" :value="batiment.id">{{batiment.title}}</option>
                                        </select>
                            </div>
                        
                            <div class="form-group">
                                    <label>Zone</label>

                                    <select class="form-control" v-model="zone_id" @change="changeZone">
                                            <option :value="0">Tous</option>
                                            <option v-for="zone in zones" :value="zone.id">{{zone.title}}</option>
                                    </select>       
                            </div>
                            <div class="form-group">
                                    <label>Porte</label>

                                    <select class="form-control" v-model="porte_id">
                                            <option :value="0">Tous</option>
                                            <option v-for="porte in portes" :value="porte.id">{{porte.marque}} {{porte.model}}</option>
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
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">TimeZone</label>
                                <select class="form-control" v-model="timezone_id">
                                    <option :value="0">Tous</option>
                                    <option v-for="timezone in timezones" :value="timezone.id">{{timezone.titre}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <button type="button"  @click.prevent.stop="filter" class="btn btn-primary">filter</button>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                                <table class="table table-bordered table-head-bg-primary" v-if="employes.length > 0">
                                    <thead>
                                        <tr>                           
                                            <th scope="col">Nom & prenom</th>
                                            <th scope="col">Département</th>                                        
                                            <th scope="col">Batiment</th>                                                                                                                                   
                                            <th scope="col">Zone</th>                                                                                                                                   
                                            <th scope="col">Timezone</th>                                                                                                                                   
                                            <th scope="col">Porte</th>                                                                                                                                   
                                            <th scope="col">
                                                
                                                 <label style="color:#fff !important">
                                                    Effacez
                                                </label>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-for="(employe,index) in employes"  >
                                            <tr :key="employe.id">
                                                                                                                                                                    
                                                    <td>
                                                        <router-link :to="{name : 'editEmploye', params : {'id' : employe.employe.id}}">
                                                        <span v-html="employe.employe.prenom + employe.employe.nom"> </span>
                                                        </router-link>
                                                    </td>
                                                                                                                                
                                                    <td>
                                                        {{employe.departement.title}} 
                                                    </td>
                                                    <td>
                                                        {{employe.batiement.title}} 
                                                    </td>                                                                            
                                                    <td>
                                                        {{employe.zone.title}} 
                                                    </td>
                                                    <td>
                                                        {{employe.timezone.titre}} 
                                                    </td>
                                                    <td>
                                                        {{employe.porte.marque}} {{employe.porte.model}} 
                                                    </td>
                                                    <td>
                                                         <a href="#" class="efface" @click.prevent.stop="effacerAccess(employe.employe.id, employe.porte.id, employe.timezone.id)">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'


export default {
      
    data(){
        return {
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
            checkall : false
        }
    },
    methods : {
        async effaceAcces(employe_id, porte_id, timezone_id){
            let that = this
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/employeseffaceaccess',{
                method : 'post',
                body : JSON.stringify({
                                       timezone_id : timezone_id, 
                                       porte_id : porte_id, 
                                       employe_id : employe_id,
                                       }),
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
                that.$notification.success("Effacé avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                that.filter()
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
        effacerAccess(employe_id, porte_id, timezone_id){
            var that = this;
            swal({
                    title: 'Vous êtes sure?',
                    text: "Vous allez effacer l'accès!",
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
                        this.effaceAcces(employe_id, porte_id, timezone_id)
                    } else {
                        swal.close();
                    }
                });
        },
        async filter(){
            let that = this
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/employesaffectes',{
                method : 'post',
                body : JSON.stringify({zone_id : this.zone_id,
                                       timezone_id : this.timezone_id, 
                                       porte_id : this.porte_id, 
                                       employes : this.selectedEmployes,
                                       batiment_id : this.batiment_id,
                                       departement_id : this.departement_id}),
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
                that.employes = response.employes
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
        changeAll(){
            if (this.checkall){
                this.selectedEmployes = this.employes.map(emp => emp.id)
            }else{
                this.selectedEmployes = []
            }
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
        async listeTimezones(){
            let that = this
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/timezones',{
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
                    that.timezones = response.data;
                    if (response.data.length>0){
                        // that.timezone_id = response.data[0].id
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
                    that.zones = response;
                    
                    if (response.length>0){
                        // that.zone_id = response[0].id;
                    }
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
        
       getdepartememnts(){
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
                if (data.status){
                    this.departements = data.departements
                    if (data.departements.length>0){
                        this.departement_id = data.departements[0].id

                    }
                    this.$store.dispatch('setLoader', false)
                    
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
            .catch(error => {
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
        this.listeTimezones()
    },
    computed:{
        ...mapGetters({
            user : 'getUser'
        }),
        canAffect(){
            return this.selectedEmployes.length>0 && this.zone_id!=0 && this.timezone_id!=0 && this.portes.length>0
        }
    }
}
</script>

<style scoped>
    .efface{
        color: #f25961;
    }
</style>
