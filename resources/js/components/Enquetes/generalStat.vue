<template>
    <div>
        <div class="row m-md-5">
            <div class="col-md-12">
                <div id="chart-container">
                    <canvas id="courbe-jours"></canvas>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Chart from 'chart.js';
export default {
    props: {
        dates :Array,
        
    },
    data(){
        return{

        }
    },
    methods:{
        init(){
           var ctx = document.getElementById('courbe-jours').getContext('2d');
            var myLineChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: this.dates.map(d => d[0].date),
                    datasets : [{
                        label : 'Réponses par jour',
                        data: this.dates.map(d => d[0].count),
                        backgroundColor: '#197dfb',
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
        },   
    },
    mounted(){
            this.init()
    },
    watch:{
        dates(old, nouv){
            this.init()
        }
    }
}
</script>