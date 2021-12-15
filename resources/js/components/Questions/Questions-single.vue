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
                    <a href="#">questions</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modifier question</div>
            </div>
            <div class="card-body">      
                <form @submit.prevent="updateQuestion" v-if="loaded">
                  <router-link to="/questions" class="back-to"><i class="icon-arrow-left"></i> questions</router-link>
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
                        
                        
                                                                                <label>Type</label>
                                            <select class="form-control" v-model="form.type">
                                                                                                    <option value="simple">simple</option>
                                                                                                    <option value="quiz">quiz</option>
                                                                                                    <option value="multiple">multiple</option>
                                                                                            </select>
                                                            
                                          <has-error :form="form" field="type"></has-error>
                                                
                        
                                </div>
                            </div>
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                                                                  <label>Options</label>
                                          <input class="form-control" type="number" v-model="form.options"/>
                        
                                          <has-error :form="form" field="options"></has-error>
                                                
                        
                                </div>
                            </div>
                                                                        
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
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                        
                                    
                                    <label>Enquete</label>
                                    <select class="form-control" v-model="form.enquete_id">
                                            
                                            <option v-for="enquete in enquetes" :value="enquete.id">
                                                 {{ enquete.title }}
                                            </option>

                                        </select>
                                                            
                                          <has-error :form="form" field="enquete_id"></has-error>
                                                
                        
                                </div>
                            </div>
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                        
                                                                           
                                       <datetime v-model="form.start_at"
                                       value-zone="Africa/Tunis"
                                       type="date"
                                       format="yyyy-MM-dd"
                                       input-class="form-control"/>
                                                                                    
                        
                                </div>
                            </div>
                                                                        
                            <div class="col-sm-4">
                                <div class="form-group">
                        
                        
                                                                           
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
                    <div class="card-action">
                        <button class="btn btn-success" type="submit" :disabled="form.busy" name="button">{{ (form.busy) ? 'Please wait...' : 'Enregistrer'}}</button>
                        <button class="btn btn-danger" @click.prevent="deleteQuestion">{{ (form.busy) ? 'Please wait...' : 'Effacer'}}</button>
                    </div>
                    
              </form>
              <span v-else>Loading question...</span>
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
  name: 'Question',
  components: {HasError, Datetime},
  data: function(){
    return {
      loaded: false,
                
                        
                        
                        
                        
                
        companies : [],
                        
                
        users : [],
                        
                
        enquetes : [],
                        
                        
                        
                        
                      form: new Form({
                                id : "",
                                question : "",
                                type : "",
                                options : "",
                                company_id : "",
                                user_id : "",
                                enquete_id : "",
                                start_at : "",
                                end_at : "",
                                created_at : "",
                                updated_at : "",
                  })
    }
  },
  created: function(){
    this.getQuestion();
  },
  methods: {
   
    getQuestion: function(Question){
      
      var that = this;
      this.form.get('/api/questions/'+this.$route.params.id).then(function(response){
        that.form.fill(response.data.question);
                
                        
                        
                        
                        
                
        that.companies =  response.data.companies;
                        
                
        that.users =  response.data.users;
                        
                
        that.enquetes =  response.data.enquetes;
                        
                        
                        
                        
                        that.loaded = true;
      }).catch(function(e){
          if (e.response && e.response.status == 404) {
              that.$router.push('/404');
          }
      });
      
    },
    updateQuestion: function(){
      var that = this;

        this.$store.dispatch('setLoader', true)
                
                        
                        
                        
                        
                        
                        
                        
                    if (this.form.start_at!=""){
                this.form.start_at = moment(this.form.start_at).format('YYYY-MM-DD')
            }
                        
                    if (this.form.end_at!=""){
                this.form.end_at = moment(this.form.end_at).format('YYYY-MM-DD')
            }
                        
                        
                
        this.form.put('/api/questions/'+this.$route.params.id)
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
    deleteQuestion: function(){
      
      var that = this;
      swal.fire({
                title: 'Vous êtes sure?',
                text: "Vous allez effacer Question!",
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
                  this.form.delete('/api/questions/'+this.$route.params.id).then(function(response){
                    that.$store.dispatch('setLoader', false)
                      that.form.fill(response.data);
                      that.$router.push('/questions');
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