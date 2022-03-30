<template>
    <div class="edit-question">
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" name="obligatoire" type="checkbox" :value="true" v-model="question.obligatoire">
                <span class="form-check-sign">Obligatoire *</span>
            </label>
        </div>
        <div class="mb-1 d-flex justify-content-between align-content-center">
            <h2>Icon</h2>
            <div class="selectgroup selectgroup-secondary selectgroup-pills">
                
                <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="face" class="selectgroup-input" v-model="question.typeIcon" @change.prevent.stop="typechanged('face')" >
                    <span class="selectgroup-button selectgroup-button-icon" :class="{'active-radio': question.typeIcon=='face'}">3</span>
                </label>
                <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="face4" class="selectgroup-input" v-model="question.typeIcon" @change.prevent.stop="typechanged('face4')">
                    <span class="selectgroup-button selectgroup-button-icon" :class="{'active-radio': question.typeIcon=='face4'}">4</span>
                </label>
                <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="face5" class="selectgroup-input" v-model="question.typeIcon" @change.prevent.stop="typechanged('face5')">
                    <span class="selectgroup-button selectgroup-button-icon" :class="{'active-radio': question.typeIcon=='face5'}">5</span>
                </label>
            </div>
        </div>
        <div>
                <div>
                    <input type="text" v-model="question.textquestion" placeholder="Question" class="form-control"/>
                </div>
                <ul class="list-choix">
                    <li v-for="quest in question.questions" class="choix-text">
                            <i class="fa-2x" :class="quest.icon" :style="{color: quest.color}"></i>
                            <input type="text" v-model="quest.text" placeholder="Choix" class="form-control" style="margin-left: 5px;padding: 7px 4px;"/>
                    </li>
                </ul>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        question : Object
    },
    data(){
        return {

        }
    },
    methods:{
        typechanged(type){
            ////console.log(type)
            if (type=='face4'){
                if(this.question.questions.length==3){
                    let questions = [this.question.questions[0], 
                                    {id : 2, text : 'Bad', mobicon : 'frown-o', icon : 'far fa-frown', color : '#d57b7b', statcolor : '#d57b7b'},
                                    ...this.question.questions.slice(1)];
                    questions[2] = {id : 3, text : 'Good', mobicon : 'smile-o', icon : 'far fa-smile', color : '#8add8a', statcolor : '#8add8a'}
                    this.question.questions = questions
                }
                if(this.question.questions.length==5){
                    let questions = this.question.questions.filter(quest => quest.id!=4)
                    questions[2] = {id : 3, text : 'Good', mobicon : 'smile-o', icon : 'far fa-smile', color : '#8add8a', statcolor : '#8add8a'}   
                    this.question.questions = questions
                }
            }
            if (type=='face5'){
                if(this.question.questions.length==3){
                        let questions = [this.question.questions[0], 
                                        {id : 2, text : 'Bad', mobicon : 'frown-o', icon : 'far fa-frown', color : '#d57b7b', statcolor : '#d57b7b'},
                                        this.question.questions[1],
                                        {id : 4, text : 'Good', mobicon : 'smile-o', icon : 'far fa-smile', color : '#8add8a', statcolor : '#8add8a'},
                                        this.question.questions[2]];
                        
                        this.question.questions = questions
                }
                if(this.question.questions.length==4){
                    let questions = [this.question.questions[0], 
                                        this.question.questions[1],
                                        this.question.questions[2],
                                        {id : 4, text : 'Good', mobicon : 'smile-o', icon : 'far fa-smile', color : '#8add8a', statcolor : '#8add8a'},
                                        this.question.questions[3]];
                        
                        this.question.questions = questions
                }
                this.question.questions[2] = {id : 3, text : 'Normal', mobicon : 'meh-o', icon : 'far fa-meh', color : 'orange', statcolor : 'orange'}
            }
            if (type=='face'){
                if(this.question.questions.length==4){
                    let questions = this.question.questions.filter(quest => quest.id!=2)
                    
                    this.question.questions = questions
                }
                if(this.question.questions.length==5){
                    let questions = this.question.questions.filter(quest =>  [1,3,5].includes(quest.id) )
                    
                    this.question.questions = questions
                }
                this.question.questions[1] = {id : 3, text : 'Normal', mobicon : 'meh-o', icon : 'far fa-meh', color : 'orange', statcolor : 'orange'}
            }

            this.question.questions.map((question,i) => {
                // if (type=='face'){
                //     if (i==0){
                //         question.color = 'red'
                //         question.icon = 'far fa-frown'
                //         question.mobicon = 'frown-o'
                //     }
                //     if (i==1){
                //         question.color = 'orange'
                //         question.icon = 'far fa-meh'
                //         question.mobicon = 'meh-o'
                //     }
                //     if (i==2){
                //         question.color = 'green'
                //         question.icon = 'far fa-smile'
                //         question.mobicon = 'smile-o'
                //     }
                // }
                // if (type=='face4'){
                //     ////console.log(this.question.questions)
                //     if (i==0){
                //         question.color = 'red'
                //         question.icon = 'far fa-frown'
                //         question.mobicon = 'frown-o'
                //     }
                //     if (i==1){
                //         question.color = 'orange'
                //         question.icon = 'far fa-meh'
                //         question.mobicon = 'meh-o'
                //     }
                //     if (i==2){
                //         question.color = 'green'
                //         question.icon = 'far fa-smile'
                //         question.mobicon = 'smile-o'
                //     }
                // }
            })
        },
    },
    mounted(){
        ////console.log(this.question.typeIcon)
    }
}
</script>