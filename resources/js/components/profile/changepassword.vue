<template>
    <div>
        <div class="row">   
            <div class="col-sm-4">
                <div class="form-group" :class="{'has-error' : errorpassword}">
                    <label for="">Mot de passe</label>
                    <input type="password" class="form-control" aria-describedby="emailHelp" v-model="password" placeholder="mot de passe">
                    <template v-if="errorpassword">
                        <p class="text-danger">Vérifiez votre mot de passe</p>
                    </template>        
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group" :class="{'has-error' : errorpassword}">
                    
                    <label for="">Confirmez le mot de passe</label>
                    <input type="password" class="form-control" v-model="passwordconfirm" placeholder="mot de passe">
                </div>
                <template v-if="errorpasswordlength">
                    <p class="text-danger">Votre mot de passe doit dépasser 6 caractères</p>
                </template>
            </div>
        </div>
        <button type="submit"  @click.prevent.stop="changePass" class="btn btn-primary">Valider</button> 
    </div>
</template>


<script>
export default {
    props : {
        user : Object
    },
    data(){
        return{
            passwordconfirm : '',
            password : '',
            errorpassword : false,
            errorpasswordlength : false, 
        }
    },
    methods:{
        changePass(){
            
            this.errorpassword = false
            this.errorpasswordlength = false

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
    }
}
</script>
