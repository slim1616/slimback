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
                    <router-link to="/enquetes"> enquetes</router-link>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">Modifier enquete</div>
                <router-link :to="{name : 'singleFront', params:{id : form.id}}">
                    <i class="flaticon-chain"></i>
                </router-link>
            </div>
            <div class="card-body">
                
                <ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons" id="pills-tab-with-icon" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" @click.prevent="selectedtab = 'form'" id="pills-home-tab-icon" data-toggle="pill" href="#pills-home-icon" role="tab" aria-controls="pills-home-icon" aria-selected="true">
                            <i class="flaticon-interface-4 mr-2"></i>
                            Enquete
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" id="pills-profile-tab-icon" data-toggle="pill" href="#pills-profile-icon" role="tab" aria-controls="pills-profile-icon" aria-selected="false">
                            <i class="flaticon-user-4 mr-2"></i>
                            Utilisateurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" @click.prevent="selectedtab = 'historique'" id="pills-contact-tab-icon" data-toggle="pill" href="#pills-contact-icon" role="tab" aria-controls="pills-contact-icon" aria-selected="false">
                            <i class="flaticon-mailbox mr-2"></i>
                            Historique
                        </a>
                    </li>
                </ul>
                <div class="tab-content mt-2 mb-3" id="pills-with-icon-tabContent">
                    <div class="tab-pane fade show active" id="pills-home-icon" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                        <form @submit.prevent="updateEnquete" v-if="loaded">
                            <div class="row">
                                <input class="form-control" type="hidden" v-model="form.id"/>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input class="form-control" type="text" v-model="form.title"  maxlength="255" />                                
                                        <has-error :form="form" field="title"></has-error>
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <div>
                                        <textarea v-model="form.description" ></textarea>
                                        </div>
                                        
                                        <has-error :form="form" field="description"></has-error>
                                        
                                        
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Confidentiality</label>
                                        <select class="form-control" v-model="form.confidentiality">
                                            <option value="public">public</option>
                                            <option value="privé">privé</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Objectif</label>
                                        <input class="form-control" type="number" v-model="form.objectif" />                                
                                        <has-error :form="form" field="objectif"></has-error>
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="smallSelect">Emplacements</label>
                                        <ul class="form-control form-control-sm" id="smallSelect">
                                            <li v-for="location in emplacements">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" name="emplacement" type="checkbox" :value="location.id" v-model="form.selectedEmplacements">
                                                        <span class="form-check-sign">{{location.title}}</span>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                
                                <input class="form-control" type="hidden" v-model="form.created_at"/>
                                
                                
                                
                                
                                <input class="form-control" type="hidden" v-model="form.updated_at"/>
                                
                            </div>
                            <template v-if="['superadmin', 'admin'].includes(user.role)">
                            <div class="card-action">
                                <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                                <button class="btn btn-danger" @click.prevent="deleteEnquete">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                            </div>
                            </template>
                            
                        </form>
                        <span v-else>Loading enquete...</span>
                            <template v-if="form.id!=''">
                            <survey :survey="form"/>
                            </template>
                    </div>
                    <div class="tab-pane fade" id="pills-profile-icon" role="tabpanel" aria-labelledby="pills-profile-tab-icon">
                        <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
                        <p>The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didnâ€™t listen. She packed her seven versalia, put her initial into the belt and made herself on the way.
                        </p>
                    </div>
                    <div class="tab-pane fade" id="pills-contact-icon" role="tabpanel" aria-labelledby="pills-contact-tab-icon">
                        <template v-if="selectedtab == 'historique'">
                            <historique-reponses :enquete_id="form.id"></historique-reponses>
                        </template>
                    </div>
                    
                </div>
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
    import Survey from '../survey/Single'
    import historiqueReponses from './historiqueReponses'
    export default {
        name: 'Enquete',
        components: {HasError, Datetime, Survey, historiqueReponses},
        data: function(){
            return {
                selectedtab : 'form',
                loaded: false,
                companies : [],
                users : [],
                // selectedEmplacements : [],
                form: new Form({
                    selectedEmplacements : [],
                    confidentiality : "",
                    id : "",
                    title : "",
                    description : "",
                    company_id : "",
                    objectif : "",
                    user_id : "",
                    start_at : "",
                    end_at : "",
                    created_at : "",
                    updated_at : "",
                })
            }
        },
        created: function(){
            this.getEnquete();
        },
        methods: {
            getEnquete: function(Enquete){
                
                var that = this;
                this.form.get('/api/enquetes/'+this.$route.params.id).then(function(response){
                    that.form.fill(response.data.enquete);
                    that.emplacements =  response.data.emplacements;
                    that.companies =  response.data.companies;
                    that.users =  response.data.users;
                    that.loaded = true;
                }).catch(function(e){
                    if (e.response && e.response.status == 404) {
                        that.$router.push('/404');
                    }
                });
                
            },
            updateEnquete: function(){
                var that = this;
                
                this.$store.dispatch('setLoader', true)
                
                if (this.form.start_at!=""){
                    this.form.start_at = moment(this.form.start_at).format('YYYY-MM-DD')
                }
                
                if (this.form.end_at!=""){
                    this.form.end_at = moment(this.form.end_at).format('YYYY-MM-DD')
                }
                
                
                this.form.put('/api/enquetes/'+this.$route.params.id)
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
            deleteEnquete: function(){
                
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
                        this.$store.dispatch('setLoader', true)
                        this.form.delete('/api/enquetes/'+this.$route.params.id).then(function(response){
                            that.$store.dispatch('setLoader', false)
                            that.form.fill(response.data);
                            that.$router.push('/enquetes');
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