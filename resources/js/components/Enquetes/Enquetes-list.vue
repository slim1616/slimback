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
                    <a href="#">enquetes</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="header-btns">
                    <template v-if="['superadmin'].includes(user.role)">
                            <div class="card-title">Liste de enquetes ({{enquetes.length}})</div>
                            <router-link to="/createenquetes" class="btn btn-border btn-round btn-secondary">
                                <i class="fas fa-plus"></i> Ajouter
                            </router-link>
                    </template>
                    <template v-if="['admin'].includes(user.role)">
                        <template v-if="user.currentFormule">
                            <div class="card-title">Liste de enquetes ({{enquetes.length}}/{{user.currentFormule.nbsurvey}})</div>
                            <template v-if="user.currentFormule.nbsurvey>enquetes.length">
                                <router-link to="/createenquetes" class="btn btn-border btn-round btn-secondary">
                                    <i class="fas fa-plus"></i> Ajouter
                                </router-link>
                            </template>
                            <template v-if="user.currentFormule.nbsurvey==enquetes.length">
                                <p>Vous avez atteind le max d'enquetes</p>
                            </template>
                            </template>
                            <template v-else>
                                <p class="card-title">Abonnement expiré</p>
                            </template>
                    </template>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="enquetes.length > 0">
                        <thead>
                            <tr>
                                
                                <th scope="col">Title</th>
                                
                                <th scope="col">Description</th>
                                
                                
                                <th scope="col">company</th>
                                
                                
                                <th scope="col">user</th>
                                
                                <th scope="col">Start_at</th>
                                
                                <th scope="col">End_at</th>
                                <template v-if="['superadmin', 'admin'].includes(user.role)">
                                <th scope="col">Actions</th>
                                </template>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(enquete,index) in enquetes"  >
                                <tr :key="enquete.id">
                                    
                                    <td>
                                        <router-link :to="'/enquetes/'+enquete.id">
                                            <span v-html="enquete.title"> </span>
                                        </router-link>
                                    </td>
                                    
                                    <td>
                                        <router-link :to="'/enquetes/'+enquete.id">
                                            <span v-html="enquete.description"> </span>
                                        </router-link>
                                    </td>
                                    
                                    
                                    <td>
                                        <router-link :to="'/companies/'+enquete.company_id">
                                            <span v-html="enquete.company"></span>
                                        </router-link>
                                    </td>
                                    
                                    
                                    <td>
                                        <router-link :to="'/users/'+enquete.user_id">
                                            <span v-html="enquete.user"></span>
                                        </router-link>
                                    </td>
                                    
                                    <td>
                                        <router-link :to="'/enquetes/'+enquete.id">
                                            <span v-html="enquete.start_at"> </span>
                                        </router-link>
                                    </td>
                                    
                                    <td>
                                        <router-link :to="'/enquetes/'+enquete.id">
                                            <span v-html="enquete.end_at"> </span>
                                        </router-link>
                                    </td>
                                    <template v-if="['superadmin', 'admin'].includes(user.role)">
                                    <td>
                                        <div class="action-btns">
                                            <router-link :to="'/enquetes/'+enquete.id" class="edit-btn">
                                                <i class="icon-note"></i>
                                            </router-link>
                                            
                                            <a href="#" @click.prevent.stop="deleteEnquete(enquete,index)" class="delete-btn">
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
        name: 'Enquete',
        components: {HasError},
        data: function(){
            return {
                enquetes : false,
                form: new Form({
                    id : "",
                    title : "",
                    description : "",
                    company_id : "",
                    user_id : "",
                    start_at : "",
                    end_at : "",
                    created_at : "",
                    updated_at : "",
                })
            }
        },
        created: function(){
            this.listEnquetes();
        },
        methods: {
            listEnquetes: function(){
                
                var that = this;
                this.$store.dispatch('setLoader', true)
                this.form.get('/api/enquetes')
                .then(function(response){
                    that.$store.dispatch('setLoader', false)
                    if (response.status==200){
                        that.enquetes = response.data;
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
            createEnquete: function(){
                
                var that = this;
                this.form.post('/api/enquetes').then(function(response){
                    that.enquetes.push(response.data);
                })
                
            },
            deleteEnquete: function(enquete, index){
                var that = this;
                swal({
                    title: 'Vous êtes sure?',
                    text: "Vous allez effacer Enquete!",
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
                        this.form.delete('/api/enquetes/'+enquete.id).then(function(response){
                            that.enquetes.splice(index,1);
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