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
                    <a href="#">Ajouter utilisateur</a>
                </li>
                
               
               
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Nouvel Utilisateur</div>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        
                        <div class="col-sm-4">
                            <div class="form-group" :class="{'has-error' : errorprenom}">
                                <label for="">Prénom </label>
                                <input type="text" class="form-control" aria-describedby="" v-model="newuser.prenom" placeholder="Nom" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" :class="{'has-error' : errornom}">
                                <label for="">Nom </label>
                                <input type="text" class="form-control" aria-describedby="" v-model="newuser.nom" placeholder="Nom" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Email </label>
                                <input type="email" class="form-control" aria-describedby="" v-model="newuser.email" placeholder="email">
                                <template v-if="errors['email']">
                                        <p class="text-danger">{{errors['email'][0]}}</p>

                                </template> 
                            </div>
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                    <label for="exampleFormControlSelect1">Role</label>
                                    <select class="form-control" v-model="newuser.role_id">
                                        <option v-for="role in roles" :value="role.id">{{role.name}}</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Tel </label>
                                <input type="number" class="form-control" id="" aria-describedby="" v-model="newuser.phone" placeholder="Tel">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">Sexe</label>
                                <br/>
                                <div class="selectgroup selectgroup-pills">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="M" class="selectgroup-input" v-model="newuser.sexe">
                                        <span class="selectgroup-button">Homme</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="F" class="selectgroup-input" v-model="newuser.sexe">
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
                                <input type="text" class="form-control" v-model="newuser.adress" placeholder="adresse">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Company</label>
                                <select class="form-control" v-model="newuser.company_id">
                                        <option v-for="company in companies" :value="company.id">
                                            {{ company.title }}
                                        </option>
                                </select>
                                 <template v-if="errors['company_id']">
                                        <p class="text-danger">{{errors['company_id'][0]}}</p>
                                </template> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-sm-4">
                            <div class="form-group" :class="{'has-error' : errorpassword}">
                                <label for="">Mot de passe</label>
                                <input type="password" class="form-control" aria-describedby="emailHelp" v-model="newuser.password" placeholder="mot de passe">
                                <template v-if="errorpassword">
                                    <p class="text-danger">Vérifiez votre mot de passe</p>
                                </template>        
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" :class="{'has-error' : errorpassword}">
                                
                                <label for="">Confirmez le mot de passe</label>
                                <input type="password" class="form-control" v-model="newuser.passwordconfirm" placeholder="mot de passe">
                            </div>
                            <template v-if="errorpasswordlength">
                                <p class="text-danger">Votre mot de passe doit dépasser 6 caractères</p>
                            </template>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" v-model="newuser.active">
                                    <span class="form-check-sign">Actif</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit"  @click.prevent.stop="add" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
// import * as moment from 'moment';
// import { Datetime } from 'vue-datetime';
// import 'vue-datetime/dist/vue-datetime.css'
// window.moment = moment
export default {
    // components : {Datetime},
    data(){
        return {
            companies : [],
            roles : [],
            newuser : {
                nom:'',
                prenom:'',
                prenom:'',
                email:'',
                adress:'',
                sexe:'M',
                phone:'',
                role_id : 1,
                // postal_code:'',
                active : true,
            },
            errornom : false,
            errorprenom : false,
            errorpassword : false,
            errorpasswordlength : false,
            errors : {}
        }
    },
    methods : {
        getRoles(){
           this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/roles',{
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
                    this.roles = data.roles
                    this.companies = data.companies
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
        },
        add(){
            this.errors = []
            this.errorprenom = false
            this.errornom = false
            this.errorpassword = false
            this.errorpasswordlength = false
            if (this.newuser.nom.trim()==""){
                this.errornom = true
            }
            if (this.newuser.prenom.trim()==""){
                this.errorprenom = true
            }
            if (this.newuser.password!=this.newuser.passwordconfirm){
                this.errorpassword = true
            }
            if (this.newuser.password.length<6){
                this.errorpasswordlength = true
            }
            if (this.errorprenom||this.errornom||this.errorpassword|| this.errorpasswordlength){
                return false
            }
            this.$store.dispatch('setLoader', true)
            
            let res = fetch(window.location.origin + '/api/user/add',{
                method : 'post',
                body : JSON.stringify(this.newuser),
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
                    this.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                    this.$store.dispatch('setLoader', false)
                    this.$router.push({ name: 'editUser', params:{id : data.user.id} }) 
                }else{
                    this.$store.dispatch('setLoader', false)
                    if (data.errors){
                        this.errors = data.errors
                    }else{
                        swal("Erreur", "Une erreur c'est produite", {
                            icon : "error",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-danger'
                                }
                            },
                        });
                    }
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
        this.getRoles()
        
    },
    computed:{
        ...mapGetters({
            user : 'getUser'
        }),
        birthday(){
            return this.newuser.birthday? moment(this.newuser.birthday).format('YYYY-MM-DD') : null
        }
    }
    
}
</script>
