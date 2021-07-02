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
                <div class="header-btns">
                  <div class="card-title">Liste de questions</div>
                  <router-link to="/createquestions" class="btn btn-border btn-round btn-secondary">
                        <i class="fas fa-plus"></i> Ajouter
                  </router-link>
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-primary" v-if="questions.length > 0">
                        <thead>
                          <tr>
                                                                                                                   
                                                                    <th scope="col">Question</th>
                                                                                                                         
                                                                    <th scope="col">Type</th>
                                                                                                                         
                                                                    <th scope="col">Options</th>
                                                                                                                         
                                
                                    <th scope="col">company</th>
                                                                                                                         
                                
                                    <th scope="col">user</th>
                                                                                                                         
                                
                                    <th scope="col">enquete</th>
                                                                                                                         
                                                                    <th scope="col">Start_at</th>
                                                                                                                         
                                                                    <th scope="col">End_at</th>
                                                                                                                                                                                                                                      <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            <template v-for="(question,index) in questions"  >
                                <tr :key="question.id">
                                                                                                                                                           
                                                                                            <td>
                                                    <router-link :to="'/questions/'+question.id">
                                                    <span v-html="question.question"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/questions/'+question.id">
                                                    <span v-html="question.type"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/questions/'+question.id">
                                                    <span v-html="question.options"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                            
                                                <td>
                                                    <router-link :to="'/companies/'+question.company_id">
                                                        <span v-html="question.company"></span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                            
                                                <td>
                                                    <router-link :to="'/users/'+question.user_id">
                                                        <span v-html="question.user"></span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                            
                                                <td>
                                                    <router-link :to="'/enquetes/'+question.enquete_id">
                                                        <span v-html="question.enquete"></span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/questions/'+question.id">
                                                    <span v-html="question.start_at"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                   
                                                                                            <td>
                                                    <router-link :to="'/questions/'+question.id">
                                                    <span v-html="question.end_at"> </span>
                                                    </router-link>
                                                </td>
                                                                                                                                                                                                                                                                                                                    <td>
                                      <div class="action-btns">
                                          <router-link :to="'/questions/'+question.id" class="edit-btn">
                                              <i class="icon-note"></i>
                                          </router-link>

                                          <a href="#" @click.prevent.stop="deleteQuestion(question,index)" class="delete-btn">
                                            <i class="icon-close" ></i>
                                          </a>
                                      </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                      </table>
                  </div>
              </div>
      </div><!-- Card -->
  </div><!-- page-inner -->
</template>

<script>
import { Form, HasError, AlertError } from 'vform'
export default {
  name: 'Question',
  components: {HasError},
  data: function(){
    return {
      questions : false,
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
    this.listQuestions();
  },
  methods: {
    listQuestions: function(){
      
      var that = this;
      this.$store.dispatch('setLoader', true)
      this.form.get('/api/questions')
      .then(function(response){
              that.$store.dispatch('setLoader', false)
                if (response.status==200){
                  that.questions = response.data;
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
            //   that.form.fill(response.data);
          })
          .catch((response) => {
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
    createQuestion: function(){
      
      var that = this;
      this.form.post('/api/questions').then(function(response){
        that.questions.push(response.data);
      })
      
    },
    deleteQuestion: function(question, index){
          var that = this;
          swal({
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
                  this.form.delete('/api/questions/'+question.id).then(function(response){
                    that.questions.splice(index,1);
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
</style>

<style scoped>
    .header-btns{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .action-btns{
        display: flex;
        justify-content: space-evenly;
        align-items: center;
    }
    .edit-btn{
      color: #31ce36!important;
      margin: 0 10px;
      text-decoration : none;
    }
    .delete-btn{
      color: #f25961!important;
      text-decoration : none;
    }
</style>