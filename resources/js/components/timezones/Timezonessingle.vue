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
                    <a href="#">timezones</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modifier timezone</div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updateTimezone" v-if="loaded">
                  <router-link to="/timezones" class="back-to"><i class="icon-arrow-left"></i> timezones</router-link>
                  <div class="row">
                                                
                           
                                          <input class="form-control" type="hidden" v-model="form.id"/>
                        
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                                                      <label>Titre</label>
                                          <input class="form-control" type="text" v-model="form.titre"  maxlength="255" />
                                                                                                      <has-error :form="form" field="titre"></has-error>
                                                
                                                        </div>
                            </div>
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                  <label>Heure_debut</label>
                                            <vue-timepicker input-class="form-control"	 :minute-interval="5" v-model="form.heure_debut"></vue-timepicker>
                                                                  <has-error :form="form" field="heure_debut"></has-error>
                                                
                                                        </div>
                            </div>
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                        <label>Heure_fin</label>
                                        <vue-timepicker input-class="form-control"	 :minute-interval="5" v-model="form.heure_fin"></vue-timepicker>
                                        <has-error :form="form" field="heure_fin"></has-error>
                                </div>
                            </div>
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                  <label>Marge_entree</label>
                                          <input class="form-control" type="number" v-model="form.marge_entree"/>
                                                                  <has-error :form="form" field="marge_entree"></has-error>
                                                
                                                        </div>
                            </div>
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                  <label>Marge_sortie</label>
                                          <input class="form-control" type="number" v-model="form.marge_sortie"/>
                                                                  <has-error :form="form" field="marge_sortie"></has-error>
                                                
                                                        </div>
                            </div>
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                  <label>Marge_entree_retard</label>
                                          <input class="form-control" type="number" v-model="form.marge_entree_retard"/>
                                                                  <has-error :form="form" field="marge_entree_retard"></has-error>
                                                
                                                        </div>
                            </div>
                                                                                                    <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                  <label>Marge_sortie_retard</label>
                                          <input class="form-control" type="number" v-model="form.marge_sortie_retard"/>
                                                                  <has-error :form="form" field="marge_sortie_retard"></has-error>
                                                
                                                        </div>
                            </div>
                            <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Planning</label>
                                        <input class="form-control" type="number" v-model="schedule"/>
                                        <has-error :form="form" field="planning"></has-error>
                                    </div>
                            </div>
                                                                        
                           
                                          <input class="form-control" type="hidden" v-model="form.created_at"/>
                        
                                                                        
                           
                                          <input class="form-control" type="hidden" v-model="form.updated_at"/>
                        
                                                                  </div>
                    <div class="card-action">
                        <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                        <button class="btn btn-danger" @click.prevent="deleteTimezone">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                    </div>
                    
              </form>
            <div id="weekly-schedule"></div>
            </div>
        </div>
  </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
// import 'vue-daily-scheduler/dist/vue-schedule.min.css'
// import VueSchedule from 'vue-daily-scheduler'

import VueTimepicker from 'vue2-timepicker'
 
// CSS
import 'vue2-timepicker/dist/VueTimepicker.css'
import { setTimeout } from 'timers';

export default {
  name: 'Timezone',
  components: {HasError, VueTimepicker},
  data: function(){
    return {
      loaded: false,
      schedule: {
                0: [],
                1: [],
                2: [],
                3: [],
                4: [],
                5: [],
                6: []
            },
      form: new Form({
          "id" : "",
          "titre" : "",
          "heure_debut" : "",
          "heure_fin" : "",
          "marge_entree" : "",
          "marge_sortie" : "",
          "marge_entree_retard" : "",
          "marge_sortie_retard" : "",
          "planning" : "",
          "created_at" : "",
          "updated_at" : "",
        
      })
    }
  },
  created: function(){

    this.getTimezone();
  },
  methods: {
    getTimezone: function(Timezone){
      
      var that = this;
      this.form.get('/api/timezones/'+this.$route.params.id).then(function(response){
        that.form.fill(response.data.data);
        let tab = JSON.parse(response.data.data.planning)
        const obj = {...tab};

        try{
            
            setTimeout(() => {
                $("#weekly-schedule").data('artsy.dayScheduleSelector').deserialize(obj);

            },1000)
        }catch(error){
            console.log(error)
        }
        that.loaded = true;
      }).catch(function(e){
          if (e.response && e.response.status == 404) {
              that.$router.push('/404');
          }
      });
      
    },
    updateTimezone: function(){
      var that = this;
        this.form.planning = $("#weekly-schedule").data('artsy.dayScheduleSelector').serialize({ });
        console.log(this.form.planning)
        this.$store.dispatch('setLoader', true)
        this.form.put('/api/timezones/'+this.$route.params.id)
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
    deleteTimezone: function(){
      
      var that = this;
      swal({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Timezone!",
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
                  this.form.delete('/api/timezones/'+this.$route.params.id).then(function(response){
                    that.$store.dispatch('setLoader', false)
                      that.form.fill(response.data);
                      that.$router.push('/timezones');
                    })
                } else {
                    swal.close();
                }
            }); 
    },
    drawTab(){
        $("#weekly-schedule").dayScheduleSelector({
                days        : [0, 1, 2, 3, 4, 5, 6],  
                startTime   : '00:00',         
                endTime     : '24:00',     
                interval    : 30,    
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
  mounted(){
      var vm = this
      setTimeout(function() {
          vm.drawTab()
      },1000)
  }
}
// $("#day-schedule").data('artsy.dayScheduleSelector').deserialize({
//         //'0': [['09:30', '11:00'], ['13:00', '16:30']]
//         //'1': [['09:00', '11:00'], ['13:00', '16:00']]

// [parsing]

//       });
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

  /* .vws-table-rule{
      display: flex;
  }
  .vws-table-rule-body{
      display: flex;
  }
  .vws-table-rule-heading, .vws-rule-time{
      flex-direction: column;
  } */
  
  #schedule-table{
      width:100%;
  }
  .schedule-header >tr> th{
      text-align: center;
  }
.schedule-rows td {
  width: 80px;
  height: 10px;
  margin: 3px;
  padding: 5px;
  background-color: #0b438e;
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
.schedule-rows td[data-selecting] { background-color: #63ce3c; }

.schedule-rows td[data-disabled] { opacity: 0.55; }

</style>

