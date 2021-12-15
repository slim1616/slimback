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
                <div class="card-title">Modifier emplacement</div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updateEmplacement" v-if="loaded">
                    <router-link to="/mesemplacements" class="back-to"><i class="icon-arrow-left"></i> emplacements</router-link>
                    <div class="row">
                        
                        
                        
                        
                        <input class="form-control" type="hidden" v-model="form.id"/>
                        
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control" type="text" v-model="form.title"  maxlength="255" />
                                
                                <has-error :form="form" field="title"></has-error>
                                
                                
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
                    <template v-if="['superadmin', 'admin'].includes(user.role)">
                        <div class="card-action">
                            <template v-if="['superadmin'].includes(user.role)">
                                <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                                <button class="btn btn-danger" @click.prevent="deleteEmplacement">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                            </template>
                            <template v-if="user.currentFormule">
                                <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                                <button class="btn btn-danger" @click.prevent="deleteEmplacement">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                            </template>
                        </div>
                    </template>
                    
                </form>
                <span v-else>Loading emplacement...</span>
            </div>
        </div>
    </div>
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
                loaded: false,
                
                companies : [],
                
                
                users : [],
                
                
                form: new Form({
                    code_borne : "",
                    borne : "",
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
            this.getEmplacement();
        },
        methods: {
            getEmplacement: function(Emplacement){
                
                var that = this;
                this.form.get('/api/emplacements/'+this.$route.params.id).then(function(response){
                    that.loaded = true;
                    if(response.data.status){
                        that.form.fill(response.data.emplacement);
                        that.companies =  response.data.companies;
                        that.users =  response.data.users;
                    }else{
                        alert('Erreur, accès interdit')
                        that.$router.go(-1)
                    }
                }).catch(function(e){
                    if (e.response && e.response.status == 404) {
                        that.$router.push('/404');
                    }
                });
                
            },
            updateEmplacement: function(){
                var that = this;
                
                this.$store.dispatch('setLoader', true)
                
                
                
                
                
                
                
                
                
                
                this.form.put('/api/emplacements/'+this.$route.params.id)
                .then(function(response){
                    that.$store.dispatch('setLoader', false)
                    if (response.status==200){
                        that.$notification.success("Modifié avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
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
            deleteEmplacement: function(){
                
                var that = this;
                swal.fire({
                    title: 'Vous êtes sure?',
                    text: "Vous allez effacer Emplacement!",
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
                        this.$store.dispatch('setLoader', true)
                        this.form.delete('/api/emplacements/'+this.$route.params.id).then(function(response){
                            that.$store.dispatch('setLoader', false)
                            that.form.fill(response.data);
                            that.$router.push('/emplacements');
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
    .back-to{
        display: flex;
        align-items: center;
        text-decoration : none;
    }
    .back-to:hover{
        text-decoration : none;
    }
    .back-to i{
        margin-right : 7px;
    }
</style>