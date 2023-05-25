<template>
  <div
    class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6  shadow-lg rounded"
  >
    <div class="relative w-full max-w-full flex flex-col lg:flex-row lg:items-center pt-5 pl-5">
        <div class="flex items-center mb-5 lg:mb-0">
            <span class="w-10 h-10 bg-gray-100 border border-gray-200 mr-3 flex items-center justify-center rounded"><i class="fa fa-money-bill"></i></span>
            <h2 class="text-blueGray-400 text-md font-semibold">
                Billing & Payment
            </h2>
        </div>

        <Datepicker class="ml-auto max-w-[300px] mr-5" v-model="rangedate" @update:model-value="handleDate" month-picker   format="yyyy-MM" range placeholder="Range Date" />
    </div>
    <div class="p-4 flex-auto">
      <div class="relative h-[350px] flex items-center justify-center" v-if="loader">
        <Loader></Loader>
      </div>
      <div class="relative h-[350px]">
        <canvas id="bar-chart"></canvas>
      </div>
    </div>
  </div>
</template>
<script>
import Chart from 'chart.js/auto';
import axios from 'axios';
export default {
    data(){
        return{
            chartdata:[],
            loader:true,
            rangedate:'',
            myBar:null,
            params:{
                start:null,
                end:null,
            }
        }
    },
    methods:{

        handleDate(modelData)  {
            let startM = ('0'+(modelData[0].month+1)).slice(-2);
            let start = `${modelData[0].year}-${startM}`
            this.params.start = start;
            let endM = ('0'+(modelData[1].month+1)).slice(-2);
            let end = `${modelData[1].year}-${endM}`
            this.params.end = end;
            this.myBar.destroy();
            this.fetchBar();
        },
        async fetchBar(){
            const res = await axios.get(route('statistik.billing_payment',this.params));
            this.chartdata = res.data.data;
            this.loader = false;
            let config = {
                type: "bar",
                data: {
                labels: this.chartdata.label,
                datasets: [
                    {
                    label: 'REVENUE',
                    backgroundColor: "#E9001A",
                    borderColor: "#E9001A",
                    data: this.chartdata.data,
                    fill: false,
                    barThickness: 20,
                    },
                ],
                },
                options: {
                maintainAspectRatio: false,
                responsive: true,
                title: {
                    display: false,
                    text: "Orders Chart",
                },
                tooltips: {
                    mode: "index",
                    intersect: false,
                },
                hover: {
                    mode: "nearest",
                    intersect: true,
                },
                legend: {
                    labels: {
                    fontColor: "rgba(0,0,0,.4)",
                    fontWeight:700,
                    },
                    align: "end",
                    position: "bottom",
                },
                scales: {
                    x:{
                        display: false,
                        scaleLabel: {
                        display: true,
                        labelString: "Month",
                        },
                        gridLines: {
                        borderDash: [2],
                        borderDashOffset: [2],
                        color: "rgba(33, 37, 41, 0.3)",
                        zeroLineColor: "rgba(33, 37, 41, 0.3)",
                        zeroLineBorderDash: [2],
                        zeroLineBorderDashOffset: [2],
                        },
                    },
                    y:{
                        display: true,
                        scaleLabel: {
                        display: false,
                        labelString: "Value",
                        },
                        gridLines: {
                        borderDash: [2],
                        drawBorder: false,
                        borderDashOffset: [2],
                        color: "rgba(33, 37, 41, 0.2)",
                        zeroLineColor: "rgba(33, 37, 41, 0.15)",
                        zeroLineBorderDash: [2],
                        zeroLineBorderDashOffset: [2],
                        },
                    },
                },
                },
            };
            let ctx = document.getElementById("bar-chart").getContext("2d");
            this.myBar = new Chart(ctx, config);
        }
    },
  mounted: function () {
    this.fetchBar();
  },
};
</script>
