<template>
    <svg width="80px"  height="80px"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="lds-bar-chart" style="">
    <g transform="rotate(180 50 50)">
      <rect ng-attr-x="{{config.x1}}" y="15" ng-attr-width="{{config.width}}" height="38.086" fill="#c00" style='opacity:0.5'  x="14" width="12">
        <animate attributeName="height" calcMode="spline" values="50;70;30;50" keyTimes="0;0.33;0.66;1" dur="1" keySplines="0.5 0 0.5 1;0.5 0 0.5 1;0.5 0 0.5 1" begin="-0.4s" repeatCount="indefinite"></animate>
      </rect>
      <rect ng-attr-x="{{config.x2}}" y="15" ng-attr-width="{{config.width}}" height="69.7963" fill="#fac090" x="34" width="12">
        <animate attributeName="height" calcMode="spline" values="50;70;30;50" keyTimes="0;0.33;0.66;1" dur="1" keySplines="0.5 0 0.5 1;0.5 0 0.5 1;0.5 0 0.5 1" begin="-0.2s" repeatCount="indefinite"></animate>
      </rect>
      <rect ng-attr-x="{{config.x3}}" y="15" ng-attr-width="{{config.width}}" height="32.3702" fill="#ff7c81" x="54" width="12">
        <animate attributeName="height" calcMode="spline" values="50;70;30;50" keyTimes="0;0.33;0.66;1" dur="1" keySplines="0.5 0 0.5 1;0.5 0 0.5 1;0.5 0 0.5 1" begin="-0.6s" repeatCount="indefinite"></animate>
      </rect>
      <rect ng-attr-x="{{config.x4}}" y="15" ng-attr-width="{{config.width}}" height="58.1981" fill="#000" style='opacity:0.5' x="74" width="12">
        <animate attributeName="height" calcMode="spline" values="50;70;30;50" keyTimes="0;0.33;0.66;1" dur="1" keySplines="0.5 0 0.5 1;0.5 0 0.5 1;0.5 0 0.5 1" begin="0s" repeatCount="indefinite"></animate>
      </rect>
    </g>
  </svg>
</template>
