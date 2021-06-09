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
                    <a href="#">Emploi du temps</a>
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
                <div class="card-title">Affectez les emplois des employés</div>
            </div>
            <div class="card-body">
                    <ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons" id="pills-tab-with-icon" role="tablist">
                        <li class="nav-item submenu">
                            <a class="nav-link d-flex align-items-center active show" id="pills-home-tab-icon" data-toggle="pill" href="#edit-emploi" role="tab" aria-controls="pills-home-icon" aria-selected="true">
                                <i class="la flaticon-calendar"></i>
                                <span style="margin-left:5px">Emploi</span>
                            </a>
                        </li>
                        <li class="nav-item submenu">
                            <a class="nav-link d-flex align-items-center" id="pills-home-tab-icon" data-toggle="pill" href="#employes-select" role="tab" aria-controls="pills-home-tab-icon" aria-selected="false">
                                <i class="fas fa-users"></i>
                                <span style="margin-left:5px">Employes</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2 mb-3" id="pills-with-icon-tabContent">
                        <div class="tab-pane fade active show" id="edit-emploi" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                            <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                
                                                    <label>Marge entree</label>
                                                    <input class="form-control" type="number" v-model="marge_entree"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" v-model="usegrid">
                                                <span class="form-check-sign">Vue Tableau</span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-3">
                                        <div class="form-group">
                                                    <label>Marge sortie</label>
                                                    <input class="form-control" type="number" v-model="marge_sortie"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                                    <label>Marge entree retard</label>
                                                    <input class="form-control" type="number" v-model="marge_entree_retard"/>
                                            </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                                <label>Marge sortie retard</label>
                                                <input class="form-control" type="number" v-model="marge_sortie_retard"/>
                                        </div>
                                    </div> -->
                            </div>
                            <div v-show="usegrid==false">
                                <div class="row m-3 bg-grey2" v-if="massEmploi.length>0">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                        <label>Lundi</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                
                                                <input class="form-control" type="time" v-model="massEmploi[1][0][0]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    
                                                <input class="form-control" type="time" v-model="massEmploi[1][0][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    
                                                <input class="form-control" type="time" v-model="massEmploi[1][1][0]"/>
                                            </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                
                                                <input class="form-control" type="time" v-model="massEmploi[1][1][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                        <i class="fa fa-copy copy" @click="currentDay = massEmploi[1]"></i>
                                        <i class="fa fa-paste paste" @click="changeDay(1, currentDay)"></i> 
                                    </div>
                                </div>

                                <div class="row m-3 bg-grey2" v-if="massEmploi.length>0">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                        <label>Mardi</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                
                                                
                                                    <input class="form-control" type="time" v-model="massEmploi[2][0][0]"/>
                                                
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    
                                                    <input class="form-control" type="time" v-model="massEmploi[2][0][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    
                                                    <input class="form-control" type="time" v-model="massEmploi[2][1][0]"/>
                                            </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                
                                                <input class="form-control" type="time" v-model="massEmploi[2][1][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                        <i class="fa fa-copy copy" @click="currentDay = massEmploi[2]"></i>
                                        <i class="fa fa-paste paste" @click="changeDay(2, currentDay)"></i> 
                                    </div>
                                    
                                </div>

                                <div class="row m-3 bg-grey2" v-if="massEmploi.length>0">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                        <label>Mercredi</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[3][0][0]"/>    
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[3][0][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[3][1][0]"/>
                                            </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                <input class="form-control" type="time" v-model="massEmploi[3][1][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                        <i class="fa fa-copy copy" @click="currentDay = massEmploi[3]"></i>
                                        <i class="fa fa-paste paste" @click="changeDay(3, currentDay)"></i> 
                                    </div>
                                </div>


                                <div class="row m-3 bg-grey2" v-if="massEmploi.length>0">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                        <label>Jeudi</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[4][0][0]"/>    
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[4][0][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[4][1][0]"/>
                                            </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                <input class="form-control" type="time" v-model="massEmploi[4][1][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                        <i class="fa fa-copy copy" @click="currentDay = massEmploi[4]"></i>
                                        <i class="fa fa-paste paste" @click="changeDay(4, currentDay)"></i> 
                                    </div>
                                </div>

                                <div class="row m-3 bg-grey2" v-if="massEmploi.length>0">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                        <label>Vendredi</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[5][0][0]"/>    
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[5][0][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[5][1][0]"/>
                                            </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                <input class="form-control" type="time" v-model="massEmploi[5][1][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                        <i class="fa fa-copy copy" @click="currentDay = massEmploi[5]"></i>
                                        <i class="fa fa-paste paste" @click="changeDay(5, currentDay)"></i> 
                                    </div>
                                </div>
                                <div class="row m-3 bg-grey2" v-if="massEmploi.length>0">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                        <label>Samedi</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[6][0][0]"/>    
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[6][0][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[6][1][0]"/>
                                            </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                <input class="form-control" type="time" v-model="massEmploi[6][1][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                        <i class="fa fa-copy copy" @click="currentDay = massEmploi[6]"></i>
                                        <i class="fa fa-paste paste" @click="changeDay(6, currentDay)"></i> 
                                    </div>
                                </div>

                                <div class="row m-3 bg-grey2" v-if="massEmploi.length>0">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                        <label>Dimanche</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[0][0][0]"/>    
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[0][0][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                    <input class="form-control" type="time" v-model="massEmploi[0][1][0]"/>
                                            </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                                <input class="form-control" type="time" v-model="massEmploi[0][1][1]"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                        <i class="fa fa-copy copy" @click="currentDay = massEmploi[0]"></i>
                                        <i class="fa fa-paste paste" @click="changeDay(0, currentDay)"></i> 
                                    </div>
                                </div>
                            </div>
                            <div v-show="usegrid==true">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3 class="text-primary">Emploi</h3>
                                    </div>
                                </div>
                                <div class="">
                                    <div id="weekly-schedule"></div>
                                </div>
                            </div>
                        </div>

                    
                        <div class="tab-pane fade" id="employes-select" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                                <form>
                                    <div class="align-items-center d-flex">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Departement</label>
                                                <select class="form-control" v-model="departement_id" @change="changeDepartement()">
                                                    <option v-for="departement in departements" :value="departement.id" :key="departement.id">{{departement.title}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control"  placeholder="recherche" v-model="search">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="align-items-center d-flex justify-content-sm-between">
                                                    <template v-if="canAffect">
                                                        <button type="button"  @click.prevent.stop="affect" class="btn btn-border btn-round btn-secondary">Affecter</button>
                                                    </template>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="table-responsive">
                                                <table class="table table-bordered table-head-bg-primary" v-if="filtredemployes.length > 0">
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
            departement_id : 0,
            marge_entree : 15,
            marge_sortie : 0,
            marge_entree_retard : 0,
            marge_sortie_retard : 0,
            checkall : false,
            usegrid : false,
            massEmploi : [],
            search : '',
            currentDay : []
        }
    },
    methods : {
        changeDay(index, currentDay){
            let newTab = this.massEmploi.map((emp, i) => {
                console.log(i)
                if (i==index){
                    
                    return currentDay
                }else{
                    return emp
                }
            })
            this.massEmploi = newTab
        },
        async affect(){
            let that = this
            if (this.usegrid){
                var emploi = $("#weekly-schedule").data('artsy.dayScheduleSelector').serialize({ });
            }else{
                // var emploi = this.massEmploi;
                let tab = this.massEmploi.map(jour => {
                            if (jour[0][0]=='00:00'&&jour[1][0]=='00:00'){
                                return [];
                            }else if (jour[0][0]!='00:00'&&jour[1][0]!='00:00'){
                                return [...jour];
                            }else if (jour[0][0]!='00:00'&&jour[1][0]=='00:00'){
                                return [...jour[0]]
                            }else if (jour[1][0]!='00:00'&&jour[0][0]=='00:00'){
                                return [...jour[1]]
                            }
                   
                    })
                // console.log(tab)
                var emploi = tab
            }
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/affectemplois',{
                method : 'post',
                body : JSON.stringify({marge_entree : this.marge_entree, 
                                       marge_sortie : this.marge_sortie, 
                                       marge_entree_retard : this.marge_entree_retard, 
                                       marge_sortie_retard : this.marge_sortie_retard, 
                                       employes : this.selectedEmployes,
                                       emploi : emploi}),
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
        drawTab(){
         $("#weekly-schedule").dayScheduleSelector({
                days        : [ 1, 2, 3, 4, 5, 6, 0],  
                startTime   : '07:00',         
                endTime     : '20:00',     
                interval    : 30,    
                stringDays  : ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],

                // Custom template                 
                template    : '<div class="day-schedule-selector">'         +
                                '<table class="schedule-table">'            +
                                '<thead class="schedule-header"></thead>' +
                                '<tbody class="schedule-rows"></tbody>'   +
                                '</table>'                                  +
                            '<div>'

            });
    }
    },
    mounted(){
        this.getdepartememnts()
        var vm = this
            setTimeout(function() {
                vm.drawTab()
            },1000)
        let tab = [
                        [['00:00', '00:00'], ['00:00', '00:00']],
                        [['00:00', '00:00'], ['00:00', '00:00']],
                        [['00:00', '00:00'], ['00:00', '00:00']],
                        [['00:00', '00:00'], ['00:00', '00:00']],
                        [['00:00', '00:00'], ['00:00', '00:00']],
                        [['00:00', '00:00'], ['00:00', '00:00']],
                        [['00:00', '00:00'], ['00:00', '00:00']],
                    ];
        console.log(tab)
        this.massEmploi = tab;
        // console.log(this.emploi)
    },
    computed:{
        ...mapGetters({
            user : 'getUser'
        }),
        canAffect(){
            return this.selectedEmployes.length>0;
        },
        filtredemployes(){
            return this.employes.filter((employe) => {
                    return employe.nom.toUpperCase().indexOf(this.search.toUpperCase()) >= 0 || employe.prenom.toUpperCase().indexOf(this.search.toUpperCase()) >= 0 ;

		        });    
        },
        notSelectedEmployes(){
            let vm = this
            let emps = this.employes.filter(emp => !vm.selectedEmployes.includes(emp.id))
            return emps.map(emp => emp.id)
        }
    },
    watch:{
       
    }
}
</script>
<style scoped>
    .copy{
        color: #317fe0;
    }
    .paste{
        color: #57a51e;
    }
</style>
