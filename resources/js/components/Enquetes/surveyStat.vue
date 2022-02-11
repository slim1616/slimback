<template>
    <div id="printable">
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
                            <div class="align-items-center d-flex flex-column justify-content-center" >
                                <i class="fa-2x mb-2" :class="quest.icon" :style="{color: quest.color}"></i>
                                <p>{{quest.text}}</p>
                            </div>
                        </li>
                    </ul>
                </template>
                <template v-if="question.question_type=='stars'">
                    <ul class="align-items-center d-flex justify-content-around">
                       <star-rating :border-width="4" 
                                                border-color="#d8d8d8" 
                                                :read-only="true"
                                                v-bind:increment="0.1"
                                                :rating="starsStat(question.id)"
                                                :rounded-corners="true" 
                                                :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]"></star-rating>
                    </ul>
                </template>
                <template v-if="question.question_type=='choix'">
                    <ul class="">
                        <li v-for="quest in question.questions">
                            <div href="#" class="align-items-center d-flex">
                                <label class="d-flex" :class="[question.typeinput=='checkbox' ? 'form-check-input': 'form-radio-input']" >
                                    <div class="icon-preview" v-if="question.typeinput=='radio'">
                                        <i class="far fa-circle"></i>
                                    </div>
                                    <div class="icon-preview" v-if="question.typeinput=='checkbox'">
                                        <i class="far fa-square"></i>
                                    </div>
                                    <span class="ml-1" :class="[question.typeinput=='checkbox' ? 'form-check-sign': 'form-radio-sign']">{{quest.text}}</span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </template>
                <div class="row m-md-5">
                        <div class="col-md-6">
                            <div id="chart-container">
                                <canvas :id="'question-bar-' + question.id"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="chart-container">
                                <canvas :id="'question-pie-' + question.id"></canvas>
                            </div>
                        </div>
                    </div>
            </div>
        </template>
    </div>
</template>

<script>
import Chart from 'chart.js';
import StarRating from 'vue-star-rating'


export default {
    components:{StarRating},
    props: {
        responses :Array,
        questions : Array,
    },
    data(){
        return{

        }
    },
    methods:{
        starsStat(section_id){
            let resp = this.questionStat(section_id)  
            let t = [];
            t[0] = resp[1]==null ? 0 : resp[1]*1
            t[1] = resp[2]==null ? 0 : resp[2]*2
            t[2] = resp[3]==null ? 0 : resp[3]*3
            t[3] = resp[4]==null ? 0 : resp[4]*4
            t[4] = resp[5]==null ? 0 : resp[5]*5
            let nb = resp.reduce((previousValue, currentValue) => previousValue + currentValue);
            let sum = t.reduce((previousValue, currentValue) => previousValue + currentValue);
            if (nb>0){
                return sum/nb
            }else{
                return 0;
            }
        },
        questionStat(section_id){
            let resp = []
            this.flatresponses.forEach(response => {
                if (response.section_id==section_id){
                    if (resp[response.reponse.id]!=null){
                        resp[response.reponse.id]+=1
                    }else{
                        resp[response.reponse.id] = 1
                    }
                }
            })
            if (resp.length==0){
                resp.push(0)
            }
            console.log(resp)
            return resp;
        },
        init(){
            console.log('init')
            this.questions.forEach(question => {
            // console.log(question.questions)
            let resp = this.questionStat(question.id)
            console.log('resp');
            console.log(resp);
                let t = []
            if (question.questions.length==3){
                t[0] = resp[1]=='undefined' ? 0 : resp[1]
                t[1] = resp[3]=='undefined' ? 0 : resp[3]
                t[2] = resp[5]=='undefined' ? 0 : resp[5]
            }
            if (question.questions.length==4){
                t[0] = resp[1]=='undefined' ? 0 : resp[1]
                t[1] = resp[2]=='undefined' ? 0 : resp[2]
                t[2] = resp[3]=='undefined' ? 0 : resp[3]
                t[3] = resp[5]=='undefined' ? 0 : resp[5]
            }
            if (question.questions.length==5){
                t[0] = resp[1]=='undefined' ? 0 : resp[1]
                t[1] = resp[2]=='undefined' ? 0 : resp[2]
                t[2] = resp[3]=='undefined' ? 0 : resp[3]
                t[3] = resp[4]=='undefined' ? 0 : resp[4]
                t[4] = resp[5]=='undefined' ? 0 : resp[5]
            }
            // for (let index = 0; index < question.questions.length; index++) {
            //     if (resp[index+1]!='undefined'){
            //         t[index] = resp[index+1];
            //     }else{
            //         t[index] = 0;
            //     }
                
            // }

            // t.forEach((el,i) => {
            //         if (resp[i]!='undefined'){
            //             el[i] = resp[i]
            //         }else{
            //             el[i] = 0
            //         }
            //     })
            // console.log('t')
            // console.log(t)
            // console.log(t.values())
            
            var ctx = document.getElementById('question-bar-'+question.id).getContext('2d');
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: question.questions.map(q => q.text),
                    datasets : [{
                        label : 'Répartition par réponse',
                        backgroundColor: question.questions.map(q => q.statcolor),
                        data: t,
                    }],
                },
                options: {
                    legend: {
                        display: false
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero:true
                            },
                            gridLines: {
                                drawTicks: false,
                                display: false
                            }
                        }],
                        yAxes: [{
                            display: false,
                            scaleShowLabels: false,
                            ticks: {
                                beginAtZero:true
                            },
                            gridLines: {
                                drawTicks: false,
                                display: false
                            }
                        }]
                    },
                }
            });
            var ctxpie = document.getElementById('question-pie-'+question.id).getContext('2d');
            var myPieChart = new Chart(ctxpie, {
                type: 'pie',
                data: {
                    labels: question.questions.map(q => q.text),
                    datasets : [{
                        backgroundColor: question.questions.map(q => q.statcolor),
                        data: t,
                    }],
                    hoverOffset: 4
                },
                options: {
                    legend: {
                        display: false
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    
                    
                }
            });
            
        })
        }   
    },
    computed:{
        flatresponses(){
            let t = []
            this.responses.forEach(response => {
                response.reponses.forEach(res => t.push(res))
            })
            return t
        }
    },
    mounted(){
        this.init()
    },
    watch:{
        responses(old, nouv){
            this.init()
        }
    }
}
</script>