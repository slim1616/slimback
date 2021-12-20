<template>
    <div style="width:100%" id="demo">   
        
        <div>
            <h1 class="title-enquete">{{enquete.title}}</h1>
        </div>
        

        <template v-if="enquete.layout=='slides'">
            <div class="fullscreen-wrapper">
                <div class="modal-swiper" :class="{isfinish : isFinished&&!fullscreen}">
                    <div>
                        <h2 class="title-enquete">{{enquete.title}}</h2>
                    </div>
                    <template v-if="!fullscreen">
                        <div style="    display: flex;justify-content: center;align-items: center;width: 100%;height: 100%;">
                            <button class="btn btn-outline-primary" type="button" @click="toggle" >Commencer</button>
                        </div>
                    </template>
                    <template v-if="fullscreen">
                        <div>
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
                                                <h2 class="txt-question">{{question.textquestion}}
                                                    <template v-if="question.obligatoire">
                                                        <span class="red">*</span>
                                                    </template>
                                                </h2>
                                            </div>
                                            <template v-if="question.question_type=='icons'">
                                                <ul class="align-items-center d-flex justify-content-around">
                                                    <li v-for="quest in question.questions">
                                                        <div class="align-items-center d-flex flex-column justify-content-center" :class="{'selected-option':selectedQuestion(question.id, quest.id)}" @click.prevent.stop="addResponse(question.id, quest)">
                                                            <i class="fa-2x mb-2" :class="quest.icon" :style="{color: quest.color}"></i>
                                                            <p>{{quest.text}}</p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </template>
                                            <template v-if="question.question_type=='choix'">
                                                <div style="display: flex;justify-content: center;">
                                                <ul class="">
                                                    <li v-for="quest in question.questions" class="align-items-center d-flex">
                                                            <label :class="[question.typeinput=='checkbox' ? '': 'form-radio-input']" >
                                                                <input :type="question.typeinput" name="question" :class="[question.typeinput=='checkbox' ? 'form-check-label': 'form-radio-label']" @change="addResponse(question.id, quest, question.typeinput)"/>
                                                                <span :class="[question.typeinput=='checkbox' ? 'form-check-sign': 'form-radio-sign']">{{quest.text}}</span>
                                                            </label>
                                                    </li>
                                                </ul>
                                                </div>
                                            </template>
                                        </div>
                                    </swiper-slide>
                                </template>
                                    <swiper-slide>
                                        <div class="question-front finish">
                                                <i class="fa fa-check-circle fa-4x"></i>
                                                <h3 style="margin-top: 30px;text-align:center">Merci pour votre attention</h3>
                                                <a :href="url">Accueil</a>
                                                <a href="#" @click.prevent.stop="restart">Recommencer</a>
                                        </div>
                                    </swiper-slide>
                            </swiper>
                        </div>
                    </template>
                </div>
            </div>
        </template>
            
        
        
        <!-- ------ -->
        <template v-if="enquete.layout=='form'">
            <template v-for="(question,i) in questions">
                    <div class="question-front" v-show="currentQuestions.includes(question.id)">
                        <span class="align-items-center d-flex justify-content-center num-question">{{ i+1  }}</span>
                        <div>
                            <h2 class="txt-question">{{question.textquestion}}
                                <template v-if="question.obligatoire">
                                    <span class="red">*</span>
                                </template>
                            </h2>
                        </div>
                        <template v-if="question.question_type=='icons'">
                            <ul class="align-items-center d-flex justify-content-around">
                                <li v-for="quest in question.questions">
                                    <div class="align-items-center d-flex flex-column justify-content-center" :class="{'selected-option':selectedQuestion(question.id, quest.id)}" @click.prevent.stop="addResponse(question.id, quest)">
                                        <i class="fa-2x mb-2" :class="quest.icon" :style="{color: quest.color}"></i>
                                        <p>{{quest.text}}</p>
                                    </div>
                                </li>
                            </ul>
                        </template>
                        <template v-if="question.question_type=='choix'">
                            <div style="display: flex;justify-content: center;">
                                <ul class="">
                                    <li v-for="quest in question.questions" class="align-items-center d-flex">
                                            <label :class="[question.typeinput=='checkbox' ? '': 'form-radio-input']" >
                                                <input :type="question.typeinput" name="question" :class="[question.typeinput=='checkbox' ? 'form-check-label': 'form-radio-label']" @change="addResponse(question.id, quest, question.typeinput)"/>
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
                                <div class="progression" :style="{width: (responsesIndex.length)/questions.length*100 + '%'}">

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
    const isBetween = (num1,num2,value) => value >= num1 && value <= num2 
    import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper'
    import { api as fullscreen } from 'vue-fullscreen'

    // Import Swiper styles
    import 'swiper/swiper-bundle.css'
import { setTimeout } from 'timers';
export default {
    components: {
      Swiper,
      SwiperSlide,
    },
    props:{
        enquete_id : Number,
    },
    data(){
        return {
            fullscreen: false,
            teleport: false,
            url : window.location.origin,
            isFinished : false,
            swiperOptions: {
                allowTouchMove: false
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
            restart(){
                location.reload();
            },
            async toggle () {
                await fullscreen.toggle(this.$el.querySelector('.fullscreen-wrapper'), {
                    teleport: this.teleport,
                    callback: (isFullscreen) => {
                    this.fullscreen = isFullscreen
                    },
                })
                this.fullscreen = fullscreen.isFullscreen
            },
            onSwiper(event){
                console.log('onSwiper')
                
            },
            onSlideChange(event){
                console.log('onSlideChange')
                console.log(event.activeIndex)
                if (event.activeIndex==this.questions.length){
                        this.isFinished = true
                        this.sendResponses()
                        event.allowTouchMove = false
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
                let index = this.responses.findIndex(response => response.section_id==section_id)
                if (index!=-1){
                    if(type=='checkbox'){
                        let f = this.responses.find(r => r.reponse.id==reponse.id)
                        if (f){
                            this.responses = this.responses.filter(r => r.reponse.id!=reponse.id)
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
                setTimeout(()=> {
                    this.swiper.slideNext()
                },900)
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
                    console.log(err)
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
                    console.log(err)
                    this.loading = false
                    this.loader = false
                })
                
            },
            async getEnquete(password, enqueste_id){
                console.log(password, enqueste_id)
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
                    console.log(err)
                    this.loading = false
                    this.loader = false
                })
            }
    },
    computed:{
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
            return Math.round(this.questions.length/this.questionParPage);
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
             console.log(t)
             console.log(completed)
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
        background: #eee;
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
