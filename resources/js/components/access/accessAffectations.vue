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
                <div class="card-title">Affectez vos employés</div>
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
                                            <option v-for="zone in zones" :value="zone.id">{{zone.title}}</option>
                                    </select>       
                            </div>
                            <div class="form-group">
                                    <label>Porte</label>

                                    <select class="form-control" v-model="porte_id">
                                            <option :value="0">Tous</option>
                                            <option v-for="porte in portes" :value="porte.id">{{porte.titre}} {{porte.model}}</option>
                                    </select>       
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Departement</label>
                                <select class="form-control" v-model="departement_id" @change="changeDepartement()">
                                    <option value="0">Tous</option>
                                    <option v-for="departement in departements" :value="departement.id">{{departement.title}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">TimeZone</label>
                                <select class="form-control" v-model="timezone_id">
                                    <option v-for="timezone in timezones" :value="timezone.id">{{timezone.titre}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="align-items-center d-flex justify-content-sm-between">
                                    <template v-if="canAffect">
                                    <button type="button"  @click.prevent.stop="affect" class="btn btn-primary">Affecter/Effacer</button>
                                    </template>
                                    <button class="btn btn-primary" @click.prevent.stop="sendToDevice">Envoyer</button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="align-items-center d-flex justify-content-sm-between m-2">
                        <div class="text-success">
                            Employés : {{employes.length}}
                        </div>
                         <div class="header-employes">
                            <input type="text" v-model="searchusr" class="form-control" placeholder="recherche"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                                <table class="table table-bordered table-head-bg-primary" v-if="employes.length > 0">
                                    <thead>
                                        <tr>                           
                                            <th scope="col">Description</th>
                                            <th scope="col">CardNo</th>                                        
                                            <th scope="col">Fonction </th>                                                                                                                                   
                                            <th scope="col">
                                                
                                                 <label style="color:#fff !important">
                                                    Actions
                                                    <input type="checkbox" style="margin-left:5px" v-model="checkall" @change="changeAll"/>
                                                </label>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-for="(employe,index) in filtredemployes"  >
                                            <tr :key="employe.id">                                           
                                                    <td>
                                                        <router-link :to="{name : 'editEmploye', params : {'id' : employe.id}}">
                                                        <span v-html="employe.prenom + ' ' + employe.nom"> </span>
                                                        </router-link>
                                                    </td>
                                                                                                                                
                                                    <td>
                                                        {{employe.cardNo}}
                                                    </td>
                                                    <td>
                                                        {{employe.fingerPrint}}
                                                    </td>                                                                            
                                                <td>
                                                         <input type="checkbox" v-model="selectedEmployes" :value="employe.id"/>                                                                                                                                                                                                                                   
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
            checkall : false,
            searchusr : '',
        }
    },
    methods : {
        sendToDevice(){
        let that = this
        this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/sendusersbyporteandtimezone',{
                method : 'post',
                body : JSON.stringify({timezone_id : this.timezone_id, porte_id : this.porte_id,zone_id : this.zone_id}),
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
        async affect(){
            let that = this
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/affectemployes',{
                method : 'post',
                body : JSON.stringify({zone_id : this.zone_id, 
                                       timezone_id : this.timezone_id,
                                       porte_id : this.porte_id, 
                                       employes : this.selectedEmployes,
                                       notselected : this.notSelectedEmployes}),
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
                that.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
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
                        that.porte_id = response[0].id
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
                        that.timezone_id = response.data[0].id
                        
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
                        that.zone_id = response[0].id;
                        that.changeZone()
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
        changeDepartement(){
                this.selectedEmployes = []
                this.$store.dispatch('setLoader', true)
                let res = fetch(window.location.origin + '/api/employedepartement/' + this.departement_id,{
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
                        this.employes = data.employes
                        this.$store.dispatch('setLoader', false)
                        this.getselectedEmployes()
                        
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
        
       getdepartememnts(){
           this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/departementslist',{
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
                        this.changeDepartement()
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
        getselectedEmployes(){
            this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/getcurrentemployesaccess',{
                method : 'post',
                body : JSON.stringify({porte_id : this.porte_id, timezone_id : this.timezone_id}),
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
                    // console.log(data)
                    this.$store.dispatch('setLoader', false)
                    this.selectedEmployes = data.selectedEmployes
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
        this.listeTimezones()
    },
    computed:{
        ...mapGetters({
            user : 'getUser'
        }),
        canAffect(){
            return this.zone_id!=0 && this.timezone_id!=0 && this.portes.length>0
        },
        notSelectedEmployes(){
            let vm = this
            let emps = this.employes.filter(emp => !vm.selectedEmployes.includes(emp.id))
            return emps.map(emp => emp.id)
        },
        filtredemployes(){
            return this.employes.filter((employe) => {
                
                if (employe.nom!=null&&employe.prenom!=null){
                    // console.log((user.nom.toUpperCase().indexOf(this.searchusr.toUpperCase()) >= 0 || user.prenom.toUpperCase().indexOf(this.searchusr.toUpperCase()) >= 0))
                    return (employe.nom.toUpperCase().indexOf(this.searchusr.toUpperCase()) >= 0 || employe.prenom.toUpperCase().indexOf(this.searchusr.toUpperCase()) >= 0);
                }
		        });
        }
    },
    watch:{
        porte_id(nouv, old){
            if (nouv!=0){
                this.getselectedEmployes()
            }
        }
    }
}
</script>
