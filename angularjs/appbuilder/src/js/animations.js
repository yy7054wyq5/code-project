/**
*动画
*/
var appAnimations = angular.module('view-slide-in', ['ngAnimate']);

appAnimations.animation('.view-slide-in', function () {
      return {
            enter: function(element, done) {
                  element.css({
                        opacity: 0.5,
                        position: "relative",
                        top: "100px",
                        left: "200px"
                  })
                  .animate({
                        top: 0,
                        left: 0,
                        opacity: 1
                  }, 1000, done);
            }
    };
});