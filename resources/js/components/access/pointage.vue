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
                    <a href="#">Pointage</a>
                </li>
                
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="align-items-center d-flex justify-content-between">
                    <div class="card-title">Pointage</div>
                    <button class="btn btn-border btn-rounded btn-secondary"
                        @click.prevent.stop="importFromAllDevices">
                        <i class="icon-cloud-download"></i> Importer
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Date début</label>
                            <datetime v-model="date_deb"
                                        value-zone="Africa/Tunis"
                                        type="datetime"
                                        format="dd/MM/yyyy HH:mm"
                                        input-class="form-control">
                                </datetime>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Date fin</label>
                            <datetime v-model="date_fin"
                                        value-zone="Africa/Tunis"
                                        type="datetime"
                                        format="dd/MM/yyyy HH:mm"
                                        input-class="form-control">
                                </datetime>
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Departement</label>
                                <select class="form-control" v-model="departement_id" @change="changeDemartement">
                                    <option :value="0">Tous</option>
                                    <option v-for="departement in departements" :value="departement.id">{{departement.title}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Employes</label>
                                <template v-if="employe_id!=0">
                                    <router-link :to="{name : 'editEmploye', params : {'id' : employe_id}}">
                                        <i class="fa fa-search"></i>
                                    </router-link>
                                </template>
                                <v-select :options="employes" 
                                           v-model="employe_id" 
                                           :reduce="employe => employe.id" 
                                           :getOptionLabel="employe => employe.nom + ' ' + employe.prenom"
                                           @input="filter">
                                </v-select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <button class="btn btn-border btn-round btn-success"  @click.prevent.stop="filter">filter</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="selectgroup selectgroup-pills">
                                <label class="selectgroup-item" @click.prevent.stop="currentFilter = 'all'" >
                                    <input type="checkbox" name="value" value="all" class="selectgroup-input" :checked="currentFilter=='all'">
                                    <span class="selectgroup-button">Tous</span>
                                </label>
                                <label class="selectgroup-item" @click.prevent.stop="currentFilter = 'abs'" >
                                    <input type="checkbox" name="value" value="abs" class="selectgroup-input" :checked="currentFilter=='abs'">
                                    <span class="selectgroup-button">Absents</span>
                                </label>
                                <label class="selectgroup-item" @click.prevent.stop="currentFilter = 'erreur'" >
                                    <input type="checkbox" name="value" value="erreur" class="selectgroup-input" :checked="currentFilter=='erreur'">
                                    <span class="selectgroup-button">Problème pointage</span>
                                </label>
                                <label class="selectgroup-item" @click.prevent.stop="currentFilter = 'retard'" >
                                    <input type="checkbox" name="value" value="retard" class="selectgroup-input" :checked="currentFilter=='retard'">
                                    <span class="selectgroup-button">Retard/Av heure</span>
                                </label>
                              
                            </div>
                        </div>
                        <div class="col-sm-6">
                            
                            <div class="col-sm-6 col-md-3"><div class="card card-stats card-round"><div class="card-body "><div class="row align-items-center"><div class="col-icon"><div class="icon-big text-center icon-primary bubble-shadow-small"><i class="flaticon-users"></i></div></div> <div class="col col-stats ml-3 ml-sm-0"><div class="numbers"><p class="card-category">Total</p> <h4 class="card-title">{{filtred.length}}</h4></div></div></div></div></div></div>
                        </div>
                    </div>
                    
                <template v-if="typereport=='employe'">
                    <div v-if="filtred.length>0" class="align-items-center d-flex justify-content-end p-2">
                        <div class="">
                            <button @click.prevent.stop="makePdf" class="btn btn-border btn-danger btn-round btn-sm">
                                <span class="btn-label">
                                    <i class="far fa-file-pdf"></i>
                                </span> 
                                pdf
                            </button>

                            <download-excel
                                class="btn btn-border btn-success btn-round btn-sm"
                                header="Historique des accèes & Pointage"
                                :data="filtred"
                                :fields="json_fields"
                                worksheet="Historique"
                                name="Historique.xls"
                                >
                                <i class="far fa-file-excel" style="font-size: 16px;"></i>
                                Excel
                                </download-excel> 
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                                <table class="table table-bordered table-head-bg-primary" name="table" ref="table" id="pdf-make" v-if="filtred.length > 0">
                                    <thead>
                                        <tr>                           
                                            <th scope="col">Date</th>
                                            <th scope="col">Entrée Matin</th>
                                            <th scope="col">Sortie Matin</th>
                                            <th scope="col">Entrée A midi</th>
                                            <th scope="col">Sortie A midi</th>
                                            <th scope="col">RT      EO</th>
                                            <th scope="col">Commentaire</th>

                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <template v-for="(pointage,index) in filtred">
                                            <tr>
                                                                                                                                                                    
                                                    <td>
                                                       {{pointage.pointages.date | parseDate}}
                                                    </td>
                                                    <td>
                                                        <b v-if="pointage.pointages.emploiejour[0]">{{pointage.pointages.emploiejour[0][0]}}</b>
                                                        <template v-if="pointage.pointages.pointagejour[0]">
                                                            | {{pointage.pointages.pointagejour[0].heure}} 
                                                        </template>
                                                    </td>
                                                    <td>
                                                        <b v-if="pointage.pointages.emploiejour[0]">{{pointage.pointages.emploiejour[0][1]}}</b> 
                                                        <template v-if="pointage.pointages.pointagejour[1]">
                                                           | {{pointage.pointages.pointagejour[1].heure}} 
                                                        </template>
                                                    </td>
                                                    <td>
                                                        <b v-if="pointage.pointages.emploiejour[1]">{{pointage.pointages.emploiejour[1][0]}}</b>
                                                        <template v-if="pointage.pointages.pointagejour[2]">
                                                        | {{pointage.pointages.pointagejour[2].heure}} 
                                                        </template>
                                                    </td>
                                                    <td>
                                                        <b v-if="pointage.pointages.emploiejour[1]">{{pointage.pointages.emploiejour[1][1]}}</b> 
                                                        <template v-if="pointage.pointages.pointagejour[3]">
                                                            | {{pointage.pointages.pointagejour[3].heure}} 
                                                        </template>
                                                    </td>
                                                    <td>
                                                            <span style="color:red" v-if="pointage.pointages.retardmatin!=0">
                                                                {{pointage.pointages.retardmatin | minToDate}}
                                                            </span>
                                                            <span style="color:red" v-if="pointage.pointages.retardmatin==0">
                                                                00:00
                                                            </span>
                                                            |
                                                            <span style="color:red" v-if="pointage.pointages.avhapmidi!=0">
                                                                {{pointage.pointages.avhapmidi | minToDate}}
                                                            </span>
                                                            <span style="color:red" v-if="pointage.pointages.avhapmidi==0">
                                                                00:00
                                                            </span>
                                                    </td>
                                                    <td>
                                                        <div v-html="pointage.pointages.msg"></div>
                                                        <p v-if="pointage.pointages.nbseances*2!=pointage.pointages.nbpointage" class="text-info">Erreur de Pointage ({{pointage.pointages.nbpointage}}/{{pointage.pointages.nbseances*2}})</p>
                                                    </td>
                                                
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                                <template v-if="filtred.length==0">
                                    <p class="text-warning m-3" style="text-align:center">Pas de données</p>
                                </template>
                            </div>
                    </div>
                </template>
                <template v-if="typereport=='all'">
                     <div v-if="filtred.length>0" class="align-items-center d-flex justify-content-end p-2">
                        <div class="">
                            <button @click.prevent.stop="makePdf" class="btn btn-border btn-danger btn-round btn-sm">
                                <span class="btn-label">
                                    <i class="far fa-file-pdf"></i>
                                </span> 
                                pdf
                            </button>

                            <download-excel
                                class="btn btn-border btn-success btn-round btn-sm"
                                header="Historique des accèes & Pointage"
                                :data="filtred"
                                :fields="json_all"
                                worksheet="Historique"
                                name="Historique.xls"
                                >
                                <i class="far fa-file-excel" style="font-size: 16px;"></i>
                                Excel
                                </download-excel> 
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                                <table class="table table-bordered table-head-bg-primary" name="table" ref="table" id="pdf-make" v-if="filtred.length > 0">
                                    <thead>
                                        <tr>                           
                                            <th scope="col">Date</th>
                                            <th scope="col" style="width: 20%;"> Nom & prénom</th>
                                            <th scope="col">Département</th>
                                            <th scope="col">Entrée Matin</th>
                                            <th scope="col">Sortie Matin</th>
                                            <th scope="col">Entrée A midi</th>
                                            <th scope="col">Sortie A midi</th>
                                            <th scope="col">RT      EO</th>
                                            <th scope="col" style="width: 10%;">Etat</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <template v-for="(pointage,index) in filtred">
                                            <tr>
                                                    <td>
                                                        {{pointage.date | parseDate}}
                                                    </td>
                                                    <td style="width: 20%;">
                                                        <router-link :to="{name : 'editEmploye', params : {'id' : pointage.employe.id}}">
                                                            <template v-if="pointage.employe.id!=0">
                                                                <div class="avatar avatar-xs" style="margin-right:3px">
                                                                    <img :src="pointage.employe.avatar" class="avatar-img rounded-circle"/>
                                                                </div>
                                                            </template>
                                                           <span> {{pointage.employe.matricule}}-{{pointage.employe.prenom}} {{pointage.employe.nom}}</span>
                                                        </router-link>
                                                    </td>
                                                    <td>
                                                        <template v-if="pointage.pointages">
                                                            {{pointage.employe.departement}} 
                                                        </template>
                                                        <template v-else>
                                                            Absent
                                                        </template>
                                                    </td>
                                                    <td>
                                                        <template v-if="pointage.pointages">
                                                            <span>
                                                            <b v-if="pointage.pointages.emploiejour[0]">{{pointage.pointages.emploiejour[0][0]}}</b>
                                                            <template v-if="pointage.pointages.pointagejour[0]">
                                                                | {{pointage.pointages.pointagejour[0].heure}} 
                                                            </template>
                                                            <template v-else>
                                                                | 00:00
                                                            </template>
                                                            </span>
                                                        </template>
                                                    </td>
                                                    <td>
                                                        <template v-if="pointage.pointages">
                                                            <b v-if="pointage.pointages.emploiejour[0]">{{pointage.pointages.emploiejour[0][1]}}</b> 
                                                            <template v-if="pointage.pointages.pointagejour[1]">
                                                            | {{pointage.pointages.pointagejour[1].heure}} 
                                                            </template>
                                                            <template v-else>
                                                                | 00:00
                                                            </template>
                                                        </template>
                                                    </td>
                                                    <td>
                                                        <template v-if="pointage.pointages">
                                                            <b v-if="pointage.pointages.emploiejour[1]">{{pointage.pointages.emploiejour[1][0]}}</b>
                                                            <template v-if="pointage.pointages.pointagejour[2]">
                                                            | {{pointage.pointages.pointagejour[2].heure}} 
                                                            </template>
                                                            <template v-else>
                                                                | 00:00
                                                            </template>
                                                        </template>

                                                    </td>
                                                    <td>
                                                        <template v-if="pointage.pointages">
                                                            <b v-if="pointage.pointages.emploiejour[1]">{{pointage.pointages.emploiejour[1][1]}}</b> 
                                                            <template v-if="pointage.pointages.pointagejour[3]">
                                                                | {{pointage.pointages.pointagejour[3].heure}} 
                                                            </template>
                                                            <template v-else>
                                                                | 00:00
                                                            </template>
                                                        </template>
                                                    </td>
                                                    <td>
                                                            <span style="color:red" v-if="pointage.pointages.retardmatin!=0">
                                                                {{pointage.pointages.retardmatin | minToDate}}
                                                            </span>
                                                            <span style="color:red" v-if="pointage.pointages.retardmatin==0">
                                                                00:00
                                                            </span>
                                                            |
                                                            <span style="color:red" v-if="pointage.pointages.avhapmidi!=0">
                                                                {{pointage.pointages.avhapmidi | minToDate}}
                                                            </span>
                                                            <span style="color:red" v-if="pointage.pointages.avhapmidi==0">
                                                                00:00
                                                            </span>
                                                    </td>
                                                    <td style="width: 10%;">
                                                        <div v-html="pointage.pointages.msg"></div>
                                                        <p v-if="pointage.pointages.nbseances*2!=pointage.pointages.nbpointage" class="text-info">Erreur de Pointage ({{pointage.pointages.nbpointage}}/{{pointage.pointages.nbseances*2}})</p>
                                                    </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                                <template v-if="filtred.length==0">
                                    <p class="text-warning m-3" style="text-align:center">Pas de données</p>
                                </template>
                            </div>
                    </div>
                </template>
                    
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pointages</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                                <ol class="activity-feed">
                                    <li class="feed-item feed-item-secondary" v-for="p in currentpointages">
                                        <time class="date" datetime="9-25">{{p.heure}}</time>
                                        <span class="text"></span>
                                    </li>
                                </ol>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import * as moment from 'moment';
import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css'
import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'
import TableExport from 'tableexport'
import 'vue-select/dist/vue-select.css';
import Vue from 'vue'
import vSelect from 'vue-select'
function  minToDate(value){
            var num = value;
            var hours = (num / 60);
            var rhours = Math.floor(hours);
            rhours = rhours==0 ? '00' : rhours;
            var minutes = (hours - rhours) * 60;
            var rminutes = Math.round(minutes);
            rminutes = rminutes<=9 ? '0'+rminutes : rminutes
            return  rhours + ":" + rminutes ;
        }
Vue.component('v-select', vSelect)
window.moment = moment

export default {
    components : {Datetime},
    data(){
        return {
            typereport : 'employe',
            currentpointages : [],
            employe_id : 0,
            search : '',
            pointages : [],
            departements : [],
            employes : [],
            currentFilter : 'all',
            selectedEmployes : [],
            departement_id : 0,
             date_deb : moment().startOf('days').subtract(1, 'days').toISOString(),
             date_fin : moment().endOf('days').subtract(1, 'days').toISOString(),  
            //date_deb : moment().subtract(1, 'days').toISOString(),
            //date_fin : moment().subtract(1, 'days').toISOString(),  
            json_fields: {
                // 'Jour': 'pointages.date',
                'Jour': {
                    field: "pointages.date",
                        callback: (value) => {
                            return moment(value).format("DD/MM/YYYY");
                    },
                },
                'Entrée Matin': {
                    field: "pointages.pointagejour",
                        callback: (value) => {
                            if (value[0]){
                                return `${value[0].heure}`;
                            }else{
                                return '00:00';
                            }
                    },
                },
                'Sortie Matin': {
                    field: "pointages.pointagejour",
                        callback: (value) => {
                            if (value[1]){
                                return `${value[1].heure}`;
                            }else{
                                return '00:00';
                            }
                    },
                },
                'Entrée A midi': {
                    field: "pointages.pointagejour",
                        callback: (value) => {
                            if (value[2]){
                                return `${value[2].heure}`;
                            }else{
                                return '00:00';
                            }
                    },
                },
                'Sortie A midi': {
                    field: "pointages.pointagejour",
                        callback: (value) => {
                            if (value[3]){
                                return `${value[3].heure}`;
                            }else{
                                return '00:00';
                            }
                    },
                },  
                'RT': {
                    field: "pointages.retardmatin",
                        callback: (value) => {
                                return minToDate(value);
                        
                    },
                },
                'EO': {
                    field: "pointages.avhapmidi",
                        callback: (value) => {
                                return minToDate(value);
                        
                    },
                },
                'Commentaire': 'pointages.msg',
                // 'Nb Pointages': 'pointages.nbpointage',
            },
            json_all: {
                'Date': {
                    field: "pointages",
                        callback: (value) => {
                            return `${value.date}`;
                    },
                },
                'Employé': {
                    field: "employe",
                        callback: (value) => {
                            return `${value.prenom} ${value.nom}`;
                    },
                },
                'Entrée Matin': {
                    field: "pointages.pointagejour",
                        callback: (value) => {
                            if (value[0]){
                                return `${value[0].heure}`;
                            }else{
                                return '00:00';
                            }
                    },
                },
                'Sortie Matin': {
                    field: "pointages.pointagejour",
                        callback: (value) => {
                            if (value[1]){
                                return `${value[1].heure}`;
                            }else{
                                return '00:00';
                            }
                    },
                },
                'Entrée A midi': {
                    field: "pointages.pointagejour",
                        callback: (value) => {
                            if (value[2]){
                                return `${value[2].heure}`;
                            }else{
                                return '00:00';
                            }
                    },
                },
                'Sortie A midi': {
                    field: "pointages.pointagejour",
                        callback: (value) => {
                            if (value[3]){
                                return `${value[3].heure}`;
                            }else{
                                return '00:00';
                            }
                    },
                },
                'RT': {
                    field: "pointages.retardmatin",
                        callback: (value) => {
                                return minToDate(value);
                        
                    },
                },
                'EO': {
                    field: "pointages.avhapmidi",
                        callback: (value) => {
                                return minToDate(value);
                        
                    },
                },
                'Commentaire': 'pointages.msg',
            },
        }
    },
    filters:{
        parseDate(value){
            return moment(value).format("DD/MM/YYYY")
            // return moment(value).format("dddd DD/MM/YYYY")
        },
        minToDate(value){
            var num = value;
            var hours = (num / 60);
            var rhours = Math.floor(hours);
            rhours = rhours==0 ? '00' : rhours;
            var minutes = (hours - rhours) * 60;
            var rminutes = Math.round(minutes);
            rminutes = rminutes<=9 ? '0'+rminutes : rminutes
            return  rhours + ":" + rminutes ;
        }
    },
    methods : {
        makePdf(){
            let img = window.location.origin + '/img/logo.png';
          const doc = new jsPDF('landscape')
          doc.setFontSize(18);
          if (this.typereport =='employe'){
              let emp = this.employes.find(emp => emp.id == this.employe_id);
              doc.addImage(img, 15,  10, 20, 20);
              doc.text(70, 20, emp.prenom + ' ' + emp.nom + ' pointage du ' + moment(this.date_deb).format('DD/MM/YYYY') + ' à ' + moment(this.date_fin).format('DD/MM/YYYY'));
          }else{
              let dep = this.departements.find(d => d.id==this.departement_id)
              let type = ''
              if (this.currentFilter=='all'){
                  type = 'Tous'
              }
              if (this.currentFilter=='abs'){
                  type = 'Absents'
              }
              if (this.currentFilter=='erreur'){
                  type = 'Erreur de pointage'
              }
              if (this.currentFilter=='retard'){
                  type = 'retard/av heure'
              }
              let depname = dep ? dep.title : '' 
                depname += ' ' + type +' : '+ this.filtred.length
              doc.addImage(img, 15,  10, 20, 20);
              doc.text(70, 20, 'Pointage du ' + moment(this.date_deb).format('DD/MM/YYYY') + ' à ' + moment(this.date_fin).format('DD/MM/YYYY') + ' (' + depname + ')' );
              ``
          }
            var res = doc.autoTableHtmlToJson(document.getElementById("pdf-make"));
            var columns = [res.columns[0], res.columns[1],res.columns[2],res.columns[3],res.columns[4],res.columns[5],res.columns[6],res.columns[7],res.columns[8]];
            doc.autoTable(columns, res.data, {startY: 40,styles: {
         overflow: 'linebreak',
         columnWidth: 'wrap',
         fontSize: 8,
         overflowColumns: 'linebreak'
     }});
             
            // doc.autoTable({ html: '#pdf-make',startY: 12 })
            doc.save('pointage.pdf')

      },
        async filter(){
            let that = this
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/filterpointage',{
                method : 'post',
                body : JSON.stringify({employe_id : this.employe_id,
                                       departement_id : this.departement_id,
                                       date_deb : moment(this.date_deb).format('YYYY-MM-DD HH:mm:ss'),
                                       date_fin : moment(this.date_fin).format('YYYY-MM-DD HH:mm:ss')}),
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
            .then(function(response){
                console.log(response);
                that.$store.dispatch('setLoader', false)
                that.typereport = response.typereport
                that.pointages = response.pointages
            })
            .catch((error) => {
                console.log(error)
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
        async importFromAllDevices(){
            var that = this;
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/importelogsstandalone',{
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
            .then(function(response){
                    that.$store.dispatch('setLoader', false)
                })
                .catch((response) => {
                    console.log(error)
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
        async changeDemartement(){
            let that = this
            this.pointages = []
            this.porte_id = 0
            if (this.zone_id==0){
                return
            }
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/getemployes/' + this.departement_id,{
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
            .then(function(response){
                    that.$store.dispatch('setLoader', false)
                    that.employes = response.employes;
                    if (response.length>0){
                        // that.porte_id = response[0].id
                    }
                })
                .catch((error) => {
                    console.log(error)
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
        getdepartememnts(){
            let that = this
            this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/departements',{
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
                if (data){
                    that.departements = data
                    if (data.length>0){
                        that.departement_id = data[0].id
                        this.changeDemartement()
                    }
                    that.$store.dispatch('setLoader', false)
                    
                }
            })
            .catch(error => {
                console.log(error)
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
        }
    },
    mounted(){
        moment.locale('fr');
        this.getdepartememnts()

    },
    computed:{
        ...mapGetters({
            user : 'getUser'
        }),
        filtred(){
            let t = []
            if (this.currentFilter=='abs'){
                t = this.pointages.filter(obj => obj.pointages.nbpointage==0)
            }
            if (this.currentFilter=='all'){
                t = this.pointages
            }
            if (this.currentFilter=='erreur'){
                t = this.pointages.filter(obj => obj.pointages.nbseances*2!=obj.pointages.nbpointage)
            }
            if (this.currentFilter=='retard'){
                t = this.pointages.filter(obj => obj.pointages.msg!='' && obj.pointages.nbpointage!=0)
            }
            return t;
        }
    }
}
</script>

<style scoped>
    .efface{
        color: #f25961;
    }
    .current{
        background :#eee;
    }
</style>

<style>
    .table td, .table th{
        padding: 2px !important;
    }
</style>

