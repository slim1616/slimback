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
                    <a href="#">compagnes</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modifier compagne</div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updateCompagne" v-if="loaded">
                  <router-link to="/compagnes" class="back-to"><i class="icon-arrow-left"></i> compagnes</router-link>
                  <div class="row">

                                                
                           

                                          <input class="form-control" type="hidden" v-model="form.id"/>
                        
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                        
                                                                            
                                          <label>Question</label>
                                          <input class="form-control" type="text" v-model="form.question"  maxlength="255" />
                                                            
                                          <has-error :form="form" field="question"></has-error>
                                                
                        
                                </div>
                            </div>
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">  
                                        <label>Début</label>                 
                                       <datetime v-model="form.start_at"
                                       value-zone="Africa/Tunis"
                                       type="date"
                                       format="dd/MM/yyyy"
                                       input-class="form-control"/>
                                                                                    
                        
                                </div>
                            </div>
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                                        <label>Fin</label>    
                                       <datetime v-model="form.end_at"
                                       value-zone="Africa/Tunis"
                                       type="date"
                                       format="dd/MM/yyyy"
                                       input-class="form-control"/>
                                                                                    
                        
                                </div>
                            </div>
                            <!-- <div class="col-sm-4">
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
                                                                                                -->
                            <input class="form-control" type="hidden" v-model="form.created_at"/>
                            <input class="form-control" type="hidden" v-model="form.updated_at"/>
                           

                        
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                                <template v-if="user.role=='superadmin'">
                                    <button class="btn btn-danger" @click.prevent="deleteCompagne">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                                </template>
                            </div>
                    <ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons" id="pills-tab-with-icon" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active d-flex align-items-center" @click.prevent="selectedtab = 'form'" id="pills-home-tab-icon" data-toggle="pill" href="#pills-home-icon" role="tab" aria-controls="pills-home-icon" aria-selected="true">
                                <i class="la flaticon-placeholder-1 mr-2"></i>
                                Bornes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="pills-profile-tab-icon" data-toggle="pill" href="#pills-profile-icon" role="tab" aria-controls="pills-profile-icon" aria-selected="false">
                                <i class="la flaticon-calendar mr-2"></i>
                                Horaires
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" @click.prevent="selectedtab = 'historique'" id="pills-contact-tab-icon" data-toggle="pill" href="#pills-contact-icon" role="tab" aria-controls="pills-contact-icon" aria-selected="false">
                                <i class="la flaticon-graph-2 mr-2"></i>
                                Statistiques
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2 mb-3" id="pills-with-icon-tabContent">
                        <div class="tab-pane fade show active" id="pills-home-icon" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                            <div>
                                <div class="form-group">
                                        <label for="smallSelect">Bornes</label>
                                        <ul class="form-control form-control-sm" id="smallSelect">
                                            <li v-for="borne in bornes" :key="borne.id">
                                                <div class="form-check justify-content-between d-flex">
                                                    <label class="form-check-label">
                                                        <template v-if="user.role=='superadmin'">
                                                            <input class="form-check-input" name="emplacement" :disabled="actifbornes.includes(borne.id)" type="checkbox" :value="borne.id" v-model="form.selectedbornes">
                                                        </template>
                                                        <span class="form-check-sign">{{borne.title}}</span>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile-icon" role="tabpanel" aria-labelledby="pills-profile-tab-icon">
                            <div id="weekly-schedule"></div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact-icon" role="tabpanel" aria-labelledby="pills-contact-tab-icon">
                            <div class="row">
                                <div class="col-sm-4">
                                <div class="form-group">  
                                        <label>Début</label>                 
                                       <datetime v-model="day"
                                       value-zone="Africa/Tunis"
                                       type="date"
                                       format="dd/MM/yyyy"
                                       input-class="form-control"/>
                                                                                    
                        
                                </div>
                            </div>
                            </div>
                            <a href="#" @click.prevent.stop="filter(day,'day')">Journée</a>
                            <a href="#" @click.prevent.stop="filter(day,'week')">Semaine</a>
                            <a href="#" @click.prevent.stop="filter(day,'month')">Mois</a>
                            <div id="download"></div>
                            <div v-if="pdfsrc!=null">
                                    {{currentPage}} / {{pageCount}}
                                    <pdf
                                        v-for="i in pageCount"
                                        :key="i"
                                        :src="pdfsrc"
                                        :page="i"
                                        style=""
                                    ></pdf>
                                    <pdf :src="pdfsrc" 
                                        style="display:none"
                                        @num-pages="pageCount = $event"
			                            @page-loaded="currentPage = $event">
                                    </pdf>

                            </div>
                        </div>
                        
                    </div>
                    
                    
              </form>
              <span v-else>Loading compagne...</span>
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
import axios from 'axios'
import pdf from 'vue-pdf'

