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
                <template v-if="user.role=='superadmin'">
                    <li class="nav-item">
                        <a href="#">abonnements</a>
                    </li>
                </template>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <template v-if="user.role=='superadmin'">
                <div class="card-title">Modifier abonnement</div>
                </template>
                <template v-else>
                    <div class="card-title"> Abonnement</div>
                </template>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updateAbonnement" v-if="loaded">
                    <template v-if="user.role=='superadmin'">
                        <router-link to="/abonnements" class="back-to"><i class="icon-arrow-left"></i> abonnements</router-link>
                    </template>
                    <template v-else>
                            <router-link :to="{name : 'CompanyAbonnements'}" class="back-to"><i class="icon-arrow-left"></i> abonnements</router-link>
                    </template>
                    <div class="row">
                        <input class="form-control" type="hidden" v-model="form.id"/>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Formule</label>
                                <template v-if="user.role=='superadmin'">
                                    <select class="form-control" v-model="form.formule_id">
                                        <option v-for="formule in formules" :value="formule.id">
                                            {{ formule.title }}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="formule_id"></has-error>
                                </template>
                                <template v-else>
                                    <p>{{ formule.title }}</p>
                                </template>
                                
                                
                            </div>
                        </div>
                        <template v-if="user.role=='superadmin'">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Company</label>
                                    <select class="form-control" v-model="form.company_id">
                                        
                                        <option v-for="company in companies" :value="company.id">
                                            {{ company.title }}
                                        </option>
                                        
                                    </select>
                                    
                                    <has-error :form="form" field="company_id"></has-error>
                                    
                                    
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>User</label>
                                    <select class="form-control" v-model="form.user_id">
                                        
                                        <option v-for="user in users" :value="user.id">
                                            {{ user.name }}
                                        </option>
                                        
                                    </select>
                                    <has-error :form="form" field="user_id"></has-error>
                                </div>
                            </div>
                        </template>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <template v-if="user.role=='superadmin'">
                                <label>Début</label>
                                <datetime v-model="form.start_at"
                                value-zone="Africa/Tunis"
                                type="date"
                                format="dd/MM/yyyy"
                                input-class="form-control"/>
                                </template>
                                <template v-else>
                                    <label>Début</label>
                                    <p>{{form.start_at|frDate}}</p>
                                </template>
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <template v-if="user.role=='superadmin'">
                                <label>Fin</label>
                                <datetime v-model="form.end_at"
                                value-zone="Africa/Tunis"
                                type="date"
                                format="dd/MM/yyyy"
                                input-class="form-control"/>
                                </template>
                                <template v-else>
                                    <label>Fin</label>
                                    <p>{{form.end_at|frDate}}</p>
                                </template>
                            </div>
                        </div>
                        
                        
                        
                        <input class="form-control" type="hidden" v-model="form.created_at"/>
                        
                        
                        
                        
                        <input class="form-control" type="hidden" v-model="form.updated_at"/>
                        
                    </div>
                    <div class="card-action" v-if="user.role=='superadmin'">
                        <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                        <button class="btn btn-danger" @click.prevent="deleteAbonnement">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                    </div>
                    
                </form>
                <span v-else>Loading abonnement...</span>
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
        name: 'Abonnement',
        filters:{
            frDate(val){
                if (val){
                    return moment(val).format('DD/MM/YYYY');
                }else{
                    return ""
                }
            }
        },
        components: {HasError, Datetime},
        data: function(){
            return {
                loaded: false,
                
                
                
                formules : [],
                
                
                companies : [],
                
                
                users : [],
                
                
                
                
                form: new Form({
                    id : "",
                    formule_id : "",
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
            this.getAbonnement();
        },
        methods: {
            
            getAbonnement: function(Abonnement){
                
                var that = this;
                this.form.get('/api/abonnements/'+this.$route.params.id).then(function(response){
                    that.form.fill(response.data.abonnement);
                    
                    that.formules =  response.data.formules;
                    
                    
                    that.companies =  response.data.companies;
                    
                    
                    that.users =  response.data.users;
                    
                    
                    
                    
                    that.loaded = true;
                }).catch(function(e){
                    if (e.response && e.response.status == 404) {
                        that.$router.push('/404');
                    }
                });
                
            },
            updateAbonnement: function(){
                var that = this;
                
                this.$store.dispatch('setLoader', true)
                
                
                
                
                
                if (this.form.start_at!=""){
                    this.form.start_at = moment(this.form.start_at).format('YYYY-MM-DD')
                }
                
                if (this.form.end_at!=""){
                    this.form.end_at = moment(this.form.end_at).format('YYYY-MM-DD')
                }
                
                
                
                this.form.put('/api/abonnements/'+this.$route.params.id)
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
            deleteAbonnement: function(){
                
                var that = this;
                swal({
                    title: 'Vous êtes sure?',
                    text: "Vous allez effacer Abonnement!",
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
                        this.form.delete('/api/abonnements/'+this.$route.params.id).then(function(response){
                            that.$store.dispatch('setLoader', false)
                            that.form.fill(response.data);
                            that.$router.push('/abonnements');
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
            }),
            formule(){
                return this.formules.find(formule => formule.id==this.form.formule_id)
            }
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