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
                    <a href="#">emplacements</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-btns">
                    <div class="card-title">Liste des emplacements</div>
                    <template v-if="['superadmin'].includes(user.role)">
                        <router-link to="/createemplacements" class="btn btn-border btn-round btn-secondary">
                            <i class="fas fa-plus"></i> Ajouter
                        </router-link>
                    </template>
                    <template v-if="['admin'].includes(user.role)">
                        <template v-if="user.currentFormule">
                            <template v-if="user.currentFormule.nbsemplacements<emplacements.length">
                                <router-link to="/createemplacements" class="btn btn-border btn-round btn-secondary">
                                    <i class="fas fa-plus"></i> Ajouter
                                </router-link>
                            </template>
                        </template>
                    </template>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="emplacements.length > 0">
                        <thead>
                            <tr>
                                
                                <th scope="col">Title</th>
                                
                                <th scope="col">Adresse</th>
                                
                                <th scope="col">Email</th>
                                
                                <th scope="col">Tel</th>
                                
                                
                                <th scope="col">company</th>
                                
                                <template v-if="['superadmin', 'admin'].includes(user.role)">
                                <th scope="col">Actions</th>
                                </template>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(emplacement,index) in emplacements"  >
                                <tr :key="emplacement.id">
                                    
                                    <td>
                                        <router-link :to="'/emplacements/'+emplacement.id">
                                            <span v-html="emplacement.title"> </span>
                                        </router-link>
                                    </td>
                                    
                                    <td>
                                        <router-link :to="'/emplacements/'+emplacement.id">
                                            <span v-html="emplacement.adresse"> </span>
                                        </router-link>
                                    </td>
                                    
                                    <td>
                                        <router-link :to="'/emplacements/'+emplacement.id">
                                            <span v-html="emplacement.email"> </span>
                                        </router-link>
                                    </td>
                                    
                                    <td>
                                        <router-link :to="'/emplacements/'+emplacement.id">
                                            <span v-html="emplacement.tel"> </span>
                                        </router-link>
                                    </td>
                                    
                                    
                                    <td>
                                        <router-link :to="'/companies/'+emplacement.company_id">
                                            <span v-html="emplacement.company"></span>
                                        </router-link>
                                    </td>
                                    
                                    
                                    <template v-if="['superadmin', 'admin'].includes(user.role)">
                                    <td>
                                        <div class="action-btns">
                                            <router-link :to="'/emplacements/'+emplacement.id" class="edit-btn">
                                                <i class="icon-note"></i>
                                            </router-link>
                                            
                                            <a href="#" @click.prevent.stop="deleteEmplacement(emplacement,index)" class="delete-btn">
                                                <i class="icon-close" ></i>
                                            </a>
                                        </div>
                                    </td>
                                    </template>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- Card -->
    </div><!-- page-inner -->
</template>

<script>

    import { Form, HasError, AlertError } from 'vform'
    import {mapGetters} from 'vuex'
    export default {
        name: 'Emplacement',
        components: {HasError},
        data: function(){
            return {
                emplacements : false,
                form: new Form({
                    id : "",
                    title : "",
                    adresse : "",
                    email : "",
                    tel : "",
                    company_id : "",
                    user_id : "",
                    created_at : "",
                    updated_at : "",
                })
            }
        },
        created: function(){
            this.listEmplacements();
        },
        methods: {
            listEmplacements: function(){
                
                var that = this;
                this.$store.dispatch('setLoader', true)
                this.form.get('/api/emplacements')
                .then(function(response){
                    that.$store.dispatch('setLoader', false)
                    if (response.status==200){
                        that.emplacements = response.data;
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
            createEmplacement: function(){
                
                var that = this;
                this.form.post('/api/emplacements').then(function(response){
                    that.emplacements.push(response.data);
                })
                
            },
            deleteEmplacement: function(emplacement, index){
                var that = this;
                swal.fire({
                    title: 'Vous êtes sure?',
                    text: "Vous allez effacer un Emplacement!",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'oui',
                    cancelButtonText: 'annuler',
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    }
                }).then((Delete) => {
                    if (Delete.isConfirmed) {
                        this.form.delete('/api/emplacements/'+emplacement.id).then(function(response){
                            that.emplacements.splice(index,1);
                        })
                        .catch(error => {
                            swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Erreur!',
                                customClass: {
                                confirmButton: 'btn btn-danger',
                                }
                            })
                        })
                    } else {
                        swal.close();
                    }
                });
                
                
                
            }
        },
        computed:{
            ...mapGetters({
                user : 'getUser',
            })
        }
        
    }
</script>

<style>
    .invalid-feedback{
        display: block;
    }
</style>

<style scoped>
    .header-btns{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .action-btns{
        display: flex;
        justify-content: space-evenly;
        align-items: center;
    }
    .edit-btn{
        color: #31ce36!important;
        margin: 0 10px;
        text-decoration : none;
    }
    .delete-btn{
        color: #f25961!important;
        text-decoration : none;
    }
</style>