export default {
  name: 'Compagne',
  components: {HasError, Datetime, pdf},
  data: function(){
    return {
        day : moment().startOf('days').toISOString(),
        pageCount : 0,
        currentPage: 0,
        pdfsrc : null,
        loaded: false,                
        emploi : [],
        bornes :[],
        companies : [],
        actifbornes :[],
        form: new Form({
            id : "",
            selectedbornes : [],
            question : "",
            company_id : "",
            start_at : "",
            end_at : "",
            emploie : "",
            created_at : "",
            updated_at : "",
        })                 
    }
  },
  methods: {
        async filter(date, type){
            this.$store.dispatch('setLoader', true)
            const cont = document.querySelector('#download');
            while (cont.firstChild) cont.removeChild(cont.firstChild);
            if (this.pdfsrc){
                this.pdfsrc = null
            }
            let url = window.location.origin + '/api/borne/filterreponses'
            if (type=='month'){
                url = window.location.origin + '/api/borne/monthreponses'
            }
            axios({
                url: url,
                method: 'POST',
                data : {company_id : this.form.company_id, compagne_id : this.form.id, date : moment(date).format('YYYY-MM-DD'), type : type},
                responseType: 'blob', // important
                }).then((response) => {
                    this.$store.dispatch('setLoader', false)
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    this.pdfsrc = url 
                    const link = document.createElement('a');
                    link.href = url;
                    link.innerText = "télécharger"
                    // link.setAttribute('class', 'signature');

                    link.setAttribute('download', 'file.pdf');
                    // document.body.appendChild(link);
                    cont.appendChild(link)
                });
            return
            this.$store.dispatch('setLoader', true)
            let res = await fetch(window.location.origin + '/api/borne/filterreponses', {
                    method : 'post',
                    body : JSON.stringify({company_id : this.form.company_id, compagne_id : this.form.id}),
                    headers : {
                        'Content-type' : 'Application/json',
                        'Accept': 'application/pdf',
                        'X-Requested-With' : 'XMLHttpRequest',
                        'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then((response) => {
                    
                    if (response.status==200) {
                        console.log(response.body)
                        return response.json();
                    }else if (response.status==401) {
                        //window.location.replace(window.location.href);  
                    }
                    this.$store.dispatch('setLoader', false)
                })
                .then(data => {
                    this.$store.dispatch('setLoader', false)
                    console.log(data)
                    if (data.status){

                        
                    }

                })
                .catch(err => {
                    console.log(err)
                    this.$store.dispatch('setLoader', false)
                })
        },
        getCompagne: function(Compagne){
        
            var that = this;
            this.form.get('/api/compagnes/'+this.$route.params.id).then(function(response){
                that.form.fill(response.data.compagne);         
                that.companies =  response.data.companies;
                that.bornes =  response.data.bornes;
                that.actifbornes = response.data.actifbornes
                if (response.data.compagne.emploie){
                        let tab = JSON.parse(response.data.compagne.emploie)
                        const obj = {...tab};
                        try{
                            setTimeout(() => {
                                if (obj){
                                    $("#weekly-schedule").data('artsy.dayScheduleSelector').deserialize(obj);
                                }
                                that.loaded = true;

                            },1000)
                        }catch(error){
                            console.log(error)
                        }
                    
                    }
                that.loaded = true;
            }).catch(function(e){
                console.log(e)
                if (e.response && e.response.status == 404) {
                    that.$router.push('/404');
                }
            });
        
        },
        updateCompagne: function(){
            var that = this;

            this.$store.dispatch('setLoader', true)
                    
                            
                            
                            
                        if (this.form.start_at!=""){
                    this.form.start_at = moment(this.form.start_at).format('YYYY-MM-DD')
                }
                            
                        if (this.form.end_at!=""){
                    this.form.end_at = moment(this.form.end_at).format('YYYY-MM-DD')
                }
                            
                            
            this.form.emploie = $("#weekly-schedule").data('artsy.dayScheduleSelector').serialize({ });
            console.log(this.form.emploie)         
                    
            this.form.put('/api/compagnes/'+this.$route.params.id)
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
        deleteCompagne: function(){
        
                var that = this;
                swal({
                            title: 'Vous êtes sure?',
                            text: "Vous allez effacer Compagne!",
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
                            this.form.delete('/api/compagnes/'+this.$route.params.id).then(function(response){
                                that.$store.dispatch('setLoader', false)
                                that.form.fill(response.data);
                                that.$router.push('/compagnes');
                                })
                            } else {
                                swal.close();
                            }
                        }); 
        },
        drawTab(){
                console.log('drawTab')
                $("#weekly-schedule").dayScheduleSelector({
                    days        : [1, 2, 3, 4, 5, 6, 0],  
                    startTime   : '00:00',         
                    endTime     : '24:00',     
                    interval    : 60,    
                    stringDays  : ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                    // Custom template                 
                    template    : '<div class="day-schedule-selector">'         +
                                    '<table class="schedule-table">'            +
                                    '<thead class="schedule-header"></thead>' +
                                    '<tbody class="schedule-rows"></tbody>'   +
                                    '</table>'                                  +
                                '<div>'
                });
        }
        
  },
  computed:{
      ...mapGetters({
          user : 'getUser',
      })
  },
  mounted(){
        this.getCompagne();
        var vm = this
        setTimeout(function() {
            vm.drawTab()
        },1000)
  }
}
</script>




<style>
     .schedule-table{
        width : 100% !important;
    }
    /*
 .schedule-rows td {
        width: 80px;
        height: 2px !important;
        margin: 3px;
        padding: 2px !important;
        background-color: #0b438e;
        cursor: pointer;
        border: solid 1px #fff;
    } */
</style>
<style>
.schedule-rows td {
  width: 50px;
  height: 15px;
  margin: 3px;
  padding: 0px;
  background-color: #eee;
  cursor: pointer;
  border: solid 1px #fff;
}
.schedule-rows td:first-child {
  background-color: transparent;
  text-align: right;
  position: relative;
  top: -12px;
}
.schedule-rows td[data-selected],
.schedule-rows td[data-selecting] {
  background-color: #6a0bc1;
}
.schedule-rows td[data-disabled] {
  opacity: 0.55;
}
</style>
