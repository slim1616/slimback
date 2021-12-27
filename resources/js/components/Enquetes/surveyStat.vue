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
                            <div class="align-items-center d-flex flex-column justify-content-center" >
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
export default {
    props: {
        responses :Array,
        questions : Array,
    },
    data(){
        return{

        }
    },
    methods:{
        questionStat(section_id){
            let resp = []
            this.flatresponses.forEach(response => {
                if (response.section_id==section_id){
                    if (resp[response.reponse.id-1]!=null){
                        resp[response.reponse.id-1]+=1
                    }else{
                        resp[response.reponse.id-1] = 1
                    }
                }
            })
            if (resp.length==0){
                resp.push(0)
            }
            return resp;
        },
        init(){
            this.questions.forEach(question => {
            var ctx = document.getElementById('question-bar-'+question.id).getContext('2d');
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: question.questions.map(q => q.text),
                    datasets : [{
                        label : 'Répartition par réponse',
                        backgroundColor: question.questions.map(q => q.statcolor),
                        data: this.questionStat(question.id),
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
                        data: this.questionStat(question.id),
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