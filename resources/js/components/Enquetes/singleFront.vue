<template>
    <div style="width:80%">   
        <div>
            <h1 class="title-enquete">{{enquete.title}}</h1>
        </div>
        
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
                        <ul class="">
                            <li v-for="quest in question.questions" class="align-items-center d-flex">
                                    <label :class="[question.typeinput=='checkbox' ? '': 'form-radio-input']" >
                                        <input :type="question.typeinput" name="question" :class="[question.typeinput=='checkbox' ? 'form-check-label': 'form-radio-label']" @change="addResponse(question.id, quest, question.typeinput)"/>
                                        <span :class="[question.typeinput=='checkbox' ? 'form-check-sign': 'form-radio-sign']">{{quest.text}}</span>
                                    </label>
                            </li>
                        </ul>
                    </template>
                </div>
        </template>
        <template v-if="questions.length>0">
            <div class="justify-content-between d-flex question-front">
                <div class="d-flex align-items-center">

                    <button @click.prevent.stop="pred" class="mx-2 btn btn-sm btn-light" v-if="current>0"><i class="fa fa-chevron-left"></i> precedent</button>
                    <button @click.prevent.stop="next" class="mx-2 btn btn-sm btn-light" v-if="current<nbpages-1">suivant <i class="fa fa-chevron-right"></i></button>
                    <div class="mx-2">
                        <div class="d-flex progresss-bg">
                            <div class="progression" :style="{width: (current+1)/nbpages*100 + '%'}">

                            </div>
                        </div>
                    </div>
                    page {{current+1}} / {{nbpages}}
                </div>
                <div v-if="canSubmit">
                    <button class="btn btn-secondary btn-send" @click.prevent.stop="sendResponses">
                        Envoyer
                        <span class="btn-label" style="margin-left:7px">
                            <i class="la flaticon-message"></i>
                        </span>
                    </button>
                </div>
            </div>
        </template>
        
    </div>
</template>

<script>
    const isBetween = (num1,num2,value) => value >= num1 && value <= num2 

export default {
    props:{
        enquete_id : Number,
    },
    data(){
        return {
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
            pred(){
                if (this.current>0){
                    this.current -= 1
                }
            },
            next(){
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
                            window.location.replace(window.location.origin);   
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
    }
}
</script>