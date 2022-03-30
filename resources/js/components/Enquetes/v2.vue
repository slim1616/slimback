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
                                            <div v-if="question.question_type=='choix'" :id="'questioned-'+question.order">
                                                <choix-edit :question="question"></choix-edit>
                                            </div>
                                    </template>
                            </template>
                            <div class="form-group">
                                <select class="form-control" v-model="selectedTypeQuestion" @change="changeTypeQuestion">
                                    <option value="">Choisir un type</option>
                                    <option value="icons">Icons</option>
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
import choixEdit from './choixEdit'

export default {
    components:{draggable, IconEdit, choixEdit},
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
                questions:[ {id : 1, text : '1/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'red'}, 
                            {id : 2, text : '2/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : '#d17474'},
                            {id : 3, text : '3/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'orange'},
                            {id : 4, text : '4/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : '#6ebb30'},
                            {id : 5, text : '5/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'green'}],
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
            if (this.selectedTypeQuestion=='choix'){
                this.questions.push(q)
                // this.savequestion()
            }
            this.initCurrentQuestion()
        },
        changeTypeQuestion(){
            if (this.selectedTypeQuestion=='icons'){
                this.currentQuestion = {
                    typeIcon : 'star',
                    id: 0, 
                    label : 'Icons',
                    textquestion : '',
                    obligatoire : true,
                    questions:[ {id : 1, text : '1/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'red'}, 
                                {id : 2, text : '2/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : '#d17474'},
                                {id : 3, text : '3/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'orange'},
                                {id : 4, text : '4/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : '#6ebb30'},
                                {id : 5, text : '5/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'green'}],
                    question_type : "icons", 
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
                questions:[{id : 1, text : '1/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'red'}, 
                            {id : 2, text : '2/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : '#d17474'},
                            {id : 3, text : '3/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'orange'},
                            {id : 4, text : '4/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : '#6ebb30'},
                            {id : 5, text : '5/5', mobicon : 'star', icon : 'fas fa-star', color : '#efef44', statcolor : 'green'}],
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
            if (this.questions){
                this.questions.forEach(function(question, index) {
                    ////console.log(document.getElementById('question-'+question.order))
                    document.getElementById('question-'+question.order).style.height =  document.getElementById('questioned-'+question.order).offsetHeight + 'px'
                    question.order = index;
                })
            }
        }
    }
}
</script>







<template>
    <div style="width:100%" id="demo">   
        
        <template v-if="enquete.layout=='slides'">
            <div class="fullscreen-wrapper">
                <div class="d-flex flex-column justify-content-center modal-swiper" :class="{isfinish : isFinished&&!fullscreen}">
                    <template v-if="!fullscreen">
                        <div style="display: flex;justify-content: center;align-items: center;width: 100%;height: 100%;flex-direction:column">
                            <div>
                                <h2 class="title-enquete" style="    margin: 10px;">{{enquete.title}}</h2>
                            </div>
                            <button class="btn btn-outline-primary" type="button" @click="toggle" >Commencer</button>
                            <div>
                                <img :src="url + '/img/startenquete.png'" style="width:50%;margin: 10px auto;"/>
                            </div>
                            <div>
                                <img :src="url + '/img/logo.png'" style="width: 100px;position: absolute;bottom: 0;left: calc(50% - 50px);"/>
                            </div>
                        </div>
                    </template>
                    <template v-if="fullscreen">
                        <div>
                            <div>
                                <h2 class="title-enquete">{{enquete.title}}</h2>
                            </div>
                            <swiper
                                :space-between="50"
                                ref="mySwiper" 
                                :auto-update="true"
                                :auto-destroy="true"
                                :options="swiperOptions"
                                @swiper="onSwiper"
                                @slideChange="onSlideChange">   
                                <template v-for="(question,i) in questions">
                                    <swiper-slide>
                                        <div class="question-front" >
                                            <span class="align-items-center d-flex justify-content-center num-question">{{ i+1  }}</span>
                                            <div>
                                                <h2 class="txt-question">{{question.textquestion}}</h2>
                                            </div>
                                            <template v-if="question.question_type=='icons'">
                                                <template v-if="question.typeIcon=='face'">
                                                    <ul class="align-items-center d-flex justify-content-around" style="padding: 20px 0;">
                                                        <li v-for="quest in question.questions">
                                                            <div class="align-items-center d-flex flex-column justify-content-center" :class="{'selected-option':selectedQuestion(question.id, quest.id)}" @click.prevent.stop="addResponse(question.id, quest)">
                                                                <template v-if="question.typeIcon=='face'">
                                                                    <i class="fa-3x mb-2" :class="quest.icon" style="padding:10px;border-radius:50%" :style="{backgroundColor: quest.color}"></i>
                                                                </template>
                                                                <template v-else>
                                                                    <i class="fa-3x mb-2" :class="quest.icon" :style="{color: quest.color}"></i>
                                                                </template>
                                                                <p>{{quest.text}}</p>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </template>
                                                <template v-if="question.typeIcon=='star'">
                                                    <star-rating />
                                                </template>
                                            </template>
                                            <template v-if="question.question_type=='choix'">
                                                <div style="display: flex;justify-content: center;">
                                                    <ul class="">
                                                        <li v-for="(quest) in question.questions" class="align-items-center d-flex" :key="quest.id">
                                                                <label :class="[question.typeinput=='checkbox' ? '': 'form-radio-input']" >
                                                                    <input :type="question.typeinput" :name="'question-'+ question.id" :checked="isChecked(question, quest)" :class="[question.typeinput=='checkbox' ? 'form-check-label': 'form-radio-label']" @change="addResponse(question.id, quest, question.typeinput)"/>
                                                                    <span :class="[question.typeinput=='checkbox' ? 'form-check-sign': 'form-radio-sign']">{{quest.text}}</span>
                                                                </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button v-if="question.typeinput=='checkbox'" class="btn btn-link" @click.prevent.stop="swiper.slideNext()">Continuer <i class="fa fa-chevron-right"></i></button>
                                                </div>
                                            </template>
                                        </div>
                                    </swiper-slide>
                                </template>
                                    <swiper-slide>
                                        <div class="finish">
                                                <h3 style="margin-top: 30px;text-align:center">Merci pour votre attention</h3>
                                                <div>
                                                    <img :src="url + '/img/finish.png'" style="width: 95%;margin: 5px auto;"/>
                                                </div>
                                                <div>
                                                    <a :href="url" style="margin-right:10px">Accueil</a>
                                                    <a href="#" @click.prevent.stop="restart">Recommencer</a>
                                                </div>
                                        </div>
                                    </swiper-slide>
                            </swiper>
                        </div>
                    </template>
                        <div class="d-flex justify-content-center">
                            <img :src="url + '/img/logo.png'" style="width:100px;position: absolute;"/>
                        </div>
                </div>
            </div>
        </template>
            
        
        
        <!-- ------ -->
        <template v-if="enquete.layout=='form'">
            <div>
                <h2 class="title-enquete">{{enquete.title}}</h2>
            </div>
            <template v-for="(question,i) in questions">
                    <div class="question-front" v-show="currentQuestions.includes(question.id)" :key="i">
                        <span class="align-items-center d-flex justify-content-center num-question">{{ i+1  }}</span>
                        <div>
                            <h2 class="txt-question">{{question.textquestion}}
                                <template v-if="question.obligatoire">
                                    <span class="red">*</span>
                                </template>
                            </h2>
                        </div>
                        <template v-if="question.question_type=='icons'">
                            <template v-if="question.typeIcon=='face'">
                                <ul class="align-items-center d-flex justify-content-around">
                                    <li v-for="quest in question.questions" :key="quest.id">
                                        <div class="align-items-center d-flex flex-column justify-content-center" :class="{'selected-option':selectedQuestion(question.id, quest.id)}" @click.prevent.stop="addResponse(question.id, quest)">
                                            <template v-if="question.typeIcon=='face'">
                                                <i class="fa-3x mb-2" :class="quest.icon" style="padding:10px;border-radius:50%" :style="{backgroundColor: quest.color}"></i>
                                            </template>
                                            <template v-else>
                                                <i class="fa-3x mb-2" :class="quest.icon" :style="{color: quest.color}"></i>
                                            </template>

                                            <p>{{quest.text}}</p>
                                        </div>
                                    </li>
                                </ul>
                            </template>
                            <template v-if="question.typeIcon=='star'">
                                <div class="align-items-center d-flex justify-content-center">
                                    <star-rating :padding="10" :star-size="60" border-color="#000" :show-rating="false" inactive-color="#eee" active-color="#e1f348" :rounded-corners="true" :border-width="1" @rating-selected="setRating($event, question)"/>
                                </div>
                            </template>
                        </template>
                        <template v-if="question.question_type=='choix'">
                            <div style="display: flex;justify-content: center;">
                                <ul class="">
                                    <li v-for="quest in question.questions" class="align-items-center d-flex" :key="quest.id">
                                            <label :class="[question.typeinput=='checkbox' ? '': 'form-radio-input']" >
                                                <input :type="question.typeinput" :name="'question-'+ question.id" :checked="isChecked(question, quest)" :class="[question.typeinput=='checkbox' ? 'form-check-label': 'form-radio-label']" @change="addResponse(question.id, quest, question.typeinput)"/>
                                                <span :class="[question.typeinput=='checkbox' ? 'form-check-sign': 'form-radio-sign']">{{quest.text}}</span>
                                            </label>
                                    </li>
                                </ul>
                            </div>
                        </template>
                    </div>
            </template>
            <template v-if="questions.length>0">
                <div class="justify-content-between d-flex question-front">
                    <div class="d-flex align-items-center">
                        <button @click.prevent.stop="pred" class="mx-2 btn btn-sm btn-light" v-if="current>0"><i class="fa fa-chevron-left"></i> precedent</button>
                        <button @click.prevent.stop="suivant" class="mx-2 btn btn-sm btn-light" v-if="current<nbpages-1">suivant <i class="fa fa-chevron-right"></i></button>
                        <div class="mx-2">
                            <div class="d-flex progresss-bg">
                                <div class="progression" :style="{width: (uniqueReponses.length)/questions.length*100 + '%'}">

                                </div>
                            </div>
                        </div>
                        page {{current+1}} / {{nbpages}}
                    </div>
                    <div v-if="canSubmit" class="align-items-center d-flex">
                        <button class="btn btn-secondary btn-send btn-sm" @click.prevent.stop="sendResponses">
                            Envoyer
                            <span class="btn-label" style="margin-left:7px">
                                <i class="la flaticon-message"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </template>
        </template>
        
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    const isBetween = (num1,num2,value) => value >= num1 && value <= num2 
    import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper'
    import { api as fullscreen } from 'vue-fullscreen'
    import StarRating from 'vue-star-rating'



    // Import Swiper styles
    import 'swiper/swiper-bundle.css'
import { setTimeout } from 'timers';
export default {
    components: {
      Swiper,
      SwiperSlide,
      StarRating
    },
    props:{
        enquete_id : String,
    },
    data(){
        return {
            fullscreen: false,
            teleport: false,
            url : window.location.origin,
            isFinished : false,
            swiperOptions: {
                allowTouchMove: true
            },
            back: false,
            currentIndex: 0,
            enquete : {},
            questions : [],
            loading : false,
            uniqid : '',
            responses : [],
            loader : false,
            questionParPage : 2,
            current : 0
        }
    },
    methods: {
            setRating(rating,question){
                ////console.log(question.id);
                let find = question.questions.find(quest =>quest.id==rating)
                ////console.log(rating);
                ////console.log(find);
                if (find){
                    this.addResponse(question.id,find, 'star')
                }
            },
            isChecked(question, quest){
                return this.responses.find(resp => resp.section_id==question.id&&resp.reponse.id==quest.id)
            },
            restart(){
                location.reload();
            },
            async toggle () {
                if (this.enquete.layout=='slides'){
                    await fullscreen.toggle(this.$el.querySelector('.fullscreen-wrapper'), {
                        teleport: this.teleport,
                        callback: (isFullscreen) => {
                        this.fullscreen = isFullscreen
                        },
                    })
                    this.fullscreen = fullscreen.isFullscreen
                }
            },
            onSwiper(event){
                ////console.log('onSwiper')
                
            },
            onSlideChange(event){
                ////console.log('onSlideChange')
                ////console.log(event.activeIndex)
                if (event.activeIndex==this.questions.length){
                        if (this.canSubmit){
                            this.isFinished = true
                            this.sendResponses()
                            event.allowTouchMove = false
                        }else{
                            this.swiper.slidePrev()
                        }
                }
                
            },
            //******************* */
            pred(){
                if (this.current>0){
                    this.current -= 1
                }
            },
            suivant(){
                if (this.current+1<this.nbpages){
                    this.current += 1
                }
            },
            selectedQuestion(section_id, id){
                let exist = false
                this.responsesIndex.forEach(response => {
                    if (response.section_id==section_id&&response.id==id){
                        exist = true
                    }
                })
                return exist;
            },
             addResponse(section_id, reponse, type){
                 ////console.log(type)
                let index = this.responses.findIndex(response => response.section_id==section_id)
                if (index!=-1){
                    if(type=='checkbox'){
                        let f = this.responses.find(r => r.reponse.id==reponse.id&&r.section_id==section_id)
                        if (f){
                            this.responses = this.responses.filter(r => {
                                if (r.section_id!=section_id){
                                    return true
                                }else{
                                    if (r.reponse.id!=reponse.id){
                                        return true
                                    }else{
                                        return false
                                    }
                                }
                            })
                        }else{
                            this.responses.push({enquete_id : this.enquete.id, reponse : reponse, uniqid : this.uniqid, section_id : section_id})   
                        }

                    }else{    
                        let newresp = this.responses.filter(response => response.section_id!=section_id)
                        newresp.push({enquete_id : this.enquete.id, reponse : reponse, uniqid : this.uniqid, section_id : section_id})
                        this.responses = newresp
                    }
                }else{
                    this.responses.push({enquete_id : this.enquete.id, reponse : reponse, uniqid : this.uniqid, section_id : section_id})
                }
                let that = this
                if (this.swiper){
                    setTimeout(()=> {
                        if(type!='checkbox'){
                            that.swiper.slideNext()
                        }
                    },500)
                }
            },
            async sendResponses(){
                this.loader = true
                this.loading = true;
                let res = await fetch(window.location.origin + '/api/enquetes/addresponse', {
                    method : 'post',
                    body : JSON.stringify({responses: this.responses,enquete_id : this.enquete.id, uniqid : this.uniqid, emplacement_id : 0, source : 'web' }),
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
                        swal.fire({
                            icon: 'success',
                            title: 'Votre reponse à été envoyé ',
                            text: "Merci pour votre attention",
                            type: 'success'
                        }).then((result) => {
                            if (this.enquete.layout=='form'){
                                window.location.replace(window.location.origin);   
                            }
                            this.isFinished = false
                        })
                        
                    }

                })
                .catch(err => {
                    ////console.log(err)
                    this.loader = false
                })
            },
            async getEnqueteInit(){
                this.loading = true;
                let res = await fetch(window.location.origin + '/api/enquetes/frontstart/' + this.enquete_id, {
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
                    this.loader = false
                })
                .then(data => {
                    this.loading = false
                    this.loader = false
                    if (data.status){
                        if (data.enquete.confidentiality=='public'){
                            this.questionParPage = data.enquete.questionParPage
                            this.enquete = data.enquete
                            this.questions = data.questions
                            this.uniqid = data.uniqid
                        }else{
                            (async () => {
                                const { value: password } = await swal.fire({
                                    title: 'Entrer le mot de passe',
                                    input: 'password',
                                    inputLabel: 'Mot de passe',
                                    inputPlaceholder: 'Entre le mot de passe',
                                    inputAttributes: {
                                        maxlength: 10,
                                        autocapitalize: 'off',
                                        autocorrect: 'off'
                                    }
                                })
                                if (password) {
                                    this.getEnquete(password, this.enquete_id)
                                }
                                })()

                        }
                    }else{
                        alert('Enquete n\'existe pas');
                    }
                })
                .catch(err => {
                    ////console.log(err)
                    this.loading = false
                    this.loader = false
                })
                
            },
            async getEnquete(password, enqueste_id){
                ////console.log(password, enqueste_id)
                 this.loading = true;
                let res = await fetch(window.location.origin + '/api/enquetes/privatefront/' + this.enquete_id, {
                    method : 'post',
                    body : JSON.stringify({'password' : password}),
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
                    this.loader = false
                })
                .then(data => {
                    this.loading = false
                    this.loader = false
                    if (data.status){
                        this.questionParPage = data.enquete.questionParPage
                        this.enquete = data.enquete
                        this.questions = data.questions
                        this.uniqid = data.uniqid
                    }else{
                        Swal.fire({
                            title: 'Error',
                            text: data.msg,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'Annuler',
                            confirmButtonText: 'ressayer'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                this.getEnqueteInit()
                            }
                        })
                    }
                })
                .catch(err => {
                    ////console.log(err)
                    this.loading = false
                    this.loader = false
                })
            }
    },
    computed:{
        ...mapGetters({
            // url : 'getUrl' 
        }),
        uniqueReponses(){
            let tab = [];
            this.responsesIndex.forEach(resp => {
                if (!tab.includes(resp.section_id)){
                    tab.push(resp.section_id)
                }
            })
            return tab;
        },
        swiper() {
            if (this.$refs.mySwiper){
                return this.$refs.mySwiper.$swiper
            }
        },
        currentQuestions(){
            return this.questions.map((question,i) => {
                if (isBetween(this.current*this.questionParPage, ((this.current+1)*this.questionParPage)-1, i)){
                    return question.id;
                }
            })
        },
        nbpages(){
            return Math.ceil(this.questions.length/this.questionParPage);
        },
        responsesIndex(){
            return this.responses.map(function(response){
                return {section_id : response.section_id, id: response.reponse.id }
                })
        },
        canSubmit(){
            let t = [];
             this.questions.forEach(q => {if (q.obligatoire){ t.push(q.id) }} )
             let completed = [];
             this.responses.forEach(res => {
                 if (t.includes(res.section_id)){
                     if (!completed.includes(res.section_id)){
                        completed.push(res.section_id)
                     }
                 }
             } )
             ////console.log(t)
             ////console.log(completed)
             return t.length==completed.length
        }
    },
    mounted(){
        this.getEnqueteInit()
        this.toggle()
    }
}
</script>

<style scoped>
    .modal-swiper{
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        z-index: 999;
    }
    .isfinish{
        filter: blur(3px);
    }
    .finish{
        color: #1572e8;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
</style>
