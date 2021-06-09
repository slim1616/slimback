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
                <div class="card-title">Ajouter timezone</div>
            </div>
            <div class="card-body">
                <form @submit.prevent="createTimezone">
                  <router-link to="/timezones" class="back-to"><i class="icon-arrow-left"></i> timezones</router-link>
                  <div class="row">
                           
                  
                           
                            <input class="form-control" type="hidden" v-model="form.id"/>
                             
                
                <div class="col-sm-4">
                      <div class="form-group">
                                                                                                      <label>Titre</label>
                                          <input class="form-control" type="text" v-model="form.titre"  maxlength="255" />
                                                                          <has-error :form="form" field="titre"/>
                                                          </div>
                  </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                            <label>Heure_debut</label>
                            <vue-timepicker input-class="form-control"	 :minute-interval="5" v-model="form.heure_debut"></vue-timepicker>
                            <has-error :form="form" field="heure_debut"/>
                                                          </div>
                  </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Heure_fin</label>
                        <vue-timepicker input-class="form-control"	 :minute-interval="5" v-model="form.heure_fin"></vue-timepicker>
                        <has-error :form="form" field="heure_fin"/>
                        </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                    <label>Marge_entree</label>
                            <input class="form-control" type="number" v-model="form.marge_entree"/>
                                      <has-error :form="form" field="marge_entree"/>
                                                          </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                    <label>Marge_sortie</label>
                            <input class="form-control" type="number" v-model="form.marge_sortie"/>
                                      <has-error :form="form" field="marge_sortie"/>
                                                          </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                    <label>Marge_entree_retard</label>
                            <input class="form-control" type="number" v-model="form.marge_entree_retard"/>
                                      <has-error :form="form" field="marge_entree_retard"/>
                                                          </div>
                  </div>
                                                          <div class="col-sm-4">
                      <div class="form-group">
                                                    <label>Marge_sortie_retard</label>
                            <input class="form-control" type="number" v-model="form.marge_sortie_retard"/>
                                      <has-error :form="form" field="marge_sortie_retard"/>
                                                          </div>
                  </div>
                                           
                           
                            <input class="form-control" type="hidden" v-model="form.created_at"/>
                             
                
                                           
                  
                           
                            <input class="form-control" type="hidden" v-model="form.updated_at"/>
                             
                
                                            </div>
                  <div class="row">
                      <button class="btn btn-primary" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Ajouter'}}</button>
                  </div>
                </form>
                <div class="row">
                    <div id="weekly-schedule"></div>
                </div>
          </div>
      </div><!-- Card-body -->
  </div><!-- page-inner -->
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
import VueTimepicker from 'vue2-timepicker'
 
// CSS
import 'vue2-timepicker/dist/VueTimepicker.css'

export default {
  name: 'Timezone',
  components: {HasError, VueTimepicker},
  data: function(){
    return {
      timezones : false,
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
          "heure_debut" : "00:00",
          "heure_fin" : "23:59",
          "marge_entree" : 0,
          "marge_sortie" : 0,
          "marge_entree_retard" : 0,
          "marge_sortie_retard" : 0,
          "planning" : "",
          "created_at" : "",
          "updated_at" : "",
      })
    }
  },
  created: function(){
    this.listTimezones();
  },
  methods: {
    onIpChange(ip) {
            console.log('ip input change:', ip);
            this.form.ip = ip
    },
    listTimezones: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/timezones')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200||response.status==201){
                  that.timezones = response.data;
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
    createTimezone: function(){
      
      var that = this;
      this.form.planning = JSON.stringify($("#weekly-schedule").data('artsy.dayScheduleSelector').serialize({ }));
      console.log(this.form.planning)
      this.form.post('/api/timezones')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
              if (response.status==200||response.status==201){
                  that.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                  that.$router.push('/timezones');
                  
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
</script>

<style>
  .invalid-feedback{
    display: block;
  }
</style>