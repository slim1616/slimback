<template>
     <div class="card">
            <div class="card-header">
                <div class="card-title">Gestion d'enquete ({{questions.length}})</div>
            </div>
            <div class="card-body"> 
                    <div class="row">
                    
                        <div class="col-sm-3" ref="infoBox">
                            
                            <template v-if="questions.length>0">
                                    <template v-for="question in questions">
                                            <div v-if="question.question_type=='icons'" :id="'questioned-' + question.order">
                                                <template v-if="question">
                                                    <icon-edit :question="question"></icon-edit>
                                                </template>
                                            </div>
                                            <div v-if="question.question_type=='stars'" :id="'questioned-' + question.order">
                                                <template v-if="question">
                                                    <stars-edit :question="question"></stars-edit>
                                                </template>
                                            </div>
                                            <div v-if="question.question_type=='choix'" :id="'questioned-'+question.order">
                                                <choix-edit :question="question"></choix-edit>
                                            </div>
                                    </template>
                            </template>
                            <div class="form-group">
                                <select class="form-control" v-model="selectedTypeQuestion" @change="changeTypeQuestion">
                                    <option value="">Choisir un type</option>
                                    <option value="icons">Icons</option>
                                    <option value="stars">Stars</option>
                                    <option value="choix">choix</option>
                                </select>
                                <button class="btn btn-primary btn-border btn-round btn-sm m-1" v-if="selectedTypeQuestion!=''" @click.prevent.stop="addQuestion()">Ajouter</button>
                            </div>

                            
                            
                        </div>

                        <div class="col-sm-9">
                            <draggable class="dragArea list-group drag-content" handle=".handle" v-model="questions" @change="log" @start="dragging = true"
                                    @end="dragging = false" ghost-class="ghost" >
                                        <template v-if="questions.length>0">
                                            <template v-for="question in questions">
                                                    <div class="handle question" :id="'question-'+question.order">
                                                        <div class="headet-question d-flex justify-content-end">
                                                            <i class="far fa-trash-alt red" @click.prevent.stop="delQuestion(question.id, question.order)"></i>
                                                        </div>
                                                        <div>
                                                            <h2 class="txt-question">{{question.textquestion}}</h2>
                                                        </div>
                                                        <template v-if="question.question_type=='icons'">
                                                            <ul class="align-items-center d-flex justify-content-around">
                                                                <li v-for="quest in question.questions">
                                                                    <div class="align-items-center d-flex flex-column justify-content-center">
                                                                        <i class="fa-2x" :class="quest.icon" :style="{color: quest.color}"></i>
                                                                        <p>{{quest.text}}</p>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </template>
                                                        <template v-if="question.question_type=='stars'">
                                                            <div class="d-flex justify-content-center pt-5">
                                                                <star-rating :show-rating="false"	:border-width="4" border-color="#d8d8d8" :rounded-corners="true" :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]"></star-rating>
                                                            </div>
                                                        </template>
                                                        <template v-if="question.question_type=='choix'">
                                                                <ul class="">
                                                                    <li v-for="quest in question.questions">
                                                                        <div href="#" class="align-items-center d-flex">
                                                                            <label :class="[question.typeinput=='checkbox' ? 'form-check-input': 'form-radio-input']">
                                                                                <input :type="question.typeinput" name="question" :class="[question.typeinput=='checkbox' ? 'form-check-label': 'form-radio-label']"/>
                                                                                <span :class="[question.typeinput=='checkbox' ? 'form-check-sign': 'form-radio-sign']">{{quest.text}}</span>
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </template>

                                                    </div>
                                            </template>
                                        </template>

                            </draggable>

                            
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                    <button class="btn btn-success" @click.prevent.stop="savequestion" v-if="questions.length>0">
                        <span class="btn-label">
                            <i class="fa fa-save"></i>
                        </span>
                        Enregistrer
                    </button>
                    </div>
            </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import IconEdit from './IconEdit'
import starsEdit from './starsEdit'
import choixEdit from './choixEdit'
import StarRating from 'vue-star-rating'


