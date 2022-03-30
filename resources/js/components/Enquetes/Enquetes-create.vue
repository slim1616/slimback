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
                <div class="card-title">Ajouter enquete</div>
            </div>
            <div class="card-body">
                <form @submit.prevent="createEnquete">
                    <router-link to="/enquetes" class="back-to"><i class="icon-arrow-left"></i> enquetes</router-link>
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
                                <label>Description</label>
                                <textarea class="form-control" v-model="form.description" ></textarea>
                                <has-error :form="form" field="description"/>
                                
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Objectif</label>
                                <input class="form-control" type="number" v-model="form.objectif" />                                
                                <has-error :form="form" field="objectif"></has-error>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Début</label>
                                <datetime v-model="form.start_at"
                                value-zone="Africa/Tunis"
                                type="date"
                                format="yyyy-MM-dd"
                                input-class="form-control"/>
                                
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>fin</label>
                                <datetime v-model="form.end_at"
                                value-zone="Africa/Tunis"
                                type="date"
                                format="yyyy-MM-dd"
                                input-class="form-control"/>
                                
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
        name: 'Enquete',
        components: {HasError, Datetime},
        data: function(){
            return {
                enquetes : false,
                companies : [],                
                users : [],
                
                form: new Form({
                    id : "",
                    title : "",
                    objectif : "",
                    description : "",
                    start_at : "",
                    end_at : "",
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
                this.form.get('/api/dataenquetes')
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
            createEnquete: function(){
                
                var that = this;
                
                
                
                
                
                
                
                if (this.form.start_at!=""){
                    this.form.start_at = moment(this.form.start_at).format('YYYY-MM-DD')
                }
                
                
                if (this.form.end_at!=""){
                    this.form.end_at = moment(this.form.end_at).format('YYYY-MM-DD')
                }
                
                
                this.form.post('/api/enquetes')
                .then(function(response){
                    that.$store.dispatch('setLoader', false)
                    ////console.log(response.data)
                    if (response.status==200||response.status==201){
                        that.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                        that.$router.push('/enquetes/'+response.data.id);
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