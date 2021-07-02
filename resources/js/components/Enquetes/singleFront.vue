<template>
    <div>   
        <template v-for="question in questions">
                <div class="question-front">
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
                            <li v-for="quest in question.questions">
                                <div href="#" class="align-items-center d-flex">
                                    <label :class="[question.typeinput=='checkbox' ? 'form-check-input': 'form-radio-input']" >
                                        <input :type="question.typeinput" name="question" :class="[question.typeinput=='checkbox' ? 'form-check-label': 'form-radio-label']" @change="addResponse(question.id, quest, question.typeinput)"/>
                                        <span :class="[question.typeinput=='checkbox' ? 'form-check-sign': 'form-radio-sign']">{{quest.text}}</span>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </template>
                </div>
        </template>
        <template v-if="questions.length>0">
            <template v-if="canSubmit">
            <div class="justify-content-end d-flex question-front">
                <button class="btn btn-secondary" @click.prevent.stop="sendResponses">
                    Envoyer
                    <span class="btn-label" style="margin-left:7px">
                        <i class="la flaticon-message"></i>
                    </span>
                </button>
            </div>
            </template>
        </template>
        
    </div>
</template>

<script>
export default {
    data(){
        return {
            enquete : {},
            questions : [],
            loading : false,
            uniqid : '',
            responses : [],
        }
    },
    methods: {
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
                 console.log(reponse)
                 console.log(type)
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
                this.$store.dispatch('setLoader',true)
                this.loading = true;
                let res = await fetch(window.location.origin + '/api/enquetes/addresponse', {
                    method : 'post',
                    body : JSON.stringify({responses: this.responses,enquete_id : this.enquete.id, uniqid : this.uniqid}),
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
                    this.$store.dispatch('setLoader',false)
                })
                .then(data => {
                    this.$store.dispatch('setLoader',false)
                    if (data.status){
                        swal({
                    title: 'Votre reponse à été envoyé ',
                    text: "Voir mes reponses!",
                    type: 'success',
                    buttons:{
                        
                        cancel: {
                            text : 'Annuler',
                            visible: true,
                            className: 'btn btn-label'
                        },
                        confirm: {
                            text : 'Oui',
                            className : 'btn btn-info'
                        }
                    }
                }).then((ok) => {
                    if (ok) {
                       this.$router.push({name : 'afterresponse', params : {id : this.uniqid}})
                    } else {
                        this.$router.push({name : 'home'})
                    }
                });
                        
                    }

                })
                .catch(err => {
                    console.log(err)
                    this.$store.dispatch('setLoader',false)
                })
            },
            async getEnquete(){
                this.loading = true;
                let res = await fetch(window.location.origin + '/api/enquetes/front/' + this.$route.params.id, {
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
                    this.enquete = data.enquete
                    this.questions = data.questions
                    this.uniqid = data.uniqid
                })
                .catch(err => {
                    console.log(err)
                    this.loading = false
                    this.$store.dispatch('setLoader',false)
                })
                
            },
    },
    computed:{
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
        this.getEnquete()
    }
}
</script>