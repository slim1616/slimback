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
                <template v-if="user.currentFormule||user.role=='superadmin'">
                <div class="align-items-center d-flex flex-1 justify-content-around">
                    <div>
                        <a :href="'/enquete/' + form.id" target="_blank" title="Commencer l'enquête">
                            <i class="flaticon-chain"></i>
                        </a>
                        <span v-if="form.confidentiality=='private'" style="margin-left: 7px;background: #f2f2f2;padding: 4px;border-radius: 5px;"><i class="fa fa-lock"></i> <b>{{form.password}}</b> </span>
                    </div>
                    <a href="#" @click.prevent.stop="sendMail" title="Envoyer lien de l'enquête par email">
                        <i class="far fa-envelope"></i>
                    </a>
                    <a href="#" @click.prevent.stop="copiedUrl" title="Copier le lien de l'enquête">
                        <i class="far fa-copy"></i>
                    </a>
                    <a href="#" @click.prevent.stop="copiedUrl" title="Partager sur facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <input type="text" style="opacity:0;position:absolute;width: 0;" :value="'/enquete/' + form.id" id="cplink"/> 
                </div>
                </template>
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
                                        <textarea v-model="form.description" class="form-control" ></textarea>
                                        </div>
                                        
                                        <has-error :form="form" field="description"></has-error>
                                        
                                        
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Confidentiality</label>
                                        <select class="form-control" v-model="form.confidentiality">
                                            <option value="public">public</option>
                                            <option value="private">privé</option>
                                        </select>
                                    </div>
                                </div>
                                <template v-if="form.confidentiality=='private'">
                                    <div class="form-group">
                                        <label>Mot de passe</label>
                                        <input class="form-control" type="password" v-model="form.password" />                                
                                        <has-error :form="form" field="password"></has-error>
                                    </div>
                                </template>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Objectif</label>
                                        <input class="form-control" type="number" v-model="form.objectif" />                                
                                        <has-error :form="form" field="objectif"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" v-model="form.online">
                                            <span class="form-check-sign">En ligne</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <template v-if="$refs.qpp">
                                    <div class="form-group" :class="{'has-error' : form.questionParPage>$refs.qpp.$data.questions.length }">
                                        <label>Questions/Page</label>
                                        <input class="form-control" type="number" v-model="form.questionParPage" :max="$refs.qpp.$data.questions.length"/>                                
                                        <has-error :form="form" field="questionParPage"></has-error>
                                    </div>
                                    </template>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Début</label>
                                        <datetime v-model="form.start_at"
                                        value-zone="Africa/Tunis"
                                        type="date"
                                        format="dd/MM/yyyy"
                                        input-class="form-control"/>
                                        
                                        
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>fin</label>
                                        <datetime v-model="form.end_at"
                                        value-zone="Africa/Tunis"
                                        type="date"
                                        format="dd/MM/yyyy"
                                        input-class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="smallSelect">Emplacements</label>
                                        <ul class="form-control form-control-sm" id="smallSelect">
                                            <li v-for="location in emplacements">
                                                    <input type="text" style="opacity:0;position: absolute;" v-model="location.password" :id="'pass-'+location.emplacement_id"/>
                                                <div class="form-check justify-content-between d-flex">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" name="emplacement" type="checkbox" :value="location.emplacement_id" v-model="form.selectedEmplacements">
                                                        <span class="form-check-sign">{{location.title}}</span>
                                                    </label>
                                                    <div>
                                                        
                                                        
                                                        <div class="btn-group dropdown">
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                <span class="btn-label">
                                                                    <i class="fa fa-cog"></i>
                                                                </span>
                                                            </button>
                                                            <ul class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                <li>
                                                                    <router-link class="dropdown-item" :to="{ name : 'Emplacementssingle', params : { id : location.emplacement_id}}">
                                                                        <i class="fas fa-eye"></i> Voir
                                                                    </router-link>
                                                                    <a href="#" class="dropdown-item" @click.prevent.stop="copiedPass(location.emplacement_id)" title="copier le mot de passe">
                                                                        <i class="fas fa-copy"></i> copier le mot de passe
                                                                    </a>
                                                                    <a href="#" class="dropdown-item" @click.prevent.stop="regeneratePass(location.emplacement_id)" title="regenerer le mot de passe">
                                                                        <i class="fas fa-redo"></i> régénérer mot de passe
                                                                    </a>
                                                                    
                                                                    <div class="dropdown-divider"></div>
                                                                    <vue-qrcode :value="`[ '${location.emplacement_id}' ,  '${form.id}', '${location.password}' ]`" />
                                                                    <p style="text-align: center;">{{location.title}}</p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label">Disposition</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="layout" value="form" v-model="form.layout" class="selectgroup-input" :checked="form.layout=='form'">
                                                <span class="selectgroup-button selectgroup-button-icon"><i class="fab fa-wpforms"></i></span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="layout" value="slides" v-model="form.layout" class="selectgroup-input" :checked="form.layout=='slides'">
                                                <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-tv"></i></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <template v-if="['superadmin', 'admin'].includes(user.role)">
                            <div class="card-action">
                                <template v-if="['superadmin'].includes(user.role)">
                                    <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                                    <button class="btn btn-danger" @click.prevent="deleteEnquete">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button> 
                                </template>
                                <template v-else>
                                    <template v-if="user.currentFormule">
                                        <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                                        <button class="btn btn-danger" @click.prevent="deleteEnquete">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                                    </template>
                                    <template v-else>
                                        <p>Abonnement Expiré</p>
                                    </template>
                                </template>
                            </div>
                            </template>
                            
                        </form>
                        <span v-else>Loading enquete...</span>
                            <template v-if="form.id!=''">
                            <survey :survey="form" ref="qpp"/>
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
    import VueQrcode from 'vue-qrcode'
    
    export default {
        name: 'Enquete',
        components: {HasError, Datetime, Survey, historiqueReponses, VueQrcode},
        data: function(){
            return {
                selectedtab : 'form',
                loaded: false,
                companies : [],
                users : [],
                emplacements : [],
                // selectedEmplacements : [],
                form: new Form({
                    selectedEmplacements : [],
                    confidentiality : "",
                    layout : "",
                    password : "",
                    id : "",
                    title : "",
                    online : 0,
                    questionParPage : 1,
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
            ValidateEmail(mail) 
                {
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
                {
                    return (true)
                }
                    return (false)
                },
            sendMail(){
                (async () => {
                    const { value: text } = await swal.fire({
                    input: 'textarea',
                    inputLabel: 'Envoie de mail (1 email par ligne)',
                    inputPlaceholder: 'Ajouter les adresses emails des destinataires 1 par ligne',
                    inputAttributes: {
                        'aria-label': 'Ajouter vos adresses emails'
                    },
                    showCancelButton: true,
                    confirmButtonText : 'Envoyer',
                    cancelButtonText : 'Annuler',
                    reverseButtons : true
                    })
                    if (text) {
                        console.log(text.split('\n'))
                        let emails = text.split('\n')
                        let bcc = '&bcc=';
                        if (emails.length>0){
                            emails.forEach(email => {
                                if (this.ValidateEmail(email)){
                                    bcc+= email +','
                                }else{
                                    alert(email + ' est invalide')
                                }
                            })
                        }
                        console.log(bcc)

                        var formattedBody = `Bonjour, cher client,\n`;
                                formattedBody += `Dans le but d'améliorer notre service et mieux connaitre les besoins et les soucis de nos clients.\nJe vous invite à repondre à cette enquête de satisfaction client.\n`;
                                var copyText = document.getElementById("cplink");
                                copyText.value = window.location.origin + '/enquete/' + this.form.id
                                formattedBody += copyText.value + `\n`
                                if (this.form.confidentiality=='private'){
                                    formattedBody += `Mot de passse : ${this.form.password} \n`
                                }
                                formattedBody += `Merci pour votre attention`
                        var mailToLink = "mailto:"+this.user.email+"?Subject=enquête de Satisfaction"+bcc+"&body=" + encodeURIComponent(formattedBody);
                        window.location.href = mailToLink;
                    }
                })()
            },
            async regenerateQrCode(emplacement_id){
                console.log(emplacement_id)
                let res = await fetch(window.location.origin + '/api/generateqrcode', {
                    method : 'post',
                    body : JSON.stringify({enquete_id : this.form.id, emplacement_id : emplacement_id}),
                    headers : {
                        'Content-type' : 'Application/json',
                        'X-Requested-With' : 'XMLHttpRequest',
                        'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then((response) => {
                    
                    if (response.status==200) {
                        return response.json();
                    }else if (response.status==401) {
                        //window.location.replace(window.location.href);  
                    }
                    this.loader = false
                })
                .then(data => {
                    this.loader = false
                    console.log(data)
                    if (data.status){

                        swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: "Mot de passe généré avec succès",
                            type: 'success'
                        })
                        
                    }

                })
                .catch(err => {
                    console.log(err)
                    this.loader = false
                })
            },
            async regeneratePass(emplacement_id){
                console.log(emplacement_id)
                let res = await fetch(window.location.origin + '/api/emplacements/newpass', {
                    method : 'post',
                    body : JSON.stringify({enquete_id : this.form.id, emplacement_id : emplacement_id}),
                    headers : {
                        'Content-type' : 'Application/json',
                        'X-Requested-With' : 'XMLHttpRequest',
                        'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then((response) => {
                    
                    if (response.status==200) {
                        return response.json();
                    }else if (response.status==401) {
                        //window.location.replace(window.location.href);  
                    }
                    this.loader = false
                })
                .then(data => {
                    this.loader = false
                    if (data.status){
                        this.emplacements = this.emplacements.map(emp => { if (emp.emplacement_id==emplacement_id){
                                                        emp.password = data.password
                                                    }
                                                    return emp;
                        }) 
                        console.log(this.emplacements)
                        swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: "Mot de passe généré avec succès",
                            type: 'success'
                        })
                        
                    }

                })
                .catch(err => {
                    console.log(err)
                    this.loader = false
                })
            },
            copiedPass(id){
                var copyText = document.getElementById("pass-"+id);
                copyText.focus()
                /* Select the text field */
                copyText.select();
                copyText.setSelectionRange(0, 99999); /* For mobile devices */

                /* Copy the text inside the text field */
                document.execCommand("copy");
            },
            copiedUrl(){
                var copyText = document.getElementById("cplink");
                copyText.value = window.location.origin + copyText.value
                console.log(copyText.value)
                copyText.focus()
                /* Select the text field */
                copyText.select();
                copyText.setSelectionRange(0, 99999); /* For mobile devices */

                /* Copy the text inside the text field */
                document.execCommand("copy");
            },
            getEnquete: function(Enquete){
                var that = this;
                this.form.get('/api/enquetes/'+this.$route.params.id).then(function(response){
                    if (response.data.status==true){
                        that.form.fill(response.data.enquete);
                        that.emplacements =  response.data.emplacements;
                        that.companies =  response.data.companies;
                        that.users =  response.data.users;
                    }else{
                        alert(response.data.msg)
                        that.$router.go(-1)
                    }
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
                swal.fire({
                    title: 'Vous êtes sure?',
                    text: "Vous allez effacer Enquete!",
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
                        this.form.delete('/api/enquetes/'+this.$route.params.id).then(function(response){
                            that.$store.dispatch('setLoader', false)
                            that.form.fill(response.data);
                            that.$router.push('/enquetes');
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