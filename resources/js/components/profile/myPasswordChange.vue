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
                    <a href="#">Profil</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Mot de passe</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modifier mot de passe</div>
            </div>
            <div class="card-body">
                <form>
                    <div class="col-sm-6">
                        <div class="form-group" :class="{'has-error' : errorcurrent}">
                            <label for="">Mot de passe Actuel</label>
                            <input type="password" class="form-control" placeholder="" v-model="current">
                        </div>
                        <div class="form-group" :class="{'has-error' : errorpassword}">
                            <label for="">Nouveau mot de passe</label>
                            <input type="password" class="form-control" placeholder="" v-model="password">
                            <small class="form-text text-muted">Votre nouveau mot de passe</small>
                        </div>
                        <div class="form-group" :class="{'has-error' : errorpassword}">
                            <label for="">Confrmez le nouveau mot de passe</label>
                            <input type="password" class="form-control" placeholder="Password" v-model="passwordconfirm">
                            <small class="form-text text-muted">Confirmez votre nouveau mot de passe</small>
                        </div>
                        <template v-if="errorpassword">
                            <p class="text-danger">Vous avez saisi 2 mots de passes differents</p>
                        </template>
                        <template v-if="errorpasswordlength">
                            <p class="text-danger">Votre mot de passe doit dépasser 6 caractères</p>
                        </template>
                        <button type="submit" @click.prevent.stop="changePass" class="btn btn-primary">Validez</button>
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
        return{
            current : '',
            password : '',
            passwordconfirm : '',
            errorcurrent : false,
            errorpassword : false,
            errorpasswordlength : false, 
        }
    },
    methods:{
        changePass(){
            this.errorpassword = false
            this.errorpasswordlength = false
            this.errorcurrent = false

            if (this.current.length<6){
                this.errorcurrent = true
            }
            if (this.password!=this.passwordconfirm){
                this.errorpassword = true
            }
            if (this.password.length<6){
                this.errorpasswordlength = true
            }
            if (this.errorpassword||this.errorpasswordlength){
                return false
            }
            this.$store.dispatch('setLoader', true)
            
            let res = fetch(window.location.origin + '/api/user/changepass',{
                method : 'post',
                body : JSON.stringify({user_id : this.user.id, password: this.password, confirm : this.passwordconfirm}),
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
                    this.$notification.success("Changé avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                    this.$store.dispatch('setLoader', false)
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
    computed:{
        ...mapGetters({
            user : 'getUser'
        })
    }
}
</script>