export default {
    components:{draggable, IconEdit, choixEdit, starsEdit, StarRating},
    props:{
        survey : Object,
    },
    data(){
        return {
            loading : false,
            selectedTypeQuestion : '',    
            currentQuestion : {
                typeIcon : 'star',
                obligatoire : true,
                id: 0, 
                label : 'Icons',
                textquestion : '',
                questions:[ {id : 1, text : 'Bad', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'red'}, 
                            {id : 2, text : 'Normal', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'orange'},
                            {id : 3, text : 'Good', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'green'}],
                question_type : "icons", 
                order: 1, 
                'icon' : 'fa-check-square', 
                status: "offline"
            },
            
            
            questions : []
        }
    },
    methods:{
        async getQuestions(){
                this.$store.dispatch('setLoader',true)
                this.loading = true
                let response = await fetch(window.location.origin + '/api/enquestions',{
                    method : 'post',
                    body : JSON.stringify({ enquete_id : this.survey.id, company_id: this.survey.company_id}),
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
                    this.loading = false
                    this.$store.dispatch('setLoader',false)
                })
                .then(data => {
                    this.loading = false
                    this.$store.dispatch('setLoader',false)
                    this.questions = []
                    // ////console.log(data.sections)
                    this.questions = data.questions
                })
                .catch(err => {
                    ////console.log(err)
                    this.$toasted.global.my_app_error();
                    this.loading = false
                    this.$store.dispatch('setLoader',false)
                })   
        },
        async savequestion(){
                this.$store.dispatch('setLoader',true)
                this.loading = true
                let response = await fetch(window.location.origin + '/api/savequestions',{
                    method : 'post',
                    body : JSON.stringify({ enquete_id : this.survey.id, company_id: this.survey.company_id,
                        questions : this.questions
                    }),
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
                    this.loading = false
                    this.$store.dispatch('setLoader',false)
                })
                .then(data => {
                    this.loading = false
                    this.$store.dispatch('setLoader',false)
                    this.questions = []
                    // ////console.log(data.sections)
                    this.questions = data.questions
                })
                .catch(err => {
                    ////console.log(err)
                    this.$toasted.global.my_app_error();
                    this.loading = false
                    this.$store.dispatch('setLoader',false)
                })
        },
        log(e){
            ////console.log(e)
            this.savequestion()
        },
        addQuestion(){
            let q = JSON.parse(JSON.stringify(this.currentQuestion));
            ////console.log(q)
            if (this.selectedTypeQuestion=='icons'){
                this.questions.push(q)
                // this.savequestion()
            }
            if (this.selectedTypeQuestion=='stars'){
                this.questions.push(q)
                // this.savequestion()
            }
            if (this.selectedTypeQuestion=='choix'){
                this.questions.push(q)
                // this.savequestion()
            }
            this.initCurrentQuestion()
        },
        changeTypeQuestion(){
            if (this.selectedTypeQuestion=='icons'){
                this.currentQuestion = {
                    typeIcon : 'face',
                    id: 0, 
                    label : 'Icons',
                    textquestion : '',
                    obligatoire : true,
                    questions:[ {id : 1, text : 'Very Bad', mobicon : 'frown-o', icon : 'far fa-frown', color : 'red', statcolor : 'red'}, 
                                {id : 3, text : 'Normal', mobicon : 'meh-o', icon : 'far fa-meh', color : 'orange', statcolor : 'orange'},
                                {id : 5, text : 'Very Good', mobicon : 'smile-o', icon : 'far fa-smile', color : 'green', statcolor : 'green'}],
                    question_type : "icons", 
                    order: 1, 
                    'icon' : 'fa-check-square', 
                    status: "offline"
                }
            }
             if (this.selectedTypeQuestion=='stars'){
                this.currentQuestion = {
                    typeIcon : 'star',
                    id: 0, 
                    label : 'Icons',
                    textquestion : '',
                    obligatoire : true,
                    questions:[{id : 1, text : '1/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'red'}, 
                            {id : 2, text : '2/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : '#d17474'},
                            {id : 3, text : '3/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'orange'},
                            {id : 4, text : '4/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : '#6ebb30'},
                            {id : 5, text : '5/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'green'}],
                    question_type : "stars", 
                    order: 1, 
                    'icon' : 'fa-check-square', 
                    status: "offline"
                }
            }
            if (this.selectedTypeQuestion=='choix'){
                this.currentQuestion = {
                    typeinput : 'radio',
                    id: 0, 
                    label : 'Choix',
                    question_type : "choix",
                    textquestion : '',
                    obligatoire : true,
                    questions:[{id : 1, text : 'Bad', statcolor : '#' + Math.floor(Math.random()*16777215).toString(16)}, 
                               {id : 2, text : 'Normal', statcolor : '#' + Math.floor(Math.random()*16777215).toString(16)},
                               {id : 3, text : 'Good', statcolor : '#' + Math.floor(Math.random()*16777215).toString(16)}], 
                    order: 1, 
                    'icon' : 'fa-check-square', 
                    status: "offline"
                }
            }
        },
        async delQuestion(question_id, order){
            if (confirm('Vous $etes sure d\'effacer cette question?')){
                if (question_id==0){
                    this.questions = this.questions.filter(question => question.order!=order)
                    return false
                }
                this.loading = true
                let response = await fetch(window.location.origin + '/api/delquestion/'+question_id,{
                    method : 'delete',
                    body : JSON.stringify({ enquete_id : this.survey.id}),
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
                    this.loading = false
                })
                .then(data => {
                    this.loading = false
                    this.questions = []
                    // ////console.log(data.sections)
                    this.questions = data.questions
                })
                .catch(err => {
                    ////console.log(err)
                    this.$toasted.global.my_app_error();
                    this.loading = false
                })
            }
        },
        initCurrentQuestion(){
            this.selectedTypeQuestion = ''
            this.currentQuestion = {
                id: 0, 
                local_id : 1, 
                label : 'Icons',
                textquestion : '',
                obligatoire : true,
                questions:[{id : 1, text : 'Bad', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'red'}, 
                            {id : 2, text : 'Normal', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'orange'},
                            {id : 3, text : 'Good', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'green'}],
                question_type : "icons", 
                order: 1, 
                'icon' : 'fa-check-square', 
                status: "offline"
            }
        }
    },
    mounted() {
        this.$store.dispatch('setSideBarHide', true)
        this.getQuestions()
    },
    computed:{
        
    },
    watch : {
        questions(nv, old){
            let vm = this
            this.questions.forEach(function(question, index) {
                document.getElementById('question-'+question.order).style.height =  document.getElementById('questioned-'+question.order).offsetHeight + 'px'
                question.order = index;
            })
        }
    }
}
</script>