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
                    <a href="#">Utilisateurs</a>
                </li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="header-btns">
                    <div class="card-title">Liste des Utilisateurs</div>
                    <router-link :to="{name:'addUser'}" class="btn btn-border btn-primary btn-round">
                                <i class="fa fa-user-plus"></i> Ajouter
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <download-excel
                    class="btn btn-primary"
                    header="Liste des utilisateurs"
                    :data="users"
                    :fields="json_fields"
                    worksheet="utilisateurs"
                    name="utilisateurs.xls"
                    >
                    Export Excel
                    </download-excel>
                <table class="table table-head-bg-secondary mb-3">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom & prénom</th>
                            <th scope="col">Email</th>
                            <th>Role</th>
                            <th scope="col">Etat</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="u in users">
                            <td>{{u.id}}</td>
                            <td>{{u.nom}} {{u.prenom}}</td>
                            <td>{{u.email}}</td>
                            <td>{{u.role}}</td>
                            <td>
                                <template v-if="u.active">
                                        <i class="la flaticon-success" style="color: green;"></i>
                                </template>
                                <template v-else>
                                        <i class="la flaticon-exclamation" style="color: orange;"></i>
                                </template>
                            </td>
                            <td>
                                <template v-if="user.role=='superadmin'">
                                    <div class="header-btns">
                                    <router-link :to="{name : 'editUser', params : {id : u.id}}" class="btn btn-icon btn-round btn-info edituser">
                                        <i class="fa fa-edit"></i>
                                    </router-link>
                                    <button type="button" class="btn btn-icon btn-round btn-danger" @click.prevent.stop="effaceUser(u.id)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    </div>
                                </template>
                            </td>
                        </tr>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>
import {mapGetters} from 'vuex'

export default {
    data(){
        return{
            users : [],
            json_fields: {
                '#': 'id',
                'nom': 'nom',
                'prenom' :  'prenom',
                'email': 'email',
                'role': 'role',
                'Etat' : {
                    field: "active",
                    callback: (value) => {
                    return value ? 'actif' : 'inactif';
                    },
                },
            },
        }
    },
    methods :{
        effaceUser(user_id){
             swal.fire({
                    title: 'Vous êtes sure?',
                    text: "Vous allez effacer un utilisateur!",
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
                       this.deleteUser(user_id)
                    } else {
                        swal.close();
                    }
                });
        },
        deleteUser(user_id){

        },
         getusers(){
            let res = fetch(window.location.origin + '/api/user/all',{
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
                        this.users = data.users
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
    computed:{
        ...mapGetters({
            user : 'getUser'
        }),
    },
    mounted(){
        this.getusers()
    }
}
</script>

<style scoped>
    .header-btns{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .edituser{
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
