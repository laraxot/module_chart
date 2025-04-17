const echarts = require("echarts");
const Canvas = require('canvas');
const { JSDOM } = require('jsdom');
const fs = require('fs');
echarts.setCanvasCreator(() => {
    return new Canvas(100, 100);
});

const { window } = new JSDOM();
global.window = window;
global.navigator = window.navigator;
global.document = window.document;

const root = document.createElement('div');
root.style.cssText = 'width: 500px; height: 500px;';

const chart = echarts.init(root, null, {
    renderer: 'svg'
});
chart.setOption({
    title: {
        text: 'ECharts 入门示例'
    },
    tooltip: {},
    legend: {
        data: ['销量']
    },
    xAxis: {
        data: ['衬衫', '羊毛衫', '雪纺衫', '裤子', '高跟鞋', '袜子']
    },
    yAxis: {},
    series: [{
        animation: false,
        name: '销量',
        type: 'bar',
        data: [5, 20, 36, 10, 10, 20]
    }]
});

fs.writeFileSync('basic.svg', root.querySelector('svg').outerHTML, 'utf-8');

chart.dispose();