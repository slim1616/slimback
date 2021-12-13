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
                <div class="card-title">Ajouter emplacement</div>
            </div>
            <div class="card-body">
                <form @submit.prevent="createEmplacement">
                    <router-link to="/emplacements" class="back-to"><i class="icon-arrow-left"></i> emplacements</router-link>
                    <div class="row">
                        
                        
                        
                        
                        <input class="form-control" type="hidden" v-model="form.id"/>
                        
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control" type="text" v-model="form.title"  maxlength="255" />
                                
                                <has-error :form="form" field="title"/>
                                
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Adresse</label>
                                <input class="form-control" type="text" v-model="form.adresse"  maxlength="255" />
                                
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="text" v-model="form.email"  maxlength="255" />
                                
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tel</label>
                                <input class="form-control" type="text" v-model="form.tel"  maxlength="255" />
                                
                            </div>
                        </div>    
                        <div class="col-sm-2">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" v-model="form.borne">
                                    <span class="form-check-sign">Borne?</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4" v-if="form.borne==1">
                            <div class="form-group">
                                <label>Code borne</label>
                                <input class="form-control" type="text" v-model="form.code_borne"  maxlength="255" />
                            </div>
                        </div>                    
                        <input class="form-control" type="hidden" v-model="form.created_at"/>
                        <input class="form-control" type="hidden" v-model="form.updated_at"/>
                        
                        
                    </div>
                    <div class="row">
                        <template v-if="['superadmin'].includes(user.role)">
                            <button class="btn btn-primary" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Ajouter'}}</button>
                        </template>
                        <template v-if="user.currentFormule">
                            <button class="btn btn-primary" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Ajouter'}}</button>
                        </template>
                    </div>
                </form>
            </div>
        </div><!-- Card-body -->
    </div><!-- page-inner -->
</template>

<script>
    import { Form, HasError, AlertError } from 'vform'
    import * as moment from 'moment';
    import { Datetime } from 'vue-datetime';
    import 'vue-datetime/dist/vue-datetime.css'
    import {mapGetters} from 'vuex'
    
    export default {
        name: 'Emplacement',
        components: {HasError, Datetime},
        data: function(){
            return {
                code_borne : "",
                borne : "",
                emplacements : false,
                companies : [],
                users : [],
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
            this.listdata();
        },
        methods: {
            listdata: function(){
                
                var that = this;
                this.$store.dispatch('setLoader', true)
                this.form.get('/api/dataemplacements')
                .then(function(response){
                    that.$store.dispatch('setLoader', false)
                    if (response.status==200||response.status==201){
                        
                        
                        
                        
                        
                        
                        
                        that.companies =  response.data.companies;
                        
                        
                        that.users =  response.data.users;
                        
                        
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
                })
                .catch((response) => {
                    that.$store.dispatch('setLoader', false)
                    
                });
            },
            createEmplacement: function(){
                
                var that = this;
                this.form.post('/api/emplacements')
                .then(function(response){
                    that.$store.dispatch('setLoader', false)
                    if (response.status==200||response.status==201){
                        that.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                        that.$router.push('/mesemplacements');
                    }else{
                        swal("Erreur", "Erreru de requete", {
                            icon : "error",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-danger'
                                }
                            },
                        });
                    }
                })
                .catch((response) => {
                    that.$store.dispatch('setLoader', false)
                });  
            },
            
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