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
                    <a href="#">formules</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title"> formule</div>
            </div>
            <div class="card-body">      
                <router-link to="/formule/view" class="back-to"><i class="icon-arrow-left"></i> formules</router-link>
                <div class="">
                    <div class="row justify-content-center align-items-center mb-1">
                        
                        <div class="col-md-3 pl-md-0 pr-md-0">
                            <div class="card card-pricing card-pricing-focus card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">{{formule.title}}</h4>
                                    <div class="card-price">
                                        <span class="price">{{formule.price}}</span>
                                        <span class="text">/Dt</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="specification-list">
                                        <li>
                                            <span class="name-specification">Nb Enquetes</span>
                                            <span class="status-specification">{{formule.nbsurvey}}</span>
                                        </li>
                                        <li>
                                            <span class="name-specification">Emplacements</span>
                                            <span class="status-specification">{{formule.nbsemplacements}}</span>
                                        </li>
                                        <li>
                                            <span class="name-specification">Durée</span>
                                            <template v-if="formule.nbmois==0">
                                                <span class="status-specification">Illimité</span>
                                            </template>
                                            <template v-else>
                                            <span class="status-specification">{{formule.nbmois}} Mois</span>
                                            </template>
                                        </li>
                                        
                                    </ul>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-light btn-block"><b>Get Started</b></button>
                                </div>
                            </div>
                        </div>
                        
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
    
    export default {
        name: 'Formule',
        components: {HasError, Datetime},
        data: function(){
            return {
                loaded: false,
                formule : null
                
            }
        },
        created: function(){
            this.getFormule();
        },
        methods: {
            
            getFormule: function(Formule){
                let res = fetch(window.location.origin + '/api/formules/'+this.$route.params.id,{
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
                        this.formule = data.formule
                        this.$store.dispatch('setLoader', false)
                        
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
                
            },
            updateFormule: function(){
                var that = this;
                
                this.$store.dispatch('setLoader', true)
                
                
                
                
                
                
                
                
                
                this.form.put('/api/formules/'+this.$route.params.id)
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
            deleteFormule: function(){
                
                var that = this;
                swal({
                    title: 'Vous êtes sure?',
                    text: "Vous allez effacer Formule!",
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
                        this.form.delete('/api/formules/'+this.$route.params.id).then(function(response){
                            that.$store.dispatch('setLoader', false)
                            that.form.fill(response.data);
                            that.$router.push('/formules');
                        })
                    } else {
                        swal.close();
                    }
                }); 
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