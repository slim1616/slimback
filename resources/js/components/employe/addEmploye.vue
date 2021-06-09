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
                    <a href="#">Employées</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Ajout</a>
                </li>
               
               
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ajouter un employer</div>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group" :class="{'has-error' : errornom}">
                                <label for="">Nom </label>
                                <input type="text" class="form-control" aria-describedby="" v-model="employe.nom" placeholder="Nom" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" :class="{'has-error' : errorprenom}">
                                <label for="">Prénom </label>
                                <input type="text" class="form-control" aria-describedby="" v-model="employe.prenom" placeholder="Nom" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Fonction </label>
                                <input type="text" class="form-control" aria-describedby="" v-model="employe.fonction" placeholder="fonction">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                    <label for="exampleFormControlSelect1">Departement</label>
                                    <select class="form-control" v-model="employe.departement_id">
                                        <option v-for="departement in departements" :value="departement.id">{{departement.title}}</option>
                                        
                                    </select>
                                </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Email </label>
                                <input type="email" class="form-control" aria-describedby="" v-model="employe.email" placeholder="email">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Matricule </label>
                                <input type="text" class="form-control" aria-describedby="" v-model="employe.matricule" placeholder="matricule">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Tel </label>
                                <input type="number" class="form-control" id="" aria-describedby="" v-model="employe.phone" placeholder="Tel">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">Sexe</label>
                                <br/>
                                <div class="selectgroup selectgroup-pills">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="M" class="selectgroup-input" v-model="employe.sexe">
                                        <span class="selectgroup-button">Homme</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="F" class="selectgroup-input" v-model="employe.sexe">
                                        <span class="selectgroup-button">Femme</span>
                                    </label>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="">Adresse </label>
                                <input type="text" class="form-control" v-model="employe.adress" placeholder="adresse">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Code Postal </label>
                                <input type="number" class="form-control" v-model="employe.postal_code" placeholder="code postal">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Photo</label>
                                <input type="file" class="form-control-file">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">CardNo </label>
                                <input type="number" class="form-control" v-model="employe.cardNo" placeholder="code postal">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Date de naissance</label>
                                <datetime v-model="employe.birthday"
                                            value-zone="Africa/Tunis"
                                            type="date"
                                            format="dd/MM/yyyy"

                                                    input-class="form-control">
                                    </datetime>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" v-model="employe.active">
                                    <span class="form-check-sign">Actif</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit"  @click.prevent.stop="add" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import * as moment from 'moment';
import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css'
window.moment = moment
export default {
    components : {Datetime},
    data(){
        return {
            employe : {
                nom:'',
                prenom:'',
                prenom:'',
                email:'',
                matricule:'',
                fonction:'',
                adress:'',
                sexe:'M',
                phone:'',
                postal_code:'',
                cardNo:'',
                departement_id : 1,
                active : true,
            },
            departements : [],
            errornom : false,
            errorprenom : false
        }
    },
    methods : {
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
                console.log(data)
                if (data.status){
                    this.departements = data.departements
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
        add(){
            this.errorprenom = false
            this.errornom = false
            if (this.employe.nom.trim()==""){
                this.errornom = true
            }
            if (this.employe.prenom.trim()==""){
                this.errorprenom = true
            }
            if (this.errorprenom||this.errornom){
                return false
            }
            this.$store.dispatch('setLoader', true)
            let employe = this.employe
            // console.log(this.birthday)
                employe.birthday = this.birthday
            let res = fetch(window.location.origin + '/api/employe/add',{
                method : 'post',
                body : JSON.stringify(this.employe),
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
                    this.employe = data.employe
                    this.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                    this.$store.dispatch('setLoader', false)
                    this.$router.push({ name: 'editEmploye', params: { id :  data.employe.id} }) 
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
        }

    },
    mounted(){
        this.getdepartememnts()

        
    },
    computed:{
        ...mapGetters({
            user : 'getUser'
        }),
        birthday(){
            return this.employe.birthday? moment(this.employe.birthday).format('YYYY-MM-DD') : null
        }
    }
    
}
</script>
