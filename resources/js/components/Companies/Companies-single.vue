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
                    <a href="#">companies</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modifier company</div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updateCompany" v-if="loaded">
                    <template v-if="user.role=='superadmin'">
                        <router-link to="/companies" class="back-to"><i class="icon-arrow-left"></i> companies</router-link>
                    </template>
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
                                
                                
                                <label>Type</label>
                                <select class="form-control" v-model="form.type">
                                    <option value="Personnel">Personnel</option>
                                    <option value="SUARL">SUARL</option>
                                    <option value="SARL">SARL</option>
                                    <option value="SA">SA</option>
                                </select>
                                
                                <has-error :form="form" field="type"></has-error>
                                
                                
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
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                
                                
                                
                                <label>Codetva</label>
                                <input class="form-control" type="text" v-model="form.codetva"  maxlength="255" />
                                
                                
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <template v-if="user.role=='superadmin'">
                                <label>User</label>
                                    <select class="form-control" v-model="form.user_id">
                                        
                                        <option v-for="user in users" :value="user.id">
                                            {{ user.name }}
                                        </option>
                                        
                                    </select>
                                    <has-error :form="form" field="user_id"></has-error>
                                </template>
                                <template v-else>
                                    <input class="form-control" type="hidden" v-model="form.user_id"/>
                                </template>
                                
                                
                            </div>
                        </div>
                        
                        
                        
                        <input class="form-control" type="hidden" v-model="form.created_at"/>
                        
                        
                        
                        
                        <input class="form-control" type="hidden" v-model="form.updated_at"/>
                        
                    </div>
                    <template v-if="['admin','superadmin'].includes(user.role)">
                        <div class="card-action">
                            <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                            <button class="btn btn-danger" @click.prevent="deleteCompany">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                        </div>
                    </template>
                    
                </form>
                <span v-else>Loading company...</span>
            </div>
        </div>
    </div>
</template>

<script>
    import { Form, HasError, AlertError } from 'vform'
    import * as moment from 'moment';
    import { Datetime } from 'vue-datetime';
    import 'vue-datetime/dist/vue-datetime.css'
    import {mapGetters} from 'vuex';
    
    export default {
        name: 'Company',
        components: {HasError, Datetime},
        data: function(){
            return {
                loaded: false,

                users : [],
                
                
                form: new Form({
                    id : "",
                    title : "",
                    type : "",
                    adresse : "",
                    email : "",
                    tel : "",
                    codetva : "",
                    user_id : "",
                    created_at : "",
                    updated_at : "",
                })
            }
        },
        created: function(){
            this.getCompany();
        },
        methods: {
            
            getCompany: function(Company){
                
                var that = this;
                this.form.get('/api/companies/'+this.$route.params.id).then(function(response){
                    console.log(response.data.status==true)
                    if (response.data.status==true){
                        that.form.fill(response.data.company);
                        that.users =  response.data.users;
                    }else{
                        alert(response.data.msg)
                        that.$router.push({name : 'accueil'})
                    }
                    
                    
                    that.loaded = true;
                }).catch(function(e){
                    if (e.response && e.response.status == 404) {
                        that.$router.push('/404');
                    }
                });
                
            },
            updateCompany: function(){
                var that = this;
                
                this.$store.dispatch('setLoader', true)
                
                
                
                
                
                
                
                
                
                
                
                this.form.put('/api/companies/'+this.$route.params.id)
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
            deleteCompany: function(){
                
                var that = this;
                swal.fire({
                    title: 'Vous êtes sure?',
                    text: "Vous allez effacer Company!",
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
                        this.form.delete('/api/companies/'+this.$route.params.id).then(function(response){
                            that.$store.dispatch('setLoader', false)
                            that.form.fill(response.data);
                            that.$router.push('/companies');
                        })
                    } else {
                        swal.close();
                    }
                }); 
            }
        },
        computed:{
            ...mapGetters({
                user : 'getUser'
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