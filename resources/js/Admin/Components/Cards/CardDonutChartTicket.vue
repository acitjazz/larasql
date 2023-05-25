<template>
  <div
    class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6  shadow-lg rounded"
  >
      <div class="relative w-full max-w-full flex items-center pt-5 pl-5">
        <div class="flex items-center">
            <span class="w-10 h-10 bg-gray-100 border border-gray-200 mr-3 flex items-center justify-center rounded"><i class="fa fa-ticket"></i></span>
            <h2 class="text-blueGray-400 text-md font-semibold">
                Ticket
            </h2>
        </div>
       </div>
        <div class="px-4 pb-10 max-w-[600px] mx-auto w-full">
            <div class="h-auto lg:h-[250px] mb-5 relative flex-col lg:flex-row flex items-center w-full">
                <div class="w-[200px] mx-auto lg:w-4/12"> <canvas id="pie-chart"></canvas></div>
                <div class="w-full lg:w-6/12 mx-7" id="legend-container"></div>
            </div>
        </div>
  </div>
</template>

<script>
import Chart from 'chart.js/auto';
import axios from 'axios';
export default {
  name: 'App',
  data() {
    return {
        total:0,
        data:{
            labels: ['Open', 'Pending', 'Technical close', 'Close'],
            datasets: [
                {
                 backgroundColor: ['#E9001A', '#063EAB', '#000', '#CCCCCC'],
                    data: [40, 20, 80, 10]
                }
            ]
        },
        options:{
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
            legend: {
                position: 'right',
            },
            }
        }
    }
  },
  created(){
    this.fetchBar();
  },
  methods:{
    async fetchBar(){

        const res = await axios.get(route('statistik.ticket'));
        this.data = res.data.data.chart;
        this.total = res.data.data.total;
        var total = this.total;
        const getOrCreateLegendList = (chart, id) => {
        const legendContainer = document.getElementById(id);
        let listContainer = legendContainer.querySelector('ul');

        if (!listContainer) {
            listContainer = document.createElement('ul');
            listContainer.style.display = 'block';
            listContainer.style.margin = 0;
            listContainer.style.padding = 0;

            legendContainer.appendChild(listContainer);
        }

        return listContainer;
        };

        const htmlLegendPlugin = {
        id: 'htmlLegend',
        afterUpdate(chart, args, options) {
            const ul = getOrCreateLegendList(chart, options.containerID);

            // Remove old legend items
            while (ul.firstChild) {
            ul.firstChild.remove();
            }
            // Reuse the built-in legendItems generator
            const items = chart.options.plugins.legend.labels.generateLabels(chart);

            items.forEach(item => {
            const li = document.createElement('li');
            li.classList = 'flex items-center justify-between w-full lg:ml-3'

            li.onclick = () => {
                const {type} = chart.config;
                if (type === 'pie' || type === 'doughnut') {
                // Pie and doughnut charts only have a single dataset and visibility is per item
                chart.toggleDataVisibility(item.index);
                } else {
                chart.setDatasetVisibility(item.datasetIndex, !chart.isDatasetVisible(item.datasetIndex));
                }
                chart.update();
            };

            // Color box
            const boxSpan = document.createElement('span');
            boxSpan.style.background = item.fillStyle;
            boxSpan.style.borderColor = item.strokeStyle;
            boxSpan.style.borderWidth = item.lineWidth + 'px';
            boxSpan.style.display = 'inline-block';
            boxSpan.style.height = '20px';
            boxSpan.style.marginRight = '10px';
            boxSpan.style.width = '20px';

            // Text
            const textContainer = document.createElement('strong');
            textContainer.style.color = '#000';
            textContainer.style.margin = 0;
            textContainer.style.fontWeight = 600;
            textContainer.style.padding = 0;
            textContainer.style.fontSize = '12px';
            textContainer.style.textDecoration = item.hidden ? 'line-through' : '';

            // chartVal
            const chartValContainer = document.createElement('span');
            chartValContainer.style.color = '#000';
            chartValContainer.style.marginLeft = 'auto';
            chartValContainer.style.padding = 0;
            textContainer.style.fontWeight = 600;
            chartValContainer.style.fontSize = '14px';
            chartValContainer.style.textDecoration = item.hidden ? 'line-through' : '';

            const chartval = document.createTextNode(chart.data.datasets[0].data[item.index]);
            const text = document.createTextNode(item.text);

            chartValContainer.appendChild(chartval);
            textContainer.appendChild(text);

            li.appendChild(boxSpan);
            li.appendChild(textContainer);
            li.appendChild(chartValContainer);
            ul.appendChild(li);
            });

            const totaltextContainer = document.createElement('span');
            const totalValueContainer = document.createElement('span');
            const totaltext = document.createTextNode('TOTAL');
            const totalValue = document.createTextNode(total);
            const totalli = document.createElement('li');
            totalValueContainer.style.marginLeft  = 'auto';
            totaltextContainer.style.fontWeight = 600;
            totaltextContainer.style.fontSize = '14px';
            totalli.classList = 'flex items-center justify-between mt-5 w-full lg:ml-3'
            totalli.style.fontSize = '14px';
            totaltextContainer.appendChild(totaltext);
            totalValueContainer.appendChild(totalValue);
            totalli.appendChild(totaltextContainer);
            totalli.appendChild(totalValueContainer);

            ul.appendChild(totalli);

        }
        };
            let config = {
                type: "pie",
                data: this.data,
                plugins: [htmlLegendPlugin],
                options: {
                plugins: {
                htmlLegend: {
                    // ID of the container to put the legend in
                    containerID: 'legend-container',
                },
                legend: {
                    display: false,
                }
                },
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
                },
            };
            let ctx = document.getElementById("pie-chart").getContext("2d");
            this.myBar = new Chart(ctx, config);
    }
  }
}
</script>
